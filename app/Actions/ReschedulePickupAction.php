<?php

namespace App\Actions;

use App\Models\JadwalLangganan;
use App\Models\Langganan;
use App\Models\Paket;
use Carbon\CarbonImmutable;

/**
 * Dynamic Scheduling: Generate / Reschedule jadwal penjemputan langganan.
 *
 * Logika:
 * - Total Kuota = (durasi_hari / 7) × frekuensi_jemput_per_minggu
 * - Interval = masa_aktif / total_kuota
 * - Jadwal tersebar merata, auto-reschedule saat ada order manual
 */
class ReschedulePickupAction
{
    /**
     * Hitung total kuota jemputan dari frekuensi mingguan.
     *
     * Contoh:
     * - Paket Hemat: 2x/minggu × 4 minggu (30 hari) = 8 kuota
     * - Paket Reguler: 3x/minggu × 4 minggu = 12 kuota
     * - Paket Premium: 7x/minggu × 4 minggu = 28 kuota
     * - Paket Tahunan: 3x/minggu × 52 minggu (365 hari) = 156 kuota
     */
    public static function hitungTotalKuota(Paket $paket): int
    {
        $frekuensiPerMinggu = $paket->frekuensi_jemput;
        $durasiHari = $paket->durasi_hari;

        // Hitung jumlah minggu penuh (dibulatkan ke bawah)
        $jumlahMinggu = (int) floor($durasiHari / 7);

        return max(1, $jumlahMinggu * $frekuensiPerMinggu);
    }

    /**
     * Generate jadwal awal saat langganan baru disetujui.
     */
    public function generateInitial(Langganan $langganan): void
    {
        $paket = $langganan->paket;
        if (!$paket || !$langganan->tanggal_mulai || !$langganan->tanggal_selesai) {
            return;
        }

        // Hapus jadwal lama jika ada (re-generate)
        $langganan->jadwalLangganan()->delete();

        $totalKuota = self::hitungTotalKuota($paket);
        $mulai      = CarbonImmutable::parse($langganan->tanggal_mulai);
        $selesai    = CarbonImmutable::parse($langganan->tanggal_selesai);

        $this->generateJadwalDariTitik($langganan, $mulai, $selesai, $totalKuota);
    }

    /**
     * Reschedule setelah order manual mengonsumsi kuota.
     *
     * @param Langganan       $langganan
     * @param CarbonImmutable $titikOrder  Tanggal order manual terjadi
     */
    public function rescheduleAfterManualOrder(Langganan $langganan, CarbonImmutable $titikOrder): void
    {
        $paket = $langganan->paket;
        if (!$paket) return;

        // 1. Cari jadwal 'terjadwal' terdekat setelah/pada titik order → hangus
        $jadwalHangus = JadwalLangganan::where('langganan_id', $langganan->id)
            ->where('status', 'terjadwal')
            ->whereDate('tanggal_jemput', '>=', $titikOrder->toDateString())
            ->orderBy('tanggal_jemput')
            ->first();

        if ($jadwalHangus) {
            $jadwalHangus->update([
                'status'            => 'selesai',
                'catatan_skip'      => 'Dikonsumsi oleh order manual',
                'diselesaikan_pada' => now(),
            ]);
        }

        // 2. Hapus semua jadwal 'terjadwal' yang tersisa (akan di-generate ulang)
        JadwalLangganan::where('langganan_id', $langganan->id)
            ->where('status', 'terjadwal')
            ->delete();

        // 3. Hitung sisa kuota
        $totalKuota   = self::hitungTotalKuota($paket);
        $sudahSelesai = JadwalLangganan::where('langganan_id', $langganan->id)
            ->where('status', 'selesai')
            ->count();

        $sisaKuota = max(0, $totalKuota - $sudahSelesai);

        if ($sisaKuota <= 0) {
            return; // Kuota habis
        }

        // 4. Generate jadwal baru dari titik order
        $selesai = CarbonImmutable::parse($langganan->tanggal_selesai);
        $this->generateJadwalDariTitik($langganan, $titikOrder, $selesai, $sisaKuota);
    }

    /**
     * Core: Generate N jadwal tersebar merata dari titik mulai hingga selesai.
     *
     * Rumus: interval = sisa_hari / sisa_kuota
     * Setiap jadwal ditempatkan pada: titik_mulai + round(interval × ke-N)
     */
    private function generateJadwalDariTitik(
        Langganan $langganan,
        CarbonImmutable $mulai,
        CarbonImmutable $selesai,
        int $kuota
    ): void {
        if ($kuota <= 0) return;

        $totalHari = $mulai->diffInDays($selesai);
        if ($totalHari <= 0) return;

        // Interval minimal 1 hari
        $interval = max(1, $totalHari / $kuota);

        $jadwalData = [];
        for ($i = 0; $i < $kuota; $i++) {
            $hariKe = (int) round($interval * ($i + 1));
            $tanggal = $mulai->addDays($hariKe);

            // Pastikan tidak melewati tanggal selesai
            if ($tanggal->gt($selesai)) {
                $tanggal = $selesai;
            }

            $jadwalData[] = [
                'langganan_id'   => $langganan->id,
                'user_id'        => $langganan->user_id,
                'tanggal_jemput' => $tanggal->toDateString(),
                'jam_jemput'     => '08:00',
                'status'         => 'terjadwal',
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
        }

        if (!empty($jadwalData)) {
            JadwalLangganan::insert($jadwalData);
        }
    }

    /**
     * Cek sisa kuota penjemputan.
     */
    public function sisaKuota(Langganan $langganan): int
    {
        $totalKuota = self::hitungTotalKuota($langganan->paket);
        $sudahSelesai = JadwalLangganan::where('langganan_id', $langganan->id)
            ->where('status', 'selesai')
            ->count();

        return max(0, $totalKuota - $sudahSelesai);
    }
}

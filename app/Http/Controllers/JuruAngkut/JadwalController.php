<?php

namespace App\Http\Controllers\JuruAngkut;

use App\Http\Controllers\Controller;
use App\Models\JadwalLangganan;
use App\Models\Konfigurasi;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    /**
     * Tampilkan jadwal: tab Pesanan Reguler & tab Pelanggan Langganan.
     */
    public function index(Request $request)
    {
        // ── 1. PESANAN REGULER MENDATANG (belum bisa diklaim karena tanggal future) ──
        $pesananReguler = Pesanan::with(['pengguna', 'detailPesanan.kategoriSampah'])
            ->where('status', 'menunggu')
            ->whereDate('tanggal_jemput', '>', today())
            ->orderBy('tanggal_jemput')
            ->get();

        // ── 2. LANGGANAN AKTIF — grouped by langganan with all jadwal ──
        $langgananAktif = \App\Models\Langganan::with(['pengguna', 'paket'])
            ->where('status', 'aktif')
            ->whereDate('tanggal_selesai', '>=', today())
            ->get()
            ->map(function ($l) {
                // Ambil semua jadwal untuk langganan ini
                $jadwalSemua = JadwalLangganan::where('langganan_id', $l->id)
                    ->orderBy('tanggal_jemput')
                    ->get();

                $totalJadwal = $jadwalSemua->count();
                $selesai = $jadwalSemua->where('status', 'selesai')->count();
                $terjadwal = $jadwalSemua->where('status', 'terjadwal')->count();
                $nextJadwal = $jadwalSemua->where('status', 'terjadwal')
                    ->where('tanggal_jemput', '>=', today())
                    ->first();

                return (object) [
                    'id'              => $l->id,
                    'nama_pelanggan'  => $l->pengguna->name ?? 'Pelanggan',
                    'paket_nama'      => $l->paket->nama ?? 'Paket',
                    'frekuensi'       => $l->paket->frekuensi_jemput ?? 0,
                    'satuan'          => $l->paket->satuan_frekuensi ?? 'minggu',
                    'tanggal_mulai'   => $l->tanggal_mulai,
                    'tanggal_selesai' => $l->tanggal_selesai,
                    'total_jadwal'    => $totalJadwal,
                    'selesai'         => $selesai,
                    'terjadwal'       => $terjadwal,
                    'next_tanggal'    => $nextJadwal?->tanggal_jemput?->format('d M Y'),
                    'jadwal_list'     => $jadwalSemua->map(fn($j) => (object) [
                        'id'      => $j->id,
                        'tanggal' => $j->tanggal_jemput->format('d M Y'),
                        'hari'    => $j->tanggal_jemput->translatedFormat('l'),
                        'jam'     => $j->jam_jemput,
                        'status'  => $j->status,
                        'raw_date' => $j->tanggal_jemput->toDateString(),
                    ]),
                ];
            });

        // Summary counts
        $totalPesananReguler = $pesananReguler->count();
        $totalLanggananAktif = $langgananAktif->count();

        // Badge count for nav
        $terjadwalHariIni = JadwalLangganan::whereDate('tanggal_jemput', today())
            ->where('status', 'terjadwal')->count()
            + Pesanan::where('status', 'menunggu')->whereDate('tanggal_jemput', '>', today())->count();

        return view('juru_angkut.jadwal.index', compact(
            'pesananReguler',
            'langgananAktif',
            'totalPesananReguler',
            'totalLanggananAktif',
            'terjadwalHariIni'
        ));
    }

    /**
     * Mulai jemput: konversi jadwal → pesanan baru, redirect ke proses jemput.
     */
    public function mulaiJemput($id)
    {
        $jadwal = JadwalLangganan::with(['pelanggan', 'langganan'])->findOrFail($id);

        if ($jadwal->status !== 'terjadwal') {
            return back()->withErrors(['jadwal' => 'Jadwal ini sudah diproses.']);
        }

        $user = Auth::user();
        $langganan = $jadwal->langganan;
        $pelanggan = $jadwal->pelanggan;

        // Hitung ongkir berdasarkan jarak (gunakan alamat pelanggan yang tersimpan di profil)
        $latBase = (float) Konfigurasi::getValue('lat_bank_sampah', -0.026330);
        $lonBase = (float) Konfigurasi::getValue('lon_bank_sampah', 109.342504);

        // Gunakan koordinat pelanggan dari profil (wajib diisi via middleware)
        $latUser = $pelanggan->latitude ?? $latBase;
        $lonUser = $pelanggan->longitude ?? $lonBase;
        $alamat = $pelanggan->alamat ?? 'Alamat pelanggan';

        // Hitung jarak (Haversine fallback)
        $jarakKm = $this->hitungJarakHaversine($latBase, $lonBase, (float) $latUser, (float) $lonUser);

        // Hitung ongkir
        $baseFee = (int) Konfigurasi::getValue('ongkir_base_fee', 10000);
        $perKm   = (int) Konfigurasi::getValue('ongkir_per_km', 2500);
        $ongkir = $baseFee;
        if ($jarakKm > 1) {
            $ongkir = $baseFee + (ceil($jarakKm - 1) * $perKm);
        }

        // Buat pesanan dari jadwal
        $pesanan = DB::transaction(function () use ($jadwal, $user, $pelanggan, $langganan, $alamat, $latUser, $lonUser, $jarakKm, $ongkir) {
            $pesanan = Pesanan::create([
                'nomor_pesanan'      => Pesanan::generateNomor(),
                'user_id'            => $pelanggan->id,
                'pengangkut_id'      => $user->id,
                'langganan_id'       => $langganan->id,
                'alamat_jemput'      => $alamat,
                'latitude'           => $latUser,
                'longitude'          => $lonUser,
                'jarak_km'           => $jarakKm,
                'tanggal_jemput'     => $jadwal->tanggal_jemput,
                'jam_jemput'         => $jadwal->jam_jemput,
                'status'             => 'diklaim',
                'tipe_pesanan'       => 'langganan',
                'biaya_jemput'       => 0, // Gratis untuk langganan
                'ongkir_juru_angkut' => $ongkir,
                'biaya_admin'        => 0,
                'metode_pembayaran'  => 'saldo',
                'diklaim_pada'       => now(),
            ]);

            // Update jadwal
            $jadwal->update([
                'pesanan_id'    => $pesanan->id,
                'pengangkut_id' => $user->id,
                'status'        => 'selesai',
                'diselesaikan_pada' => now(),
            ]);

            return $pesanan;
        });

        return redirect()->route('juru-angkut.order.proses-jemput', $pesanan->id)
            ->with('success', 'Jadwal berhasil dikonversi menjadi pesanan. Silakan proses jemput!');
    }

    /**
     * Skip jadwal hari ini → reschedule ke minggu depan.
     */
    public function skip(Request $request, $id)
    {
        $jadwal = JadwalLangganan::with('langganan')->findOrFail($id);

        if ($jadwal->status !== 'terjadwal') {
            return back()->withErrors(['jadwal' => 'Jadwal ini sudah diproses.']);
        }

        $alasan = $request->input('alasan', null);

        DB::transaction(function () use ($jadwal, $alasan) {
            // 1. Tandai sebagai dilewati
            $jadwal->update([
                'status'        => 'dilewati',
                'catatan_skip'  => $alasan,
                'dilewati_pada' => now(),
            ]);

            // 2. Reschedule ke hari yang sama minggu depan
            $tanggalPengganti = $jadwal->tanggal_jemput->addWeek();
            $langganan = $jadwal->langganan;

            if ($langganan && $tanggalPengganti->lte($langganan->tanggal_selesai)) {
                // Cek tidak ada duplikat
                $exists = JadwalLangganan::where('langganan_id', $jadwal->langganan_id)
                    ->whereDate('tanggal_jemput', $tanggalPengganti)
                    ->exists();

                if (!$exists) {
                    JadwalLangganan::create([
                        'langganan_id'  => $jadwal->langganan_id,
                        'user_id'       => $jadwal->user_id,
                        'tanggal_jemput' => $tanggalPengganti->toDateString(),
                        'jam_jemput'    => $jadwal->jam_jemput,
                        'status'        => 'terjadwal',
                    ]);
                }
            }
        });

        return back()->with('success', 'Jadwal berhasil dilewati dan dijadwalkan ulang ke minggu depan.');
    }

    /**
     * Haversine distance calculation (KM).
     */
    private function hitungJarakHaversine(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return round($earthRadius * $c, 2);
    }
}

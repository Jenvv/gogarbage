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
     * Tampilkan semua jadwal langganan hari ini dan mendatang.
     */
    public function index(Request $request)
    {
        $tanggal = $request->query('tanggal', today()->toDateString());

        // Jadwal hari yang dipilih (semua jadwal yang belum di-assign atau milik JA ini)
        $jadwalHariIni = JadwalLangganan::with(['pelanggan', 'langganan.paket'])
            ->whereDate('tanggal_jemput', $tanggal)
            ->where('status', 'terjadwal')
            ->orderBy('jam_jemput')
            ->get();

        // Jadwal mendatang (7 hari ke depan)
        $jadwalMendatang = JadwalLangganan::with(['pelanggan', 'langganan.paket'])
            ->whereDate('tanggal_jemput', '>', $tanggal)
            ->whereDate('tanggal_jemput', '<=', now()->addDays(7)->toDateString())
            ->where('status', 'terjadwal')
            ->orderBy('tanggal_jemput')
            ->orderBy('jam_jemput')
            ->get();

        // Summary stats
        $totalHariIni = JadwalLangganan::whereDate('tanggal_jemput', today())->count();
        $selesaiHariIni = JadwalLangganan::whereDate('tanggal_jemput', today())->where('status', 'selesai')->count();
        $dilewatiHariIni = JadwalLangganan::whereDate('tanggal_jemput', today())->where('status', 'dilewati')->count();
        $terjadwalHariIni = JadwalLangganan::whereDate('tanggal_jemput', today())->where('status', 'terjadwal')->count();

        return view('juru_angkut.jadwal.index', compact(
            'jadwalHariIni',
            'jadwalMendatang',
            'tanggal',
            'totalHariIni',
            'selesaiHariIni',
            'dilewatiHariIni',
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

        // Hitung ongkir berdasarkan jarak (gunakan alamat pelanggan)
        $latBase = (float) Konfigurasi::getValue('lat_bank_sampah', -0.026330);
        $lonBase = (float) Konfigurasi::getValue('lon_bank_sampah', 109.342504);

        // Ambil koordinat pelanggan dari alamat tersimpan (jika ada dari pesanan terakhir)
        $pesananTerakhir = Pesanan::where('user_id', $pelanggan->id)
            ->whereNotNull('latitude')
            ->latest()
            ->first();

        $latUser = $pesananTerakhir->latitude ?? $latBase;
        $lonUser = $pesananTerakhir->longitude ?? $lonBase;
        $alamat = $pesananTerakhir->alamat_jemput ?? $pelanggan->alamat ?? 'Alamat pelanggan';

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

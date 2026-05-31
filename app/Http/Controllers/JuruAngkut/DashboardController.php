<?php

namespace App\Http\Controllers\JuruAngkut;

use App\Http\Controllers\Controller;
use App\Models\JadwalLangganan;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dashboard utama Juru Angkut.
     */
    public function index()
    {
        // Sementara: ambil user pertama dengan role juru_angkut, atau user yang login
        $user = Auth::user();

        // Order menunggu (belum diklaim oleh siapapun)
        $orderMenunggu = Pesanan::with(['pengguna', 'detailPesanan.kategoriSampah'])
            ->where('status', 'menunggu')
            ->orderBy('created_at', 'desc')
            ->get();

        // Riwayat pengangkutan (order yang sudah selesai oleh pengangkut ini)
        $riwayat = Pesanan::with(['pengguna', 'detailPesanan.kategoriSampah'])
            ->where('status', 'selesai')
            ->when($user, function ($query) use ($user) {
                $query->where('pengangkut_id', $user->id);
            })
            ->orderBy('diselesaikan_pada', 'desc')
            ->limit(5)
            ->get();

        // Statistik hari ini
        $pendapatanHariIni = Pesanan::where('status', 'selesai')
            ->when($user, function ($query) use ($user) {
                $query->where('pengangkut_id', $user->id);
            })
            ->whereDate('diselesaikan_pada', today())
            ->sum('komisi_pengangkut');

        $orderHariIni = Pesanan::where('status', 'selesai')
            ->when($user, function ($query) use ($user) {
                $query->where('pengangkut_id', $user->id);
            })
            ->whereDate('diselesaikan_pada', today())
            ->count();

        // Jadwal langganan hari ini (terjadwal)
        $jadwalHariIniCount = JadwalLangganan::whereDate('tanggal_jemput', today())
            ->where('status', 'terjadwal')
            ->count();

        return view('juru_angkut.index', compact(
            'orderMenunggu',
            'riwayat',
            'pendapatanHariIni',
            'orderHariIni',
            'user',
            'jadwalHariIniCount'
        ));
    }
}

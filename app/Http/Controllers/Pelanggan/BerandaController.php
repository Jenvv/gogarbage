<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\JadwalLangganan;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerandaController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $aktivitas = Pesanan::where('user_id', $userId)
            ->with('detailPesanan.kategoriSampah')
            ->latest()
            ->limit(4)
            ->get();

        // Pesanan aktif (sedang berlangsung) untuk floating bar
        $pesananAktif = Pesanan::where('user_id', $userId)
            ->whereNotIn('status', ['selesai', 'dibatalkan', 'menunggu'])
            ->latest()
            ->first();

        // Jadwal langganan hari ini
        $jadwalHariIni = JadwalLangganan::with(['langganan.paket'])
            ->where('user_id', $userId)
            ->whereDate('tanggal_jemput', today())
            ->first();

        return view('pelanggan.index', compact('aktivitas', 'pesananAktif', 'jadwalHariIni'));
    }
}


<?php

namespace App\Http\Controllers\Pengepul;

use App\Http\Controllers\Controller;
use App\Models\PenjualanPengepul;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistik bulan ini
        $bulanIni = now()->startOfMonth();
        $transaksiSelesai = PenjualanPengepul::where('pembeli_id', $user->id)
            ->where('status', 'selesai')
            ->where('created_at', '>=', $bulanIni);

        $totalPembelian = (clone $transaksiSelesai)->count();
        $totalBerat = (clone $transaksiSelesai)->sum('total_berat');

        // Request aktif (menunggu / disetujui)
        $requestAktif = PenjualanPengepul::where('pembeli_id', $user->id)
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->with('detail.kategori')
            ->latest()
            ->get();

        // 5 transaksi terakhir yang selesai
        $transaksiTerakhir = PenjualanPengepul::where('pembeli_id', $user->id)
            ->where('status', 'selesai')
            ->with('detail.kategori')
            ->latest()
            ->limit(5)
            ->get();

        return view('pengepul.index', compact(
            'user',
            'totalPembelian',
            'totalBerat',
            'requestAktif',
            'transaksiTerakhir'
        ));
    }
}

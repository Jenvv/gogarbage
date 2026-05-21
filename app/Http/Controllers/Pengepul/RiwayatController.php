<?php

namespace App\Http\Controllers\Pengepul;

use App\Http\Controllers\Controller;
use App\Models\PenjualanPengepul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $bulanIni = now()->startOfMonth();

        // Statistik bulan ini
        $queryBulanIni = PenjualanPengepul::where('pembeli_id', $user->id)
            ->where('status', 'selesai')
            ->where('created_at', '>=', $bulanIni);

        $countBulanIni = (clone $queryBulanIni)->count();
        $beratBulanIni = (clone $queryBulanIni)->sum('total_berat');
        $pengeluaranBulanIni = (clone $queryBulanIni)->sum('total_harga');

        // Semua transaksi selesai
        $transaksi = PenjualanPengepul::where('pembeli_id', $user->id)
            ->where('status', 'selesai')
            ->with('detail.kategori')
            ->latest()
            ->get();

        return view('pengepul.riwayat.index', compact(
            'transaksi',
            'countBulanIni',
            'beratBulanIni',
            'pengeluaranBulanIni'
        ));
    }

    public function show($id)
    {
        $penjualan = PenjualanPengepul::where('pembeli_id', Auth::id())
            ->with(['detail.kategori', 'admin'])
            ->findOrFail($id);

        return view('pengepul.riwayat.detail', compact('penjualan'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $year = now()->year;

        // Summary stats
        $totalPengguna = User::where('role', 'pengguna')->count();
        $totalPengepul = User::where('role', 'pengepul')->count();

        // Juru angkut aktif: punya pesanan dengan status non-final
        $juruAngkutAktif = User::where('role', 'juru_angkut')
            ->whereHas('pesananSebagaiPengangkut', function ($q) {
                $q->whereIn('status', ['diklaim', 'dalam_perjalanan', 'tiba', 'penimbangan']);
            })
            ->count();

        // Total sampah (kg) — jumlah berat pada pesanan yang sudah selesai
        $totalSampah = (float) Pesanan::where('status', 'selesai')->sum('total_berat');

        // Pertumbuhan bulanan (Jan..Dec) untuk pengguna, pengepul, dan total sampah
        $growthUsers = [];
        $growthPengepul = [];
        $growthSampah = [];
        for ($m = 1; $m <= 12; $m++) {
            $growthUsers[] = User::whereYear('created_at', $year)->whereMonth('created_at', $m)->count();
            $growthPengepul[] = User::whereYear('created_at', $year)->whereMonth('created_at', $m)
                ->where('role', 'pengepul')->count();

            $growthSampah[] = (float) Pesanan::whereNotNull('diselesaikan_pada')
                ->whereYear('diselesaikan_pada', $year)
                ->whereMonth('diselesaikan_pada', $m)
                ->sum('total_berat');
        }

        // Distribusi jenis sampah (pakai detail_pesanan.berat)
        $distribution = DetailPesanan::join('kategori_sampah', 'detail_pesanan.kategori_sampah_id', '=', 'kategori_sampah.id')
            ->select('kategori_sampah.nama as name', DB::raw('SUM(detail_pesanan.berat) as total'))
            ->groupBy('kategori_sampah.id', 'kategori_sampah.nama')
            ->orderByDesc('total')
            ->get();

        $categoryLabels = $distribution->pluck('name')->toArray();
        $categorySeries = $distribution->pluck('total')->map(fn($v) => (float) $v)->toArray();

        // Recent orders
        $recentPesanan = Pesanan::with('pengguna')->orderByDesc('created_at')->limit(8)->get();

        return view('admin.dashboard.index', compact(
            'totalPengguna',
            'totalPengepul',
            'juruAngkutAktif',
            'totalSampah',
            'growthUsers',
            'growthPengepul',
            'growthSampah',
            'categoryLabels',
            'categorySeries',
            'recentPesanan'
        ));
    }
}

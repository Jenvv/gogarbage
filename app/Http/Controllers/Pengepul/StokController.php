<?php

namespace App\Http\Controllers\Pengepul;

use App\Http\Controllers\Controller;
use App\Models\KategoriSampah;
use App\Models\StokGudang;

class StokController extends Controller
{
    public function index()
    {
        $kategori = KategoriSampah::aktif()
            ->with('stokGudang')
            ->orderBy('nama')
            ->get();

        $totalStok = StokGudang::sum('stok_kg');

        return view('pengepul.stok_gudang.index', compact('kategori', 'totalStok'));
    }
}

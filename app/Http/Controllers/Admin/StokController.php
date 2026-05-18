<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriSampah;
use App\Models\StokGudang;
use App\Models\LogStokGudang;
use Illuminate\Support\Facades\Auth;

class StokController extends Controller
{
    public function index(Request $request)
    {
        $categories = KategoriSampah::with('stokGudang')->orderBy('nama')->get();
        $logs = LogStokGudang::with(['kategori', 'pembuat'])->orderByDesc('created_at')->limit(100)->get();

        return view('admin.stok.index', compact('categories', 'logs'));
    }

    public function adjust(Request $request)
    {
        $data = $request->validate([
            'kategori_sampah_id' => 'required|exists:kategori_sampah,id',
            'jumlah_kg' => 'required|numeric|min:0.01',
            'tipe' => 'required|in:masuk,keluar',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        $kategoriId = $data['kategori_sampah_id'];
        $jumlah = (float) $data['jumlah_kg'];
        $tipe = $data['tipe'];

        $stok = StokGudang::firstOrCreate(
            ['kategori_sampah_id' => $kategoriId],
            ['stok_kg' => 0, 'total_masuk' => 0, 'total_keluar' => 0]
        );

        $stokSebelum = (float) $stok->stok_kg;

        if ($tipe === 'masuk') {
            $stokSesudah = $stokSebelum + $jumlah;
            $stok->stok_kg = $stokSesudah;
            $stok->total_masuk = ($stok->total_masuk ?? 0) + $jumlah;
        } else {
            if ($stokSebelum < $jumlah) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi untuk pengurangan.');
            }
            $stokSesudah = $stokSebelum - $jumlah;
            $stok->stok_kg = $stokSesudah;
            $stok->total_keluar = ($stok->total_keluar ?? 0) + $jumlah;
        }

        $stok->save();

        LogStokGudang::create([
            'stok_gudang_id' => $stok->id,
            'kategori_sampah_id' => $kategoriId,
            'tipe' => $tipe,
            'jumlah_kg' => $jumlah,
            'stok_sebelum' => $stokSebelum,
            'stok_sesudah' => $stokSesudah,
            'deskripsi' => $data['deskripsi'] ?? null,
            'dibuat_oleh' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Penyesuaian stok berhasil.');
    }
}

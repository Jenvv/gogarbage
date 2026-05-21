<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriSampah;
use App\Models\StokGudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KategoriSampahController extends Controller
{
    // ══════════════════════════════════════════
    //  INDEX — List Kategori Sampah
    // ══════════════════════════════════════════

    public function index()
    {
        $kategori = KategoriSampah::latest()->get();

        return view('admin.master_data.kategori_sampah', compact('kategori'));
    }

    // ══════════════════════════════════════════
    //  STORE — Tambah Kategori Sampah
    //  Saat create, buat juga stok_gudang dengan stok_kg = 0
    //  Fields: nama, slug, deskripsi, harga_per_kg, satuan, ikon, aktif
    // ══════════════════════════════════════════

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:kategori_sampah,slug',
            'deskripsi'   => 'nullable|string',
            'harga_per_kg' => 'required|numeric|min:0',
            'satuan'      => 'nullable|string|max:50',
            'ikon'        => 'nullable|image|max:2048',
            'aktif'       => 'required|boolean',
        ]);

        // Auto-generate slug dari nama jika kosong
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['nama']);
            // Pastikan unique
            $original = $validated['slug'];
            $count = 1;
            while (KategoriSampah::where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = $original . '-' . $count++;
            }
        }

        // Default satuan
        if (empty($validated['satuan'])) {
            $validated['satuan'] = 'kg';
        }

        // Handle ikon upload
        if ($request->hasFile('ikon')) {
            $validated['ikon'] = $request->file('ikon')->store('kategori-sampah', 'public');
        }

        DB::transaction(function () use ($validated) {
            $kategori = KategoriSampah::create($validated);

            // Buat stok_gudang otomatis dengan stok_kg = 0
            StokGudang::create([
                'kategori_sampah_id' => $kategori->id,
                'stok_kg' => 0,
                'total_masuk' => 0,
                'total_keluar' => 0,
            ]);
        });

        return redirect()->route('admin.master-data.kategori-sampah')
            ->with('success', 'Kategori sampah berhasil ditambahkan.');
    }

    // ══════════════════════════════════════════
    //  UPDATE — Edit Kategori Sampah
    // ══════════════════════════════════════════

    public function update(Request $request, KategoriSampah $kategoriSampah)
    {
        $validated = $request->validate([
            'nama'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:kategori_sampah,slug,' . $kategoriSampah->id,
            'deskripsi'   => 'nullable|string',
            'harga_per_kg' => 'required|numeric|min:0',
            'satuan'      => 'nullable|string|max:50',
            'ikon'        => 'nullable|image|max:2048',
            'aktif'       => 'required|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['nama']);
            $original = $validated['slug'];
            $count = 1;
            while (KategoriSampah::where('slug', $validated['slug'])->where('id', '!=', $kategoriSampah->id)->exists()) {
                $validated['slug'] = $original . '-' . $count++;
            }
        }

        if (empty($validated['satuan'])) {
            $validated['satuan'] = 'kg';
        }

        if ($request->hasFile('ikon')) {
            if ($kategoriSampah->ikon && Storage::disk('public')->exists($kategoriSampah->ikon)) {
                Storage::disk('public')->delete($kategoriSampah->ikon);
            }
            $validated['ikon'] = $request->file('ikon')->store('kategori-sampah', 'public');
        }

        $kategoriSampah->update($validated);

        return redirect()->route('admin.master-data.kategori-sampah')
            ->with('success', 'Kategori sampah berhasil diperbarui.');
    }

    // ══════════════════════════════════════════
    //  DESTROY — Soft delete via aktif = false
    //  Ada FK dari pesanan/detail, jadi set aktif = false
    // ══════════════════════════════════════════

    public function destroy(KategoriSampah $kategoriSampah)
    {
        $kategoriSampah->update(['aktif' => false]);

        return redirect()->route('admin.master-data.kategori-sampah')
            ->with('success', 'Kategori sampah telah dinonaktifkan.');
    }
}

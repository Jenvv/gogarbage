<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hadiah;
use App\Models\KlaimHadiah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HadiahController extends Controller
{
    // ══════════════════════════════════════════
    //  INDEX — Katalog Hadiah + Klaim Hadiah Masuk
    // ══════════════════════════════════════════

    public function index()
    {
        $hadiah = Hadiah::latest()->get();

        $klaim = KlaimHadiah::with(['pengguna', 'hadiah', 'pemroses'])
            ->latest()
            ->get();

        return view('admin.hadiah.index', compact('hadiah', 'klaim'));
    }

    // ══════════════════════════════════════════
    //  STORE — Tambah Hadiah baru
    //  Fields: nama, deskripsi, biaya_poin, stok, gambar, tipe, aktif
    // ══════════════════════════════════════════

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'deskripsi'  => 'nullable|string',
            'biaya_poin' => 'required|integer|min:1',
            'stok'       => 'required|integer|min:0',
            'gambar'     => 'nullable|image|max:2048',
            'tipe'       => 'required|in:voucher,fisik,lainnya',
            'aktif'      => 'required|boolean',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('hadiah', 'public');
        }

        Hadiah::create($validated);

        return redirect()->route('admin.hadiah')
            ->with('success', 'Hadiah berhasil ditambahkan.');
    }

    // ══════════════════════════════════════════
    //  UPDATE — Edit Hadiah
    // ══════════════════════════════════════════

    public function update(Request $request, Hadiah $hadiah)
    {
        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'deskripsi'  => 'nullable|string',
            'biaya_poin' => 'required|integer|min:1',
            'stok'       => 'required|integer|min:0',
            'gambar'     => 'nullable|image|max:2048',
            'tipe'       => 'required|in:voucher,fisik,lainnya',
            'aktif'      => 'required|boolean',
        ]);

        if ($request->hasFile('gambar')) {
            if ($hadiah->gambar && Storage::disk('public')->exists($hadiah->gambar)) {
                Storage::disk('public')->delete($hadiah->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('hadiah', 'public');
        }

        $hadiah->update($validated);

        return redirect()->route('admin.hadiah')
            ->with('success', 'Hadiah berhasil diperbarui.');
    }

    // ══════════════════════════════════════════
    //  DESTROY — Hapus Hadiah
    // ══════════════════════════════════════════

    public function destroy(Hadiah $hadiah)
    {
        if ($hadiah->gambar && Storage::disk('public')->exists($hadiah->gambar)) {
            Storage::disk('public')->delete($hadiah->gambar);
        }

        $hadiah->delete();

        return redirect()->route('admin.hadiah')
            ->with('success', 'Hadiah berhasil dihapus.');
    }

    // ══════════════════════════════════════════
    //  PROSES KLAIM HADIAH
    //  Side effects:
    //    disetujui → kurangi hadiah.stok
    //    ditolak   → kembalikan users.poin sebesar poin_digunakan
    //    dikirim   → update status saja
    // ══════════════════════════════════════════

    public function prosesKlaim(Request $request, KlaimHadiah $klaim)
    {
        $request->validate([
            'status'  => 'required|in:disetujui,dikirim,ditolak',
            'catatan' => [
                'required_if:status,ditolak',
                'nullable',
                'string',
                \Illuminate\Validation\Rule::in([
                    'Stok hadiah fisik habis / tidak tersedia',
                    'Indikasi transaksi mencurigakan / kecurangan poin',
                    'Kesalahan sistem / data poin tidak sinkron',
                    'Penukaran kategori reward ini sedang ditangguhkan',
                    'Voucher digital tidak dapat diterbitkan saat ini'
                ])
            ],
        ]);

        $newStatus = $request->status;

        DB::transaction(function () use ($klaim, $newStatus, $request) {
            if ($newStatus === 'disetujui') {
                // Kurangi stok hadiah
                $hadiah = $klaim->hadiah;
                if ($hadiah->stok > 0) {
                    $hadiah->decrement('stok');
                }
            } elseif ($newStatus === 'ditolak') {
                // Kembalikan poin user
                $user = $klaim->pengguna;
                $user->increment('poin', $klaim->poin_digunakan);
            }
            // dikirim → hanya update status

            $klaim->status = $newStatus;
            $klaim->diproses_oleh = $request->user()->id;
            $klaim->diproses_pada = now();
            if ($request->filled('catatan')) {
                $klaim->catatan = $request->catatan;
            }
            $klaim->save();
        });

        return redirect()->route('admin.hadiah')
            ->with('success', 'Klaim hadiah berhasil diproses.');
    }
}

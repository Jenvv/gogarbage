<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Hadiah;
use App\Models\KlaimHadiah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KlaimController extends Controller
{
    /**
     * Tampilkan halaman katalog reward dan riwayat klaim poin.
     */
    public function index()
    {
        $poin = auth()->user()->poin;

        // Hadiah yang aktif
        $hadiah = Hadiah::aktif()->latest()->get();

        // Riwayat penukaran milik pengguna yang login
        $riwayat = KlaimHadiah::with('hadiah')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('pelanggan.klaim.index', compact('poin', 'hadiah', 'riwayat'));
    }

    /**
     * Simpan pengajuan penukaran poin.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hadiah_id' => 'required|exists:hadiah,id',
        ]);

        $hadiah = Hadiah::findOrFail($request->hadiah_id);

        if (!$hadiah->aktif) {
            return back()->with('error', 'Reward ini sudah tidak aktif.');
        }

        // Jika tipe bukan voucher, pastikan stok mencukupi
        if ($hadiah->tipe !== 'voucher' && $hadiah->stok <= 0) {
            return back()->with('error', 'Stok hadiah ini sedang habis.');
        }

        /** @var User $user */
        $user = auth()->user();

        if ($user->poin < $hadiah->biaya_poin) {
            return back()->with('error', 'Poin Anda tidak mencukupi untuk melakukan penukaran ini.');
        }

        $isDonasi = stripos($hadiah->nama, 'donasi') !== false;

        DB::transaction(function () use ($user, $hadiah, $isDonasi) {
            // 1. Kurangi poin user
            $user->decrement('poin', $hadiah->biaya_poin);

            // 2. Buat klaim baru
            KlaimHadiah::create([
                'user_id' => $user->id,
                'hadiah_id' => $hadiah->id,
                'poin_digunakan' => $hadiah->biaya_poin,
                'status' => $isDonasi ? 'disetujui' : 'menunggu',
                'diproses_pada' => $isDonasi ? now() : null,
                'catatan' => $isDonasi ? 'Disetujui otomatis oleh sistem (Donasi)' : null,
            ]);

            // Jika donasi, kurangi stok hadiah jika ada
            if ($isDonasi && $hadiah->stok > 0) {
                $hadiah->decrement('stok');
            }
        });

        $message = $isDonasi
            ? 'Donasi berhasil disalurkan! Terima kasih banyak atas kebaikan Anda.'
            : $hadiah->nama . ' berhasil diajukan! Admin akan segera mengonfirmasi klaim Anda.';

        return back()->with('success_claim', $message);
    }
}

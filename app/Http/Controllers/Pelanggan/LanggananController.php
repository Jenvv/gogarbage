<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Langganan;
use App\Models\Paket;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LanggananController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil semua paket yang aktif
        $paketList = Paket::where('aktif', true)->get();

        // Cek langganan aktif user
        $langgananAktif = $user ? $user->langgananAktif() : null;

        return view('pelanggan.langganan.index', compact(
            'paketList',
            'langgananAktif'
        ));
    }

    // User berlangganan paket baru.
    // Insert ke tabel langganan + transaksi dalam DB::transaction.
    public function store(Request $request)
    {
        $request->validate([
            'paket_id' => 'required|exists:paket,id',
        ]);

        $user = Auth::user();

        // Cek apakah user sudah punya langganan aktif
        $langgananAktif = $user->langgananAktif();
        if ($langgananAktif) {
            return back()->withErrors([
                'langganan' => 'Kamu sudah memiliki langganan aktif (' . $langgananAktif->paket->nama . '). Tunggu sampai berakhir untuk berlangganan lagi.'
            ]);
        }

        $paket = Paket::where('aktif', true)->findOrFail($request->paket_id);

        DB::transaction(function () use ($user, $paket) {

            // 1. Insert ke tabel langganan
            $langganan = Langganan::create([
                'user_id'            => $user->id,
                'paket_id'           => $paket->id,
                'status'             => 'aktif',
                'metode_pembayaran'  => 'tunai',
                'jumlah_bayar'       => $paket->harga,
                'tanggal_mulai'      => now()->toDateString(),
                'tanggal_selesai'    => now()->addDays($paket->durasi_hari)->toDateString(),
                'disetujui_pada'     => now(),
            ]);

            // 2. Insert ke tabel transaksi (record pembayaran langganan)
            Transaksi::create([
                'nomor_transaksi' => 'TRX-' . now()->format('Ymd') . '-' . str_pad(
                    Transaksi::whereDate('created_at', today())->count() + 1,
                    4,
                    '0',
                    STR_PAD_LEFT
                ),
                'user_id'        => $user->id,
                'tipe'           => 'keluar',
                'jumlah'         => $paket->harga,
                'saldo_sebelum'  => $user->saldo,
                'saldo_sesudah'  => $user->saldo,
                'status'         => 'selesai',
                'referensi_type' => Langganan::class,
                'referensi_id'   => $langganan->id,
                'deskripsi'      => 'Berlangganan ' . $paket->nama,
            ]);
        });

        return redirect()
            ->route('pelanggan.langganan')
            ->with('success', 'Berhasil berlangganan ' . $paket->nama . '!');
    }
}

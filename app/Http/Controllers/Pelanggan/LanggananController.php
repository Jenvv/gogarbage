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

        // Cek langganan menunggu (transfer/tunai belum disetujui)
        $langgananMenunggu = $user ? Langganan::where('user_id', $user->id)
            ->whereIn('status', ['menunggu', 'menunggu_tunai'])
            ->with('paket')
            ->latest()
            ->first() : null;

        $saldoUser = $user ? $user->saldo : 0;

        return view('pelanggan.langganan.index', compact(
            'paketList',
            'langgananAktif',
            'langgananMenunggu',
            'saldoUser'
        ));
    }

    // User berlangganan paket baru.
    public function store(Request $request)
    {
        $request->validate([
            'paket_id' => 'required|exists:paket,id',
            'metode_pembayaran' => 'required|in:tunai,saldo,transfer',
            'bukti_pembayaran' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        // Cek apakah user sudah punya langganan aktif atau menunggu
        $langgananAktif = $user->langgananAktif();
        if ($langgananAktif) {
            return back()->withErrors([
                'langganan' => 'Kamu sudah memiliki langganan aktif (' . $langgananAktif->paket->nama . ').'
            ]);
        }

        $langgananMenunggu = Langganan::where('user_id', $user->id)
            ->whereIn('status', ['menunggu', 'menunggu_tunai'])
            ->first();
        if ($langgananMenunggu) {
            return back()->withErrors([
                'langganan' => 'Kamu masih memiliki langganan yang sedang menunggu konfirmasi.'
            ]);
        }

        $paket = Paket::where('aktif', true)->findOrFail($request->paket_id);
        $metodeInput = $request->metode_pembayaran;

        // Validasi saldo
        if ($metodeInput === 'saldo' && $user->saldo < $paket->harga) {
            return back()->withErrors([
                'saldo' => 'Saldo kamu tidak mencukupi untuk berlangganan paket ini.'
            ]);
        }

        // Validasi bukti transfer
        if ($metodeInput === 'transfer' && !$request->hasFile('bukti_pembayaran')) {
            return back()->withErrors([
                'bukti_pembayaran' => 'Bukti transfer wajib diupload jika memilih metode Transfer Bank.'
            ]);
        }

        // Handle file upload
        $buktiPath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        DB::transaction(function () use ($user, $paket, $metodeInput, $buktiPath) {
            $saldoSebelum = $user->saldo;

            if ($metodeInput === 'saldo') {
                $user->update(['saldo' => $user->saldo - $paket->harga]);
            }

            $saldoSesudah = $user->saldo;

            // Status berdasarkan metode:
            // saldo → langsung aktif
            // transfer → menunggu (admin verifikasi bukti)
            // tunai → menunggu_tunai (juru angkut konfirmasi, lalu admin setujui)
            $statusLangganan = match ($metodeInput) {
                'saldo' => 'aktif',
                'transfer' => 'menunggu',
                'tunai' => 'menunggu_tunai',
            };

            // 1. Insert ke tabel langganan
            $langganan = Langganan::create([
                'user_id'            => $user->id,
                'paket_id'           => $paket->id,
                'status'             => $statusLangganan,
                'metode_pembayaran'  => $metodeInput,
                'bukti_pembayaran'   => $buktiPath,
                'jumlah_bayar'       => $paket->harga,
                'tanggal_mulai'      => $metodeInput === 'saldo' ? now()->toDateString() : null,
                'tanggal_selesai'    => $metodeInput === 'saldo' ? now()->addDays($paket->durasi_hari)->toDateString() : null,
                'disetujui_pada'     => $metodeInput === 'saldo' ? now() : null,
                'catatan'            => match ($metodeInput) {
                    'saldo' => 'Dibayar menggunakan Saldo GoGarbage',
                    'transfer' => 'Menunggu verifikasi admin (Transfer Bank)',
                    'tunai' => 'Menunggu konfirmasi tunai oleh juru angkut',
                },
            ]);

            // 2. Insert ke tabel transaksi
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
                'saldo_sebelum'  => $saldoSebelum,
                'saldo_sesudah'  => $saldoSesudah,
                'status'         => $metodeInput === 'saldo' ? 'selesai' : 'menunggu',
                'referensi_type' => Langganan::class,
                'referensi_id'   => $langganan->id,
                'deskripsi'      => 'Berlangganan ' . $paket->nama . ' via ' . ucfirst($metodeInput),
            ]);
        });

        $successMsg = match ($metodeInput) {
            'saldo' => 'Berhasil berlangganan ' . $paket->nama . '! Saldo telah dipotong.',
            'transfer' => 'Bukti transfer terkirim. Langganan akan aktif setelah diverifikasi admin.',
            'tunai' => 'Permintaan langganan terkirim. Silakan bayar tunai ke juru angkut saat penjemputan.',
        };

        return redirect()
            ->route('pelanggan.langganan')
            ->with('success', $successMsg);
    }

    /**
     * Batalkan langganan yang belum aktif (menunggu / menunggu_tunai).
     */
    public function batalkan($id)
    {
        $user = Auth::user();

        $langganan = Langganan::where('id', $id)
            ->where('user_id', $user->id)
            ->whereIn('status', ['menunggu', 'menunggu_tunai'])
            ->firstOrFail();

        DB::transaction(function () use ($user, $langganan) {
            // Jika metode saldo, kembalikan saldo
            if ($langganan->metode_pembayaran === 'saldo') {
                $user->update(['saldo' => $user->saldo + $langganan->jumlah_bayar]);
            }

            // Update status langganan
            $langganan->update([
                'status' => 'dibatalkan',
                'catatan' => 'Dibatalkan oleh pelanggan pada ' . now()->format('d M Y H:i'),
            ]);

            // Update transaksi terkait
            Transaksi::where('referensi_type', Langganan::class)
                ->where('referensi_id', $langganan->id)
                ->where('status', 'menunggu')
                ->update(['status' => 'dibatalkan']);
        });

        $refundMsg = $langganan->metode_pembayaran === 'saldo'
            ? ' Saldo sebesar Rp ' . number_format($langganan->jumlah_bayar, 0, ',', '.') . ' telah dikembalikan.'
            : '';

        return redirect()
            ->route('pelanggan.langganan')
            ->with('success', 'Langganan berhasil dibatalkan.' . $refundMsg);
    }
}

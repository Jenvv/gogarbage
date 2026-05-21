<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\TopUp;
use App\Models\Penarikan;
use App\Models\Transaksi;
use App\Models\RekeningUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DompetController extends Controller
{
    /**
     * Halaman utama dompet — saldo + riwayat transaksi
     */
    public function index()
    {
        $user = Auth::user();

        // Rekening utama user (untuk penarikan)
        $rekening = RekeningUser::where('user_id', $user->id)
            ->where('is_utama', true)
            ->first();

        // Gabungkan riwayat: Top Up + Penarikan + Transaksi
        $topUps = TopUp::where('user_id', $user->id)
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'id' => 'TU' . str_pad($item->id, 3, '0', STR_PAD_LEFT),
                    'db_id' => $item->id,
                    'type' => 'topup',
                    'title' => 'Top Up Saldo',
                    'date' => $item->created_at->format('d M Y'),
                    'date_raw' => $item->created_at,
                    'amount' => '+Rp ' . number_format($item->jumlah, 0, ',', '.'),
                    'amount_raw' => $item->jumlah,
                    'status' => $item->status === 'menunggu' ? 'pending' : ($item->status === 'disetujui' ? 'success' : 'rejected'),
                    'status_label' => $item->status,
                    'method' => $item->metode_pembayaran,
                    'bukti' => $item->bukti_pembayaran,
                    'alasan_penolakan' => $item->alasan_penolakan,
                ];
            });

        $penarikanList = Penarikan::where('user_id', $user->id)
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'id' => 'TK' . str_pad($item->id, 3, '0', STR_PAD_LEFT),
                    'db_id' => $item->id,
                    'type' => 'expense',
                    'title' => 'Penarikan ke ' . ($item->nama_bank ?? 'Bank'),
                    'date' => $item->created_at->format('d M Y'),
                    'date_raw' => $item->created_at,
                    'amount' => '-Rp ' . number_format($item->jumlah, 0, ',', '.'),
                    'amount_raw' => $item->jumlah,
                    'status' => $item->status === 'menunggu' ? 'pending' : ($item->status === 'disetujui' || $item->status === 'selesai' ? 'success' : 'rejected'),
                    'status_label' => $item->status,
                    'method' => ($item->nama_bank ?? '') . ' — ' . $item->nomor_rekening,
                    'bukti' => null,
                    'alasan_penolakan' => $item->alasan_penolakan,
                ];
            });

        // Transaksi lain (masuk dari pesanan, komisi, koreksi)
        $transaksiLain = Transaksi::where('user_id', $user->id)
            ->whereIn('tipe', ['masuk', 'komisi', 'koreksi'])
            ->latest()
            ->get()
            ->map(function ($item) {
                $isKoreksi = $item->tipe === 'koreksi';
                $isPositif = $item->saldo_sesudah >= $item->saldo_sebelum;
                return [
                    'id' => $item->nomor_transaksi,
                    'db_id' => $item->id,
                    'type' => $isKoreksi ? ($isPositif ? 'income' : 'expense') : 'income',
                    'title' => $item->deskripsi ?? ($isKoreksi ? 'Koreksi Saldo Admin' : 'Pendapatan Sampah'),
                    'date' => $item->created_at->format('d M Y'),
                    'date_raw' => $item->created_at,
                    'amount' => ($isPositif ? '+' : '-') . 'Rp ' . number_format($item->jumlah, 0, ',', '.'),
                    'amount_raw' => $item->jumlah,
                    'status' => 'success',
                    'status_label' => $item->status,
                    'method' => 'Saldo GoGarbage',
                    'bukti' => null,
                    'alasan_penolakan' => null,
                ];
            });

        // Gabung dan sort by tanggal terbaru
        $riwayat = $topUps->concat($penarikanList)->concat($transaksiLain)
            ->sortByDesc('date_raw')
            ->values();

        return view('pelanggan.dompet.index', compact('user', 'rekening', 'riwayat'));
    }

    /**
     * Simpan rekening user (buat/update)
     */
    public function simpanRekening(Request $request)
    {
        $request->validate([
            'nama_bank' => 'required|string|max:100',
            'nomor_rekening' => 'required|string|max:50',
            'nama_rekening' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        // Set semua rekening user ke bukan utama
        RekeningUser::where('user_id', $user->id)->update(['is_utama' => false]);

        // Buat atau update rekening utama
        RekeningUser::updateOrCreate(
            ['user_id' => $user->id, 'is_utama' => true],
            [
                'nama_bank' => $request->nama_bank,
                'nomor_rekening' => $request->nomor_rekening,
                'nama_rekening' => $request->nama_rekening,
                'is_utama' => true,
            ]
        );

        return redirect()->route('pelanggan.dompet')->with('success', 'Rekening berhasil disimpan');
    }

    /**
     * Proses request Top Up
     */
    public function topUp(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:10000',
            'metode_pembayaran' => 'required|string|max:100',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $user = Auth::user();

        $path = $request->file('bukti_pembayaran')->store('bukti_topup', 'public');

        TopUp::create([
            'user_id' => $user->id,
            'jumlah' => $request->jumlah,
            'metode_pembayaran' => $request->metode_pembayaran,
            'bukti_pembayaran' => $path,
            'status' => 'menunggu',
        ]);

        return redirect()->route('pelanggan.dompet')->with('success', 'Request top up berhasil dikirim. Menunggu konfirmasi admin.');
    }

    /**
     * Proses request Penarikan Saldo
     */
    public function tarikSaldo(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'jumlah' => 'required|numeric|min:10000|max:' . $user->saldo,
        ]);

        // Ambil rekening utama
        $rekening = RekeningUser::where('user_id', $user->id)
            ->where('is_utama', true)
            ->first();

        if (!$rekening) {
            return redirect()->route('pelanggan.dompet')
                ->with('error', 'Silakan tambahkan rekening terlebih dahulu sebelum melakukan penarikan.');
        }

        Penarikan::create([
            'user_id' => $user->id,
            'jumlah' => $request->jumlah,
            'metode' => 'transfer_bank',
            'nama_rekening' => $rekening->nama_rekening,
            'nomor_rekening' => $rekening->nomor_rekening,
            'nama_bank' => $rekening->nama_bank,
            'status' => 'menunggu',
        ]);

        return redirect()->route('pelanggan.dompet')
            ->with('success', 'Permintaan penarikan saldo berhasil dikirim. Menunggu persetujuan admin.');
    }
}

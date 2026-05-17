<?php

namespace App\Http\Controllers\JuruAngkut;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\KategoriSampah;
use App\Models\Pesanan;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * List semua order masuk (status = menunggu).
     */
    public function index()
    {
        $orders = Pesanan::with(['pengguna', 'detailPesanan.kategoriSampah'])
            ->where('status', 'menunggu')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('juru_angkut.order.index', compact('orders'));
    }

    /**
     * Detail order tertentu.
     */
    public function show($id)
    {
        $pesanan = Pesanan::with(['pengguna', 'detailPesanan.kategoriSampah'])
            ->findOrFail($id);

        return view('juru_angkut.order.detail_order', compact('pesanan'));
    }

    /**
     * Terima / Klaim order.
     */
    public function terima($id)
    {
        $user = Auth::user();

        $pesanan = Pesanan::findOrFail($id);

        // Pastikan status masih menunggu
        if ($pesanan->status !== 'menunggu') {
            return back()->withErrors(['order' => 'Order ini sudah diklaim oleh pengangkut lain.']);
        }

        $pesanan->update([
            'status'        => 'diklaim',
            'pengangkut_id' => $user ? $user->id : null,
            'diklaim_pada'  => now(),
        ]);

        return redirect()->route('juru-angkut.order.proses-jemput', $pesanan->id)
            ->with('success', 'Order berhasil diterima!');
    }

    /**
     * Tolak order (kembalikan ke status menunggu / batal).
     */
    public function tolak($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        if ($pesanan->status !== 'menunggu') {
            return back()->withErrors(['order' => 'Order ini tidak bisa ditolak.']);
        }

        // Untuk saat ini, tolak = dibatalkan
        $pesanan->update([
            'status' => 'dibatalkan',
        ]);

        return redirect()->route('juru-angkut.order.index')
            ->with('success', 'Order telah ditolak.');
    }

    /**
     * Halaman proses jemput (form input berat per kategori sampah).
     */
    public function prosesJemput($id)
    {
        $pesanan = Pesanan::with(['pengguna', 'detailPesanan.kategoriSampah'])
            ->findOrFail($id);

        // Pastikan order dalam status diklaim atau dalam_perjalanan
        if (!in_array($pesanan->status, ['diklaim', 'dalam_perjalanan', 'tiba', 'penimbangan'])) {
            return redirect()->route('juru-angkut.order.index')
                ->withErrors(['order' => 'Order ini belum diklaim atau sudah selesai.']);
        }

        return view('juru_angkut.order.proses_jemput', compact('pesanan'));
    }

    /**
     * Update status order via AJAX.
     */
    public function updateStatus(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $request->validate(['status' => 'required|string']);

        $pesanan->update([
            'status' => $request->status,
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Simpan hasil timbangan dan selesaikan order.
     */
    public function selesaikanOrder(Request $request, $id)
    {
        $pesanan = Pesanan::with(['pengguna', 'detailPesanan.kategoriSampah'])
            ->findOrFail($id);

        $request->validate([
            'trash_items' => 'required|string',
            'harga_manual' => 'nullable|numeric|min:0',
        ]);

        $pesanan = DB::transaction(function () use ($pesanan, $request) {
            $totalBerat = 0;
            $totalPendapatan = 0;

            // Hitung subtotal anorganik manual jika ada
            $hargaManual = $request->input('harga_manual');

            $trashItems = json_decode($request->input('trash_items'), true);
            if (!is_array($trashItems)) {
                $trashItems = [];
            }

            // Hapus detail lama, kita replace dengan hasil timbangan real dari Jasa Angkut
            $pesanan->detailPesanan()->delete();

            // Update berat per detail pesanan
            foreach ($trashItems as $item) {
                $berat = floatval($item['kg'] ?? 0);
                $jenis = $item['jenis'] ?? ''; // Nama kategori (Organik, Anorganik, dll)

                $kategori = \App\Models\KategoriSampah::where('nama', $jenis)->first();
                $harga_per_kg = $kategori ? $kategori->harga_per_kg : 0;
                $kategori_id = $kategori ? $kategori->id : null;

                // Gunakan harga manual jika ada dan jenisnya anorganik
                if ($hargaManual !== null && strcasecmp($jenis, 'Anorganik') === 0) {
                    $subtotal = $hargaManual;
                } else {
                    $subtotal = $berat * $harga_per_kg;
                }

                $pesanan->detailPesanan()->create([
                    'kategori_sampah_id' => $kategori_id,
                    'berat'    => $berat,
                    'harga_per_kg' => $harga_per_kg,
                    'subtotal' => $subtotal,
                ]);

                $totalBerat += $berat;
                $totalPendapatan += $subtotal;
            }

            // Hitung poin (1kg = 10 poin, 1x order = 5 poin)
            $poinBerat = (int) ($totalBerat * 10);
            $poinOrder = 5;
            $totalPoin = $poinBerat + $poinOrder;

            // Hitung bagi hasil (70% pengangkut, 30% perusahaan dari biaya_jemput)
            $komisi = $pesanan->biaya_jemput * 0.70;
            $perusahaan = $pesanan->biaya_jemput * 0.30;

            // Update pesanan
            $pesanan->update([
                'status'             => 'selesai',
                'total_berat'        => $totalBerat,
                'total_pendapatan'   => $totalPendapatan,
                'poin_didapat'       => $totalPoin,
                'komisi_pengangkut'  => $komisi,
                'bagian_perusahaan'  => $perusahaan,
                'diselesaikan_pada'  => now(),
            ]);

            // Update saldo & poin pengguna
            if ($pesanan->pengguna) {
                $userPelanggan = $pesanan->pengguna;
                $saldoSebelum = $userPelanggan->saldo;
                $saldoSesudah = $saldoSebelum + $totalPendapatan;

                $userPelanggan->update([
                    'saldo' => $saldoSesudah,
                    'poin'  => $userPelanggan->poin + $totalPoin,
                ]);

                // Transaksi saldo masuk untuk pelanggan
                if ($totalPendapatan > 0) {
                    Transaksi::create([
                        'nomor_transaksi' => 'TRX-' . now()->format('Ymd') . '-' . str_pad(
                            Transaksi::whereDate('created_at', today())->count() + 1,
                            4,
                            '0',
                            STR_PAD_LEFT
                        ),
                        'user_id'        => $userPelanggan->id,
                        'tipe'           => 'masuk',
                        'jumlah'         => $totalPendapatan,
                        'saldo_sebelum'  => $saldoSebelum,
                        'saldo_sesudah'  => $saldoSesudah,
                        'status'         => 'selesai',
                        'referensi_type' => Pesanan::class,
                        'referensi_id'   => $pesanan->id,
                        'deskripsi'      => 'Pendapatan dari penjualan sampah pesanan ' . $pesanan->nomor_pesanan,
                    ]);
                }
            }

            return $pesanan;
        });

        if ($pesanan->total_pendapatan > 0) {
            return redirect()->route('juru-angkut.order.pembayaran-berhasil', $pesanan->id)
                ->with('success', 'Order berhasil diselesaikan dan pembayaran dicatat!');
        }

        return redirect()->route('juru-angkut.order.selesai', $pesanan->id)
            ->with('success', 'Order berhasil diselesaikan!');
    }

    /**
     * Halaman order selesai (sukses).
     */
    public function orderSelesai($id)
    {
        $pesanan = Pesanan::with(['pengguna', 'detailPesanan.kategoriSampah'])
            ->findOrFail($id);

        return view('juru_angkut.order.order_selesai', compact('pesanan'));
    }

    /**
     * Halaman pembayaran berhasil.
     */
    public function pembayaranBerhasil($id)
    {
        $pesanan = Pesanan::with(['pengguna', 'detailPesanan.kategoriSampah'])
            ->findOrFail($id);

        return view('juru_angkut.order.pembayaran_berhasil', compact('pesanan'));
    }

    /**
     * List langganan yang menunggu pembayaran tunai.
     */
    public function langgananTunai()
    {
        $langgananTunai = \App\Models\Langganan::where('status', 'menunggu_tunai')
            ->where('metode_pembayaran', 'tunai')
            ->with(['pengguna', 'paket'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('juru_angkut.order.langganan_tunai', compact('langgananTunai'));
    }

    /**
     * Konfirmasi bahwa tunai sudah diterima dari pelanggan.
     * Status berubah dari menunggu_tunai → menunggu (menunggu approval admin).
     */
    public function konfirmasiTunai($id)
    {
        $langganan = \App\Models\Langganan::where('status', 'menunggu_tunai')
            ->findOrFail($id);

        $langganan->update([
            'status' => 'menunggu',
            'catatan' => 'Tunai telah diterima oleh juru angkut (' . Auth::user()->name . '), menunggu persetujuan admin.',
        ]);

        return redirect()
            ->route('juru-angkut.langganan-tunai')
            ->with('success', 'Pembayaran tunai untuk ' . ($langganan->pengguna->name ?? 'Pelanggan') . ' berhasil dikonfirmasi.');
    }
}

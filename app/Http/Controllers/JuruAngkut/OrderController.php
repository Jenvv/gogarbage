<?php

namespace App\Http\Controllers\JuruAngkut;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\KategoriSampah;
use App\Models\Konfigurasi;
use App\Models\Pesanan;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * List semua order masuk (status = menunggu, tanggal jemput hari ini).
     * Order untuk tanggal mendatang akan masuk ke menu Jadwal.
     */
    public function index()
    {
        $orders = Pesanan::with(['pengguna', 'detailPesanan.kategoriSampah'])
            ->where('status', 'menunggu')
            ->whereDate('tanggal_jemput', '<=', today())
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

        // Cegah terima order jika tanggal jemput masih di masa depan
        if ($pesanan->tanggal_jemput && $pesanan->tanggal_jemput->isFuture()) {
            return back()->withErrors(['order' => 'Order ini dijadwalkan untuk tanggal ' . $pesanan->tanggal_jemput->format('d M Y') . '. Silakan tunggu hingga hari tersebut untuk menerima order.']);
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
            'metode_pembayaran_pelanggan' => 'nullable|in:tunai,saldo',
        ]);

        // Server-side: cek apakah ada anorganik, jika ya maka harga_manual & metode wajib diisi
        $trashItemsRaw = json_decode($request->input('trash_items'), true);
        $hasAnorganik = false;
        if (is_array($trashItemsRaw)) {
            foreach ($trashItemsRaw as $item) {
                if (strcasecmp($item['jenis'] ?? '', 'Anorganik') === 0) {
                    $hasAnorganik = true;
                    break;
                }
            }
        }

        if ($hasAnorganik) {
            $request->validate([
                'harga_manual' => 'required|numeric|min:1',
                'metode_pembayaran_pelanggan' => 'required|in:tunai,saldo',
            ], [
                'harga_manual.required' => 'Harga pembelian anorganik wajib diisi.',
                'harga_manual.min' => 'Harga pembelian anorganik harus lebih dari 0.',
                'metode_pembayaran_pelanggan.required' => 'Metode pembayaran ke pelanggan wajib dipilih.',
            ]);
        }

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

            // Update berat per detail pesanan & Tambahkan ke Stok Gudang
            foreach ($trashItems as $item) {
                $berat = floatval($item['kg'] ?? 0);
                $jenis = $item['jenis'] ?? ''; // Nama kategori (Organik, Anorganik, dll)

                $kategori = \App\Models\KategoriSampah::where('nama', $jenis)->first();
                $kategori_id = $kategori ? $kategori->id : null;

                // Untuk anorganik: JANGAN gunakan harga_per_kg dari database (itu khusus pengepul)
                // Gunakan harga manual yang diinput oleh juru angkut
                if (strcasecmp($jenis, 'Anorganik') === 0) {
                    $subtotal = $hargaManual !== null ? floatval($hargaManual) : 0;
                    $harga_per_kg_simpan = 0; // harga_per_kg di DB khusus pengepul, jadi simpan 0
                } else {
                    $harga_per_kg_simpan = $kategori ? $kategori->harga_per_kg : 0;
                    $subtotal = $berat * $harga_per_kg_simpan;
                }

                $pesanan->detailPesanan()->create([
                    'kategori_sampah_id' => $kategori_id,
                    'berat'    => $berat,
                    'harga_per_kg' => $harga_per_kg_simpan,
                    'subtotal' => $subtotal,
                ]);

                // OTO-UPDATE STOK GUDANG
                if ($kategori_id && $berat > 0) {
                    $stok = \App\Models\StokGudang::firstOrCreate(
                        ['kategori_sampah_id' => $kategori_id],
                        ['stok_kg' => 0, 'total_masuk' => 0, 'total_keluar' => 0]
                    );

                    $stokSebelum = $stok->stok_kg;
                    $stokSesudah = $stokSebelum + $berat;

                    $stok->update([
                        'stok_kg' => $stokSesudah,
                        'total_masuk' => $stok->total_masuk + $berat,
                    ]);

                    \App\Models\LogStokGudang::create([
                        'stok_gudang_id' => $stok->id,
                        'kategori_sampah_id' => $kategori_id,
                        'tipe' => 'masuk',
                        'jumlah_kg' => $berat,
                        'stok_sebelum' => $stokSebelum,
                        'stok_sesudah' => $stokSesudah,
                        'sumber_type' => Pesanan::class,
                        'sumber_id' => $pesanan->id,
                        'deskripsi' => 'Penambahan otomatis dari pesanan #' . $pesanan->nomor_pesanan,
                        'dibuat_oleh' => Auth::id(), // Juru Angkut
                    ]);
                }

                $totalBerat += $berat;
                $totalPendapatan += $subtotal;
            }

            // Hitung poin dari konfigurasi (dynamic)
            $poinPerKg = (int) Konfigurasi::getValue('poin_per_kg', 10);
            $poinPerOrder = (int) Konfigurasi::getValue('poin_per_order', 5);
            $poinBerat = (int) ($totalBerat * $poinPerKg);
            $totalPoin = $poinBerat + $poinPerOrder;

            // Bagi hasil: untuk pesanan reguler, admin dapat komisi persentase dari biaya jemput
            if ($pesanan->tipe_pesanan === 'reguler') {
                $komisiPersen = (float) Konfigurasi::getValue('komisi_admin_persen', 10);
                $biayaJemput = (float) $pesanan->biaya_jemput;
                $perusahaan = round($biayaJemput * ($komisiPersen / 100), 2);
                $komisi = $biayaJemput - $perusahaan; // sisa untuk juru angkut
            } else {
                // Langganan: ongkir subsidi penuh ke juru angkut, admin 0
                $komisi = $pesanan->ongkir_juru_angkut;
                $perusahaan = 0;
            }

            // Metode pembayaran ke pelanggan
            $metodePembayaranPelanggan = $request->input('metode_pembayaran_pelanggan');

            // Update pesanan
            $pesanan->update([
                'status'             => 'selesai',
                'total_berat'        => $totalBerat,
                'total_pendapatan'   => $totalPendapatan,
                'poin_didapat'       => $totalPoin,
                'komisi_pengangkut'  => $komisi,
                'bagian_perusahaan'  => $perusahaan,
                'metode_pembayaran_pelanggan' => $metodePembayaranPelanggan,
                'diselesaikan_pada'  => now(),
            ]);

            // Update poin pengguna (selalu, terlepas metode pembayaran)
            if ($pesanan->pengguna) {
                $userPelanggan = $pesanan->pengguna;

                // Poin selalu ditambahkan
                $userPelanggan->update([
                    'poin' => $userPelanggan->poin + $totalPoin,
                ]);

                // Saldo hanya ditambahkan jika metode = saldo
                if ($totalPendapatan > 0 && $metodePembayaranPelanggan === 'saldo') {
                    $saldoSebelum = $userPelanggan->saldo;
                    $saldoSesudah = $saldoSebelum + $totalPendapatan;

                    $userPelanggan->update([
                        'saldo' => $saldoSesudah,
                    ]);

                    // Transaksi saldo masuk untuk pelanggan
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
                        'deskripsi'      => 'Pendapatan dari penjualan sampah pesanan ' . $pesanan->nomor_pesanan . ' (via Saldo)',
                    ]);
                }
                // Jika tunai: tidak ada perubahan saldo, tidak buat transaksi
            }

            // Subsidi ongkir untuk pesanan langganan → tambah saldo juru angkut
            if ($pesanan->tipe_pesanan === 'langganan' && $komisi > 0) {
                $juruAngkut = Auth::user();
                $saldoSebelumJA = $juruAngkut->saldo;
                $saldoSesudahJA = $saldoSebelumJA + $komisi;

                $juruAngkut->update(['saldo' => $saldoSesudahJA]);

                Transaksi::create([
                    'nomor_transaksi' => 'SUB-' . now()->format('Ymd') . '-' . str_pad(
                        Transaksi::whereDate('created_at', today())->count() + 1,
                        4,
                        '0',
                        STR_PAD_LEFT
                    ),
                    'user_id'        => $juruAngkut->id,
                    'tipe'           => 'masuk',
                    'jumlah'         => $komisi,
                    'saldo_sebelum'  => $saldoSebelumJA,
                    'saldo_sesudah'  => $saldoSesudahJA,
                    'status'         => 'selesai',
                    'referensi_type' => Pesanan::class,
                    'referensi_id'   => $pesanan->id,
                    'deskripsi'      => 'Subsidi ongkir dari langganan pesanan ' . $pesanan->nomor_pesanan . ' (jarak: ' . $pesanan->jarak_km . ' KM)',
                ]);
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

}

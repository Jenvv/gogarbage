<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PenjualanPengepul;
use App\Models\DetailPenjualanPengepul;
use App\Models\StokGudang;
use App\Models\KategoriSampah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransaksiPengepulController extends Controller
{
    /**
     * Halaman utama — tab request masuk + riwayat transaksi
     */
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'request');

        $bulanIni = now()->startOfMonth();

        // ── Request masuk (menunggu + disetujui) ──
        $requestMasuk = PenjualanPengepul::whereIn('status', ['menunggu', 'disetujui'])
            ->with(['pembeli', 'detail.kategori'])
            ->latest()
            ->get();

        // ── Riwayat transaksi (selesai + ditolak) ──
        $riwayat = PenjualanPengepul::whereIn('status', ['selesai', 'ditolak'])
            ->with(['pembeli', 'admin', 'detail.kategori'])
            ->latest()
            ->get();

        // ── Summary cards ──
        $queryBulanIni = PenjualanPengepul::where('status', 'selesai')
            ->where('created_at', '>=', $bulanIni);

        $totalTransaksi   = (clone $queryBulanIni)->count();
        $totalBerat       = (clone $queryBulanIni)->sum('total_berat');
        $totalPendapatan  = (clone $queryBulanIni)->sum('total_harga');

        // ── Badge counts ──
        $countMenunggu  = PenjualanPengepul::where('status', 'menunggu')->count();
        $countDisetujui = PenjualanPengepul::where('status', 'disetujui')->count();

        // ── Kategori untuk form manual ──
        $kategori = KategoriSampah::aktif()->with('stokGudang')->orderBy('nama')->get();

        // ── Daftar pengepul untuk dropdown ──
        $pengepul = User::where('role', 'pengepul')->orderBy('name')->get();

        return view('admin.transaksi_pengepul.index', compact(
            'tab',
            'requestMasuk',
            'riwayat',
            'totalTransaksi',
            'totalBerat',
            'totalPendapatan',
            'countMenunggu',
            'countDisetujui',
            'kategori',
            'pengepul'
        ));
    }

    /**
     * Setujui request pengepul
     */
    public function approve($id)
    {
        $penjualan = PenjualanPengepul::where('status', 'menunggu')->findOrFail($id);

        $penjualan->update([
            'status'   => 'disetujui',
            'admin_id' => Auth::id(),
        ]);

        return redirect()->route('admin.transaksi-pengepul', ['tab' => 'request'])
            ->with('success', "Request {$penjualan->nomor_invoice} telah disetujui.");
    }

    /**
     * Tolak request pengepul
     */
    public function reject($id)
    {
        $penjualan = PenjualanPengepul::where('status', 'menunggu')->findOrFail($id);

        $penjualan->update([
            'status'   => 'ditolak',
            'admin_id' => Auth::id(),
        ]);

        return redirect()->route('admin.transaksi-pengepul', ['tab' => 'request'])
            ->with('success', "Request {$penjualan->nomor_invoice} telah ditolak.");
    }

    /**
     * Selesaikan transaksi — potong stok gudang + tandai lunas
     */
    public function complete($id)
    {
        $penjualan = PenjualanPengepul::where('status', 'disetujui')
            ->with('detail')
            ->findOrFail($id);

        try {
            DB::transaction(function () use ($penjualan) {
                // Potong stok gudang per kategori
                foreach ($penjualan->detail as $detail) {
                    $stok = StokGudang::where('kategori_sampah_id', $detail->kategori_sampah_id)->first();

                    if ($stok) {
                        $stokSebelum = (float) $stok->stok_kg;
                        $stokSesudah = $stokSebelum - $detail->berat;

                        $stok->update([
                            'stok_kg' => $stokSesudah,
                            'total_keluar' => ($stok->total_keluar ?? 0) + $detail->berat,
                        ]);

                        \App\Models\LogStokGudang::create([
                            'stok_gudang_id' => $stok->id,
                            'kategori_sampah_id' => $detail->kategori_sampah_id,
                            'tipe' => 'keluar',
                            'jumlah_kg' => $detail->berat,
                            'stok_sebelum' => $stokSebelum,
                            'stok_sesudah' => $stokSesudah,
                            'sumber_type' => PenjualanPengepul::class,
                            'sumber_id' => $penjualan->id,
                            'deskripsi' => 'Pengurangan stok otomatis dari transaksi pengepul (Invoice: #' . $penjualan->nomor_invoice . ')',
                            'dibuat_oleh' => Auth::id(),
                        ]);
                    }
                }

                // Update status penjualan
                $penjualan->update([
                    'status'            => 'selesai',
                    'status_pembayaran' => 'lunas',
                    'admin_id'          => Auth::id(),
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Complete transaksi pengepul failed: ' . $e->getMessage());

            return redirect()->route('admin.transaksi-pengepul', ['tab' => 'request'])
                ->with('error', 'Gagal menyelesaikan transaksi. ' . $e->getMessage());
        }

        return redirect()->route('admin.transaksi-pengepul', ['tab' => 'riwayat'])
            ->with('success', "Transaksi {$penjualan->nomor_invoice} selesai. Stok gudang dan log mutasi telah diperbarui.");
    }

    /**
     * Buat penjualan manual oleh admin (pengepul datang langsung ke gudang)
     */
    public function store(Request $request)
    {
        $request->validate([
            'pembeli_id'        => 'required|exists:users,id',
            'metode_pembayaran' => 'required|in:tunai,transfer',
            'status_pembayaran' => 'required|in:belum_bayar,lunas',
            'catatan'           => 'nullable|string|max:500',
            'items'             => 'required|array|min:1',
            'items.*.kategori_sampah_id' => 'required|exists:kategori_sampah,id',
            'items.*.berat'     => 'required|numeric|min:0.01|max:10000',
            'items.*.harga_per_kg' => 'required|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $totalBerat = 0;
                $totalHarga = 0;
                $details = [];

                // Hitung total dan siapkan detail
                foreach ($request->items as $item) {
                    $berat = (float) $item['berat'];
                    $harga = (float) $item['harga_per_kg'];
                    $subtotal = $berat * $harga;

                    $totalBerat += $berat;
                    $totalHarga += $subtotal;

                    $details[] = [
                        'kategori_sampah_id' => $item['kategori_sampah_id'],
                        'berat'              => $berat,
                        'harga_per_kg'       => $harga,
                        'subtotal'           => $subtotal,
                    ];
                }

                // Buat penjualan — langsung selesai karena admin yang buat
                $penjualan = PenjualanPengepul::create([
                    'nomor_invoice'     => PenjualanPengepul::generateNomorInvoice(),
                    'pembeli_id'        => $request->pembeli_id,
                    'admin_id'          => Auth::id(),
                    'total_berat'       => $totalBerat,
                    'total_harga'       => $totalHarga,
                    'metode_pembayaran' => $request->metode_pembayaran,
                    'status_pembayaran' => $request->status_pembayaran,
                    'status'            => 'selesai',
                    'catatan'           => $request->catatan,
                ]);

                // Buat detail items
                foreach ($details as $d) {
                    $penjualan->detail()->create($d);
                }

                // Potong stok gudang
                foreach ($details as $d) {
                    $stok = StokGudang::where('kategori_sampah_id', $d['kategori_sampah_id'])->first();
                    if ($stok) {
                        $stokSebelum = (float) $stok->stok_kg;
                        $stokSesudah = $stokSebelum - $d['berat'];

                        $stok->update([
                            'stok_kg' => $stokSesudah,
                            'total_keluar' => ($stok->total_keluar ?? 0) + $d['berat'],
                        ]);

                        \App\Models\LogStokGudang::create([
                            'stok_gudang_id' => $stok->id,
                            'kategori_sampah_id' => $d['kategori_sampah_id'],
                            'tipe' => 'keluar',
                            'jumlah_kg' => $d['berat'],
                            'stok_sebelum' => $stokSebelum,
                            'stok_sesudah' => $stokSesudah,
                            'sumber_type' => PenjualanPengepul::class,
                            'sumber_id' => $penjualan->id,
                            'deskripsi' => 'Pengurangan stok manual dari penjualan admin langsung (Invoice: #' . $penjualan->nomor_invoice . ')',
                            'dibuat_oleh' => Auth::id(),
                        ]);
                    }
                }
            });
        } catch (\Exception $e) {
            Log::error('Store penjualan pengepul failed: ' . $e->getMessage());

            return redirect()->route('admin.transaksi-pengepul', ['tab' => 'riwayat'])
                ->with('error', 'Gagal menyimpan penjualan: ' . $e->getMessage());
        }

        return redirect()->route('admin.transaksi-pengepul', ['tab' => 'riwayat'])
            ->with('success', 'Penjualan berhasil disimpan. Stok gudang dan log mutasi telah diperbarui.');
    }
}

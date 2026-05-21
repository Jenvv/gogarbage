<?php

namespace App\Http\Controllers\Pengepul;

use App\Http\Controllers\Controller;
use App\Models\DetailPenjualanPengepul;
use App\Models\KategoriSampah;
use App\Models\PenjualanPengepul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RequestController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $filter = $request->query('status', 'semua');

        // Validasi filter agar tidak bisa inject status sembarang
        $allowedFilters = ['semua', 'menunggu', 'disetujui', 'selesai', 'ditolak'];
        if (!in_array($filter, $allowedFilters)) {
            $filter = 'semua';
        }

        $query = PenjualanPengepul::where('pembeli_id', $user->id)
            ->with('detail.kategori')
            ->latest();

        if ($filter !== 'semua') {
            $query->where('status', $filter);
        }

        $requests = $query->get();

        // Hitung per status untuk tab badges (single optimized query)
        $statusCounts = PenjualanPengepul::where('pembeli_id', $user->id)
            ->selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN status = 'menunggu' THEN 1 ELSE 0 END) as menunggu,
                SUM(CASE WHEN status = 'disetujui' THEN 1 ELSE 0 END) as disetujui,
                SUM(CASE WHEN status = 'selesai' THEN 1 ELSE 0 END) as selesai,
                SUM(CASE WHEN status = 'ditolak' THEN 1 ELSE 0 END) as ditolak
            ")
            ->first();

        $countAll      = (int) ($statusCounts->total ?? 0);
        $countMenunggu = (int) ($statusCounts->menunggu ?? 0);
        $countDisetujui = (int) ($statusCounts->disetujui ?? 0);
        $countSelesai  = (int) ($statusCounts->selesai ?? 0);
        $countDitolak  = (int) ($statusCounts->ditolak ?? 0);

        // Kategori untuk form request baru
        $kategori = KategoriSampah::aktif()->with('stokGudang')->orderBy('nama')->get();

        return view('pengepul.request_sampah.index', compact(
            'requests',
            'filter',
            'countAll',
            'countMenunggu',
            'countDisetujui',
            'countSelesai',
            'countDitolak',
            'kategori'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items'             => 'required|array|min:1',
            'items.*.kategori_sampah_id' => 'required|exists:kategori_sampah,id',
            'items.*.berat'     => 'required|numeric|min:0.1|max:10000',
            'catatan'           => 'nullable|string|max:500',
        ], [
            'items.required'    => 'Tambahkan minimal 1 item sampah.',
            'items.*.berat.min' => 'Berat minimal 0.1 kg.',
            'items.*.berat.max' => 'Berat maksimal 10.000 kg.',
            'items.*.kategori_sampah_id.exists' => 'Kategori sampah tidak valid.',
        ]);

        $user = Auth::user();

        try {
            DB::transaction(function () use ($request, $user) {
                // Pre-fetch semua kategori yang dibutuhkan dalam satu query
                $kategoriIds = collect($request->items)->pluck('kategori_sampah_id')->unique();
                $kategoriMap = KategoriSampah::whereIn('id', $kategoriIds)->get()->keyBy('id');

                $totalBerat = 0;
                $totalHarga = 0;
                $details = [];

                // Hitung estimasi total & siapkan detail rows
                foreach ($request->items as $item) {
                    $kategoriId = $item['kategori_sampah_id'];
                    $kategori = $kategoriMap->get($kategoriId);

                    if (!$kategori) {
                        throw new \Exception("Kategori sampah ID {$kategoriId} tidak ditemukan.");
                    }

                    $berat = (float) $item['berat'];
                    $harga = (float) $kategori->harga_per_kg;
                    $totalBerat += $berat;
                    $totalHarga += $berat * $harga;

                    $details[] = [
                        'kategori_sampah_id' => $kategoriId,
                        'berat'              => $berat,
                        'harga_per_kg'       => $harga,
                        'subtotal'           => $berat * $harga,
                    ];
                }

                $penjualan = PenjualanPengepul::create([
                    'nomor_invoice'     => PenjualanPengepul::generateNomorInvoice(),
                    'pembeli_id'        => $user->id,
                    'admin_id'          => $user->id, // Placeholder, admin akan update saat proses
                    'total_berat'       => $totalBerat,
                    'total_harga'       => $totalHarga,
                    'status'            => 'menunggu',
                    'status_pembayaran' => 'belum_bayar',
                    'metode_pembayaran' => 'tunai',
                    'catatan'           => $request->catatan,
                ]);

                // Batch insert detail rows
                foreach ($details as $detail) {
                    DetailPenjualanPengepul::create(array_merge($detail, [
                        'penjualan_pengepul_id' => $penjualan->id,
                    ]));
                }
            });
        } catch (\Exception $e) {
            Log::error('Pengepul request store failed: ' . $e->getMessage());

            return redirect()->route('pengepul.request')
                ->with('error', 'Gagal membuat request. Silakan coba lagi.');
        }

        return redirect()->route('pengepul.request')
            ->with('success', 'Request berhasil dikirim! Menunggu persetujuan admin.');
    }
}

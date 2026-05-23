<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;

class PesananController extends Controller
{
    /**
     * Display a listing of the pesanan for admin monitoring.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = Pesanan::with(['pengguna', 'pengangkut', 'detailPesanan.kategoriSampah']);
        if ($status) {
            $query->where('status', $status);
        }

        $pesanan = $query->orderByDesc('created_at')->get();

        return view('admin.pesanan.index', compact('pesanan'));
    }

    /**
     * Admin cancels a pesanan.
     */
    public function batalkan(Request $request, Pesanan $pesanan)
    {
        // Guard: hanya pesanan yang belum selesai/dibatalkan yang bisa dibatalkan
        if (in_array($pesanan->status, ['selesai', 'dibatalkan'])) {
            return redirect()->back()->with('error', 'Pesanan yang sudah selesai atau dibatalkan tidak bisa dibatalkan lagi.');
        }

        $request->validate([
            'alasan_pembatalan' => 'required|string|max:500',
        ], [
            'alasan_pembatalan.required' => 'Alasan pembatalan wajib diisi.',
        ]);

        $pesanan->update([
            'status' => 'dibatalkan',
            'alasan_pembatalan' => $request->alasan_pembatalan,
        ]);

        return redirect()->back()->with('success', 'Pesanan ' . $pesanan->nomor_pesanan . ' berhasil dibatalkan.');
    }

    /**
     * Admin verifies payment or updates status.
     */
    public function verifikasi(Request $request, Pesanan $pesanan)
    {
        $data = $request->validate([
            'status' => 'required|in:menunggu,diklaim,dalam_perjalanan,tiba,penimbangan,selesai,dibatalkan',
            'catatan' => 'nullable|string',
        ]);

        $pesanan->status = $data['status'];
        if ($data['status'] === 'selesai') {
            $pesanan->diselesaikan_pada = now();
        }
        if (isset($data['catatan'])) {
            $pesanan->catatan = $data['catatan'];
        }
        $pesanan->save();

        return redirect()->back()->with('success', 'Status pesanan diperbarui.');
    }
}

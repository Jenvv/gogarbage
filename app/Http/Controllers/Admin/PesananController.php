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

        $query = Pesanan::with(['pengguna', 'pengangkut', 'detailPesanan']);
        if ($status) {
            $query->where('status', $status);
        }

        $pesanan = $query->orderByDesc('created_at')->limit(50)->get();

        if ($request->ajax() || $request->wantsJson()) {
            $data = $pesanan->map(function ($p) {
                return [
                    'id' => $p->id,
                    'nomor_pesanan' => $p->nomor_pesanan,
                    'pengguna' => $p->pengguna->name ?? '-',
                    'pengangkut' => $p->pengangkut->name ?? '-',
                    'tanggal_jemput' => $p->tanggal_jemput ? $p->tanggal_jemput->format('d M Y') : $p->created_at->format('d M Y'),
                    'tipe_pesanan' => ucfirst($p->tipe_pesanan),
                    'total_berat' => number_format($p->total_berat ?? ($p->detailPesanan->sum('berat') ?? 0), 2),
                    'status' => ucfirst(str_replace('_', ' ', $p->status)),
                    'batalkan_url' => route('admin.pesanan.batalkan', $p),
                ];
            });

            return response()->json(['data' => $data]);
        }

        return view('admin.pesanan.index', compact('pesanan'));
    }

    /**
     * Admin cancels a pesanan.
     */
    public function batalkan(Request $request, Pesanan $pesanan)
    {
        $pesanan->status = 'dibatalkan';
        $pesanan->save();

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
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

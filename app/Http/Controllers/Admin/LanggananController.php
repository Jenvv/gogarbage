<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Langganan;
use App\Models\Paket;

use Illuminate\Support\Facades\Auth;

class LanggananController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = Langganan::with(['pengguna', 'paket', 'disetujuiOleh']);
        if ($status) {
            $query->where('status', $status);
        }

        $langganan = $query->orderByDesc('created_at')->limit(50)->get();

        // Summary counts
        $countMenunggu = Langganan::whereIn('status', ['menunggu', 'menunggu_tunai'])->count();
        $countAktif = Langganan::where('status', 'aktif')->count();
        $countDibatalkan = Langganan::where('status', 'dibatalkan')->count();

        if ($request->ajax() || $request->wantsJson()) {
            $data = $langganan->map(function ($l) {
                return [
                    'id' => $l->id,
                    'pelanggan' => $l->pengguna->name ?? '-',
                    'paket' => $l->paket->nama ?? '-',
                    'metode' => $l->metode_pembayaran,
                    'jumlah' => number_format($l->jumlah_bayar, 0, ',', '.'),
                    'status' => $l->status,
                    'bukti_url' => $l->bukti_pembayaran ? asset($l->bukti_pembayaran) : null,
                    'setujui_url' => route('admin.langganan.setujui', $l),
                    'tolak_url' => route('admin.langganan.tolak', $l),
                ];
            });

            return response()->json([
                'data' => $data,
                'counts' => [
                    'menunggu' => $countMenunggu,
                    'aktif' => $countAktif,
                    'dibatalkan' => $countDibatalkan,
                ],
            ]);
        }

        return view('admin.langganan.index', compact('langganan', 'countMenunggu', 'countAktif', 'countDibatalkan'));
    }

    public function setujui(Request $request, Langganan $langganan)
    {
        // set tanggal mulai hari ini and tanggal selesai berdasarkan paket.durasi_hari
        $paket = $langganan->paket;
        $langganan->status = 'aktif';
        $langganan->tanggal_mulai = now()->toDateString();
        $langganan->tanggal_selesai = $paket && $paket->durasi_hari ? now()->addDays($paket->durasi_hari)->toDateString() : null;
        $langganan->disetujui_pada = now();
        $langganan->disetujui_oleh = Auth::id();
        $langganan->save();

        return redirect()->back()->with('success', 'Langganan disetujui.');
    }

    public function tolak(Request $request, Langganan $langganan)
    {
        $data = $request->validate(['catatan' => 'nullable|string']);
        $langganan->status = 'dibatalkan';
        if (!empty($data['catatan'])) $langganan->catatan = $data['catatan'];
        $langganan->save();

        return redirect()->back()->with('success', 'Langganan ditolak.');
    }

    // ══════════════════════════════════════════
    //  PAKET LANGGANAN — CRUD
    //  Fields: nama, deskripsi, harga, durasi_hari, frekuensi_jemput,
    //          satuan_frekuensi, info_tong, biaya_jemput,
    //          persentase_bagi_hasil, aktif
    // ══════════════════════════════════════════

    public function paketIndex()
    {
        $paket = Paket::latest()->get();

        return view('admin.master_data.paket', compact('paket'));
    }

    public function storePaket(Request $request)
    {
        $validated = $request->validate([
            'nama'                  => 'required|string|max:255',
            'deskripsi'             => 'nullable|string',
            'harga'                 => 'required|numeric|min:0',
            'durasi_hari'           => 'required|integer|min:1',
            'frekuensi_jemput'      => 'required|integer|min:1',
            'satuan_frekuensi'      => 'required|in:minggu,bulan',
            'info_tong'             => 'nullable|string|max:255',
            'biaya_jemput'          => 'nullable|numeric|min:0',
            'persentase_bagi_hasil' => 'nullable|numeric|min:0|max:100',
            'aktif'                 => 'required|boolean',
        ]);

        // Defaults
        $validated['biaya_jemput'] = $validated['biaya_jemput'] ?? 0;
        $validated['persentase_bagi_hasil'] = $validated['persentase_bagi_hasil'] ?? 100;

        Paket::create($validated);

        return redirect()->route('admin.master-data.paket')
            ->with('success', 'Paket langganan berhasil ditambahkan.');
    }

    public function updatePaket(Request $request, Paket $paket)
    {
        $validated = $request->validate([
            'nama'                  => 'required|string|max:255',
            'deskripsi'             => 'nullable|string',
            'harga'                 => 'required|numeric|min:0',
            'durasi_hari'           => 'required|integer|min:1',
            'frekuensi_jemput'      => 'required|integer|min:1',
            'satuan_frekuensi'      => 'required|in:minggu,bulan',
            'info_tong'             => 'nullable|string|max:255',
            'biaya_jemput'          => 'nullable|numeric|min:0',
            'persentase_bagi_hasil' => 'nullable|numeric|min:0|max:100',
            'aktif'                 => 'required|boolean',
        ]);

        $validated['biaya_jemput'] = $validated['biaya_jemput'] ?? 0;
        $validated['persentase_bagi_hasil'] = $validated['persentase_bagi_hasil'] ?? 100;

        $paket->update($validated);

        return redirect()->route('admin.master-data.paket')
            ->with('success', 'Paket langganan berhasil diperbarui.');
    }

    public function destroyPaket(Paket $paket)
    {
        $paket->update(['aktif' => false]);

        return redirect()->route('admin.master-data.paket')
            ->with('success', 'Paket langganan telah dinonaktifkan.');
    }
}

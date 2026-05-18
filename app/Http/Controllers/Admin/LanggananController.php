<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Langganan;

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
}

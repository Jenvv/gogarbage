<?php

namespace App\Http\Controllers\JuruAngkut;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    /**
     * Tampilkan riwayat order yang sudah selesai.
     */
    public function index()
    {
        $user = Auth::user();

        $orders = Pesanan::with(['pengguna', 'detailPesanan.kategoriSampah'])
            ->where('status', 'selesai')
            ->when($user, function ($query) use ($user) {
                $query->where('pengangkut_id', $user->id);
            })
            ->orderBy('diselesaikan_pada', 'desc')
            ->get();

        return view('juru_angkut.riwayat.index', compact('orders'));
    }
}

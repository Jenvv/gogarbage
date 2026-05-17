<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerandaController extends Controller
{
    public function index()
    {
        $aktivitas = Pesanan::where('user_id', Auth::id())
            ->with('detailPesanan.kategoriSampah')
            ->latest()
            ->limit(4)
            ->get();

        return view('pelanggan.index', compact('aktivitas'));
    }
}

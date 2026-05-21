<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard.index');
    }

    public function pesanan()
    {
        return view('admin.pesanan.index');
    }

    public function langganan()
    {
        return view('admin.langganan.index');
    }

    public function stok()
    {
        return view('admin.stok.index');
    }

    public function transaksiPengepul()
    {
        return view('admin.transaksi_pengepul.index');
    }
}

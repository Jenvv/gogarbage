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

    public function pelanggan()
    {
        return view('admin.pengguna.pelanggan');
    }

    public function juruAngkut()
    {
        return view('admin.pengguna.juru_angkut');
    }

    public function pengepul()
    {
        return view('admin.pengguna.pengepul');
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

    public function keuangan()
    {
        return view('admin.keuangan.index');
    }

    public function hadiah()
    {
        return view('admin.hadiah.index');
    }

    public function kategoriSampah()
    {
        return view('admin.master_data.kategori_sampah');
    }

    public function paket()
    {
        return view('admin.master_data.paket');
    }
}

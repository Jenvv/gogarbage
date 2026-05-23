<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Konfigurasi;
use Illuminate\Http\Request;

class KonfigurasiController extends Controller
{
    public function index()
    {
        $configs = Konfigurasi::orderBy('id')->get();
        return view('admin.konfigurasi.index', compact('configs'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'biaya_jemput'             => 'required|numeric|min:0',
            'poin_per_kg'              => 'required|numeric|min:0',
            'poin_per_order'           => 'required|numeric|min:0',
            'komisi_pengangkut_persen' => 'required|numeric|min:0|max:100',
        ]);

        Konfigurasi::setValue('biaya_jemput', $request->biaya_jemput);
        Konfigurasi::setValue('poin_per_kg', $request->poin_per_kg);
        Konfigurasi::setValue('poin_per_order', $request->poin_per_order);
        Konfigurasi::setValue('komisi_pengangkut_persen', $request->komisi_pengangkut_persen);

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}

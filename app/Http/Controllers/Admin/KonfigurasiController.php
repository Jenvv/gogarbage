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
            'ongkir_base_fee'      => 'required|numeric|min:0',
            'ongkir_per_km'        => 'required|numeric|min:0',
            'biaya_admin_reguler'  => 'required|numeric|min:0',
            'poin_per_kg'          => 'required|numeric|min:0',
            'poin_per_order'       => 'required|numeric|min:0',
            'lat_bank_sampah'      => 'required|numeric',
            'lon_bank_sampah'      => 'required|numeric',
        ]);

        Konfigurasi::setValue('ongkir_base_fee', $request->ongkir_base_fee);
        Konfigurasi::setValue('ongkir_per_km', $request->ongkir_per_km);
        Konfigurasi::setValue('biaya_admin_reguler', $request->biaya_admin_reguler);
        Konfigurasi::setValue('poin_per_kg', $request->poin_per_kg);
        Konfigurasi::setValue('poin_per_order', $request->poin_per_order);
        Konfigurasi::setValue('lat_bank_sampah', $request->lat_bank_sampah);
        Konfigurasi::setValue('lon_bank_sampah', $request->lon_bank_sampah);

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}

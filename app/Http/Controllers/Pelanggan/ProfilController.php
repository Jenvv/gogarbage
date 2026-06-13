<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('pelanggan.profil.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:1000',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->name = $request->name;
        $user->telepon = $request->telepon;
        $user->alamat = $request->alamat;

        if ($request->filled('latitude') && $request->filled('longitude')) {
            $user->latitude = $request->latitude;
            $user->longitude = $request->longitude;
        }

        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }
            $path = $request->file('foto')->store('profil', 'public');
            $user->foto = $path;
        }

        $user->save();

        return redirect()->route('pelanggan.profil')->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * Halaman wajib isi alamat (untuk pelanggan yang belum set lokasi).
     */
    public function setAlamat()
    {
        $user = Auth::user();
        return view('pelanggan.profil.set_alamat', compact('user'));
    }

    /**
     * Simpan alamat wajib.
     */
    public function simpanAlamat(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string|max:1000',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ], [
            'alamat.required' => 'Alamat wajib diisi.',
            'latitude.required' => 'Silakan pilih lokasi dari peta.',
            'longitude.required' => 'Silakan pilih lokasi dari peta.',
        ]);

        $user = Auth::user();
        $user->alamat = $request->alamat;
        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->save();

        return redirect()->route('pelanggan.index')->with('success', 'Alamat berhasil disimpan!');
    }
}

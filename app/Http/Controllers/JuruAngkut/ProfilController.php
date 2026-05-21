<?php

namespace App\Http\Controllers\JuruAngkut;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Pesanan;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistik untuk JA
        $totalOrder = Pesanan::where('pengangkut_id', $user->id)
            ->where('status', 'selesai')
            ->count();

        $totalKomisi = Pesanan::where('pengangkut_id', $user->id)
            ->where('status', 'selesai')
            ->sum('komisi_pengangkut');

        return view('juru_angkut.profil.index', compact('user', 'totalOrder', 'totalKomisi'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:1000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->name = $request->name;
        $user->telepon = $request->telepon;
        $user->alamat = $request->alamat;

        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }
            $path = $request->file('foto')->store('profil', 'public');
            $user->foto = $path;
        }

        $user->save();

        return redirect()->route('juru-angkut.profil')->with('success', 'Profil berhasil diperbarui');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PenjualanPengepul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PenggunaController extends Controller
{
    // ══════════════════════════════════════════
    //  PELANGGAN (read-only list)
    //  Tidak ada form tambah — pelanggan mendaftar sendiri.
    //  Kolom tampil: Nama, Email, Telepon, Saldo, Poin
    // ══════════════════════════════════════════

    public function pelanggan()
    {
        $pelanggan = User::where('role', 'pengguna')
            ->orderBy('name')
            ->get();

        return view('admin.pengguna.pelanggan', compact('pelanggan'));
    }

    // ══════════════════════════════════════════
    //  JURU ANGKUT — CRUD
    //  INSERT users dengan role = juru_angkut
    //  Fields: name, email, password, telepon, alamat, foto
    // ══════════════════════════════════════════

    public function juruAngkut()
    {
        $juruAngkut = User::where('role', 'juru_angkut')
            ->withCount('pesananSebagaiPengangkut as total_order')
            ->orderBy('name')
            ->get();

        return view('admin.pengguna.juru_angkut', compact('juruAngkut'));
    }

    /**
     * Store a new Juru Angkut.
     */
    public function storeJuruAngkut(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'telepon'  => 'nullable|string|max:20',
            'alamat'   => 'nullable|string',
            'foto'     => 'nullable|image|max:2048',
        ]);

        $validated['role'] = 'juru_angkut';
        $validated['password'] = Hash::make($validated['password']);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('foto-pengguna', 'public');
        }

        User::create($validated);

        return redirect()->route('admin.pengguna.juru-angkut')
            ->with('success', 'Juru angkut berhasil ditambahkan.');
    }

    /**
     * Update an existing Juru Angkut.
     */
    public function updateJuruAngkut(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'telepon'  => 'nullable|string|max:20',
            'alamat'   => 'nullable|string',
            'foto'     => 'nullable|image|max:2048',
        ]);

        // Password: optional; kosong = tidak diubah
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }
            $validated['foto'] = $request->file('foto')->store('foto-pengguna', 'public');
        }

        $user->update($validated);

        return redirect()->route('admin.pengguna.juru-angkut')
            ->with('success', 'Data juru angkut berhasil diperbarui.');
    }

    /**
     * Delete a Juru Angkut.
     */
    public function destroyJuruAngkut(User $user)
    {
        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
        }

        $user->delete();

        return redirect()->route('admin.pengguna.juru-angkut')
            ->with('success', 'Juru angkut berhasil dihapus.');
    }

    // ══════════════════════════════════════════
    //  PENGEPUL — CRUD
    //  Form identik dengan Juru Angkut, kecuali role = pengepul
    //  Tampilan list: + Total Transaksi (COUNT penjualan_pengepul)
    //                 + Total Berat (SUM penjualan_pengepul.total_berat)
    // ══════════════════════════════════════════

    public function pengepul()
    {
        $pengepul = User::where('role', 'pengepul')
            ->withCount('penjualanSebagaiPembeli as total_transaksi')
            ->withSum('penjualanSebagaiPembeli as total_berat', 'total_berat')
            ->orderBy('name')
            ->get();

        return view('admin.pengguna.pengepul', compact('pengepul'));
    }

    /**
     * Store a new Pengepul.
     */
    public function storePengepul(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'telepon'  => 'nullable|string|max:20',
            'alamat'   => 'nullable|string',
            'foto'     => 'nullable|image|max:2048',
        ]);

        $validated['role'] = 'pengepul';
        $validated['password'] = Hash::make($validated['password']);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('foto-pengguna', 'public');
        }

        User::create($validated);

        return redirect()->route('admin.pengguna.pengepul')
            ->with('success', 'Pengepul berhasil ditambahkan.');
    }

    /**
     * Update an existing Pengepul.
     */
    public function updatePengepul(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'telepon'  => 'nullable|string|max:20',
            'alamat'   => 'nullable|string',
            'foto'     => 'nullable|image|max:2048',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }
            $validated['foto'] = $request->file('foto')->store('foto-pengguna', 'public');
        }

        $user->update($validated);

        return redirect()->route('admin.pengguna.pengepul')
            ->with('success', 'Data pengepul berhasil diperbarui.');
    }

    /**
     * Delete a Pengepul.
     */
    public function destroyPengepul(User $user)
    {
        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
        }

        $user->delete();

        return redirect()->route('admin.pengguna.pengepul')
            ->with('success', 'Pengepul berhasil dihapus.');
    }
}

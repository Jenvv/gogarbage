<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAlamatSet
{
    /**
     * Pelanggan wajib punya alamat + koordinat sebelum bisa akses fitur.
     * Redirect ke halaman set-alamat jika belum diisi.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (
            $user &&
            $user->role === 'pengguna' &&
            (!$user->alamat || !$user->latitude || !$user->longitude)
        ) {
            // Jangan redirect jika sudah di halaman set-alamat atau profil
            $allowedRoutes = [
                'pelanggan.set-alamat',
                'pelanggan.simpan-alamat',
                'pelanggan.profil',
                'pelanggan.profil.update',
                'logout',
            ];

            if (!in_array($request->route()?->getName(), $allowedRoutes)) {
                return redirect()->route('pelanggan.set-alamat');
            }
        }

        return $next($request);
    }
}

<?php

namespace App\Providers;

use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share active order for Pelanggan homepage only (floating transaction bar)
        View::composer('pelanggan.index', function ($view) {
            if (Auth::check()) {
                $pesananAktif = Pesanan::where('user_id', Auth::id())
                    ->whereNotIn('status', ['selesai', 'dibatalkan'])
                    ->latest()
                    ->first();
                $view->with('pesananAktif', $pesananAktif);
            }
        });

        // Share active order for Juru Angkut homepage only (floating transaction bar)
        View::composer('juru_angkut.index', function ($view) {
            if (Auth::check()) {
                $orderAktifJA = Pesanan::where('pengangkut_id', Auth::id())
                    ->whereNotIn('status', ['selesai', 'dibatalkan', 'menunggu'])
                    ->with('pengguna')
                    ->latest()
                    ->first();
                $view->with('orderAktifJA', $orderAktifJA);
            }
        });
    }
}


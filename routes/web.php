<?php

use App\Http\Controllers\Pelanggan\BerandaController;
use App\Http\Controllers\Pelanggan\JemputSampahController;
use App\Http\Controllers\Pelanggan\LanggananController;
use App\Http\Controllers\Pelanggan\RiwayatController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


// Pelanggan (sementara tanpa middleware auth agar bisa diakses saat development)
Route::get('/pelanggan', [BerandaController::class, 'index'])->name('pelanggan.index');

// Jemput Sampah
Route::get('/pelanggan/jemput-sampah', [JemputSampahController::class, 'index'])->name('pelanggan.jemput-sampah');
Route::post('/pelanggan/jemput-sampah', [JemputSampahController::class, 'store'])->name('pelanggan.jemput-sampah.store');
Route::get('/pelanggan/jemput-sampah/konfirmasi', [JemputSampahController::class, 'konfirmasi_pesanan'])->name('pelanggan.konfirmasi-pesanan');
Route::post('/pelanggan/jemput-sampah/confirm', [JemputSampahController::class, 'confirm_pesanan'])->name('pelanggan.confirm-pesanan');
Route::get('/pelanggan/jemput-sampah/{id}/sukses', [JemputSampahController::class, 'order_sukses'])->name('pelanggan.order-sukses');
Route::get('/pelanggan/jemput-sampah/{id}/tracking', [JemputSampahController::class, 'tracking_pesanan'])->name('pelanggan.tracking-pesanan');

Route::get('/pelanggan/riwayat', [RiwayatController::class, 'index'])->name('pelanggan.riwayat');
Route::get('/pelanggan/langganan', [LanggananController::class, 'index'])->name('pelanggan.langganan');
Route::post('/pelanggan/langganan', [LanggananController::class, 'store'])->name('pelanggan.langganan.store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

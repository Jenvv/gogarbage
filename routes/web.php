<?php

use App\Http\Controllers\JasaAngkut\DashboardController as JasaAngkutDashboardController;
use App\Http\Controllers\JasaAngkut\OrderController as JasaAngkutOrderController;
use App\Http\Controllers\JasaAngkut\RiwayatController as JasaAngkutRiwayatController;
use App\Http\Controllers\Pelanggan\BerandaController;
use App\Http\Controllers\Pelanggan\JemputSampahController;
use App\Http\Controllers\Pelanggan\LanggananController;
use App\Http\Controllers\Pelanggan\RiwayatController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


// Pelanggan (sementare tanpa middleware auth agar bisa diakses saat development)
Route::get('/pelanggan', [BerandaController::class, 'index'])->name('pelanggan.index');

// Pelanggan
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

// Jasa Angkut (sementara tanpa middleware auth agar bisa diakses saat development)
Route::get('/jasa-angkut', [JasaAngkutDashboardController::class, 'index'])->name('jasa-angkut.index');
Route::get('/jasa-angkut/order', [JasaAngkutOrderController::class, 'index'])->name('jasa-angkut.order.index');
Route::get('/jasa-angkut/order/{id}', [JasaAngkutOrderController::class, 'show'])->name('jasa-angkut.order.show');
Route::post('/jasa-angkut/order/{id}/terima', [JasaAngkutOrderController::class, 'terima'])->name('jasa-angkut.order.terima');
Route::post('/jasa-angkut/order/{id}/tolak', [JasaAngkutOrderController::class, 'tolak'])->name('jasa-angkut.order.tolak');
Route::get('/jasa-angkut/order/{id}/proses-jemput', [JasaAngkutOrderController::class, 'prosesJemput'])->name('jasa-angkut.order.proses-jemput');
Route::post('/jasa-angkut/order/{id}/update-status', [JasaAngkutOrderController::class, 'updateStatus'])->name('jasa-angkut.order.update-status');
Route::post('/jasa-angkut/order/{id}/selesaikan', [JasaAngkutOrderController::class, 'selesaikanOrder'])->name('jasa-angkut.order.selesaikan');
Route::get('/jasa-angkut/order/{id}/selesai', [JasaAngkutOrderController::class, 'orderSelesai'])->name('jasa-angkut.order.selesai');
Route::get('/jasa-angkut/order/{id}/pembayaran-berhasil', [JasaAngkutOrderController::class, 'pembayaranBerhasil'])->name('jasa-angkut.order.pembayaran-berhasil');
Route::get('/jasa-angkut/riwayat', [JasaAngkutRiwayatController::class, 'index'])->name('jasa-angkut.riwayat');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

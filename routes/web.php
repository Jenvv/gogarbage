<?php

use App\Http\Controllers\JuruAngkut\DashboardController as JuruAngkutDashboardController;
use App\Http\Controllers\JuruAngkut\OrderController as JuruAngkutOrderController;
use App\Http\Controllers\JuruAngkut\RiwayatController as JuruAngkutRiwayatController;
use App\Http\Controllers\Pelanggan\BerandaController;
use App\Http\Controllers\Pelanggan\JemputSampahController;
use App\Http\Controllers\Pelanggan\LanggananController;
use App\Http\Controllers\Pelanggan\RiwayatController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

// Pelanggan
Route::middleware(['auth', 'role:pengguna'])->group(function () {
    Route::get('/pelanggan', [BerandaController::class, 'index'])->name('pelanggan.index');

    // Jemput Sampah
    Route::get('/pelanggan/jemput-sampah', [JemputSampahController::class, 'index'])->name('pelanggan.jemput-sampah');
    Route::post('/pelanggan/jemput-sampah', [JemputSampahController::class, 'store'])->name('pelanggan.jemput-sampah.store');
    Route::get('/pelanggan/jemput-sampah/konfirmasi', [JemputSampahController::class, 'konfirmasi_pesanan'])->name('pelanggan.konfirmasi-pesanan');
    Route::post('/pelanggan/jemput-sampah/confirm', [JemputSampahController::class, 'confirm_pesanan'])->name('pelanggan.confirm-pesanan');
    Route::get('/pelanggan/jemput-sampah/{id}/sukses', [JemputSampahController::class, 'order_sukses'])->name('pelanggan.order-sukses');
    Route::get('/pelanggan/jemput-sampah/{id}/tracking', [JemputSampahController::class, 'tracking_pesanan'])->name('pelanggan.tracking-pesanan');
    Route::get('/pelanggan/jemput-sampah/{id}/order_selesai', [JemputSampahController::class, 'order_selesai'])->name('pelanggan.order_selesai');
    Route::get('/pelanggan/riwayat', [RiwayatController::class, 'index'])->name('pelanggan.riwayat');
    Route::get('/pelanggan/langganan', [LanggananController::class, 'index'])->name('pelanggan.langganan');
    Route::post('/pelanggan/langganan', [LanggananController::class, 'store'])->name('pelanggan.langganan.store');
    Route::post('/pelanggan/langganan/{id}/batalkan', [LanggananController::class, 'batalkan'])->name('pelanggan.langganan.batalkan');
});

// juru Angkut
Route::middleware(['auth', 'role:juru_angkut'])->group(function () {
    Route::get('/juru-angkut', [JuruAngkutDashboardController::class, 'index'])->name('juru-angkut.index');
    Route::get('/juru-angkut/order', [JuruAngkutOrderController::class, 'index'])->name('juru-angkut.order.index');
    Route::get('/juru-angkut/order/{id}', [JuruAngkutOrderController::class, 'show'])->name('juru-angkut.order.show');
    Route::post('/juru-angkut/order/{id}/terima', [JuruAngkutOrderController::class, 'terima'])->name('juru-angkut.order.terima');
    Route::post('/juru-angkut/order/{id}/tolak', [JuruAngkutOrderController::class, 'tolak'])->name('juru-angkut.order.tolak');
    Route::get('/juru-angkut/order/{id}/proses-jemput', [JuruAngkutOrderController::class, 'prosesJemput'])->name('juru-angkut.order.proses-jemput');
    Route::post('/juru-angkut/order/{id}/update-status', [JuruAngkutOrderController::class, 'updateStatus'])->name('juru-angkut.order.update-status');
    Route::post('/juru-angkut/order/{id}/selesaikan', [JuruAngkutOrderController::class, 'selesaikanOrder'])->name('juru-angkut.order.selesaikan');
    Route::get('/juru-angkut/order/{id}/selesai', [JuruAngkutOrderController::class, 'orderSelesai'])->name('juru-angkut.order.selesai');
    Route::get('/juru-angkut/order/{id}/pembayaran-berhasil', [JuruAngkutOrderController::class, 'pembayaranBerhasil'])->name('juru-angkut.order.pembayaran-berhasil');
    Route::get('/juru-angkut/riwayat', [JuruAngkutRiwayatController::class, 'index'])->name('juru-angkut.riwayat');
    Route::get('/juru-angkut/langganan-tunai', [JuruAngkutOrderController::class, 'langgananTunai'])->name('juru-angkut.langganan-tunai');
    Route::post('/juru-angkut/langganan-tunai/{id}/konfirmasi', [JuruAngkutOrderController::class, 'konfirmasiTunai'])->name('juru-angkut.langganan-tunai.konfirmasi');
});

// Admin
Route::middleware(['auth', 'role:admin_gudang'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/pengguna/pelanggan', [AdminController::class, 'pelanggan'])->name('admin.pengguna.pelanggan');
    Route::get('/pengguna/juru-angkut', [AdminController::class, 'juruAngkut'])->name('admin.pengguna.juru-angkut');
    Route::get('/pengguna/pengepul', [AdminController::class, 'pengepul'])->name('admin.pengguna.pengepul');
    Route::get('/pesanan', [AdminController::class, 'pesanan'])->name('admin.pesanan');
    Route::get('/langganan', [AdminController::class, 'langganan'])->name('admin.langganan');
    Route::get('/stok', [AdminController::class, 'stok'])->name('admin.stok');
    Route::get('/transaksi-pengepul', [AdminController::class, 'transaksiPengepul'])->name('admin.transaksi-pengepul');
    Route::get('/keuangan', [AdminController::class, 'keuangan'])->name('admin.keuangan');
    Route::get('/hadiah', [AdminController::class, 'hadiah'])->name('admin.hadiah');
    Route::get('/master-data/kategori-sampah', [AdminController::class, 'kategoriSampah'])->name('admin.master-data.kategori-sampah');
    Route::get('/master-data/paket', [AdminController::class, 'paket'])->name('admin.master-data.paket');
});


// API Endpoint for Polling Status
Route::get('/api/pesanan/{id}/status', function ($id) {
    $pesanan = \App\Models\Pesanan::find($id);
    if (!$pesanan) return response()->json(['status' => 'error'], 404);
    return response()->json(['status' => $pesanan->status]);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

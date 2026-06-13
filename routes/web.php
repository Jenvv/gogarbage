<?php

use App\Http\Controllers\JuruAngkut\DashboardController as JuruAngkutDashboardController;
use App\Http\Controllers\JuruAngkut\OrderController as JuruAngkutOrderController;
use App\Http\Controllers\JuruAngkut\RiwayatController as JuruAngkutRiwayatController;
use App\Http\Controllers\JuruAngkut\ProfilController as JuruAngkutProfilController;
use App\Http\Controllers\JuruAngkut\JadwalController as JuruAngkutJadwalController;
use App\Http\Controllers\Pelanggan\BerandaController;
use App\Http\Controllers\Pelanggan\JemputSampahController;
use App\Http\Controllers\Pelanggan\LanggananController;
use App\Http\Controllers\Pelanggan\RiwayatController;
use App\Http\Controllers\Pelanggan\ProfilController as PelangganProfilController;
use App\Http\Controllers\Pelanggan\DompetController;
use App\Http\Controllers\Pelanggan\KlaimController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KeuanganController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\LanggananController as AdminLanggananController;
use App\Http\Controllers\Admin\StokController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\HadiahController;
use App\Http\Controllers\Admin\KategoriSampahController;
use App\Http\Controllers\Admin\TransaksiPengepulController;
use App\Http\Controllers\Admin\KonfigurasiController;
use App\Http\Controllers\Pengepul\DashboardController as PengepulDashboardController;
use App\Http\Controllers\Pengepul\StokController as PengepulStokController;
use App\Http\Controllers\Pengepul\RequestController as PengepulRequestController;
use App\Http\Controllers\Pengepul\RiwayatController as PengepulRiwayatController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

// Pelanggan
Route::middleware(['auth', 'role:pengguna'])->group(function () {
    // Halaman set alamat (tidak di-guard oleh ensure.alamat)
    Route::get('/pelanggan/set-alamat', [PelangganProfilController::class, 'setAlamat'])->name('pelanggan.set-alamat');
    Route::post('/pelanggan/set-alamat', [PelangganProfilController::class, 'simpanAlamat'])->name('pelanggan.simpan-alamat');

    // Semua fitur pelanggan — wajib punya alamat
    Route::middleware('ensure.alamat')->group(function () {
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

        // Profil Pelanggan
        Route::get('/pelanggan/profil', [PelangganProfilController::class, 'index'])->name('pelanggan.profil');
        Route::post('/pelanggan/profil', [PelangganProfilController::class, 'update'])->name('pelanggan.profil.update');

        // Dompet Pelanggan
        Route::get('/pelanggan/dompet', [DompetController::class, 'index'])->name('pelanggan.dompet');
        Route::post('/pelanggan/dompet/topup', [DompetController::class, 'topUp'])->name('pelanggan.dompet.topup');
        Route::post('/pelanggan/dompet/tarik', [DompetController::class, 'tarikSaldo'])->name('pelanggan.dompet.tarik');
        Route::post('/pelanggan/dompet/rekening', [DompetController::class, 'simpanRekening'])->name('pelanggan.dompet.rekening');

        // Klaim Hadiah Pelanggan
        Route::get('/pelanggan/klaim', [KlaimController::class, 'index'])->name('pelanggan.klaim.index');
        Route::post('/pelanggan/klaim', [KlaimController::class, 'store'])->name('pelanggan.klaim.store');
    });
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

    // Jadwal Langganan - Juru Angkut
    Route::get('/juru-angkut/jadwal', [JuruAngkutJadwalController::class, 'index'])->name('juru-angkut.jadwal');
    Route::post('/juru-angkut/jadwal/{id}/mulai', [JuruAngkutJadwalController::class, 'mulaiJemput'])->name('juru-angkut.jadwal.mulai');
    Route::post('/juru-angkut/jadwal/{id}/skip', [JuruAngkutJadwalController::class, 'skip'])->name('juru-angkut.jadwal.skip');

    // Langganan tunai removed - langganan hanya antara pelanggan dan admin
    // Route::get('/juru-angkut/langganan-tunai', [JuruAngkutOrderController::class, 'langgananTunai'])->name('juru-angkut.langganan-tunai');
    // Route::post('/juru-angkut/langganan-tunai/{id}/konfirmasi', [JuruAngkutOrderController::class, 'konfirmasiTunai'])->name('juru-angkut.langganan-tunai.konfirmasi');

    // Profil Juru Angkut
    Route::get('/juru-angkut/profil', [JuruAngkutProfilController::class, 'index'])->name('juru-angkut.profil');
    Route::post('/juru-angkut/profil', [JuruAngkutProfilController::class, 'update'])->name('juru-angkut.profil.update');
});

// Admin
Route::middleware(['auth', 'role:admin_gudang'])->prefix('admin')->group(function () {
    // Dashboard Admin
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    // 
    Route::get('/pengguna/pelanggan', [PenggunaController::class, 'pelanggan'])->name('admin.pengguna.pelanggan');
    Route::get('/pengguna/juru-angkut', [PenggunaController::class, 'juruAngkut'])->name('admin.pengguna.juru-angkut');
    Route::post('/pengguna/juru-angkut', [PenggunaController::class, 'storeJuruAngkut'])->name('admin.pengguna.juru-angkut.store');
    Route::put('/pengguna/juru-angkut/{user}', [PenggunaController::class, 'updateJuruAngkut'])->name('admin.pengguna.juru-angkut.update');
    Route::delete('/pengguna/juru-angkut/{user}', [PenggunaController::class, 'destroyJuruAngkut'])->name('admin.pengguna.juru-angkut.destroy');
    Route::get('/pengguna/pengepul', [PenggunaController::class, 'pengepul'])->name('admin.pengguna.pengepul');
    Route::post('/pengguna/pengepul', [PenggunaController::class, 'storePengepul'])->name('admin.pengguna.pengepul.store');
    Route::put('/pengguna/pengepul/{user}', [PenggunaController::class, 'updatePengepul'])->name('admin.pengguna.pengepul.update');
    Route::delete('/pengguna/pengepul/{user}', [PenggunaController::class, 'destroyPengepul'])->name('admin.pengguna.pengepul.destroy');
    Route::get('/pesanan', [PesananController::class, 'index'])->name('admin.pesanan');
    Route::post('/pesanan/{pesanan}/batalkan', [PesananController::class, 'batalkan'])->name('admin.pesanan.batalkan');
    Route::post('/pesanan/{pesanan}/verifikasi', [PesananController::class, 'verifikasi'])->name('admin.pesanan.verifikasi');
    Route::get('/langganan', [AdminLanggananController::class, 'index'])->name('admin.langganan');
    Route::post('/langganan/{langganan}/setujui', [AdminLanggananController::class, 'setujui'])->name('admin.langganan.setujui');
    Route::post('/langganan/{langganan}/tolak', [AdminLanggananController::class, 'tolak'])->name('admin.langganan.tolak');
    Route::get('/stok', [StokController::class, 'index'])->name('admin.stok');
    Route::post('/stok/adjust', [StokController::class, 'adjust'])->name('admin.stok.adjust');
    Route::get('/transaksi-pengepul', [TransaksiPengepulController::class, 'index'])->name('admin.transaksi-pengepul');
    Route::post('/transaksi-pengepul', [TransaksiPengepulController::class, 'store'])->name('admin.transaksi-pengepul.store');
    Route::post('/transaksi-pengepul/{id}/approve', [TransaksiPengepulController::class, 'approve'])->name('admin.transaksi-pengepul.approve');
    Route::post('/transaksi-pengepul/{id}/reject', [TransaksiPengepulController::class, 'reject'])->name('admin.transaksi-pengepul.reject');
    Route::post('/transaksi-pengepul/{id}/complete', [TransaksiPengepulController::class, 'complete'])->name('admin.transaksi-pengepul.complete');
    Route::get('/keuangan', [KeuanganController::class, 'index'])->name('admin.keuangan');
    Route::post('/keuangan/{penarikan}/approve', [KeuanganController::class, 'approve'])->name('admin.keuangan.approve');
    Route::post('/keuangan/{penarikan}/reject', [KeuanganController::class, 'reject'])->name('admin.keuangan.reject');
    Route::post('/keuangan/topup/{topUp}/approve', [KeuanganController::class, 'approveTopUp'])->name('admin.keuangan.topup.approve');
    Route::post('/keuangan/topup/{topUp}/reject', [KeuanganController::class, 'rejectTopUp'])->name('admin.keuangan.topup.reject');
    Route::post('/keuangan/koreksi-saldo', [KeuanganController::class, 'koreksiSaldo'])->name('admin.keuangan.koreksi-saldo');
    Route::get('/hadiah', [HadiahController::class, 'index'])->name('admin.hadiah');
    Route::post('/hadiah', [HadiahController::class, 'store'])->name('admin.hadiah.store');
    Route::put('/hadiah/{hadiah}', [HadiahController::class, 'update'])->name('admin.hadiah.update');
    Route::delete('/hadiah/{hadiah}', [HadiahController::class, 'destroy'])->name('admin.hadiah.destroy');
    Route::post('/hadiah/klaim/{klaim}', [HadiahController::class, 'prosesKlaim'])->name('admin.hadiah.klaim.proses');
    Route::get('/master-data/kategori-sampah', [KategoriSampahController::class, 'index'])->name('admin.master-data.kategori-sampah');
    Route::post('/master-data/kategori-sampah', [KategoriSampahController::class, 'store'])->name('admin.master-data.kategori-sampah.store');
    Route::put('/master-data/kategori-sampah/{kategoriSampah}', [KategoriSampahController::class, 'update'])->name('admin.master-data.kategori-sampah.update');
    Route::delete('/master-data/kategori-sampah/{kategoriSampah}', [KategoriSampahController::class, 'destroy'])->name('admin.master-data.kategori-sampah.destroy');
    Route::get('/master-data/paket', [AdminLanggananController::class, 'paketIndex'])->name('admin.master-data.paket');
    Route::post('/master-data/paket', [AdminLanggananController::class, 'storePaket'])->name('admin.master-data.paket.store');
    Route::put('/master-data/paket/{paket}', [AdminLanggananController::class, 'updatePaket'])->name('admin.master-data.paket.update');
    Route::delete('/master-data/paket/{paket}', [AdminLanggananController::class, 'destroyPaket'])->name('admin.master-data.paket.destroy');
    Route::get('/konfigurasi', [KonfigurasiController::class, 'index'])->name('admin.konfigurasi');
    Route::post('/konfigurasi', [KonfigurasiController::class, 'update'])->name('admin.konfigurasi.update');
});

// ══════════════════════════════════════════
//  PENGEPUL
// ══════════════════════════════════════════
Route::middleware(['auth', 'role:pengepul'])->prefix('pengepul')->group(function () {
    Route::get('/', [PengepulDashboardController::class, 'index'])->name('pengepul.index');
    Route::get('/stok', [PengepulStokController::class, 'index'])->name('pengepul.stok');
    Route::get('/request', [PengepulRequestController::class, 'index'])->name('pengepul.request');
    Route::post('/request', [PengepulRequestController::class, 'store'])->name('pengepul.request.store');
    Route::get('/riwayat', [PengepulRiwayatController::class, 'index'])->name('pengepul.riwayat');
    Route::get('/riwayat/{id}', [PengepulRiwayatController::class, 'show'])->name('pengepul.riwayat.show');
});


// API Endpoint for Polling Status (Secured with Ownership Validation)
Route::middleware('auth')->get('/api/pesanan/{id}/status', function ($id) {
    $pesanan = \App\Models\Pesanan::find($id);
    if (!$pesanan) {
        return response()->json(['status' => 'error', 'message' => 'Pesanan tidak ditemukan'], 404);
    }
    
    $user = auth()->user();
    
    // Otorisasi: Hanya pembuat pesanan, juru angkut yang ditugaskan, atau admin yang berhak
    if ($user->role === 'pengguna' && $pesanan->user_id !== $user->id) {
        return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
    }
    if ($user->role === 'juru_angkut' && $pesanan->pengangkut_id !== $user->id) {
        return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
    }
    
    return response()->json(['status' => $pesanan->status]);
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

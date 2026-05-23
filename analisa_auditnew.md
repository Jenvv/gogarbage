# 🔍 Laporan Audit Codebase Komprehensif — GoGarbage

Laporan ini disusun sebagai hasil audit menyeluruh terhadap aspek arsitektur, keamanan, keandalan logika bisnis, serta kebersihan codebase pada proyek **GoGarbage**. Penilaian difokuskan pada 5 area utama untuk mendeteksi potensi kerentanan, bug logika, maupun efisiensi performa aplikasi.

---

## 1. Sistem Role & Otorisasi

Pada sistem multi-role GoGarbage (Pelanggan/`pengguna`, Juru Angkut/`juru_angkut`, Pengepul/`pengepul`, dan Admin/`admin_gudang`), otorisasi secara umum dikelola menggunakan middleware `RoleMiddleware`. Namun, terdapat celah krusial pada titik integrasi API eksternal/internal.

### 🔴 Kebocoran Akses: Endpoint Polling Status Pesanan Publik
* **Lokasi File:** [web.php](file:///d:/Makul/JOKI/gogarbage/routes/web.php#L153-L157)
* **Status Kerentanan:** **Kritis (High Severity)**
* **Detail Masalah:**
  Rute API polling status pesanan diletakkan di luar middleware group `auth` maupun `role`. Siapa saja (termasuk *guest* atau pengguna lain yang menebak ID pesanan) dapat memantau status pesanan orang lain secara bebas hanya dengan melakukan manipulasi parameter `{id}` pada rute:
  ```php
  Route::get('/api/pesanan/{id}/status', function ($id) { ... });
  ```
* **Dampak:** Bypass otorisasi data pribadi pelanggan (misalnya status perjalanan pengangkutan sampah, alamat jemput, dan nama pemilik pesanan).
* **Rekomendasi Perbaikan:**
  Bungkus rute di dalam middleware `auth` dan lakukan pengecekan kepemilikan pesanan (*authorization check*) agar hanya **Pelanggan pemilik pesanan** atau **Juru Angkut yang ditugaskan** yang dapat mengakses status tersebut.

#### 🛠️ Kode Perbaikan Otorisasi API
```php
// routes/web.php

// Pindahkan atau bungkus rute API status pesanan ke dalam middleware auth
Route::middleware('auth')->get('/api/pesanan/{id}/status', function ($id) {
    $pesanan = \App\Models\Pesanan::find($id);
    if (!$pesanan) {
        return response()->json(['status' => 'error', 'message' => 'Pesanan tidak ditemukan'], 404);
    }

    $user = auth()->user();
    
    // Otorisasi: Hanya pembuat pesanan, juru angkut yang diklaim, atau admin yang berhak melihat status
    if ($user->role === 'pengguna' && $pesanan->user_id !== $user->id) {
        return response()->json(['status' => 'error', 'message' => 'Akses ditolak'], 403);
    }
    if ($user->role === 'juru_angkut' && $pesanan->pengangkut_id !== $user->id) {
        return response()->json(['status' => 'error', 'message' => 'Akses ditolak'], 403);
    }

    return response()->json(['status' => $pesanan->status]);
});
```

---

## 2. Arsitektur MVC & Database

Secara arsitektural, GoGarbage telah mengikuti pola standar Laravel. Namun, ditemukan inkonsistensi mutasi data gudang yang merusak *audit trail* persediaan fisik.

### 🟡 Putusnya Jalur Riwayat Log & Akumulasi Stok Gudang
* **Lokasi File:** [TransaksiPengepulController.php](file:///d:/Makul/JOKI/gogarbage/app/Http/Controllers/Admin/TransaksiPengepulController.php) (Method `complete` & `store`)
* **Status Kerentanan:** **Sedang (Medium Severity)**
* **Detail Masalah:**
  Ketika Admin menyelesaikan transaksi penjualan sampah ke pengepul (`complete`) atau membuat penjualan manual (`store`), sistem memotong stok gudang menggunakan `decrement('stok_kg')`. Namun, sistem **tidak pernah mencatat riwayat keluar** ke dalam tabel `log_stok_gudang` dan tidak memperbarui kolom akumulasi `total_keluar` di tabel `stok_gudang`.
* **Dampak:** Kolom `total_keluar` pada tabel `stok_gudang` akan selalu bernilai `0.00` (tidak akurat), dan riwayat mutasi barang di gudang kehilangan jejak audit transaksi keluar.
* **Rekomendasi Perbaikan:**
  Perbarui method `complete` dan `store` agar selalu mencatat transaksi keluar di `LogStokGudang` dan memperbarui field `total_keluar` di tabel `stok_gudang` secara konsisten dalam sebuah database transaction.

#### 🛠️ Kode Perbaikan `complete()` di Transaksi Pengepul
```php
// app/Http/Controllers/Admin/TransaksiPengepulController.php

public function complete($id)
{
    $penjualan = PenjualanPengepul::where('status', 'disetujui')
        ->with('detail')
        ->findOrFail($id);

    try {
        DB::transaction(function () use ($penjualan) {
            // Potong stok gudang per kategori
            foreach ($penjualan->detail as $detail) {
                $stok = StokGudang::where('kategori_sampah_id', $detail->kategori_sampah_id)->first();

                if ($stok) {
                    $stokSebelum = $stok->stok_kg;
                    $stokSesudah = $stokSebelum - $detail->berat;

                    // Update stok_kg sekaligus akumulasi total_keluar
                    $stok->update([
                        'stok_kg' => $stokSesudah,
                        'total_keluar' => $stok->total_keluar + $detail->berat
                    ]);

                    // Catat ke Log Stok Gudang
                    \App\Models\LogStokGudang::create([
                        'stok_gudang_id' => $stok->id,
                        'kategori_sampah_id' => $detail->kategori_sampah_id,
                        'tipe' => 'keluar',
                        'jumlah_kg' => $detail->berat,
                        'stok_sebelum' => $stokSebelum,
                        'stok_sesudah' => $stokSesudah,
                        'sumber_type' => PenjualanPengepul::class,
                        'sumber_id' => $penjualan->id,
                        'deskripsi' => 'Pengurangan stok otomatis dari transaksi pengepul (Invoice: #' . $penjualan->nomor_invoice . ')',
                        'dibuat_oleh' => Auth::id(),
                    ]);
                }
            }

            // Update status penjualan
            $penjualan->update([
                'status'            => 'selesai',
                'status_pembayaran' => 'lunas',
                'admin_id'          => Auth::id(),
            ]);
        });
    } catch (\Exception $e) {
        Log::error('Complete transaksi pengepul failed: ' . $e->getMessage());

        return redirect()->route('admin.transaksi-pengepul', ['tab' => 'request'])
            ->with('error', 'Gagal menyelesaikan transaksi: ' . $e->getMessage());
    }

    return redirect()->route('admin.transaksi-pengepul', ['tab' => 'riwayat'])
        ->with('success', "Transaksi {$penjualan->nomor_invoice} berhasil diselesaikan. Stok gudang dan log mutasi telah diperbarui.");
}
```

---

## 3. Pengecekan Routing & UI

Pengecekan menu navigasi (*bottom navigation* & *sidebar*) serta tautan di halaman utama menghasilkan temuan berikut.

### 🟡 Menu Profil Pengepul yang Mati (*Dead Menu*)
* **Lokasi File:** [resources/views/pengepul/index.blade.php](file:///d:/Makul/JOKI/gogarbage/resources/views/pengepul/index.blade.php#L279-L289)
* **Status Temuan:** **Sedang (Medium Severity)**
* **Detail Masalah:**
  Tombol **"Profil"** pada dashboard Pengepul (`pengepul.index`) hanyalah sebuah elemen `div` statis biasa tanpa tag tautan `<a>` dan tanpa `href`. Selain itu, tidak ada rute khusus profil untuk pengepul di rute `pengepul/*` pada `web.php`, maupun di bottom navigation parsial Pengepul.
* **Dampak:** Pengepul tidak dapat mengakses atau memperbarui data profilnya sendiri (nama, telepon, password, foto) melalui aplikasi.
* **Rekomendasi Perbaikan:**
  1. Daftarkan rute profil pengepul di `routes/web.php` mengarah ke `ProfileController`.
  2. Ubah `div` statis profil di dashboard pengepul menjadi element `<a>` link yang mengarah ke rute baru tersebut.

#### 🛠️ Kode Perbaikan Dashboard Pengepul
```html
<!-- Pada resources/views/pengepul/index.blade.php -->
<!-- Ganti blok profil statis menjadi tag tautan seperti berikut -->
<a href="{{ route('pengepul.profil') }}" style="display:flex;flex-direction:column;align-items:center;gap:8px;text-decoration:none;">
    <div class="menu-box" style="background:#fff1f2;">
        <svg width="26" height="26" fill="none" stroke="#f43f5e" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
    </div>
    <p style="font-size:11px;font-weight:600;color:#374151;line-height:1.3;">Profil</p>
</a>
```

### 🟢 Tautan Mati pada Halaman Alternatif `auth/login2.blade.php`
* **Detail Masalah:**
  Terdapat tautan registrasi dan lupa kata sandi yang hanya menggunakan tanda pagar (`href="#"`) pada berkas `auth/login2.blade.php`. Tautan ini tidak mengarah ke rute pendaftaran atau pemulihan sandi yang aktif. (Namun, `auth/login.blade.php` yang aktif sudah mengarah ke rute Laravel Breeze yang benar).

---

## 4. Deteksi *Dead Code* (Kode Tidak Terpakai)

Pembersihan kode mati sangat penting untuk meminimalkan beban pemeliharaan aplikasi (*maintenance cost*) serta merapikan struktur proyek.

| No | Berkas / Elemen | Tipe Elemen | Lokasi / Referensi | Rekomendasi Tindakan |
|----|-----------------|-------------|--------------------|----------------------|
| 1 | `AdminController.php` | Controller | `app/Http/Controllers/Admin/AdminController.php` | **Hapus Berkas secara Aman**. Semua rute admin sudah didistribusikan ke controller khusus yang terspesialisasi (seperti `DashboardController`, `PesananController`, `KeuanganController`, dll). Hapus pula pernyataan `use` di `web.php`. |
| 2 | `login2.blade.php` | View Template | `resources/views/auth/login2.blade.php` | **Hapus Berkas**. File ini merupakan duplikat dari `login.blade.php` yang tidak pernah dipanggil oleh controller otentikasi bawaan Breeze. |

---

## 5. Analisa Logika & Bug

### 🔴 Kerentanan *Double-Spend* / Saldo Minus pada Penarikan Saldo
* **Lokasi File:** [DompetController.php](file:///d:/Makul/JOKI/gogarbage/app/Http/Controllers/Pelanggan/DompetController.php) (Method `tarikSaldo`) & [KeuanganController.php](file:///d:/Makul/JOKI/gogarbage/app/Http/Controllers/Admin/KeuanganController.php) (Method `approve`)
* **Status Kerentanan:** **Kritis (High Severity)**
* **Detail Masalah:**
  1. Ketika pelanggan mengajukan penarikan saldo di `DompetController@tarikSaldo`, saldo mereka **tidak dikunci atau dikurangi**. Saldo tetap utuh, dan data penarikan masuk ke status `menunggu`.
  2. Pelanggan dapat memanfaatkan celah ini untuk mengajukan permintaan penarikan berulang kali, atau membelanjakannya untuk pemesanan jemput sampah maupun berlangganan paket premium sebelum Admin menyetujui permintaan penarikan tersebut.
  3. Ketika Admin menyetujui penarikan saldo di `KeuanganController@approve`, saldo pengguna langsung dikurangi: `$user->saldo -= $penarikan->jumlah;` **tanpa melakukan validasi ulang** apakah sisa saldo saat ini masih mencukupi.
* **Dampak:** Saldo pelanggan dapat bernilai **negatif/minus** setelah disetujui oleh admin, sehingga menyebabkan kebocoran finansial bagi platform.
* **Rekomendasi Perbaikan:**
  Tambahkan pengecekan saldo terkini yang ketat tepat sebelum Admin menyetujui penarikan tersebut di `KeuanganController`.

#### 🛠️ Kode Perbaikan Validasi Saldo pada Persetujuan Penarikan
```php
// app/Http/Controllers/Admin/KeuanganController.php

public function approve(Request $request, Penarikan $penarikan)
{
    if ($penarikan->status !== 'menunggu') {
        return redirect()->route('admin.keuangan')
            ->with('error', 'Penarikan ini sudah diproses sebelumnya.');
    }

    $user = $penarikan->pengguna;

    // VALIDASI KRITIS: Pastikan saldo terkini pelanggan masih mencukupi sebelum didebit!
    if ($user->saldo < $penarikan->jumlah) {
        return redirect()->route('admin.keuangan')
            ->with('error', 'Persetujuan gagal! Saldo ' . $user->name . ' saat ini tidak mencukupi (Saldo saat ini: Rp ' . number_format($user->saldo, 0, ',', '.') . '). Direkomendasikan untuk menolak penarikan.');
    }

    DB::transaction(function () use ($penarikan, $request, $user) {
        $saldoSebelum = $user->saldo;

        // Potong saldo pengguna
        $user->saldo -= $penarikan->jumlah;
        $user->save();

        $penarikan->status = 'disetujui';
        $penarikan->disetujui_oleh = $request->user()->id;
        $penarikan->disetujui_pada = now();
        $penarikan->save();

        Transaksi::create([
            'nomor_transaksi' => 'TRX-' . now()->format('Ymd') . '-' . str_pad((string) (Transaksi::count() + 1), 4, '0', STR_PAD_LEFT),
            'user_id' => $penarikan->user_id,
            'tipe' => 'keluar',
            'jumlah' => $penarikan->jumlah,
            'saldo_sebelum' => $saldoSebelum,
            'saldo_sesudah' => $user->saldo,
            'status' => 'selesai',
            'referensi_type' => Penarikan::class,
            'referensi_id' => $penarikan->id,
            'deskripsi' => 'Penarikan saldo via ' . $penarikan->metode . ' ke ' . $penarikan->nama_bank . ' ' . $penarikan->nomor_rekening,
        ]);
    });

    return redirect()->route('admin.keuangan')
        ->with('success', 'Penarikan berhasil disetujui dan saldo telah dikurangi.');
}
```

---

### 🟡 Deteksi Kategori Donasi yang Rapuh (*Fragile String Matching*)
* **Lokasi File:** [KlaimController.php](file:///d:/Makul/JOKI/gogarbage/app/Http/Controllers/Pelanggan/KlaimController.php) (Line 60)
* **Status Temuan:** **Sedang (Medium Severity)**
* **Detail Masalah:**
  Logika untuk menentukan apakah penukaran poin berjenis **Donasi** (langsung disetujui otomatis tanpa verifikasi fisik oleh Admin) didasarkan pada pencocokan string teks nama hadiah:
  ```php
  $isDonasi = stripos($hadiah->nama, 'donasi') !== false;
  ```
* **Dampak:** Logika ini rapuh dan mudah rusak apabila:
  1. Admin membuat hadiah fisik/barang nyata yang kebetulan mengandung kata donasi, misalnya *"Donasi Buku Mewarnai"* (secara tidak sengaja akan langsung disetujui otomatis dan memotong stok).
  2. Admin membuat donasi resmi tetapi tidak menyertakan kata "donasi" di namanya, contoh *"Peduli Kasih Anak Yatim"* (klaim tidak akan disetujui otomatis dan malah menyangkut di status `menunggu`).
* **Rekomendasi Perbaikan:**
  Tambahkan kolom baru `is_donasi` (boolean) ke dalam tabel `hadiah` lewat migrasi baru, lalu ubah logika di controller agar membaca status boolean dari database, bukan dengan teknik manipulasi teks string nama hadiah.

---

> [!IMPORTANT]
> **Prioritas Utama Perbaikan:**
> 1. Terapkan *Double-Spend Protection* saldo di `KeuanganController@approve`.
> 2. Pindahkan API `/api/pesanan/{id}/status` ke dalam middleware `auth` dan beri otorisasi kepemilikan.
> 3. Terapkan riwayat mutasi keluar stok gudang pengepul di `TransaksiPengepulController`.

# ♻️ Spesifikasi Sistem "Go Garbage" (Prompt for Database Generation)

**Context:**
Sistem ini adalah aplikasi Bank Sampah Induk (BSI) skala kabupaten (Mempawah). Terdapat 4 Role utama: Pengguna (Masyarakat/RT), Juru Angkut, Admin Gudang, dan Pengepul. Tolong buatkan rancangan database (Laravel Migration) yang rapi, normalisasi yang baik, dan optimal berdasarkan alur bisnis berikut.

## 📦 1. Skema Paket Langganan (Subscriptions)

* **Paket Rumahan (3 Bulan | Rp 150.000):** Dapat 2 tong, jemput 1x seminggu. Ongkos otomatis Rp 0. Hasil sampah anorganik 100% jadi saldo.
* **Paket RT (1 Tahun | Rp 1.200.000):** Dapat 1 tong besar 120L, jemput 1x sebulan. Hasil sampah menjadi Uang Kas RT (masuk ke dompet digital akun RT).

## 👥 2. Role, Alur Kerja & Struktur Menu

### A. Pengguna (Masyarakat / Pengurus RT)

**Alur:** Pesan jemput (atau otomatis terjadwal jika langganan) -> Juru angkut timbang & ambil -> Saldo masuk dompet -> Tarik saldo (Withdraw).
**Menu Aplikasi:**

* **Beranda:** Menampilkan Saldo Dompet, Total Poin, dan Status Paket Aktif.
* **Jemput Sampah:** Form order (Lokasi, Tanggal, Jam). Jika langganan aktif, metode pembayaran *lock* di Rp 0.
* **Paket Langganan:** Katalog beli paket (Payment Gateway/Upload Bukti TF).
* **Riwayat:** List order, tracking status (Menunggu, Di Jalan, Selesai), dan nota detail berat sampah.
* **Tarik Dana (Withdraw):** Form tarik saldo ke rekening/e-wallet.
* **Tukar Poin (Reward):** Katalog penukaran poin (Voucher, Sembako).
* **Profil:** Data diri & pengaturan alamat.

### B. Juru Angkut

**Alur:** Akun dipakai 1 tim (2 orang) per shift. Ambil order di papan tugas -> Datang ke lokasi -> Timbang sampah anorganik -> Input di aplikasi -> Selesaikan order -> Setor ke gudang. Skema gaji menggunakan bagi hasil (Misal 70% Juru Angkut, 30% Perusahaan).
**Menu Aplikasi:**

* **Papan Tugas:** List orderan masuk dari pengguna yang siap diklaim (*first come first serve*).
* **Tugas Aktif:** Detail order yang dikerjakan, tombol navigasi Maps, form input berat sampah anorganik (per kategori), dan tombol selesaikan order.
* **Riwayat Tugas:** History pekerjaan yang sudah selesai.
* **Komisi Saya:** Cek pendapatan dari sistem bagi hasil.
* **Profil:** Data armada.

### C. Admin Gudang (Dashboard Web)

**Alur:** Pantau order, approve withdraw, terima setoran Juru Angkut (otomatis nambah stok gudang), jual partai besar ke Pengepul (otomatis ngurangin stok gudang).
**Menu Aplikasi:**

* **Dashboard Utama:** Statistik transaksi, user aktif, total profit, dan stok gudang.
* **Kelola Pesanan:** Monitoring order reguler & langganan.
* **Keuangan:** Approval tarik dana (Withdraw) & Approval langganan manual.
* **Penjualan (B2B):** Form input transaksi saat Pengepul datang beli sampah.
* **Master Data:** Kelola User, Kategori & Harga Sampah, Paket Langganan, Katalog Reward.

### D. Pengepul Besar

**Alur:** Cek stok ketersediaan sampah di gudang Go Garbage -> Datang ke gudang -> Beli dalam skala ton.
**Menu Aplikasi:**

* **Live Stok Gudang (Beranda):** Menampilkan sisa stok sampah secara *real-time* (Misal: Plastik 500kg, Besi 200kg).
* **Riwayat Pembelian:** Catatan histori transaksi dia dengan gudang.
* **Profil:** Data diri/perusahaan pengepul.

## 🏆 3. Logika Poin & Saldo

* **Poin:** 1kg sampah anorganik = 10 Poin. 1x order selesai = 5 Poin.
* **Saldo:** Hasil perkalian berat sampah anorganik * harga perkilo akan otomatis masuk ke tabel dompet pengguna saat status order "Selesai".

## 💻 Instruksi untuk Claude Opus:

Buatkan script `php artisan make:migration` beserta isi Schema-nya untuk struktur database di atas. Pastikan mencakup tabel-tabel inti berikut (bisa disesuaikan/ditambah jika perlu):

1. `users` (gabung semua role pake enum, tambah kolom poin & saldo)
2. `packages` & `user_subscriptions` (untuk langganan)
3. `waste_categories` (jenis sampah & harga perkilo)
4. `orders` & `order_items` (transaksi penjemputan & detail timbangan)
5. `transactions` (mutasi riwayat keluar masuk saldo dompet)
6. `inventories` (stok gudang real-time)
7. `b2b_sales` (penjualan admin ke pengepul)
8. `rewards` & `reward_claims` (sistem poin)

Gunakan standar penamaan kolom Laravel, foreign key constraint yang rapi (onDelete cascade/restrict sesuai konteks), dan tipe data yang tepat (decimal untuk uang/berat).
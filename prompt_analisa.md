Kamu adalah senior software engineer yang bertugas melakukan **audit menyeluruh** pada aplikasi ini.

Lakukan analisis secara **sistematis dan mendalam** mengikuti urutan berikut:

---

## 1. ANALISIS ALUR APLIKASI

Petakan alur lengkap untuk setiap aktor berikut:
- **Pelanggan** — mulai dari registrasi hingga selesai transaksi
- **Juru Angkut** — mulai dari penerimaan tugas hingga penyelesaian
- **Pengepul** — mulai dari penerimaan barang hingga pelaporan
- **Admin** — manajemen pengguna, data, laporan, dan konfigurasi

Untuk setiap aktor, jelaskan: *siapa melakukan apa, kapan, dan bagaimana alurnya saling terhubung.*

---

## 2. AUDIT DATABASE (Model & Migration)

Identifikasi dan dokumentasikan **seluruh tabel** yang ada maupun yang seharusnya ada:

- Daftar semua tabel beserta kolom-kolomnya
- Relasi antar tabel (foreign key, one-to-many, many-to-many, dll.)
- Tabel mana saja yang digunakan oleh masing-masing aktor (Pelanggan / Juru Angkut / Pengepul / Admin)
- Apakah ada tabel yang **missing**, **redundan**, atau **strukturnya perlu diperbaiki**?

---

## 3. AUDIT CONTROLLER & LOGIKA BISNIS

Periksa setiap controller yang ada:

- Fungsi apa saja yang sudah tersedia
- Apakah logika bisnis sudah sesuai dengan alur di poin 1
- Fungsi apa yang **belum dibuat** atau **perlu diperbaiki**
- Apakah ada query yang tidak efisien atau rawan bug

---

## 4. AUDIT TAMPILAN & NAVIGASI (Bottom Navbar)

Analisis navigasi bottom navbar untuk setiap aktor:

- Menu apa saja yang **sudah ada**
- Menu apa saja yang **seharusnya ada tapi belum dibuat**
- Apakah urutan dan struktur menu sudah sesuai dengan kebutuhan pengguna
- Sertakan **contoh query/tampilan** untuk menu-menu yang kamu rekomendasikan

---

## 5. RINGKASAN — DAFTAR YANG PERLU DITINDAKLANJUTI

Setelah analisis selesai, buat **tiga daftar terpisah** yang jelas:

### ✅ Daftar Menu yang Belum Dibuat
| No | Nama Menu | Aktor | Prioritas |
|----|-----------|-------|-----------|
| ... | ... | ... | Tinggi/Sedang/Rendah |

### ✅ Daftar Fungsi yang Belum Dibuat
| No | Nama Fungsi | Controller | Aktor | Keterangan |
|----|-------------|------------|-------|------------|
| ... | ... | ... | ... | ... |

### ✅ Daftar yang Perlu Diperbaiki
| No | Bagian | Masalah | Solusi yang Disarankan |
|----|--------|---------|------------------------|
| ... | ... | ... | ... |

---

**Gunakan format yang rapi dan terstruktur. Jika ada asumsi yang kamu buat, sebutkan secara eksplisit.**

---

**Perubahan utama yang dilakukan:**
1. **Dipecah menjadi 5 bagian** — agar Claude tidak skip bagian mana pun
2. **Instruksi lebih spesifik** — misalnya relasi tabel, prioritas, dan contoh query
3. **Output berbentuk tabel** — memudahkan review dan tindak lanjut
4. **Urutan logis** — alur → database → controller → tampilan → ringkasan
5. **Tone sebagai senior engineer** — mendorong analisis kritis, bukan sekadar deskriptif
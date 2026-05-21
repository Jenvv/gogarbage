# 🎨 Figma AI Prompts — Menu Pengepul GoGarbage

> **Design System Reference:**
> - Frame: 390 × 844px (iPhone 14 portrait)
> - Font: Poppins (400, 500, 600, 700, 800)
> - Primary: Green gradient `linear-gradient(150deg, #2ecc71, #1aab57, #168a45)`
> - Background: `#f2f3f7`
> - Cards: White `#fff`, border-radius 16–22px, subtle shadow
> - Bottom nav: 64px fixed, 4 tabs (Home, Stok, Request, Riwayat)
> - Style: Clean modern mobile app, consistent with Pelanggan & Juru Angkut screens

---

## Prompt 1 — Dashboard (`/pengepul`)

```
Design a mobile dashboard screen (390x844px) for a waste collector (Pengepul) role in a garbage management app called "GoGarbage". Use Poppins font throughout.

TOP SECTION: A green gradient header (from #2ecc71 to #168a45, angled 150deg) with padding 30px 20px 68px. Inside the header:
- Top row: Left side shows "Selamat Datang," in 13px semi-transparent white, below it the user name "Ahmad Pengepul" in 22px extra-bold white. Right side has a 44px circle avatar with white border and user icon.
- Below: Two glassmorphism stat cards side by side (background rgba(255,255,255,0.18), border rgba(255,255,255,0.28), border-radius 14px). Left card: label "Total Pembelian" in small white text, value "12" in 19px bold white. Right card: label "Total Berat" with value "156.5 kg".

FLOATING MENU CARD: A white card (border-radius 22px, shadow) overlapping the header by -46px margin-top. Title "Menu Utama" 16px bold. Grid of 4 icon buttons (60x60px rounded-18px each):
1. "Stok Gudang" — teal background #d1fae5, warehouse/box icon in #059669
2. "Request Ambil" — blue background #dbeafe, clipboard-plus icon in #2563eb, red badge "2" on corner
3. "Riwayat" — purple background #ede9fe, clock icon in #7c3aed
4. "Profil" — red background #fee2e2, user icon in #dc2626

REQUEST AKTIF SECTION: Title "Request Aktif" with green pill badge "2 aktif". Two white list cards (border-radius 16px, shadow):
- Card 1: Left green circle icon, "INV-20260519-0001" bold, "3 item · Est. 25 kg" gray subtitle, right side orange badge "Menunggu"
- Card 2: Similar layout, right side blue badge "Disetujui"

TRANSAKSI TERAKHIR SECTION: Title "Transaksi Terakhir" with "Lihat Semua" green link. White card with 3 list items separated by thin gray lines. Each item: left green checkmark circle, invoice number bold, date gray, right side "Rp 450.000" in green bold.

BOTTOM NAV: Fixed 64px white bar with 4 tabs: Home (green filled, active), Stok (gray), Request (gray), Riwayat (gray). Each tab has icon + label.

Background color: #f2f3f7. No device frame.
```

---

## Prompt 2 — Stok Gudang (`/pengepul/stok`)

```
Design a mobile stock inventory screen (390x844px) for a waste collector role in "GoGarbage" app. Poppins font.

GREEN HEADER: Compact header (padding 44px 20px 22px), green gradient (#2ecc71 to #168a45). Contains:
- Back arrow button (white) on left
- Title "Stok Gudang" in 20px extra-bold white
- Subtitle "Lihat ketersediaan stok sampah" in 13px semi-transparent white

SCROLL AREA below header, background #f2f3f7:

SUMMARY ROW: Horizontal scroll of 3 mini stat pills (white background, border-radius 14px, shadow) in a row with 12px gap, margin 16px:
- "Total Kategori: 4"
- "Stok Tersedia: 523.5 kg"  
- "Update: Hari ini"

STOCK LIST: Title "Kategori Sampah" 15px bold, margin 16px. Below are 4 stock cards, each a white card (border-radius 16px, shadow, padding 16px), stacked with 10px gap:

Card 1 - Organik:
- Left: 44px green circle with leaf icon
- Center: "Organik" bold 14px, "Rp 2.000/kg" gray 12px
- Right column: "125.5 kg" in 16px bold green, below a small green progress bar (75% full)
- Bottom right: Green outlined button "Request Ambil" with plus icon

Card 2 - Anorganik:
- Left: 44px blue circle with recycle icon
- Center: "Anorganik" bold, "Rp 3.500/kg" gray
- Right: "230.0 kg" blue bold, blue progress bar (90%)
- Bottom: Blue outlined button "Request Ambil"

Card 3 - B3 (Berbahaya):
- Left: 44px orange circle with warning icon
- Center: "B3" bold, "Rp 5.000/kg" gray
- Right: "45.0 kg" orange bold, orange progress bar (30%)
- Bottom: Orange outlined button "Request Ambil"

Card 4 - Elektronik:
- Left: 44px purple circle with cpu/chip icon
- Center: "Elektronik" bold, "Rp 8.000/kg" gray
- Right: "123.0 kg" purple bold, purple progress bar (60%)
- Bottom: Purple outlined button "Request Ambil"

BOTTOM NAV: Same 4-tab bar. "Stok" tab is active (green filled), others gray.

Clean, modern, no device frame. Adequate padding bottom for scroll (80px).
```

---

## Prompt 3 — Request / Booking (`/pengepul/request`)

```
Design a mobile request management screen (390x844px) for waste collector in "GoGarbage" app. Poppins font.

GREEN HEADER: Compact green gradient header. Back arrow + Title "Request Saya" 20px bold white. Subtitle: "4 total request" in 13px white.

FILTER TABS: Horizontal scrollable tab bar just below header, white background, border-bottom gray. Tabs: "Semua (4)" active with green underline and green text bold, "Menunggu (1)" gray, "Disetujui (1)" gray, "Selesai (2)" gray, "Ditolak (0)" gray.

REQUEST LIST: Vertical list of request cards in scroll area (bg #f2f3f7):

Card 1 (Status: Menunggu):
- White card, border-radius 16px, shadow, left orange/yellow border-left 4px
- Top row: "INV-20260519-0003" bold 14px, right side: orange pill badge "Menunggu" (bg #fef3c7, text #b45309)
- Middle: "3 item · Est. 45 kg" gray 12px
- Detail chips row: "Organik 15kg", "Anorganik 20kg", "B3 10kg" as small rounded gray pills
- Bottom row: "19 Mei 2026, 10:30" gray, right: estimated "~Rp 157.500" in dark text
- Catatan: small italic gray text "Ambil sore hari"

Card 2 (Status: Disetujui):
- Left green border-left 4px
- "INV-20260519-0002" bold, green pill "Disetujui" (bg #dcfce7, text #15803d)  
- "2 item · Est. 30 kg"
- Bottom shows "Silakan datang ke gudang" in green info box

Card 3 (Status: Selesai + Lunas):
- Left blue/gray border
- "INV-20260518-0005" bold, blue-gray pill "Selesai" 
- "2 item · 28.5 kg (actual)"
- "Rp 99.750" bold green
- Small green checkmark badge "Lunas"

Card 4 (Status: Selesai + Belum Bayar):
- "INV-20260517-0001", gray pill "Selesai"
- Red badge "Belum Bayar"

FLOATING ACTION BUTTON: Bottom-right corner (above nav), 56px green gradient circle with white "+" icon. Shadow. This opens the "Buat Request" form.

BOTTOM NAV: "Request" tab active (green), others gray.

No device frame. Modern, clean.
```

---

## Prompt 4A — Form Buat Request (Bottom Sheet Modal)

```
Design a mobile bottom sheet modal overlay (390x844px) for creating a new stock request in "GoGarbage" app. Poppins font.

BACKDROP: Semi-transparent dark overlay (rgba(0,0,0,0.45)) covering the previous request list screen (dimmed behind).

BOTTOM SHEET: White panel sliding from bottom, border-radius 24px 24px 0 0, padding 20px. Max height 85% of screen.

HANDLE BAR: Centered 40px × 4px gray rounded bar at top.

HEADER: "Buat Request Ambil" 16px extra-bold, subtitle "Pilih jenis dan estimasi berat" 12px gray. Close X button on right (32px circle, gray bg).

FORM CONTENT (scrollable):

Section 1 - Items (repeater):
- Label "Item Sampah" with green "Tambah Item" button (dashed border, green text, plus icon)
- Item Row 1: Two columns — Left: dropdown select "Organik ▾" (green border on focus), Right: number input "15" with "kg" suffix. Delete (X) button on far right.
- Item Row 2: "Anorganik ▾" select, "20 kg" input, delete button.
- Item Row 3: "B3 ▾" select, "10 kg" input, delete button.

Section 2 - Summary strip:
- Horizontal bar with light green background (border-radius 12px): "3 item" | divider | "Est. 45 kg" | divider | "~Rp 157.500"

Section 3 - Catatan:
- Label "Catatan (opsional)" 
- Textarea with placeholder "Contoh: Ambil sore hari setelah jam 3"
- 2 rows, rounded border, gray placeholder

FOOTER: Full-width green gradient button "Kirim Request" with send/paper-plane icon. Bold white text, border-radius 14px, padding 15px.

Clean, modern. No device frame.
```

---

## Prompt 5 — Riwayat Transaksi (`/pengepul/riwayat`)

```
Design a mobile transaction history screen (390x844px) for waste collector in "GoGarbage" app. Poppins font.

GREEN HEADER: Compact green gradient. Back arrow + "Riwayat Transaksi" 20px bold white. Subtitle "Semua transaksi selesai" 13px white.

SUMMARY CARDS: 3 cards in a row below header (white, rounded 14px, shadow, margin 16px):
- Card 1: "Bulan Ini" label, "8" big bold number, "Transaksi" small gray
- Card 2: "Total Berat", "156.5 kg" bold green
- Card 3: "Pengeluaran", "Rp 1.2 Jt" bold dark

TRANSACTION LIST: Title "Mei 2026" as month divider (gray text, thin line).

List of transaction cards (white, rounded 16px, shadow, 10px gap):

Card 1:
- Top row: Invoice "INV-20260518-0005" bold, right "19 Mei 2026" gray 11px
- Middle row: 2 category pills "Organik 15kg" "Anorganik 13.5kg"  
- Bottom row: Left "28.5 kg total" gray, Right "Rp 99.750" 16px bold green
- Status badge row: Green pill "Lunas" with checkmark

Card 2:
- "INV-20260517-0001", "17 Mei 2026"
- Pills "Anorganik 20kg" "Elektronik 5kg"
- "25 kg total", "Rp 145.000" green
- Red pill "Belum Bayar"

Card 3:
- "INV-20260515-0002", "15 Mei 2026"
- "Organik 30kg"
- "30 kg", "Rp 60.000" green
- Green "Lunas"

Show 2 more similar cards below. At bottom of list: "Tampilkan lebih banyak" text button in green.

BOTTOM NAV: "Riwayat" tab active (green), others gray.

No device frame. Modern, clean mobile UI.
```

---

## Prompt 6 — Detail Invoice (sub-page of Riwayat)

```
Design a mobile invoice detail screen (390x844px) for "GoGarbage" app. Poppins font.

GREEN HEADER: Compact green gradient. Back arrow + "Detail Transaksi" 20px bold white.

INVOICE HEADER CARD: White card (rounded 18px, shadow, margin 16px, padding 20px).
- Top: Invoice number "INV-20260518-0005" in 16px bold, with small copy icon button
- Below: "19 Mei 2026 · 10:30 WIB" gray text
- Status row: Green pill "Selesai" + Green pill "Lunas"
- Thin gray divider line
- Two-column info: Left "Admin: Budi Admin", Right "Metode: Tunai"

ITEM DETAIL CARD: White card below (rounded 18px, shadow).
- Header strip: Light green background, "Detail Item" bold with box icon, "2 item" right side
- Table-style rows:
  Row 1: "🌿 Organik" | "15 kg" | "Rp 2.000/kg" | "Rp 30.000" bold
  Row 2: "♻️ Anorganik" | "13.5 kg" | "Rp 3.500/kg" | "Rp 47.250" bold
  Each row separated by thin line
- Summary footer inside card:
  Thin divider, then:
  "Total Berat" left — "28.5 kg" right bold
  "Total Harga" left — "Rp 77.250" right in 18px extra-bold green
  Background: light green gradient (f0fdf4 to dcfce7), rounded 12px, padding 14px

CATATAN CARD (if exists): Small white card with note icon and italic gray text "Pengambilan sore hari"

BOTTOM: No nav bar on detail page. Just adequate bottom padding.

No device frame. Clean, modern, receipt-like layout.
```

---

## Bottom Navigation Reference (untuk semua halaman)

```
4-tab bottom navigation, 64px height, white background, 1px top border gray:

Tab 1: Home icon (house) + "Home" label
Tab 2: Box/warehouse icon + "Stok" label  
Tab 3: Clipboard/request icon + "Request" label
Tab 4: Clock/history icon + "Riwayat" label

Active state: Green fill icon (#16a34a) + green bold text
Inactive state: Gray stroke icon (#9ca3af) + gray text
```

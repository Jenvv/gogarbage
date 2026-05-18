@extends('admin.layouts.app')

{{-- =====================================================================
     DARK MODE — raw CSS via @push('styles')
     Prefix class: hd- (Hadiah)
     Warna mengacu token TailAdmin:
       panel bg    → #1a2231  (gray-dark)
       border dark → #1d2939  (gray-800)
       input border→ #344054  (gray-700)
       text muted  → #98a2b3  (gray-400)
       text label  → #d0d5dd  (gray-300)
       text utama  → rgba(255,255,255,.90)
       placeholder → rgba(255,255,255,.30)
       input bg    → rgba(255,255,255,.05)
       prefix bg   → rgba(255,255,255,.04)
====================================================================== --}}

@push('styles')
    <style>
        /* ── PANEL ── */
        .dark #modalHadiahPanel {
            background-color: #1a2231;
            border-color: #1d2939;
        }

        /* ── HEADER ── */
        .dark #hd-header {
            border-bottom-color: #1d2939;
        }

        .dark #hd-icon-wrap {
            background-color: rgba(34, 197, 94, 0.10);
        }

        .dark #hd-icon-wrap svg {
            stroke: #4ade80;
        }

        .dark #modalHadiahTitle {
            color: rgba(255, 255, 255, 0.90);
        }

        .dark #hd-header-sub {
            color: #98a2b3;
        }

        .dark #hd-close-btn:hover {
            background-color: rgba(255, 255, 255, 0.05);
            color: #d0d5dd;
        }

        /* ── LABEL & HINT ── */
        .dark .hd-label {
            color: #d0d5dd;
        }

        .dark .hd-label-opt {
            color: #667085;
        }

        .dark .hd-hint {
            color: #667085;
        }

        /* ── INPUT & TEXTAREA ── */
        .dark .hd-input {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: #344054;
            color: rgba(255, 255, 255, 0.90);
        }

        .dark .hd-input::placeholder {
            color: rgba(255, 255, 255, 0.30);
        }

        .dark .hd-input:focus {
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.15);
        }

        /* ── INPUT GROUP (prefix/suffix wrapper) ── */
        .dark .hd-input-group {
            border-color: #344054;
        }

        .dark .hd-input-group:focus-within {
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.15);
        }

        .dark .hd-input-group .hd-suffix {
            background-color: rgba(255, 255, 255, 0.04);
            border-color: #344054;
            color: #98a2b3;
        }

        .dark .hd-input-group .hd-group-input {
            color: rgba(255, 255, 255, 0.90);
        }

        .dark .hd-input-group .hd-group-input::placeholder {
            color: rgba(255, 255, 255, 0.30);
        }

        /* ── SELECT ── */
        .dark .hd-select {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: #344054;
            color: rgba(255, 255, 255, 0.90);
        }

        .dark .hd-select:focus {
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.15);
        }

        .dark .hd-select option {
            background-color: #1a2231;
            color: rgba(255, 255, 255, 0.90);
        }

        .dark .hd-chevron {
            color: #98a2b3;
        }

        /* ── SECTION DIVIDER ── */
        .dark .hd-section-label {
            color: #667085;
            background-color: #1a2231;
        }

        .dark .hd-section-line {
            border-color: #1d2939;
        }

        /* ── DROPZONE ── */
        .dark .hd-dropzone {
            border-color: #344054;
            background-color: rgba(255, 255, 255, 0.02);
        }

        .dark .hd-dropzone:hover {
            border-color: #22c55e;
            background-color: rgba(34, 197, 94, 0.05);
        }

        .dark .hd-dropzone-icon {
            background-color: rgba(255, 255, 255, 0.05);
            color: #98a2b3;
        }

        .dark .hd-dropzone:hover .hd-dropzone-icon {
            background-color: rgba(34, 197, 94, 0.10);
            color: #4ade80;
        }

        .dark .hd-dropzone-cta {
            color: #4ade80;
        }

        .dark .hd-dropzone-or {
            color: #98a2b3;
        }

        .dark .hd-dropzone-hint {
            color: #667085;
        }

        .dark #hdGambarPreviewImg {
            box-shadow: 0 0 0 2px #344054;
        }

        .dark #hdGambarPreviewName {
            color: #d0d5dd;
        }

        .dark .hd-reset-btn {
            color: #f87171;
        }

        .dark .hd-reset-btn:hover {
            color: #fca5a5;
        }

        /* ── TOGGLE STATUS ── */
        .dark .hd-toggle-section {
            border-color: #1d2939;
            background-color: rgba(255, 255, 255, 0.02);
        }

        .dark .hd-toggle-label {
            color: #d0d5dd;
        }

        .dark .hd-toggle-desc {
            color: #98a2b3;
        }

        /* ── FOOTER ── */
        .dark #hd-footer {
            border-top-color: #1d2939;
        }

        .dark .hd-btn-cancel {
            border-color: #344054;
            background-color: rgba(255, 255, 255, 0.05);
            color: #d0d5dd;
        }

        .dark .hd-btn-cancel:hover {
            background-color: rgba(255, 255, 255, 0.10);
        }
    </style>
@endpush


@section('content')
    {{-- ── Page Header ── --}}
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Hadiah &amp; Poin</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola katalog hadiah dan proses klaim poin pelanggan</p>
        </div>
        <button onclick="modalHadiah.open()"
            class="inline-flex items-center gap-2 rounded-lg bg-green-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-green-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Hadiah
        </button>
    </div>

    {{-- ── Katalog Hadiah ── --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] mb-6">
        <div class="px-5 pt-5 md:px-6 md:pt-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Katalog Hadiah</h3>
        </div>
        <div class="p-5 md:p-6 overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Nama</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Tipe</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Biaya Poin</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Stok</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Status</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" class="py-8 text-center text-sm text-gray-400">
                            Data akan ditampilkan setelah integrasi
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Klaim Hadiah ── --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-5 pt-5 md:px-6 md:pt-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Klaim Hadiah Masuk</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Proses klaim hadiah dari pelanggan</p>
        </div>
        <div class="p-5 md:p-6 overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Pelanggan</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Hadiah</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Poin Digunakan</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Status</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" class="py-8 text-center text-sm text-gray-400">
                            Data akan ditampilkan setelah integrasi
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    {{-- ══════════════════════════════════════════
         MODAL TAMBAH HADIAH
         Dark mode: raw CSS .dark .hd-* di atas
    ══════════════════════════════════════════ --}}
    <div id="modalHadiahWrap" aria-modal="true" role="dialog" aria-labelledby="modalHadiahTitle"
        style="display:none; position:fixed; inset:0; z-index:999999;
               align-items:center; justify-content:center; padding:1rem;">

        {{-- Backdrop --}}
        <div id="modalHadiahBackdrop" onclick="modalHadiah.close()"
            style="position:absolute; inset:0;
                   background:rgba(16,24,40,0.55);
                   backdrop-filter:blur(3px);
                   -webkit-backdrop-filter:blur(3px);
                   opacity:0; transition:opacity 250ms ease;">
        </div>

        {{-- Panel --}}
        <div id="modalHadiahPanel" class="relative flex w-full flex-col rounded-2xl border border-gray-200 bg-white"
            style="z-index:1; max-width:760px; max-height:90vh;
                   box-shadow:0 20px 24px -4px rgba(16,24,40,.10),0 8px 8px -4px rgba(16,24,40,.04);
                   transform:scale(0.94); opacity:0;
                   transition:transform 280ms cubic-bezier(0.34,1.36,0.64,1), opacity 250ms ease;">

            {{-- ── Header ── --}}
            <div id="hd-header" class="flex shrink-0 items-center justify-between border-b border-gray-200 px-5 py-4">
                <div class="flex items-center gap-3">
                    <span id="hd-icon-wrap" class="flex items-center justify-center rounded-xl bg-green-50"
                        style="width:36px;height:36px">
                        {{-- Ikon gift / hadiah --}}
                        <svg style="width:20px;height:20px" class="text-green-600" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v13m0-13a4 4 0 100-8 4 4 0 000 8z
                                         M4 8h16v2a2 2 0 01-2 2H6a2 2 0 01-2-2V8z
                                         M4 12v7a2 2 0 002 2h12a2 2 0 002-2v-7" />
                        </svg>
                    </span>
                    <div>
                        <h3 id="modalHadiahTitle" class="text-base font-semibold text-gray-800">
                            Tambah Hadiah
                        </h3>
                        <p id="hd-header-sub" class="text-xs text-gray-500">
                            Tambahkan hadiah baru ke katalog penukaran poin
                        </p>
                    </div>
                </div>
                <button id="hd-close-btn" type="button" onclick="modalHadiah.close()"
                    class="flex items-center justify-center rounded-lg text-gray-400
                           transition hover:bg-gray-100 hover:text-gray-600"
                    style="width:32px;height:32px" aria-label="Tutup modal">
                    <svg style="width:20px;height:20px" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- ── Body scrollable ── --}}
            <div class="flex-1 overflow-y-auto px-5 py-5" style="scrollbar-width:thin">
                <form id="formHadiah" action="" {{-- action="{{ route('admin.hadiah.store') }}" --}} method="POST" enctype="multipart/form-data"
                    novalidate>
                    @csrf
                    <div style="display:flex;flex-direction:column;gap:1.25rem;">

                        {{-- ════ INFORMASI DASAR ════ --}}
                        <div class="relative flex items-center gap-3" style="margin-top:4px">
                            <span
                                class="hd-section-label shrink-0 text-xs font-medium
                                         text-gray-400 bg-white pr-2">
                                Informasi Dasar
                            </span>
                            <div class="hd-section-line flex-1 border-t border-gray-200"></div>
                        </div>

                        {{-- Nama Hadiah --}}
                        <div>
                            <label for="hd_nama" class="hd-label block text-sm font-medium text-gray-700"
                                style="margin-bottom:6px">
                                Nama Hadiah <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="hd_nama" name="nama" maxlength="255" required
                                autocomplete="off" placeholder="Contoh: Voucher Belanja Rp 50.000"
                                class="hd-input w-full rounded-lg border border-gray-300 bg-white
                                       text-gray-800 placeholder-gray-400
                                       text-sm px-4
                                       focus:outline-none focus:ring-2 focus:ring-green-500/20
                                       focus:border-green-400 transition"
                                style="height:44px">
                            <p class="hd-hint text-xs text-gray-400" style="margin-top:6px">
                                Maksimal 255 karakter
                            </p>
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <label for="hd_deskripsi" class="hd-label block text-sm font-medium text-gray-700"
                                style="margin-bottom:6px">
                                Deskripsi
                                <span class="hd-label-opt text-xs font-normal text-gray-400">
                                    (opsional)
                                </span>
                            </label>
                            <textarea id="hd_deskripsi" name="deskripsi" rows="3" placeholder="Keterangan singkat mengenai hadiah ini..."
                                class="hd-input w-full rounded-lg border border-gray-300 bg-white
                                       text-sm text-gray-800 placeholder-gray-400
                                       px-4 py-2.5
                                       focus:outline-none focus:ring-2 focus:ring-green-500/20
                                       focus:border-green-400 transition"
                                style="resize:none"></textarea>
                        </div>

                        {{-- Tipe Hadiah --}}
                        <div>
                            <label for="hd_tipe" class="hd-label block text-sm font-medium text-gray-700"
                                style="margin-bottom:6px">
                                Tipe Hadiah <span class="text-red-500">*</span>
                            </label>
                            <div class="relative" style="height:44px">
                                <select id="hd_tipe" name="tipe" required
                                    class="hd-select appearance-none w-full h-full rounded-lg
                                           border border-gray-300 bg-white
                                           text-sm text-gray-800
                                           pl-4 pr-9
                                           focus:outline-none focus:ring-2 focus:ring-green-500/20
                                           focus:border-green-400 transition">
                                    <option value="">— Pilih tipe hadiah —</option>
                                    <option value="voucher">Voucher</option>
                                    <option value="fisik">Fisik</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                                <span
                                    class="hd-chevron pointer-events-none absolute top-1/2
                                             -translate-y-1/2 right-3 text-sm text-gray-500
                                             leading-none select-none">
                                    ▾
                                </span>
                            </div>
                            <p class="hd-hint text-xs text-gray-400" style="margin-top:6px">
                                Voucher = kode/digital · Fisik = barang dikirim · Lainnya = dsb
                            </p>
                        </div>

                        {{-- ════ POIN & STOK ════ --}}
                        <div class="relative flex items-center gap-3" style="margin-top:4px">
                            <span
                                class="hd-section-label shrink-0 text-xs font-medium
                                         text-gray-400 bg-white pr-2">
                                Poin &amp; Stok
                            </span>
                            <div class="hd-section-line flex-1 border-t border-gray-200"></div>
                        </div>

                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">

                            {{-- Biaya Poin --}}
                            <div>
                                <label for="hd_biaya_poin" class="hd-label block text-sm font-medium text-gray-700"
                                    style="margin-bottom:6px">
                                    Biaya Poin <span class="text-red-500">*</span>
                                </label>
                                <div class="hd-input-group flex items-center overflow-hidden
                                            rounded-lg border border-gray-300"
                                    style="height:44px">
                                    <input type="number" id="hd_biaya_poin" name="biaya_poin" step="1"
                                        min="1" required placeholder="500"
                                        class="hd-group-input flex-1 h-full bg-transparent px-3
                                               text-sm text-gray-800 placeholder-gray-400
                                               focus:outline-none">
                                    <span
                                        class="hd-suffix flex items-center self-stretch px-3
                                                 border-l border-gray-300 bg-gray-50
                                                 text-xs text-gray-500 whitespace-nowrap">
                                        poin
                                    </span>
                                </div>
                                <p class="hd-hint text-xs text-gray-400" style="margin-top:6px">
                                    Minimum 1 poin
                                </p>
                            </div>

                            {{-- Stok --}}
                            <div>
                                <label for="hd_stok" class="hd-label block text-sm font-medium text-gray-700"
                                    style="margin-bottom:6px">
                                    Stok <span class="text-red-500">*</span>
                                </label>
                                <div class="hd-input-group flex items-center overflow-hidden
                                            rounded-lg border border-gray-300"
                                    style="height:44px">
                                    <input type="number" id="hd_stok" name="stok" step="1" min="0"
                                        required placeholder="0"
                                        class="hd-group-input flex-1 h-full bg-transparent px-3
                                               text-sm text-gray-800 placeholder-gray-400
                                               focus:outline-none">
                                    <span
                                        class="hd-suffix flex items-center self-stretch px-3
                                                 border-l border-gray-300 bg-gray-50
                                                 text-xs text-gray-500 whitespace-nowrap">
                                        unit
                                    </span>
                                </div>
                                <p class="hd-hint text-xs text-gray-400" style="margin-top:6px">
                                    0 = stok habis / tidak terbatas jika voucher
                                </p>
                            </div>
                        </div>

                        {{-- ════ GAMBAR ════ --}}
                        <div class="relative flex items-center gap-3" style="margin-top:4px">
                            <span
                                class="hd-section-label shrink-0 text-xs font-medium
                                         text-gray-400 bg-white pr-2">
                                Gambar
                            </span>
                            <div class="hd-section-line flex-1 border-t border-gray-200"></div>
                        </div>

                        <div>
                            <label class="hd-label block text-sm font-medium text-gray-700" style="margin-bottom:6px">
                                Gambar Hadiah
                                <span class="hd-label-opt text-xs font-normal text-gray-400">
                                    (opsional)
                                </span>
                            </label>
                            <label for="hd_gambar"
                                class="hd-dropzone group flex cursor-pointer flex-col items-center
                                       justify-center rounded-xl border-2 border-dashed
                                       border-gray-200 bg-gray-50 p-6 transition
                                       hover:border-green-400 hover:bg-green-50">

                                {{-- Placeholder --}}
                                <div id="hdGambarPlaceholder" class="flex flex-col items-center gap-2 text-center">
                                    <span
                                        class="hd-dropzone-icon flex items-center justify-center
                                                 rounded-xl bg-gray-100 text-gray-400
                                                 group-hover:bg-green-100 group-hover:text-green-500
                                                 transition"
                                        style="width:40px;height:40px">
                                        <svg style="width:20px;height:20px" fill="none" stroke="currentColor"
                                            stroke-width="1.75" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 16.5V19a1.5 1.5 0 001.5 1.5h15A1.5 1.5 0 0021 19v-2.5M16 8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-sm">
                                            <span class="hd-dropzone-cta font-medium text-green-500">
                                                Klik untuk unggah
                                            </span>
                                            <span class="hd-dropzone-or text-gray-500">
                                                atau seret ke sini
                                            </span>
                                        </p>
                                        <p class="hd-dropzone-hint text-xs text-gray-400 mt-0.5">
                                            PNG, JPG, WebP · Maks. 2 MB
                                        </p>
                                    </div>
                                </div>

                                {{-- Preview --}}
                                <div id="hdGambarPreviewBox"
                                    style="display:none;flex-direction:column;
                                           align-items:center;gap:10px;text-align:center;">
                                    <img id="hdGambarPreviewImg" src="#" alt="Preview"
                                        class="rounded-xl object-contain ring-2 ring-gray-200"
                                        style="width:72px;height:72px">
                                    <div>
                                        <p id="hdGambarPreviewName" class="text-sm font-medium text-gray-700"></p>
                                        <button type="button" onclick="hdGambarReset(event)"
                                            class="hd-reset-btn text-xs text-red-500
                                                   hover:text-red-600 mt-0.5">
                                            Hapus &amp; ganti
                                        </button>
                                    </div>
                                </div>

                                <input type="file" id="hd_gambar" name="gambar" accept="image/*" class="hidden"
                                    onchange="hdGambarPreview(event)">
                            </label>
                        </div>

                        {{-- ── Status Aktif toggle ── --}}
                        <div
                            class="hd-toggle-section flex items-start gap-4 rounded-xl
                                    border border-gray-100 bg-gray-50 p-4">
                            <button type="button" id="hdToggleBtn" role="switch" aria-checked="true"
                                onclick="hdToggleAktif()"
                                class="relative shrink-0 rounded-full focus:outline-none
                                       transition-colors duration-200"
                                style="margin-top:2px;width:44px;height:24px;background:#16a34a;">
                                <span id="hdToggleThumb" class="absolute rounded-full bg-white"
                                    style="width:20px;height:20px;top:2px;left:2px;
                                           box-shadow:0 1px 3px rgba(0,0,0,.15);
                                           transform:translateX(20px);
                                           transition:transform 200ms ease;"></span>
                            </button>

                            <input type="hidden" id="hd_aktif" name="aktif" value="1">

                            <div>
                                <p class="hd-toggle-label text-sm font-medium text-gray-700">
                                    Status Aktif
                                </p>
                                <p class="hd-toggle-desc text-xs text-gray-500 mt-0.5">
                                    Nonaktif = hadiah disembunyikan dari katalog, tidak dapat ditukar pelanggan.
                                </p>
                                <p id="hdAktifLabel" class="text-xs font-medium text-green-600 mt-1">
                                    ● Aktif
                                </p>
                            </div>
                        </div>

                    </div>{{-- /fields --}}
                </form>
            </div>{{-- /body --}}

            {{-- ── Footer ── --}}
            <div id="hd-footer"
                class="flex shrink-0 items-center justify-end gap-3
                       border-t border-gray-200 px-5 py-4">
                <button type="button" onclick="modalHadiah.close()"
                    class="hd-btn-cancel rounded-lg border border-gray-300 bg-white
                           px-4 py-2.5 text-sm font-medium text-gray-700
                           hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="button" onclick="hdSubmit()"
                    class="inline-flex items-center gap-2 rounded-lg bg-green-500
                           px-5 py-2.5 text-sm font-medium text-white
                           hover:bg-green-600 active:scale-95 transition">
                    <svg style="width:16px;height:16px" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Hadiah
                </button>
            </div>

        </div>{{-- /panel --}}
    </div>{{-- /wrap --}}
@endsection


@push('scripts')
    <script>
        (function() {
            'use strict';

            const wrap = document.getElementById('modalHadiahWrap');
            const backdrop = document.getElementById('modalHadiahBackdrop');
            const panel = document.getElementById('modalHadiahPanel');

            /* ── 1. OPEN / CLOSE ── */
            window.modalHadiah = {
                open() {
                    wrap.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                    void wrap.offsetWidth; // force reflow
                    backdrop.style.opacity = '1';
                    panel.style.transform = 'scale(1)';
                    panel.style.opacity = '1';
                },
                close() {
                    backdrop.style.opacity = '0';
                    panel.style.transform = 'scale(0.94)';
                    panel.style.opacity = '0';
                    setTimeout(function() {
                        wrap.style.display = 'none';
                        document.body.style.overflow = '';
                    }, 280);
                }
            };

            /* Escape key */
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && wrap.style.display === 'flex') {
                    window.modalHadiah.close();
                }
            });

            /* ── 2. GAMBAR PREVIEW & RESET ── */
            window.hdGambarPreview = function(e) {
                var file = e.target.files[0];
                if (!file) return;
                if (file.size > 2 * 1024 * 1024) {
                    alert('File melebihi 2 MB. Pilih file yang lebih kecil.');
                    e.target.value = '';
                    return;
                }
                var reader = new FileReader();
                reader.onload = function(ev) {
                    document.getElementById('hdGambarPreviewImg').src = ev.target.result;
                    document.getElementById('hdGambarPreviewName').textContent = file.name;
                    document.getElementById('hdGambarPlaceholder').style.display = 'none';
                    document.getElementById('hdGambarPreviewBox').style.display = 'flex';
                };
                reader.readAsDataURL(file);
            };

            window.hdGambarReset = function(e) {
                e.preventDefault();
                e.stopPropagation();
                document.getElementById('hd_gambar').value = '';
                document.getElementById('hdGambarPreviewBox').style.display = 'none';
                document.getElementById('hdGambarPlaceholder').style.display = '';
            };

            /* ── 3. TOGGLE AKTIF / NONAKTIF ── */
            var aktifState = true;

            window.hdToggleAktif = function() {
                aktifState = !aktifState;
                var btn = document.getElementById('hdToggleBtn');
                var thumb = document.getElementById('hdToggleThumb');
                var inp = document.getElementById('hd_aktif');
                var lbl = document.getElementById('hdAktifLabel');

                if (aktifState) {
                    btn.style.background = '#16a34a';
                    thumb.style.transform = 'translateX(20px)';
                    inp.value = '1';
                    lbl.textContent = '● Aktif';
                    lbl.className = 'text-xs font-medium text-green-600 mt-1';
                } else {
                    btn.style.background = '#98a2b3';
                    thumb.style.transform = 'translateX(0px)';
                    inp.value = '0';
                    lbl.textContent = '○ Nonaktif';
                    lbl.className = 'text-xs font-medium text-gray-400 mt-1';
                }
                btn.setAttribute('aria-checked', String(aktifState));
            };

            /* ── 4. SUBMIT ── */
            window.hdSubmit = function() {
                var form = document.getElementById('formHadiah');

                /* Validasi biaya poin >= 1 secara manual */
                var poin = parseInt(document.getElementById('hd_biaya_poin').value, 10);
                if (!isNaN(poin) && poin < 1) {
                    document.getElementById('hd_biaya_poin')
                        .setCustomValidity('Biaya poin minimal 1.');
                } else {
                    document.getElementById('hd_biaya_poin').setCustomValidity('');
                }

                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }
                form.submit();
            };

        })();
    </script>
@endpush

@extends('admin.layouts.app')


@push('styles')
    <style>
        /* ──────────────────────────────────────────
                               PANEL UTAMA
                            ────────────────────────────────────────── */
        .dark #modalKategoriPanel {
            background-color: #1a2231;
            border-color: #1d2939;
        }

        /* ──────────────────────────────────────────
                               HEADER
                            ────────────────────────────────────────── */
        .dark #ks-header {
            border-bottom-color: #1d2939;
        }

        .dark #ks-icon-wrap {
            background-color: rgba(34, 197, 94, 0.10);
        }

        .dark #ks-icon-wrap svg {
            stroke: #4ade80;
        }

        .dark #modalKategoriTitle {
            color: rgba(255, 255, 255, 0.90);
        }

        .dark #ks-header-sub {
            color: #98a2b3;
        }

        .dark #ks-close-btn:hover {
            background-color: rgba(255, 255, 255, 0.05);
            color: #d0d5dd;
        }

        /* ──────────────────────────────────────────
                               LABEL & HINT
                            ────────────────────────────────────────── */
        .dark .ks-label {
            color: #d0d5dd;
        }

        .dark .ks-label-opt {
            color: #667085;
        }

        .dark .ks-hint {
            color: #667085;
        }

        /* ──────────────────────────────────────────
                               INPUT & TEXTAREA
             ────────────────────────────────────────── */
        .dark .ks-input {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: #344054;
            color: rgba(255, 255, 255, 0.90);
        }

        .dark .ks-input::placeholder {
            color: rgba(255, 255, 255, 0.30);
        }

        .dark .ks-input:focus {
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.15);
        }

        /* ──────────────────────────────────────────
                               INPUT GROUP (border wrapper + prefix)
            ────────────────────────────────────────── */
        .dark .ks-input-group {
            border-color: #344054;
        }

        .dark .ks-input-group:focus-within {
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.15);
        }

        .dark .ks-input-group .ks-prefix {
            background-color: rgba(255, 255, 255, 0.04);
            border-color: #344054;
            color: #98a2b3;
        }

        .dark .ks-input-group .ks-group-input {
            color: rgba(255, 255, 255, 0.90);
        }

        .dark .ks-input-group .ks-group-input::placeholder {
            color: rgba(255, 255, 255, 0.30);
        }

        /* ──────────────────────────────────────────
                               SELECT SATUAN
             ────────────────────────────────────────── */
        .dark .ks-select {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: #344054;
            color: rgba(255, 255, 255, 0.90);
        }

        .dark .ks-select:focus {
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.15);
        }

        .dark .ks-select option {
            background-color: #1a2231;
            color: rgba(255, 255, 255, 0.90);
        }

        .dark .ks-chevron {
            color: #98a2b3;
        }

        /* ──────────────────────────────────────────
                               DROPZONE
             ────────────────────────────────────────── */
        .dark .ks-dropzone {
            border-color: #344054;
            background-color: rgba(255, 255, 255, 0.02);
        }

        .dark .ks-dropzone:hover {
            border-color: #22c55e;
            background-color: rgba(34, 197, 94, 0.05);
        }

        .dark .ks-dropzone-icon {
            background-color: rgba(255, 255, 255, 0.05);
            color: #98a2b3;
        }

        .dark .ks-dropzone:hover .ks-dropzone-icon {
            background-color: rgba(34, 197, 94, 0.10);
            color: #4ade80;
        }

        .dark .ks-dropzone-cta {
            color: #4ade80;
        }

        .dark .ks-dropzone-or {
            color: #98a2b3;
        }

        .dark .ks-dropzone-hint {
            color: #667085;
        }

        .dark #ksIkonPreviewImg {
            box-shadow: 0 0 0 2px #344054;
        }

        .dark #ksIkonPreviewName {
            color: #d0d5dd;
        }

        .dark .ks-reset-btn {
            color: #f87171;
        }

        .dark .ks-reset-btn:hover {
            color: #fca5a5;
        }

        /* ──────────────────────────────────────────
                               TOGGLE STATUS SECTION
             ────────────────────────────────────────── */
        .dark .ks-toggle-section {
            border-color: #1d2939;
            background-color: rgba(255, 255, 255, 0.02);
        }

        .dark .ks-toggle-label {
            color: #d0d5dd;
        }

        .dark .ks-toggle-desc {
            color: #98a2b3;
        }

        /* ──────────────────────────────────────────
                               FOOTER
             ────────────────────────────────────────── */
        .dark #ks-footer {
            border-top-color: #1d2939;
        }

        .dark .ks-btn-cancel {
            border-color: #344054;
            background-color: rgba(255, 255, 255, 0.05);
            color: #d0d5dd;
        }

        .dark .ks-btn-cancel:hover {
            background-color: rgba(255, 255, 255, 0.10);
        }
    </style>
@endpush


@section('content')
    {{-- ── Page Header ── --}}
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Kategori Sampah</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola jenis sampah dan harga per kilogram</p>
        </div>
        <button onclick="modalKategori.open()"
            class="inline-flex items-center gap-2 rounded-lg bg-green-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-green-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Kategori
        </button>
    </div>

    {{-- ── Tabel ── --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="overflow-x-auto p-5 md:p-6">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Nama Kategori</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Tipe</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Harga/kg</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Poin/kg</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" class="py-8 text-center text-sm text-gray-400">
                            Data akan ditampilkan setelah integrasi
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    {{-- MODAL TAMBAH KATEGORI SAMPAH --}}
    <div id="modalKategoriWrap" aria-modal="true" role="dialog" aria-labelledby="modalKategoriTitle"
        style="display:none; position:fixed; inset:0; z-index:999999;
               align-items:center; justify-content:center; padding:1rem;">

        {{-- Backdrop --}}
        <div id="modalKategoriBackdrop" onclick="modalKategori.close()"
            style="position:absolute; inset:0;
                   background:rgba(16,24,40,0.55);
                   backdrop-filter:blur(3px);
                   -webkit-backdrop-filter:blur(3px);
                   opacity:0; transition:opacity 250ms ease;">
        </div>

        {{-- Panel --}}
        <div id="modalKategoriPanel" class="relative flex w-full flex-col rounded-2xl border border-gray-200 bg-white"
            style="z-index:1; max-width:745px; max-height:90vh;
                   box-shadow:0 20px 24px -4px rgba(16,24,40,.10),0 8px 8px -4px rgba(16,24,40,.04);
                   transform:scale(0.94); opacity:0;
                   transition:transform 280ms cubic-bezier(0.34,1.36,0.64,1), opacity 250ms ease;">

            {{-- ── Header ── --}}
            <div id="ks-header" class="flex shrink-0 items-center justify-between border-b border-gray-200 px-5 py-4">
                <div class="flex items-center gap-3">
                    <span id="ks-icon-wrap" class="flex items-center justify-center rounded-xl bg-green-50"
                        style="width:36px;height:36px">
                        <svg style="width:20px;height:20px" class="text-green-600" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </span>
                    <div>
                        <h3 id="modalKategoriTitle" class="text-base font-semibold text-gray-800">
                            Tambah Kategori Sampah
                        </h3>
                        <p id="ks-header-sub" class="text-xs text-gray-500">
                            Stok gudang dibuat otomatis dengan nilai 0 kg
                        </p>
                    </div>
                </div>
                <button id="ks-close-btn" type="button" onclick="modalKategori.close()"
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
                <form id="formKategoriSampah" action="" {{-- action="{{ route('admin.kategori-sampah.store') }}" --}} method="POST"
                    enctype="multipart/form-data" novalidate>
                    @csrf
                    <div style="display:flex;flex-direction:column;gap:1.25rem;">

                        {{-- ── Nama Kategori ── --}}
                        <div>
                            <label for="ks_nama" class="ks-label block text-sm font-medium text-gray-700"
                                style="margin-bottom:6px;margin-top:12px">
                                Nama Kategori <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="ks_nama" name="nama" maxlength="255" required autocomplete="off"
                                placeholder="Contoh: Plastik Bersih" oninput="ksSlugAutoFill(this.value)"
                                class="ks-input w-full rounded-lg border border-gray-300 bg-white
                                       text-gray-800 placeholder-gray-400
                                       text-sm px-4
                                       focus:outline-none focus:ring-2 focus:ring-green-500/20
                                       focus:border-green-400 transition"
                                style="height:44px">
                            <p class="ks-hint text-xs text-gray-400" style="margin-top:6px">
                                Maksimal 255 karakter
                            </p>
                        </div>

                        {{-- ── Slug URL ── --}}
                        <div>
                            <label for="ks_slug" class="ks-label block text-sm font-medium text-gray-700"
                                style="margin-bottom:6px">
                                Slug URL
                                <span class="ks-label-opt text-xs font-normal text-gray-400">
                                    (opsional — otomatis dari nama)
                                </span>
                            </label>
                            <div class="ks-input-group flex items-center overflow-hidden
                                        rounded-lg border border-gray-300"
                                style="height:44px">
                                <span
                                    class="ks-prefix flex items-center self-stretch px-3
                                             border-r border-gray-300 bg-gray-50
                                             text-xs text-gray-500 whitespace-nowrap">
                                    /kategori/
                                </span>
                                <input type="text" id="ks_slug" name="slug" autocomplete="off"
                                    placeholder="plastik-bersih"
                                    class="ks-group-input flex-1 h-full bg-transparent px-3
                                           text-sm text-gray-800 placeholder-gray-400
                                           focus:outline-none">
                            </div>
                        </div>

                        {{-- ── Deskripsi ── --}}
                        <div>
                            <label for="ks_deskripsi" class="ks-label block text-sm font-medium text-gray-700"
                                style="margin-bottom:6px">
                                Deskripsi
                            </label>
                            <textarea id="ks_deskripsi" name="deskripsi" rows="3"
                                placeholder="Keterangan singkat mengenai kategori ini..."
                                class="ks-input w-full rounded-lg border border-gray-300 bg-white
                                       text-sm text-gray-800 placeholder-gray-400
                                       px-4 py-2.5
                                       focus:outline-none focus:ring-2 focus:ring-green-500/20
                                       focus:border-green-400 transition"
                                style="resize:none"></textarea>
                        </div>

                        {{-- ── Harga per kg + Satuan ── --}}
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">

                            {{-- Harga --}}
                            <div>
                                <label for="ks_harga_per_kg" class="ks-label block text-sm font-medium text-gray-700"
                                    style="margin-bottom:6px">
                                    Harga per kg <span class="text-red-500">*</span>
                                </label>
                                <div class="ks-input-group flex items-center overflow-hidden
                                            rounded-lg border border-gray-300"
                                    style="height:44px">
                                    <span
                                        class="ks-prefix flex items-center self-stretch px-3
                                                 border-r border-gray-300 bg-gray-50
                                                 text-xs text-gray-500">
                                        Rp
                                    </span>
                                    <input type="number" id="ks_harga_per_kg" name="harga_per_kg" step="0.01"
                                        min="0" required placeholder="0"
                                        class="ks-group-input flex-1 h-full bg-transparent px-3
                                               text-sm text-gray-800 placeholder-gray-400
                                               focus:outline-none">
                                </div>
                            </div>

                            {{-- Satuan — SVG panah dihapus, diganti karakter ▾ --}}
                            <div>
                                <label for="ks_satuan" class="ks-label block text-sm font-medium text-gray-700"
                                    style="margin-bottom:6px">
                                    Satuan
                                </label>
                                <div class="relative" style="height:44px">
                                    <select id="ks_satuan" name="satuan"
                                        class="ks-select appearance-none w-full h-full rounded-lg
                                               border border-gray-300 bg-white
                                               text-sm text-gray-800
                                               pl-4 pr-9
                                               focus:outline-none focus:ring-2 focus:ring-green-500/20
                                               focus:border-green-400 transition">
                                        <option value="kg">kg (kilogram)</option>
                                        <option value="gram">gram</option>
                                        <option value="ton">ton</option>
                                        <option value="pcs">pcs (satuan)</option>
                                        <option value="liter">liter</option>
                                    </select>
                                    <span
                                        class="ks-chevron pointer-events-none absolute top-1/2
                                                 -translate-y-1/2 right-3 text-sm text-gray-500
                                                 leading-none select-none">
                                        ▾
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- ── Ikon dropzone ── --}}
                        <div>
                            <label class="ks-label block text-sm font-medium text-gray-700" style="margin-bottom:6px">
                                Ikon Kategori
                            </label>
                            <label for="ks_ikon"
                                class="ks-dropzone group flex cursor-pointer flex-col items-center
                                       justify-center rounded-xl border-2 border-dashed
                                       border-gray-200 bg-gray-50 p-6 transition
                                       hover:border-green-400 hover:bg-green-50">

                                {{-- Placeholder --}}
                                <div id="ksIkonPlaceholder" class="flex flex-col items-center gap-2 text-center">
                                    <span
                                        class="ks-dropzone-icon flex items-center justify-center
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
                                            <span class="ks-dropzone-cta font-medium text-green-500">
                                                Klik untuk unggah
                                            </span>
                                            <span class="ks-dropzone-or text-gray-500">
                                                atau seret ke sini
                                            </span>
                                        </p>
                                        <p class="ks-dropzone-hint text-xs text-gray-400 mt-0.5">
                                            PNG, JPG, SVG · Maks. 2 MB
                                        </p>
                                    </div>
                                </div>

                                {{-- Preview --}}
                                <div id="ksIkonPreviewBox"
                                    style="display:none;flex-direction:column;
                                           align-items:center;gap:10px;text-align:center;">
                                    <img id="ksIkonPreviewImg" src="#" alt="Preview"
                                        class="rounded-xl object-contain ring-2 ring-gray-200"
                                        style="width:64px;height:64px">
                                    <div>
                                        <p id="ksIkonPreviewName" class="text-sm font-medium text-gray-700"></p>
                                        <button type="button" onclick="ksIkonReset(event)"
                                            class="ks-reset-btn text-xs text-red-500
                                                   hover:text-red-600 mt-0.5">
                                            Hapus &amp; ganti
                                        </button>
                                    </div>
                                </div>

                                <input type="file" id="ks_ikon" name="ikon" accept="image/*" class="hidden"
                                    onchange="ksIkonPreview(event)">
                            </label>
                        </div>

                        {{-- ── Status Aktif toggle ── --}}
                        <div
                            class="ks-toggle-section flex items-start gap-4 rounded-xl
                                    border border-gray-100 bg-gray-50 p-4">
                            <button type="button" id="ksToggleBtn" role="switch" aria-checked="true"
                                onclick="ksToggleAktif()"
                                class="relative shrink-0 rounded-full focus:outline-none
                                       transition-colors duration-200"
                                style="margin-top:2px;width:44px;height:24px;background:#16a34a;">
                                <span id="ksToggleThumb" class="absolute rounded-full bg-white"
                                    style="width:20px;height:20px;top:2px;left:2px;
                                           box-shadow:0 1px 3px rgba(0,0,0,.15);
                                           transform:translateX(20px);
                                           transition:transform 200ms ease;"></span>
                            </button>

                            <input type="hidden" id="ks_aktif" name="aktif" value="1">

                            <div>
                                <p class="ks-toggle-label text-sm font-medium text-gray-700">
                                    Status Aktif
                                </p>
                                <p class="ks-toggle-desc text-xs text-gray-500 mt-0.5">
                                    Nonaktif = soft delete — data tersimpan, tidak dapat dipilih di transaksi baru.
                                </p>
                                <p id="ksAktifLabel" class="text-xs font-medium text-green-600 mt-1">
                                    ● Aktif
                                </p>
                            </div>
                        </div>

                    </div>{{-- /fields --}}
                </form>
            </div>{{-- /body --}}

            {{-- ── Footer ── --}}
            <div id="ks-footer"
                class="flex shrink-0 items-center justify-end gap-3
                       border-t border-gray-200 px-5 py-4">
                <button type="button" onclick="modalKategori.close()"
                    class="ks-btn-cancel rounded-lg border border-gray-300 bg-white
                           px-4 py-2.5 text-sm font-medium text-gray-700
                           hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="button" onclick="ksSubmit()"
                    class="inline-flex items-center gap-2 rounded-lg bg-green-500
                           px-5 py-2.5 text-sm font-medium text-white
                           hover:bg-green-600 active:scale-95 transition">
                    <svg style="width:16px;height:16px" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Kategori
                </button>
            </div>

        </div>{{-- /panel --}}
    </div>{{-- /wrap --}}
@endsection


@push('scripts')
    <script>
        (function() {
            'use strict';

            const wrap = document.getElementById('modalKategoriWrap');
            const backdrop = document.getElementById('modalKategoriBackdrop');
            const panel = document.getElementById('modalKategoriPanel');

            /* 1. OPEN / CLOSE */
            window.modalKategori = {
                open() {
                    wrap.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                    void wrap.offsetWidth;
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

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && wrap.style.display === 'flex') {
                    window.modalKategori.close();
                }
            });

            /* 2. SLUG AUTO-FILL */
            var slugManual = false;
            var slugInput = document.getElementById('ks_slug');

            slugInput.addEventListener('input', function() {
                slugManual = this.value.length > 0;
            });

            window.ksSlugAutoFill = function(val) {
                if (slugManual) return;
                slugInput.value = val
                    .toLowerCase().trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/[\s_]+/g, '-')
                    .replace(/-{2,}/g, '-');
            };

            /* 3. IKON PREVIEW & RESET */
            window.ksIkonPreview = function(e) {
                var file = e.target.files[0];
                if (!file) return;
                if (file.size > 2 * 1024 * 1024) {
                    alert('File melebihi 2 MB. Pilih file yang lebih kecil.');
                    e.target.value = '';
                    return;
                }
                var reader = new FileReader();
                reader.onload = function(ev) {
                    document.getElementById('ksIkonPreviewImg').src = ev.target.result;
                    document.getElementById('ksIkonPreviewName').textContent = file.name;
                    document.getElementById('ksIkonPlaceholder').style.display = 'none';
                    document.getElementById('ksIkonPreviewBox').style.display = 'flex';
                };
                reader.readAsDataURL(file);
            };

            window.ksIkonReset = function(e) {
                e.preventDefault();
                e.stopPropagation();
                document.getElementById('ks_ikon').value = '';
                document.getElementById('ksIkonPreviewBox').style.display = 'none';
                document.getElementById('ksIkonPlaceholder').style.display = '';
            };

            /* 4. TOGGLE AKTIF / NONAKTIF */
            var aktifState = true;

            window.ksToggleAktif = function() {
                aktifState = !aktifState;
                var btn = document.getElementById('ksToggleBtn');
                var thumb = document.getElementById('ksToggleThumb');
                var inp = document.getElementById('ks_aktif');
                var lbl = document.getElementById('ksAktifLabel');

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

            /* 5. SUBMIT */
            window.ksSubmit = function() {
                var form = document.getElementById('formKategoriSampah');
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }
                form.submit();
            };

        })();
    </script>
@endpush

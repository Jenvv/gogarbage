@extends('admin.layouts.app')

@push('styles')
    <style>
        /* ──────────────────────────────────────────
                                   PANEL UTAMA
                ────────────────────────────────────────── */
        .dark #modalPaketPanel {
            background-color: #1a2231;
            border-color: #1d2939;
        }

        /* ──────────────────────────────────────────
                                   HEADER
                ────────────────────────────────────────── */
        .dark #pp-header {
            border-bottom-color: #1d2939;
        }

        .dark #pp-icon-wrap {
            background-color: rgba(34, 197, 94, 0.10);
        }

        .dark #pp-icon-wrap svg {
            stroke: #4ade80;
        }

        .dark #modalPaketTitle {
            color: rgba(255, 255, 255, 0.90);
        }

        .dark #pp-header-sub {
            color: #98a2b3;
        }

        .dark #pp-close-btn:hover {
            background-color: rgba(255, 255, 255, 0.05);
            color: #d0d5dd;
        }

        /* ──────────────────────────────────────────
                                   LABEL & HINT
                ────────────────────────────────────────── */
        .dark .pp-label {
            color: #d0d5dd;
        }

        .dark .pp-label-opt {
            color: #667085;
        }

        .dark .pp-hint {
            color: #667085;
        }

        /* ──────────────────────────────────────────
                                   INPUT & TEXTAREA
                ────────────────────────────────────────── */
        .dark .pp-input {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: #344054;
            color: rgba(255, 255, 255, 0.90);
        }

        .dark .pp-input::placeholder {
            color: rgba(255, 255, 255, 0.30);
        }

        .dark .pp-input:focus {
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.15);
        }

        /* ──────────────────────────────────────────
                                   INPUT GROUP (border wrapper + prefix)
                ────────────────────────────────────────── */
        .dark .pp-input-group {
            border-color: #344054;
        }

        .dark .pp-input-group:focus-within {
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.15);
        }

        .dark .pp-input-group .pp-prefix {
            background-color: rgba(255, 255, 255, 0.04);
            border-color: #344054;
            color: #98a2b3;
        }

        .dark .pp-input-group .pp-suffix {
            background-color: rgba(255, 255, 255, 0.04);
            border-color: #344054;
            color: #98a2b3;
        }

        .dark .pp-input-group .pp-group-input {
            color: rgba(255, 255, 255, 0.90);
        }

        .dark .pp-input-group .pp-group-input::placeholder {
            color: rgba(255, 255, 255, 0.30);
        }

        /* ──────────────────────────────────────────
                                   SELECT
                ────────────────────────────────────────── */
        .dark .pp-select {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: #344054;
            color: rgba(255, 255, 255, 0.90);
        }

        .dark .pp-select:focus {
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.15);
        }

        .dark .pp-select option {
            background-color: #1a2231;
            color: rgba(255, 255, 255, 0.90);
        }

        .dark .pp-chevron {
            color: #98a2b3;
        }

        /* ──────────────────────────────────────────
                                   DIVIDER SECTION
                ────────────────────────────────────────── */
        .dark .pp-section-divider {
            border-color: #1d2939;
            color: #667085;
        }

        .dark .pp-section-label {
            color: #667085;
            background-color: #1a2231;
        }

        /* ──────────────────────────────────────────
                                   TOGGLE STATUS SECTION
                ────────────────────────────────────────── */
        .dark .pp-toggle-section {
            border-color: #1d2939;
            background-color: rgba(255, 255, 255, 0.02);
        }

        .dark .pp-toggle-label {
            color: #d0d5dd;
        }

        .dark .pp-toggle-desc {
            color: #98a2b3;
        }

        /* ──────────────────────────────────────────
                                   FOOTER
                ────────────────────────────────────────── */
        .dark #pp-footer {
            border-top-color: #1d2939;
        }

        .dark .pp-btn-cancel {
            border-color: #344054;
            background-color: rgba(255, 255, 255, 0.05);
            color: #d0d5dd;
        }

        .dark .pp-btn-cancel:hover {
            background-color: rgba(255, 255, 255, 0.10);
        }
    </style>
@endpush


@section('content')
    {{-- ── Page Header ── --}}
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Paket Langganan</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola paket langganan jemput sampah</p>
        </div>
        <button onclick="modalPaket.open()"
            class="inline-flex items-center gap-2 rounded-lg bg-green-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-green-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Paket
        </button>
    </div>

    {{-- ── Tabel ── --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="p-5 md:p-6 overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Nama Paket</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Harga</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Durasi</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Frekuensi</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Biaya Jemput</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Status</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="7" class="py-8 text-center text-sm text-gray-400">
                            Data akan ditampilkan setelah integrasi
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    {{-- ══════════════════════════════════════════
         MODAL TAMBAH PAKET LANGGANAN
    ══════════════════════════════════════════ --}}
    <div id="modalPaketWrap" aria-modal="true" role="dialog" aria-labelledby="modalPaketTitle"
        style="display:none; position:fixed; inset:0; z-index:999999;
               align-items:center; justify-content:center; padding:1rem;">

        {{-- Backdrop --}}
        <div id="modalPaketBackdrop" onclick="modalPaket.close()"
            style="position:absolute; inset:0;
                   background:rgba(16,24,40,0.55);
                   backdrop-filter:blur(3px);
                   -webkit-backdrop-filter:blur(3px);
                   opacity:0; transition:opacity 250ms ease;">
        </div>

        {{-- Panel --}}
        <div id="modalPaketPanel" class="relative flex w-full flex-col rounded-2xl border border-gray-200 bg-white"
            style="z-index:1; max-width:760px; max-height:90vh;
                   box-shadow:0 20px 24px -4px rgba(16,24,40,.10),0 8px 8px -4px rgba(16,24,40,.04);
                   transform:scale(0.94); opacity:0;
                   transition:transform 280ms cubic-bezier(0.34,1.36,0.64,1), opacity 250ms ease;">

            {{-- ── Header ── --}}
            <div id="pp-header" class="flex shrink-0 items-center justify-between border-b border-gray-200 px-5 py-4">
                <div class="flex items-center gap-3">
                    <span id="pp-icon-wrap" class="flex items-center justify-center rounded-xl bg-green-50"
                        style="width:36px;height:36px">
                        <svg style="width:20px;height:20px" class="text-green-600" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </span>
                    <div>
                        <h3 id="modalPaketTitle" class="text-base font-semibold text-gray-800">
                            Tambah Paket Langganan
                        </h3>
                        <p id="pp-header-sub" class="text-xs text-gray-500">
                            Isi detail paket layanan jemput sampah pelanggan
                        </p>
                    </div>
                </div>
                <button id="pp-close-btn" type="button" onclick="modalPaket.close()"
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
                <form id="formPaketLangganan" action="" {{-- action="{{ route('admin.paket.store') }}" --}} method="POST" novalidate>
                    @csrf
                    <div style="display:flex;flex-direction:column;gap:1.25rem;">

                        {{-- ════ INFORMASI DASAR ════ --}}
                        <div class="pp-section-divider relative flex items-center gap-3" style="margin-top:4px">
                            <span
                                class="pp-section-label shrink-0 text-xs font-medium
                                         text-gray-400 bg-white pr-2">
                                Informasi Dasar
                            </span>
                            <div class="flex-1 border-t border-gray-200"></div>
                        </div>

                        {{-- ── Nama Paket ── --}}
                        <div>
                            <label for="pp_nama" class="pp-label block text-sm font-medium text-gray-700"
                                style="margin-bottom:6px">
                                Nama Paket <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="pp_nama" name="nama" maxlength="255" required autocomplete="off"
                                placeholder="Contoh: Paket Bulanan Standar"
                                class="pp-input w-full rounded-lg border border-gray-300 bg-white
                                       text-gray-800 placeholder-gray-400
                                       text-sm px-4
                                       focus:outline-none focus:ring-2 focus:ring-green-500/20
                                       focus:border-green-400 transition"
                                style="height:44px">
                            <p class="pp-hint text-xs text-gray-400" style="margin-top:6px">
                                Maksimal 255 karakter
                            </p>
                        </div>

                        {{-- ── Deskripsi ── --}}
                        <div>
                            <label for="pp_deskripsi" class="pp-label block text-sm font-medium text-gray-700"
                                style="margin-bottom:6px">
                                Deskripsi
                                <span class="pp-label-opt text-xs font-normal text-gray-400">
                                    (opsional)
                                </span>
                            </label>
                            <textarea id="pp_deskripsi" name="deskripsi" rows="3" placeholder="Keterangan singkat mengenai paket ini..."
                                class="pp-input w-full rounded-lg border border-gray-300 bg-white
                                       text-sm text-gray-800 placeholder-gray-400
                                       px-4 py-2.5
                                       focus:outline-none focus:ring-2 focus:ring-green-500/20
                                       focus:border-green-400 transition"
                                style="resize:none"></textarea>
                        </div>

                        {{-- ── Info Tong / Fasilitas ── --}}
                        <div>
                            <label for="pp_info_tong" class="pp-label block text-sm font-medium text-gray-700"
                                style="margin-bottom:6px">
                                Info Tong / Fasilitas
                                <span class="pp-label-opt text-xs font-normal text-gray-400">
                                    (opsional)
                                </span>
                            </label>
                            <input type="text" id="pp_info_tong" name="info_tong" maxlength="255" autocomplete="off"
                                placeholder="Contoh: Tong 60L disediakan, plastik tidak termasuk"
                                class="pp-input w-full rounded-lg border border-gray-300 bg-white
                                       text-gray-800 placeholder-gray-400
                                       text-sm px-4
                                       focus:outline-none focus:ring-2 focus:ring-green-500/20
                                       focus:border-green-400 transition"
                                style="height:44px">
                        </div>

                        {{-- ════ HARGA & DURASI ════ --}}
                        <div class="pp-section-divider relative flex items-center gap-3" style="margin-top:4px">
                            <span
                                class="pp-section-label shrink-0 text-xs font-medium
                                         text-gray-400 bg-white pr-2">
                                Harga &amp; Durasi
                            </span>
                            <div class="flex-1 border-t border-gray-200"></div>
                        </div>

                        {{-- ── Harga + Durasi (2 col) ── --}}
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">

                            {{-- Harga Paket --}}
                            <div>
                                <label for="pp_harga" class="pp-label block text-sm font-medium text-gray-700"
                                    style="margin-bottom:6px">
                                    Harga Paket <span class="text-red-500">*</span>
                                </label>
                                <div class="pp-input-group flex items-center overflow-hidden
                                            rounded-lg border border-gray-300"
                                    style="height:44px">
                                    <span
                                        class="pp-prefix flex items-center self-stretch px-3
                                                 border-r border-gray-300 bg-gray-50
                                                 text-xs text-gray-500">
                                        Rp
                                    </span>
                                    <input type="number" id="pp_harga" name="harga" step="1" min="0"
                                        required placeholder="0"
                                        class="pp-group-input flex-1 h-full bg-transparent px-3
                                               text-sm text-gray-800 placeholder-gray-400
                                               focus:outline-none">
                                </div>
                            </div>

                            {{-- Durasi (hari) --}}
                            <div>
                                <label for="pp_durasi_hari" class="pp-label block text-sm font-medium text-gray-700"
                                    style="margin-bottom:6px">
                                    Durasi <span class="text-red-500">*</span>
                                </label>
                                <div class="pp-input-group flex items-center overflow-hidden
                                            rounded-lg border border-gray-300"
                                    style="height:44px">
                                    <input type="number" id="pp_durasi_hari" name="durasi_hari" step="1"
                                        min="1" required placeholder="30"
                                        class="pp-group-input flex-1 h-full bg-transparent px-3
                                               text-sm text-gray-800 placeholder-gray-400
                                               focus:outline-none">
                                    <span
                                        class="pp-suffix flex items-center self-stretch px-3
                                                 border-l border-gray-300 bg-gray-50
                                                 text-xs text-gray-500 whitespace-nowrap">
                                        hari
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- ════ FREKUENSI JEMPUT ════ --}}
                        <div class="pp-section-divider relative flex items-center gap-3" style="margin-top:4px">
                            <span
                                class="pp-section-label shrink-0 text-xs font-medium
                                         text-gray-400 bg-white pr-2">
                                Frekuensi Jemput
                            </span>
                            <div class="flex-1 border-t border-gray-200"></div>
                        </div>

                        {{-- ── Frekuensi + Satuan (2 col) ── --}}
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">

                            {{-- Frekuensi --}}
                            <div>
                                <label for="pp_frekuensi_jemput" class="pp-label block text-sm font-medium text-gray-700"
                                    style="margin-bottom:6px">
                                    Frekuensi Jemput <span class="text-red-500">*</span>
                                </label>
                                <div class="pp-input-group flex items-center overflow-hidden
                                            rounded-lg border border-gray-300"
                                    style="height:44px">
                                    <input type="number" id="pp_frekuensi_jemput" name="frekuensi_jemput"
                                        step="1" min="1" required placeholder="2"
                                        class="pp-group-input flex-1 h-full bg-transparent px-3
                                               text-sm text-gray-800 placeholder-gray-400
                                               focus:outline-none">
                                    <span
                                        class="pp-suffix flex items-center self-stretch px-3
                                                 border-l border-gray-300 bg-gray-50
                                                 text-xs text-gray-500 whitespace-nowrap">
                                        x per
                                    </span>
                                </div>
                            </div>

                            {{-- Satuan Frekuensi --}}
                            <div>
                                <label for="pp_satuan_frekuensi" class="pp-label block text-sm font-medium text-gray-700"
                                    style="margin-bottom:6px">
                                    Satuan Frekuensi <span class="text-red-500">*</span>
                                </label>
                                <div class="relative" style="height:44px">
                                    <select id="pp_satuan_frekuensi" name="satuan_frekuensi" required
                                        class="pp-select appearance-none w-full h-full rounded-lg
                                               border border-gray-300 bg-white
                                               text-sm text-gray-800
                                               pl-4 pr-9
                                               focus:outline-none focus:ring-2 focus:ring-green-500/20
                                               focus:border-green-400 transition">
                                        <option value="minggu">Minggu</option>
                                        <option value="bulan">Bulan</option>
                                    </select>
                                    <span
                                        class="pp-chevron pointer-events-none absolute top-1/2
                                                 -translate-y-1/2 right-3 text-sm text-gray-500
                                                 leading-none select-none">
                                        ▾
                                    </span>
                                </div>
                                <p class="pp-hint text-xs text-gray-400" style="margin-top:6px">
                                    Contoh: 2× per minggu
                                </p>
                            </div>
                        </div>

                        {{-- ════ BIAYA & BAGI HASIL ════ --}}
                        <div class="pp-section-divider relative flex items-center gap-3" style="margin-top:4px">
                            <span
                                class="pp-section-label shrink-0 text-xs font-medium
                                         text-gray-400 bg-white pr-2">
                                Biaya &amp; Bagi Hasil
                            </span>
                            <div class="flex-1 border-t border-gray-200"></div>
                        </div>

                        {{-- ── Biaya Jemput + Bagi Hasil (2 col) ── --}}
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">

                            {{-- Biaya Jemput --}}
                            <div>
                                <label for="pp_biaya_jemput" class="pp-label block text-sm font-medium text-gray-700"
                                    style="margin-bottom:6px">
                                    Biaya Jemput
                                    <span class="pp-label-opt text-xs font-normal text-gray-400">
                                        (opsional)
                                    </span>
                                </label>
                                <div class="pp-input-group flex items-center overflow-hidden
                                            rounded-lg border border-gray-300"
                                    style="height:44px">
                                    <span
                                        class="pp-prefix flex items-center self-stretch px-3
                                                 border-r border-gray-300 bg-gray-50
                                                 text-xs text-gray-500">
                                        Rp
                                    </span>
                                    <input type="number" id="pp_biaya_jemput" name="biaya_jemput" step="1"
                                        min="0" value="0" placeholder="0"
                                        class="pp-group-input flex-1 h-full bg-transparent px-3
                                               text-sm text-gray-800 placeholder-gray-400
                                               focus:outline-none">
                                </div>
                                <p class="pp-hint text-xs text-gray-400" style="margin-top:6px">
                                    Default 0 (sudah termasuk harga paket)
                                </p>
                            </div>

                            {{-- Bagi Hasil --}}
                            <div>
                                <label for="pp_persentase_bagi_hasil"
                                    class="pp-label block text-sm font-medium text-gray-700" style="margin-bottom:6px">
                                    Bagi Hasil Pelanggan
                                </label>
                                <div class="pp-input-group flex items-center overflow-hidden
                                            rounded-lg border border-gray-300"
                                    style="height:44px">
                                    <input type="number" id="pp_persentase_bagi_hasil" name="persentase_bagi_hasil"
                                        step="0.01" min="0" max="100" value="100" placeholder="100"
                                        class="pp-group-input flex-1 h-full bg-transparent px-3
                                               text-sm text-gray-800 placeholder-gray-400
                                               focus:outline-none">
                                    <span
                                        class="pp-suffix flex items-center self-stretch px-3
                                                 border-l border-gray-300 bg-gray-50
                                                 text-xs text-gray-500">
                                        %
                                    </span>
                                </div>
                                <p class="pp-hint text-xs text-gray-400" style="margin-top:6px">
                                    Rentang 0–100. Default 100%
                                </p>
                            </div>
                        </div>

                        {{-- ── Status Aktif toggle ── --}}
                        <div
                            class="pp-toggle-section flex items-start gap-4 rounded-xl
                                    border border-gray-100 bg-gray-50 p-4">
                            <button type="button" id="ppToggleBtn" role="switch" aria-checked="true"
                                onclick="ppToggleAktif()"
                                class="relative shrink-0 rounded-full focus:outline-none
                                       transition-colors duration-200"
                                style="margin-top:2px;width:44px;height:24px;background:#16a34a;">
                                <span id="ppToggleThumb" class="absolute rounded-full bg-white"
                                    style="width:20px;height:20px;top:2px;left:2px;
                                           box-shadow:0 1px 3px rgba(0,0,0,.15);
                                           transform:translateX(20px);
                                           transition:transform 200ms ease;"></span>
                            </button>

                            <input type="hidden" id="pp_aktif" name="aktif" value="1">

                            <div>
                                <p class="pp-toggle-label text-sm font-medium text-gray-700">
                                    Status Aktif
                                </p>
                                <p class="pp-toggle-desc text-xs text-gray-500 mt-0.5">
                                    Nonaktif = soft delete — paket tersimpan, tidak dapat dipilih
                                    di transaksi baru.
                                </p>
                                <p id="ppAktifLabel" class="text-xs font-medium text-green-600 mt-1">
                                    ● Aktif
                                </p>
                            </div>
                        </div>

                    </div>{{-- /fields --}}
                </form>
            </div>{{-- /body --}}

            {{-- ── Footer ── --}}
            <div id="pp-footer"
                class="flex shrink-0 items-center justify-end gap-3
                       border-t border-gray-200 px-5 py-4">
                <button type="button" onclick="modalPaket.close()"
                    class="pp-btn-cancel rounded-lg border border-gray-300 bg-white
                           px-4 py-2.5 text-sm font-medium text-gray-700
                           hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="button" onclick="ppSubmit()"
                    class="inline-flex items-center gap-2 rounded-lg bg-green-500
                           px-5 py-2.5 text-sm font-medium text-white
                           hover:bg-green-600 active:scale-95 transition">
                    <svg style="width:16px;height:16px" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Paket
                </button>
            </div>

        </div>{{-- /panel --}}
    </div>{{-- /wrap --}}
@endsection


@push('scripts')
    <script>
        (function() {
            'use strict';

            const wrap = document.getElementById('modalPaketWrap');
            const backdrop = document.getElementById('modalPaketBackdrop');
            const panel = document.getElementById('modalPaketPanel');

            /* ── 1. OPEN / CLOSE ── */
            window.modalPaket = {
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

            /* Tutup dengan Escape */
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && wrap.style.display === 'flex') {
                    window.modalPaket.close();
                }
            });

            /* ── 2. TOGGLE AKTIF / NONAKTIF ── */
            var aktifState = true;

            window.ppToggleAktif = function() {
                aktifState = !aktifState;
                var btn = document.getElementById('ppToggleBtn');
                var thumb = document.getElementById('ppToggleThumb');
                var inp = document.getElementById('pp_aktif');
                var lbl = document.getElementById('ppAktifLabel');

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

            /* ── 3. SUBMIT ── */
            window.ppSubmit = function() {
                var form = document.getElementById('formPaketLangganan');

                /* Validasi bagi hasil 0–100 secara manual karena step desimal */
                var bh = parseFloat(document.getElementById('pp_persentase_bagi_hasil').value);
                if (!isNaN(bh) && (bh < 0 || bh > 100)) {
                    document.getElementById('pp_persentase_bagi_hasil').setCustomValidity(
                        'Bagi hasil harus antara 0 dan 100.'
                    );
                } else {
                    document.getElementById('pp_persentase_bagi_hasil').setCustomValidity('');
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

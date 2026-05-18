@extends('admin.layouts.app')

{{-- =====================================================================
     DARK MODE — raw CSS via @push('styles')
     Prefix class: tp- (Transaksi Pengepul)
     Warna token TailAdmin sama dengan modal sebelumnya.
====================================================================== --}}

@push('styles')
    <style>
        /* ── PANEL ── */
        .dark #modalPenjualanPanel {
            background-color: #1a2231;
            border-color: #1d2939;
        }

        /* ── HEADER ── */
        .dark #tp-header {
            border-bottom-color: #1d2939;
        }

        .dark #tp-icon-wrap {
            background-color: rgba(34, 197, 94, 0.10);
        }

        .dark #tp-icon-wrap svg {
            stroke: #4ade80;
        }

        .dark #modalPenjualanTitle {
            color: rgba(255, 255, 255, 0.90);
        }

        .dark #tp-header-sub {
            color: #98a2b3;
        }

        .dark #tp-close-btn:hover {
            background-color: rgba(255, 255, 255, 0.05);
            color: #d0d5dd;
        }

        /* ── LABEL & HINT ── */
        .dark .tp-label {
            color: #d0d5dd;
        }

        .dark .tp-label-opt {
            color: #667085;
        }

        .dark .tp-hint {
            color: #667085;
        }

        /* ── INPUT & TEXTAREA ── */
        .dark .tp-input {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: #344054;
            color: rgba(255, 255, 255, 0.90);
        }

        .dark .tp-input::placeholder {
            color: rgba(255, 255, 255, 0.30);
        }

        .dark .tp-input:focus {
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.15);
        }

        .dark .tp-input[readonly] {
            background-color: rgba(255, 255, 255, 0.02);
            border-color: #1d2939;
            color: #98a2b3;
        }

        /* ── INPUT GROUP ── */
        .dark .tp-input-group {
            border-color: #344054;
        }

        .dark .tp-input-group:focus-within {
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.15);
        }

        .dark .tp-input-group .tp-prefix {
            background-color: rgba(255, 255, 255, 0.04);
            border-color: #344054;
            color: #98a2b3;
        }

        .dark .tp-input-group .tp-suffix {
            background-color: rgba(255, 255, 255, 0.04);
            border-color: #344054;
            color: #98a2b3;
        }

        .dark .tp-input-group .tp-group-input {
            color: rgba(255, 255, 255, 0.90);
        }

        .dark .tp-input-group .tp-group-input::placeholder {
            color: rgba(255, 255, 255, 0.30);
        }

        .dark .tp-input-group.is-readonly {
            border-color: #1d2939;
        }

        .dark .tp-input-group.is-readonly .tp-suffix {
            background-color: rgba(255, 255, 255, 0.02);
            border-color: #1d2939;
        }

        .dark .tp-input-group.is-readonly .tp-group-input {
            color: #667085;
        }

        /* ── SELECT ── */
        .dark .tp-select {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: #344054;
            color: rgba(255, 255, 255, 0.90);
        }

        .dark .tp-select:focus {
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.15);
        }

        .dark .tp-select option {
            background-color: #1a2231;
            color: rgba(255, 255, 255, 0.90);
        }

        .dark .tp-chevron {
            color: #98a2b3;
        }

        /* ── SECTION DIVIDER ── */
        .dark .tp-section-label {
            color: #667085;
            background-color: #1a2231;
        }

        .dark .tp-section-line {
            border-color: #1d2939;
        }

        /* ── INVOICE BADGE ── */
        .dark .tp-invoice-badge {
            background-color: rgba(255, 255, 255, 0.04);
            border-color: #344054;
            color: #667085;
        }

        .dark #tp_nomor_invoice {
            color: rgba(255, 255, 255, 0.90);
        }

        /* ── REPEATER TABLE ── */
        .dark .tp-repeater-head {
            background-color: rgba(255, 255, 255, 0.03);
            border-bottom-color: #1d2939;
        }

        .dark .tp-repeater-head th {
            color: #667085;
        }

        .dark .tp-repeater-row {
            border-bottom-color: #1d2939;
        }

        .dark .tp-repeater-row:last-child {
            border-bottom: none;
        }

        .dark .tp-repeater-wrap {
            border-color: #344054;
            background-color: rgba(255, 255, 255, 0.02);
        }

        .dark .tp-row-select {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: #344054;
            color: rgba(255, 255, 255, 0.90);
        }

        .dark .tp-row-select:focus {
            border-color: #22c55e;
            box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.15);
        }

        .dark .tp-row-select option {
            background-color: #1a2231;
            color: rgba(255, 255, 255, 0.90);
        }

        .dark .tp-row-input {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: #344054;
            color: rgba(255, 255, 255, 0.90);
        }

        .dark .tp-row-input:focus {
            border-color: #22c55e;
            box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.15);
        }

        .dark .tp-row-input::placeholder {
            color: rgba(255, 255, 255, 0.20);
        }

        .dark .tp-row-input[readonly] {
            background-color: rgba(255, 255, 255, 0.02);
            border-color: #1d2939;
            color: #667085;
        }

        .dark .tp-row-del-btn {
            color: #667085;
        }

        .dark .tp-row-del-btn:hover {
            color: #f87171;
            background-color: rgba(248, 113, 113, 0.08);
        }

        .dark .tp-add-row-btn {
            color: #4ade80;
            border-color: #344054;
        }

        .dark .tp-add-row-btn:hover {
            background-color: rgba(34, 197, 94, 0.06);
            border-color: #22c55e;
        }

        /* ── SUMMARY STRIP ── */
        .dark .tp-summary-strip {
            background-color: rgba(255, 255, 255, 0.03);
            border-color: #1d2939;
        }

        .dark .tp-summary-label {
            color: #98a2b3;
        }

        .dark .tp-summary-value {
            color: rgba(255, 255, 255, 0.90);
        }

        .dark .tp-summary-divider {
            background-color: #1d2939;
        }

        /* ── FOOTER ── */
        .dark #tp-footer {
            border-top-color: #1d2939;
        }

        .dark .tp-btn-cancel {
            border-color: #344054;
            background-color: rgba(255, 255, 255, 0.05);
            color: #d0d5dd;
        }

        .dark .tp-btn-cancel:hover {
            background-color: rgba(255, 255, 255, 0.10);
        }
    </style>
@endpush


@section('content')
    {{-- ── Page Header ── --}}
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Transaksi Pengepul</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Transaksi terbaru dari juru angkut ke pengepul</p>
        </div>
        <button onclick="modalPenjualan.open()"
            class="inline-flex items-center gap-2 rounded-lg bg-green-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-green-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Buat Penjualan
        </button>
    </div>

    {{-- ── Summary Cards ── --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 md:gap-6 mb-6">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Transaksi</p>
            <h4 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">-</h4>
            <p class="text-xs text-gray-400 mt-1">Bulan ini</p>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Berat</p>
            <h4 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">- kg</h4>
            <p class="text-xs text-gray-400 mt-1">Bulan ini</p>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Pendapatan</p>
            <h4 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">-</h4>
            <p class="text-xs text-gray-400 mt-1">Bulan ini</p>
        </div>
    </div>

    {{-- ── Riwayat Transaksi ── --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-5 pt-5 md:px-6 md:pt-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Riwayat Transaksi</h3>
        </div>
        <div class="p-5 md:p-6 overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">No. Invoice</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Pengepul</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Jenis Sampah</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Berat</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Harga</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Status</th>
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
         MODAL BUAT PENJUALAN PENGEPUL
         Dark mode : raw CSS .dark .tp-* di atas
    ══════════════════════════════════════════ --}}
    <div id="modalPenjualanWrap" aria-modal="true" role="dialog" aria-labelledby="modalPenjualanTitle"
        style="display:none; position:fixed; inset:0; z-index:999999;
               align-items:center; justify-content:center; padding:1rem;">

        {{-- Backdrop --}}
        <div id="modalPenjualanBackdrop" onclick="modalPenjualan.close()"
            style="position:absolute; inset:0;
                   background:rgba(16,24,40,0.55);
                   backdrop-filter:blur(3px);
                   -webkit-backdrop-filter:blur(3px);
                   opacity:0; transition:opacity 250ms ease;">
        </div>

        {{-- Panel — lebih lebar karena ada repeater --}}
        <div id="modalPenjualanPanel" class="relative flex w-full flex-col rounded-2xl border border-gray-200 bg-white"
            style="z-index:1; max-width:860px; max-height:92vh;
                   box-shadow:0 20px 24px -4px rgba(16,24,40,.10),0 8px 8px -4px rgba(16,24,40,.04);
                   transform:scale(0.94); opacity:0;
                   transition:transform 280ms cubic-bezier(0.34,1.36,0.64,1), opacity 250ms ease;">

            {{-- ── Header ── --}}
            <div id="tp-header" class="flex shrink-0 items-center justify-between border-b border-gray-200 px-5 py-4">
                <div class="flex items-center gap-3">
                    <span id="tp-icon-wrap" class="flex items-center justify-center rounded-xl bg-green-50"
                        style="width:36px;height:36px">
                        {{-- Ikon receipt / penjualan --}}
                        <svg style="width:20px;height:20px" class="text-green-600" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 14l2 2 4-4M7 3H5a2 2 0 00-2 2v16l3-2 3 2 3-2 3 2 3-2 3 2V5a2 2 0 00-2-2h-2" />
                        </svg>
                    </span>
                    <div>
                        <h3 id="modalPenjualanTitle" class="text-base font-semibold text-gray-800">
                            Buat Penjualan ke Pengepul
                        </h3>
                        <p id="tp-header-sub" class="text-xs text-gray-500">
                            Stok gudang akan terpotong otomatis saat disimpan
                        </p>
                    </div>
                </div>
                <button id="tp-close-btn" type="button" onclick="modalPenjualan.close()"
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
                <form id="formPenjualan" action="" {{-- action="{{ route('admin.transaksi-pengepul.store') }}" --}} method="POST" novalidate>
                    @csrf

                    {{-- Hidden: admin_id diisi via server (Auth::id()), tidak perlu input --}}
                    <input type="hidden" name="admin_id" value="{{ auth()->id() }}">

                    <div style="display:flex;flex-direction:column;gap:1.25rem;">

                        {{-- ════ INFORMASI TRANSAKSI ════ --}}
                        <div class="relative flex items-center gap-3" style="margin-top:4px">
                            <span
                                class="tp-section-label shrink-0 text-xs font-medium
                                         text-gray-400 bg-white pr-2">
                                Informasi Transaksi
                            </span>
                            <div class="tp-section-line flex-1 border-t border-gray-200"></div>
                        </div>

                        {{-- Baris 1: Pengepul + No. Invoice --}}
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">

                            {{-- Pengepul (pembeli_id) --}}
                            <div>
                                <label for="tp_pembeli_id" class="tp-label block text-sm font-medium text-gray-700"
                                    style="margin-bottom:6px">
                                    Pengepul <span class="text-red-500">*</span>
                                </label>
                                <div class="relative" style="height:44px">
                                    <select id="tp_pembeli_id" name="pembeli_id" required
                                        class="tp-select appearance-none w-full h-full rounded-lg
                                               border border-gray-300 bg-white
                                               text-sm text-gray-800
                                               pl-4 pr-9
                                               focus:outline-none focus:ring-2 focus:ring-green-500/20
                                               focus:border-green-400 transition">
                                        <option value="">— Pilih pengepul —</option>
                                        {{-- @foreach ($pengepul as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach --}}
                                    </select>
                                    <span
                                        class="tp-chevron pointer-events-none absolute top-1/2
                                                 -translate-y-1/2 right-3 text-sm text-gray-500
                                                 leading-none select-none">▾</span>
                                </div>
                            </div>

                            {{-- No. Invoice (auto-generate, readonly) --}}
                            <div>
                                <label for="tp_nomor_invoice" class="tp-label block text-sm font-medium text-gray-700"
                                    style="margin-bottom:6px">
                                    No. Invoice
                                    <span class="tp-label-opt text-xs font-normal text-gray-400">
                                        (otomatis)
                                    </span>
                                </label>
                                <div class="tp-invoice-badge flex items-center rounded-lg border
                                            border-gray-200 bg-gray-50 px-4 text-sm"
                                    style="height:44px; gap:8px;">
                                    <svg style="width:14px;height:14px;flex-shrink:0" class="text-gray-400"
                                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                    </svg>
                                    <input type="text" id="tp_nomor_invoice" name="nomor_invoice" readonly
                                        autocomplete="off" placeholder="Generating..."
                                        class="flex-1 bg-transparent text-sm text-gray-700
                                               placeholder-gray-400 focus:outline-none"
                                        style="min-width:0">
                                </div>
                                <p class="tp-hint text-xs text-gray-400" style="margin-top:6px">
                                    Format: INV-YYYYMMDD-XXXX
                                </p>
                            </div>
                        </div>

                        {{-- Baris 2: Metode Bayar + Status Bayar --}}
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">

                            {{-- Metode Pembayaran --}}
                            <div>
                                <label for="tp_metode_pembayaran" class="tp-label block text-sm font-medium text-gray-700"
                                    style="margin-bottom:6px">
                                    Metode Bayar <span class="text-red-500">*</span>
                                </label>
                                <div class="relative" style="height:44px">
                                    <select id="tp_metode_pembayaran" name="metode_pembayaran" required
                                        class="tp-select appearance-none w-full h-full rounded-lg
                                               border border-gray-300 bg-white
                                               text-sm text-gray-800
                                               pl-4 pr-9
                                               focus:outline-none focus:ring-2 focus:ring-green-500/20
                                               focus:border-green-400 transition">
                                        <option value="">— Pilih metode —</option>
                                        <option value="tunai">Tunai</option>
                                        <option value="transfer">Transfer</option>
                                    </select>
                                    <span
                                        class="tp-chevron pointer-events-none absolute top-1/2
                                                 -translate-y-1/2 right-3 text-sm text-gray-500
                                                 leading-none select-none">▾</span>
                                </div>
                            </div>

                            {{-- Status Pembayaran --}}
                            <div>
                                <label for="tp_status_pembayaran" class="tp-label block text-sm font-medium text-gray-700"
                                    style="margin-bottom:6px">
                                    Status Bayar <span class="text-red-500">*</span>
                                </label>
                                <div class="relative" style="height:44px">
                                    <select id="tp_status_pembayaran" name="status_pembayaran" required
                                        class="tp-select appearance-none w-full h-full rounded-lg
                                               border border-gray-300 bg-white
                                               text-sm text-gray-800
                                               pl-4 pr-9
                                               focus:outline-none focus:ring-2 focus:ring-green-500/20
                                               focus:border-green-400 transition">
                                        <option value="belum_bayar">Belum Bayar</option>
                                        <option value="lunas">Lunas</option>
                                    </select>
                                    <span
                                        class="tp-chevron pointer-events-none absolute top-1/2
                                                 -translate-y-1/2 right-3 text-sm text-gray-500
                                                 leading-none select-none">▾</span>
                                </div>
                            </div>
                        </div>

                        {{-- Catatan --}}
                        <div>
                            <label for="tp_catatan" class="tp-label block text-sm font-medium text-gray-700"
                                style="margin-bottom:6px">
                                Catatan
                                <span class="tp-label-opt text-xs font-normal text-gray-400">
                                    (opsional)
                                </span>
                            </label>
                            <textarea id="tp_catatan" name="catatan" rows="2" placeholder="Catatan tambahan untuk transaksi ini..."
                                class="tp-input w-full rounded-lg border border-gray-300 bg-white
                                       text-sm text-gray-800 placeholder-gray-400
                                       px-4 py-2.5
                                       focus:outline-none focus:ring-2 focus:ring-green-500/20
                                       focus:border-green-400 transition"
                                style="resize:none"></textarea>
                        </div>

                        {{-- ════ DETAIL ITEM ════ --}}
                        <div class="relative flex items-center gap-3" style="margin-top:4px">
                            <span
                                class="tp-section-label shrink-0 text-xs font-medium
                                         text-gray-400 bg-white pr-2">
                                Detail Item
                            </span>
                            <div class="tp-section-line flex-1 border-t border-gray-200"></div>
                        </div>

                        {{-- Repeater wrapper --}}
                        <div class="tp-repeater-wrap rounded-xl border border-gray-200 overflow-hidden">

                            {{-- Head --}}
                            <div class="tp-repeater-head"
                                style="display:grid;
                                       grid-template-columns: minmax(160px,1fr) 100px 120px 120px 40px;
                                       gap:0;
                                       background:#f9fafb;
                                       border-bottom:1px solid #e5e7eb;
                                       padding:0 12px;">
                                <div class="py-2.5 text-xs font-medium text-gray-500">Jenis Sampah</div>
                                <div class="py-2.5 text-xs font-medium text-gray-500 text-right pr-3">Berat (kg)</div>
                                <div class="py-2.5 text-xs font-medium text-gray-500 text-right pr-3">Harga/kg (Rp)</div>
                                <div class="py-2.5 text-xs font-medium text-gray-500 text-right pr-3">Subtotal (Rp)</div>
                                <div></div>
                            </div>

                            {{-- Rows container --}}
                            <div id="tpItemRows">
                                {{-- Baris default pertama — template diisi via JS --}}
                            </div>

                            {{-- Tombol tambah baris --}}
                            <div class="px-3 py-2.5 border-t border-gray-100">
                                <button type="button" onclick="tpAddRow()"
                                    class="tp-add-row-btn inline-flex items-center gap-1.5
                                           rounded-lg border border-gray-200 bg-transparent
                                           px-3 py-1.5 text-xs font-medium text-green-600
                                           transition hover:bg-green-50 hover:border-green-300">
                                    <svg style="width:13px;height:13px" fill="none" stroke="currentColor"
                                        stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    Tambah Baris
                                </button>
                            </div>
                        </div>

                        {{-- ════ RINGKASAN ════ --}}
                        <div class="tp-summary-strip rounded-xl border border-gray-200 bg-gray-50"
                            style="padding:14px 16px;">
                            <div style="display:flex; align-items:center; gap:0;">

                                {{-- Total Berat --}}
                                <div style="flex:1; text-align:center;">
                                    <p class="tp-summary-label text-xs text-gray-400" style="margin-bottom:4px">Total
                                        Berat</p>
                                    <p class="tp-summary-value text-base font-semibold text-gray-800">
                                        <span id="tpTotalBerat">0</span>
                                        <span class="text-xs font-normal text-gray-400 ml-0.5">kg</span>
                                    </p>
                                </div>

                                <div class="tp-summary-divider" style="width:1px;height:36px;background:#e5e7eb;"></div>

                                {{-- Total Harga --}}
                                <div style="flex:1; text-align:center;">
                                    <p class="tp-summary-label text-xs text-gray-400" style="margin-bottom:4px">Total
                                        Harga</p>
                                    <p class="tp-summary-value text-base font-semibold text-gray-800">
                                        <span class="text-xs font-normal text-gray-400 mr-0.5">Rp</span>
                                        <span id="tpTotalHarga">0</span>
                                    </p>
                                </div>

                                <div class="tp-summary-divider" style="width:1px;height:36px;background:#e5e7eb;"></div>

                                {{-- Jumlah Item --}}
                                <div style="flex:1; text-align:center;">
                                    <p class="tp-summary-label text-xs text-gray-400" style="margin-bottom:4px">Jumlah
                                        Item</p>
                                    <p class="tp-summary-value text-base font-semibold text-gray-800">
                                        <span id="tpJumlahItem">0</span>
                                        <span class="text-xs font-normal text-gray-400 ml-0.5">baris</span>
                                    </p>
                                </div>

                            </div>
                        </div>

                    </div>{{-- /fields --}}
                </form>
            </div>{{-- /body --}}

            {{-- ── Footer ── --}}
            <div id="tp-footer"
                class="flex shrink-0 items-center justify-end gap-3
                       border-t border-gray-200 px-5 py-4">
                <button type="button" onclick="modalPenjualan.close()"
                    class="tp-btn-cancel rounded-lg border border-gray-300 bg-white
                           px-4 py-2.5 text-sm font-medium text-gray-700
                           hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="button" onclick="tpSubmit()"
                    class="inline-flex items-center gap-2 rounded-lg bg-green-500
                           px-5 py-2.5 text-sm font-medium text-white
                           hover:bg-green-600 active:scale-95 transition">
                    <svg style="width:16px;height:16px" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Penjualan
                </button>
            </div>

        </div>{{-- /panel --}}
    </div>{{-- /wrap --}}
@endsection


@push('scripts')
    <script>
        (function() {
            'use strict';

            /* ─── Elemen utama ─── */
            const wrap = document.getElementById('modalPenjualanWrap');
            const backdrop = document.getElementById('modalPenjualanBackdrop');
            const panel = document.getElementById('modalPenjualanPanel');

            /* ── 1. OPEN / CLOSE ── */
            window.modalPenjualan = {
                open() {
                    tpGenerateInvoice(); // buat nomor invoice saat buka
                    wrap.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                    void wrap.offsetWidth;
                    backdrop.style.opacity = '1';
                    panel.style.transform = 'scale(1)';
                    panel.style.opacity = '1';

                    /* pastikan minimal 1 baris saat dibuka */
                    if (document.querySelectorAll('.tp-item-row').length === 0) {
                        tpAddRow();
                    }
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
                    window.modalPenjualan.close();
                }
            });


            /* ── 2. GENERATE NOMOR INVOICE ── */
            function tpGenerateInvoice() {
                /*
                 * Format: INV-YYYYMMDD-XXXX
                 * Dalam produksi, nomor final di-generate server
                 * (PenjualanPengepul::generateNomorInvoice()).
                 * Di sini hanya preview client-side.
                 */
                var now = new Date();
                var ymd = now.getFullYear().toString() +
                    String(now.getMonth() + 1).padStart(2, '0') +
                    String(now.getDate()).padStart(2, '0');
                var rand = String(Math.floor(1000 + Math.random() * 9000));
                document.getElementById('tp_nomor_invoice').value = 'INV-' + ymd + '-' + rand;
            }


            /* ── 3. REPEATER BARIS ITEM ── */
            var tpRowIndex = 0;

            var tpKategoriData = [
              
            ];

            /* Bangun <option> dari tpKategoriData */
            function tpBuildOptions(excludeIds) {
                var html = '<option value="">— Pilih jenis sampah —</option>';
                tpKategoriData.forEach(function(k) {
                    if (excludeIds.indexOf(String(k.id)) === -1) {
                        html += '<option value="' + k.id + '" ' +
                            'data-harga="' + k.harga_per_kg + '" ' +
                            'data-stok="' + k.stok_tersedia + '">' +
                            k.nama +
                            ' (stok: ' + k.stok_tersedia + ' kg)' +
                            '</option>';
                    }
                });
                return html;
            }

            /* Daftar kategori_sampah_id yang sudah dipilih di baris lain */
            function tpUsedIds() {
                var used = [];
                document.querySelectorAll('.tp-row-kategori').forEach(function(sel) {
                    if (sel.value) used.push(sel.value);
                });
                return used;
            }

            /* Refresh semua select agar tidak duplikat pilihan */
            function tpRefreshSelects(changedSel) {
                var usedAll = tpUsedIds();
                document.querySelectorAll('.tp-row-kategori').forEach(function(sel) {
                    var currentVal = sel.value;
                    /* exclude semua used kecuali milik select ini sendiri */
                    var exclude = usedAll.filter(function(id) {
                        return id !== currentVal;
                    });
                    sel.innerHTML = tpBuildOptions(exclude);
                    sel.value = currentVal; /* kembalikan nilai yang dipilih */
                });
            }

            window.tpAddRow = function() {
                var idx = tpRowIndex++;
                var used = tpUsedIds();

                var row = document.createElement('div');
                row.className = 'tp-item-row';
                row.dataset.idx = idx;
                row.style.cssText = 'display:grid;' +
                    'grid-template-columns: minmax(160px,1fr) 100px 120px 120px 40px;' +
                    'align-items:center; gap:0;' +
                    'padding:8px 12px;' +
                    'border-bottom:1px solid #e5e7eb;';

                row.innerHTML =
                    /* Jenis sampah */
                    '<div style="padding-right:8px">' +
                    '<select name="items[' + idx + '][kategori_sampah_id]"' +
                    ' class="tp-row-select tp-row-kategori appearance-none w-full rounded-lg' +
                    ' border border-gray-300 bg-white text-sm text-gray-800' +
                    ' pl-3 pr-7 focus:outline-none transition"' +
                    ' style="height:36px"' +
                    ' onchange="tpOnKategoriChange(this)">' +
                    tpBuildOptions(used) +
                    '</select>' +
                    '</div>'

                    /* Berat */
                    +
                    '<div style="padding-right:8px">' +
                    '<input type="number" name="items[' + idx + '][berat]"' +
                    ' class="tp-row-input w-full rounded-lg border border-gray-300 bg-white' +
                    ' text-sm text-gray-800 text-right px-3 focus:outline-none transition"' +
                    ' style="height:36px"' +
                    ' step="0.01" min="0.01" placeholder="0.00" required' +
                    ' oninput="tpCalcRow(this.closest(\'.tp-item-row\'))">' +
                    '</div>'

                    /* Harga per kg */
                    +
                    '<div style="padding-right:8px">' +
                    '<input type="number" name="items[' + idx + '][harga_per_kg]"' +
                    ' class="tp-row-input w-full rounded-lg border border-gray-300 bg-white' +
                    ' text-sm text-gray-800 text-right px-3 focus:outline-none transition"' +
                    ' style="height:36px"' +
                    ' step="1" min="0" placeholder="0" required' +
                    ' oninput="tpCalcRow(this.closest(\'.tp-item-row\'))">' +
                    '</div>'

                    /* Subtotal (readonly) */
                    +
                    '<div style="padding-right:8px">' +
                    '<input type="number" name="items[' + idx + '][subtotal]"' +
                    ' class="tp-row-input w-full rounded-lg border border-gray-200 bg-gray-50' +
                    ' text-sm text-gray-500 text-right px-3 focus:outline-none"' +
                    ' style="height:36px"' +
                    ' readonly tabindex="-1" placeholder="0">' +
                    '</div>'

                    /* Hapus baris */
                    +
                    '<div style="display:flex;justify-content:center;">' +
                    '<button type="button"' +
                    ' class="tp-row-del-btn flex items-center justify-center rounded-lg' +
                    ' text-gray-400 transition hover:text-red-500 hover:bg-red-50"' +
                    ' style="width:32px;height:32px"' +
                    ' onclick="tpRemoveRow(this)" aria-label="Hapus baris">' +
                    '<svg style="width:15px;height:15px" fill="none" stroke="currentColor"' +
                    ' stroke-width="2" viewBox="0 0 24 24">' +
                    '<path stroke-linecap="round" stroke-linejoin="round"' +
                    ' d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858' +
                    'L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>' +
                    '</svg>' +
                    '</button>' +
                    '</div>';

                document.getElementById('tpItemRows').appendChild(row);
                tpUpdateSummary();
            };

            window.tpRemoveRow = function(btn) {
                var row = btn.closest('.tp-item-row');
                if (document.querySelectorAll('.tp-item-row').length <= 1) {
                    /* jangan hapus baris terakhir — reset saja */
                    row.querySelectorAll('input[type="number"]').forEach(function(i) {
                        i.value = '';
                    });
                    row.querySelector('.tp-row-kategori').value = '';
                    tpUpdateSummary();
                    return;
                }
                row.remove();
                tpRefreshSelects(null);
                tpUpdateSummary();
            };

            /* Saat pilih kategori → prefill harga_per_kg dari data */
            window.tpOnKategoriChange = function(sel) {
                var row = sel.closest('.tp-item-row');
                var opt = sel.options[sel.selectedIndex];
                var harga = opt ? (opt.dataset.harga || '') : '';

                /* prefill harga/kg */
                row.querySelector('input[name$="[harga_per_kg]"]').value = harga;

                /* set max berat dari stok */
                var stok = opt ? parseFloat(opt.dataset.stok || 0) : 0;
                var beratInput = row.querySelector('input[name$="[berat]"]');
                if (stok > 0) {
                    beratInput.max = stok;
                    beratInput.title = 'Maks. ' + stok + ' kg (stok tersedia)';
                } else {
                    beratInput.removeAttribute('max');
                }

                tpRefreshSelects(sel);
                tpCalcRow(row);
            };

            /* Hitung subtotal satu baris & refresh summary */
            window.tpCalcRow = function(row) {
                var berat = parseFloat(row.querySelector('input[name$="[berat]"]').value) || 0;
                var harga = parseFloat(row.querySelector('input[name$="[harga_per_kg]"]').value) || 0;
                var sub = berat * harga;
                row.querySelector('input[name$="[subtotal]"]').value = sub > 0 ? sub.toFixed(0) : '';
                tpUpdateSummary();
            };

            /* Hitung & tampilkan total keseluruhan */
            function tpUpdateSummary() {
                var totalBerat = 0,
                    totalHarga = 0;
                var jumlah = 0;

                document.querySelectorAll('.tp-item-row').forEach(function(row) {
                    var b = parseFloat(row.querySelector('input[name$="[berat]"]').value) || 0;
                    var s = parseFloat(row.querySelector('input[name$="[subtotal]"]').value) || 0;
                    if (b > 0) {
                        totalBerat += b;
                        totalHarga += s;
                        jumlah++;
                    }
                });

                document.getElementById('tpTotalBerat').textContent =
                    totalBerat % 1 === 0 ? totalBerat.toString() : totalBerat.toFixed(2);
                document.getElementById('tpTotalHarga').textContent =
                    totalHarga.toLocaleString('id-ID');
                document.getElementById('tpJumlahItem').textContent = jumlah;
            }


            /* ── 4. SUBMIT + VALIDASI ── */
            window.tpSubmit = function() {
                var form = document.getElementById('formPenjualan');
                var valid = true;

                /* Cek minimal 1 baris item terisi */
                var hasItem = false;
                document.querySelectorAll('.tp-item-row').forEach(function(row) {
                    var kat = row.querySelector('.tp-row-kategori').value;
                    var berat = row.querySelector('input[name$="[berat]"]').value;
                    if (kat && parseFloat(berat) > 0) hasItem = true;
                });

                if (!hasItem) {
                    alert('Tambahkan minimal 1 baris item dengan jenis sampah dan berat yang valid.');
                    valid = false;
                }

                if (!valid) return;

                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }
                form.submit();
            };

        })();
    </script>
@endpush

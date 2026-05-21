<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Go Garbage – Request Saya</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <style>
        * {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: #e8e8e8;
            display: flex;
            justify-content: center;
            min-height: 100vh;
        }

        .phone-wrapper {
            width: 390px;
            height: 100vh;
            background: #f2f3f7;
            position: relative;
            overflow: hidden;
            box-shadow: 0 0 48px rgba(0, 0, 0, 0.18);
            display: flex;
            flex-direction: column;
        }

        @media (max-width: 390px) {
            body {
                background: #f2f3f7;
            }

            .phone-wrapper {
                width: 100%;
                box-shadow: none;
            }
        }

        .page-header {
            background: linear-gradient(135deg, #2ecc71 0%, #1aab57 60%, #168a45 100%);
            padding: 20px 20px 20px;
            flex-shrink: 0;
        }

        .tab-bar {
            background: #fff;
            display: flex;
            align-items: flex-end;
            padding: 0 16px;
            border-bottom: 1.5px solid #e5e7eb;
            flex-shrink: 0;
            overflow-x: auto;
            scrollbar-width: none;
            gap: 4px;
        }

        .tab-bar::-webkit-scrollbar {
            display: none;
        }

        .tab-item {
            padding: 14px 10px 12px;
            font-size: 13px;
            font-weight: 600;
            color: #9ca3af;
            cursor: pointer;
            white-space: nowrap;
            border-bottom: 2.5px solid transparent;
            transition: all 0.18s;
            text-decoration: none;
        }

        .tab-item.active {
            color: #16a34a;
            border-bottom-color: #16a34a;
            font-weight: 700;
        }

        .scroll-area {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }

        .scroll-area::-webkit-scrollbar {
            display: none;
        }

        .req-card {
            background: #fff;
            border-radius: 16px;
            padding: 16px 16px 14px;
            margin: 12px 16px 0;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            border-left: 4px solid transparent;
            text-decoration: none;
            display: block;
        }

        .chip {
            display: inline-block;
            background: #f3f4f6;
            color: #374151;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 99px;
        }

        .badge-yellow {
            background: #fef3c7;
            color: #d97706;
            font-size: 11.5px;
            font-weight: 700;
            padding: 5px 13px;
            border-radius: 99px;
            white-space: nowrap;
        }

        .badge-green {
            background: #dcfce7;
            color: #16a34a;
            font-size: 11.5px;
            font-weight: 700;
            padding: 5px 13px;
            border-radius: 99px;
            white-space: nowrap;
        }

        .badge-gray {
            background: #f3f4f6;
            color: #6b7280;
            font-size: 11.5px;
            font-weight: 700;
            padding: 5px 13px;
            border-radius: 99px;
            white-space: nowrap;
        }

        .badge-red {
            background: #fee2e2;
            color: #dc2626;
            font-size: 11.5px;
            font-weight: 700;
            padding: 5px 13px;
            border-radius: 99px;
            white-space: nowrap;
        }

        .info-note {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            padding: 9px 12px;
            font-size: 12px;
            font-weight: 600;
            color: #16a34a;
            margin-top: 12px;
        }

        .nav-bottom {
            height: 64px;
            background: #fff;
            border-top: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-around;
            flex-shrink: 0;
        }

        .nav-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            padding-top: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        /* FAB */
        .fab {
            position: absolute;
            bottom: 80px;
            right: 20px;
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(22, 163, 74, 0.4);
            cursor: pointer;
            z-index: 50;
            border: none;
            transition: transform 0.15s;
        }

        .fab:active {
            transform: scale(0.9);
        }

        /* Modal – smooth slide-up animation */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0);
            z-index: 999;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            visibility: hidden;
            pointer-events: none;
            transition: background 0.35s ease, visibility 0s linear 0.35s;
        }

        .modal-backdrop.show {
            visibility: visible;
            pointer-events: auto;
            background: rgba(0, 0, 0, 0.45);
            transition: background 0.35s ease, visibility 0s linear 0s;
        }

        .modal-sheet {
            width: 390px;
            max-height: 85vh;
            background: #fff;
            border-radius: 24px 24px 0 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            transform: translateY(100%);
            opacity: 0;
            transition:
                transform 0.45s cubic-bezier(0.16, 1, 0.3, 1),
                opacity 0.3s ease;
            will-change: transform, opacity;
            box-shadow: 0 -8px 40px rgba(0, 0, 0, 0.12);
        }

        .modal-backdrop.show .modal-sheet {
            transform: translateY(0);
            opacity: 1;
        }

        @media (max-width: 390px) {
            .modal-sheet {
                width: 100%;
            }
        }

        .modal-body {
            flex: 1;
            overflow-y: auto;
            padding: 0 20px 20px;
            scrollbar-width: none;
        }

        .modal-body::-webkit-scrollbar {
            display: none;
        }

        .form-select {
            width: 100%;
            height: 40px;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 0 12px;
            font-size: 13px;
            font-family: 'Poppins', sans-serif;
            color: #111827;
            background: #fff;
            appearance: none;
            -webkit-appearance: none;
        }

        .form-select:focus {
            outline: none;
            border-color: #16a34a;
            box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.12);
        }

        .form-input {
            width: 100%;
            height: 40px;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 0 12px;
            font-size: 13px;
            font-family: 'Poppins', sans-serif;
            color: #111827;
        }

        .form-input:focus {
            outline: none;
            border-color: #16a34a;
            box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.12);
        }

        .form-textarea {
            width: 100%;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 13px;
            font-family: 'Poppins', sans-serif;
            color: #111827;
            resize: none;
        }

        .form-textarea:focus {
            outline: none;
            border-color: #16a34a;
            box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.12);
        }
    </style>
</head>

<body>
    <div class="phone-wrapper">

        <!-- ── HEADER ── -->
        <div class="page-header">
            <div style="display:flex;align-items:center;gap:14px;margin-bottom:4px;">
                <a href="{{ route('pengepul.index') }}"
                    style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;text-decoration:none;">
                    <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 style="font-size:20px;font-weight:800;color:#fff;">Request Saya</h1>
            </div>
            <p style="font-size:13px;color:rgba(255,255,255,0.82);font-weight:400;padding-left:50px;">
                {{ $countAll }} total request</p>
        </div>

        <!-- ── TAB BAR ── -->
        <div class="tab-bar">
            <a href="{{ route('pengepul.request', ['status' => 'semua']) }}"
                class="tab-item {{ $filter === 'semua' ? 'active' : '' }}">Semua ({{ $countAll }})</a>
            <a href="{{ route('pengepul.request', ['status' => 'menunggu']) }}"
                class="tab-item {{ $filter === 'menunggu' ? 'active' : '' }}">Menunggu ({{ $countMenunggu }})</a>
            <a href="{{ route('pengepul.request', ['status' => 'disetujui']) }}"
                class="tab-item {{ $filter === 'disetujui' ? 'active' : '' }}">Disetujui ({{ $countDisetujui }})</a>
            <a href="{{ route('pengepul.request', ['status' => 'selesai']) }}"
                class="tab-item {{ $filter === 'selesai' ? 'active' : '' }}">Selesai ({{ $countSelesai }})</a>
            <a href="{{ route('pengepul.request', ['status' => 'ditolak']) }}"
                class="tab-item {{ $filter === 'ditolak' ? 'active' : '' }}">Ditolak ({{ $countDitolak }})</a>
        </div>

        <!-- ── SCROLL AREA ── -->
        <div class="scroll-area">
            <div style="padding-bottom:28px;">

                @if (session('success'))
                    <div
                        style="margin:12px 16px 0;padding:12px 14px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;font-size:13px;font-weight:600;color:#16a34a;">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div
                        style="margin:12px 16px 0;padding:12px 14px;background:#fee2e2;border:1px solid #fecaca;border-radius:12px;font-size:13px;font-weight:600;color:#dc2626;">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div
                        style="margin:12px 16px 0;padding:12px 14px;background:#fee2e2;border:1px solid #fecaca;border-radius:12px;font-size:13px;font-weight:600;color:#dc2626;">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                @forelse($requests as $req)
                    @php
                        $borderColor = match ($req->status) {
                            'menunggu' => '#f59e0b',
                            'disetujui' => '#16a34a',
                            'ditolak' => '#dc2626',
                            default => '#9ca3af',
                        };
                        $isSelesai = $req->status === 'selesai';
                    @endphp
                    <div class="req-card" style="border-left-color:{{ $borderColor }};">
                        <div
                            style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:10px;">
                            <p style="font-size:14px;font-weight:800;color:#111827;">{{ $req->nomor_invoice }}</p>
                            @if ($req->status === 'menunggu')
                                <span class="badge-yellow">Menunggu</span>
                            @elseif($req->status === 'disetujui')
                                <span class="badge-green">Disetujui</span>
                            @elseif($req->status === 'selesai')
                                <span class="badge-gray">Selesai</span>
                            @elseif($req->status === 'ditolak')
                                <span class="badge-red">Ditolak</span>
                            @endif
                        </div>
                        <p style="font-size:12px;color:#6b7280;font-weight:500;margin-bottom:10px;">
                            {{ $req->detail->count() }} item ·
                            {{ $isSelesai ? '' : 'Est. ' }}{{ number_format($req->total_berat, 1, ',', '.') }}
                            kg{{ $isSelesai ? ' (actual)' : '' }}
                        </p>
                        <div style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:12px;">
                            @foreach ($req->detail as $d)
                                <span class="chip">{{ $d->kategori?->nama ?? '-' }}
                                    {{ number_format($d->berat, 1, ',', '.') }}kg</span>
                            @endforeach
                        </div>
                        <div style="display:flex;align-items:center;justify-content:space-between;">
                            <span
                                style="font-size:11.5px;color:#9ca3af;font-weight:500;">{{ $req->created_at->format('d M Y, H:i') }}</span>
                            <span
                                style="font-size:13px;font-weight:800;color:{{ $isSelesai ? '#16a34a' : '#111827' }};">
                                {{ $isSelesai ? '' : '~' }}Rp {{ number_format($req->total_harga, 0, ',', '.') }}
                            </span>
                        </div>
                        @if ($req->catatan)
                            <p style="font-size:11.5px;color:#9ca3af;font-weight:500;margin-top:4px;font-style:italic;">
                                Catatan: {{ $req->catatan }}</p>
                        @endif
                        @if ($req->status === 'disetujui')
                            <div class="info-note">Silakan datang ke gudang</div>
                        @endif
                        @if ($isSelesai)
                            <div style="margin-top:8px;">
                                @if ($req->status_pembayaran === 'lunas')
                                    <span
                                        style="display:inline-flex;align-items:center;gap:5px;font-size:11.5px;font-weight:700;color:#16a34a;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:99px;padding:4px 12px;">
                                        <svg width="12" height="12" fill="none" stroke="#16a34a"
                                            stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Lunas
                                    </span>
                                @else
                                    <span class="badge-red">Belum Bayar</span>
                                @endif
                            </div>
                        @endif
                    </div>
                @empty
                    <div
                        style="background:#fff;border-radius:16px;padding:40px 16px;margin:16px;box-shadow:0 2px 12px rgba(0,0,0,0.06);text-align:center;">
                        <svg width="48" height="48" fill="none" stroke="#d1d5db" stroke-width="1.5"
                            viewBox="0 0 24 24" style="margin:0 auto 12px;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p style="font-size:14px;color:#9ca3af;font-weight:600;">Belum ada request</p>
                        <p style="font-size:12px;color:#d1d5db;margin-top:4px;">Tekan tombol + untuk membuat request
                            baru</p>
                    </div>
                @endforelse

            </div>
        </div>

        <!-- ── FAB ── -->
        <button class="fab" onclick="openRequestModal()">
            <svg width="28" height="28" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
        </button>

        <!-- ── BOTTOM NAV ── -->
        @include('pengepul.partials.navigation')

    </div>


    {{-- ═══════════════════════════════════════
         MODAL: BUAT REQUEST AMBIL (Prompt 4A)
    ═══════════════════════════════════════ --}}
    <div class="modal-backdrop" id="requestModal">
        <div class="modal-sheet">

            <!-- Handle bar -->
            <div style="display:flex;justify-content:center;padding:10px 0 4px;">
                <div style="width:40px;height:4px;background:#d1d5db;border-radius:99px;"></div>
            </div>

            <!-- Header -->
            <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 20px 14px;">
                <div>
                    <h3 style="font-size:16px;font-weight:800;color:#111827;">Buat Request Ambil</h3>
                    <p style="font-size:12px;color:#9ca3af;font-weight:400;margin-top:2px;">Pilih jenis dan estimasi
                        berat</p>
                </div>
                <button onclick="closeRequestModal()"
                    style="width:32px;height:32px;background:#f3f4f6;border-radius:50%;border:none;display:flex;align-items:center;justify-content:center;cursor:pointer;">
                    <svg width="18" height="18" fill="none" stroke="#6b7280" stroke-width="2.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <form id="formRequest" action="{{ route('pengepul.request.store') }}" method="POST">
                    @csrf

                    <!-- Item rows -->
                    <div style="margin-bottom:16px;">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                            <p style="font-size:13px;font-weight:700;color:#111827;">Item Sampah</p>
                            <button type="button" onclick="addItemRow()"
                                style="font-size:12px;font-weight:700;color:#16a34a;background:none;border:1.5px dashed #16a34a;border-radius:8px;padding:5px 12px;cursor:pointer;display:flex;align-items:center;gap:4px;">
                                <svg width="14" height="14" fill="none" stroke="#16a34a"
                                    stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Item
                            </button>
                        </div>
                        <div id="itemRows"></div>
                    </div>

                    <!-- Summary -->
                    <div id="summaryStrip"
                        style="background:#f0fdf4;border-radius:12px;padding:12px 14px;display:flex;align-items:center;justify-content:space-around;margin-bottom:16px;">
                        <div style="text-align:center;">
                            <p style="font-size:10px;color:#6b7280;font-weight:500;">Item</p>
                            <p style="font-size:14px;font-weight:800;color:#111827;" id="sumItem">0</p>
                        </div>
                        <div style="width:1px;height:28px;background:#bbf7d0;"></div>
                        <div style="text-align:center;">
                            <p style="font-size:10px;color:#6b7280;font-weight:500;">Est. Berat</p>
                            <p style="font-size:14px;font-weight:800;color:#111827;" id="sumBerat">0 kg</p>
                        </div>
                        <div style="width:1px;height:28px;background:#bbf7d0;"></div>
                        <div style="text-align:center;">
                            <p style="font-size:10px;color:#6b7280;font-weight:500;">Est. Harga</p>
                            <p style="font-size:14px;font-weight:800;color:#111827;" id="sumHarga">Rp 0</p>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <div style="margin-bottom:16px;">
                        <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">
                            Catatan <span style="font-size:11px;color:#9ca3af;font-weight:400;">(opsional)</span>
                        </label>
                        <textarea name="catatan" rows="2" class="form-textarea" placeholder="Contoh: Ambil sore hari setelah jam 3"></textarea>
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        style="width:100%;padding:14px;background:linear-gradient(135deg,#22c55e 0%,#16a34a 100%);color:#fff;font-size:14px;font-weight:800;font-family:'Poppins',sans-serif;border:none;border-radius:14px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:transform 0.15s;"
                        onmousedown="this.style.transform='scale(0.97)'" onmouseup="this.style.transform='scale(1)'">
                        <svg width="18" height="18" fill="none" stroke="#fff" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Kirim Request
                    </button>
                </form>
            </div>

        </div>
    </div>

    <script>
        (function() {
            'use strict';

            // Kategori data dari server
            @php
                $kategoriJson = $kategori
                    ->map(function ($k) {
                        return [
                            'id' => $k->id,
                            'nama' => $k->nama,
                            'harga' => $k->harga_per_kg,
                            'stok' => $k->stokGudang ? $k->stokGudang->stok_kg : 0,
                        ];
                    })
                    ->values();
            @endphp
            var kategoriData = @json($kategoriJson);

            var rowIdx = 0;

            // Open modal with smooth slide-up
            window.openRequestModal = function() {
                var modal = document.getElementById('requestModal');
                // Use rAF to ensure the browser paints the hidden state first
                requestAnimationFrame(function() {
                    modal.classList.add('show');
                });
                document.body.style.overflow = 'hidden';
                if (document.querySelectorAll('.item-row').length === 0) {
                    addItemRow();
                }
            };

            // Close modal with smooth slide-down
            window.closeRequestModal = function() {
                var modal = document.getElementById('requestModal');
                modal.classList.remove('show');
                document.body.style.overflow = '';
            };

            // Close on backdrop click
            document.getElementById('requestModal').addEventListener('click', function(e) {
                if (e.target === this) closeRequestModal();
            });

            // Add item row
            window.addItemRow = function() {
                var idx = rowIdx++;
                var row = document.createElement('div');
                row.className = 'item-row';
                row.dataset.idx = idx;
                row.style.cssText = 'display:flex;align-items:center;gap:8px;margin-bottom:10px;';

                var optionsHtml = '<option value="">— Pilih —</option>';
                kategoriData.forEach(function(k) {
                    optionsHtml += '<option value="' + k.id + '" data-harga="' + k.harga + '" data-stok="' +
                        k.stok + '">' + k.nama + ' (' + k.stok + ' kg)</option>';
                });

                row.innerHTML =
                    '<div style="flex:1;">' +
                    '<select name="items[' + idx +
                    '][kategori_sampah_id]" class="form-select item-kategori" onchange="updateSummary()" required>' +
                    optionsHtml +
                    '</select>' +
                    '</div>' +
                    '<div style="width:90px;">' +
                    '<input type="number" name="items[' + idx +
                    '][berat]" class="form-input item-berat" placeholder="kg" step="0.1" min="0.1" oninput="updateSummary()" required />' +
                    '</div>' +
                    '<button type="button" onclick="removeRow(this)" style="width:32px;height:32px;background:none;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;">' +
                    '<svg width="18" height="18" fill="none" stroke="#ef4444" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>' +
                    '</button>';

                document.getElementById('itemRows').appendChild(row);
                updateSummary();
            };

            window.removeRow = function(btn) {
                btn.closest('.item-row').remove();
                updateSummary();
            };

            window.updateSummary = function() {
                var rows = document.querySelectorAll('.item-row');
                var totalBerat = 0;
                var totalHarga = 0;

                rows.forEach(function(row) {
                    var sel = row.querySelector('.item-kategori');
                    var inp = row.querySelector('.item-berat');
                    var berat = parseFloat(inp.value) || 0;
                    var harga = 0;
                    if (sel.selectedIndex > 0) {
                        harga = parseFloat(sel.options[sel.selectedIndex].dataset.harga) || 0;
                    }
                    totalBerat += berat;
                    totalHarga += berat * harga;
                });

                document.getElementById('sumItem').textContent = rows.length;
                document.getElementById('sumBerat').textContent = totalBerat.toFixed(1) + ' kg';
                document.getElementById('sumHarga').textContent = 'Rp ' + totalHarga.toLocaleString('id-ID');
            };

        })();
    </script>
</body>

</html>

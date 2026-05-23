<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Proses Jemput</title>
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
            align-items: flex-start;
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

        .scroll-area {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .scroll-area::-webkit-scrollbar {
            display: none;
        }

        /* ── Header ── */
        .header-green {
            background: linear-gradient(150deg, #2ecc71 0%, #1aab57 50%, #168a45 100%);
            padding: 44px 20px 22px;
            flex-shrink: 0;
        }

        /* ── Cards ── */
        .white-card {
            background: #fff;
            border-radius: 18px;
            margin: 16px 16px 14px;
            padding: 20px;
            box-shadow: 0 2px 14px rgba(0, 0, 0, 0.07);
        }

        /* ── Navigasi btn ── */
        .btn-navigasi {
            width: 100%;
            padding: 13px 0;
            border-radius: 12px;
            border: none;
            background: #2563eb;
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 16px;
            transition: opacity 0.18s;
        }

        .btn-navigasi:hover {
            opacity: 0.88;
        }

        /* ── Timeline circles ── */
        .step-circle-active {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 3px solid #2563eb;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
            flex-shrink: 0;
            animation: pulse-ring 2s infinite;
        }

        .step-circle-active::after {
            content: '';
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #2563eb;
        }

        .step-circle-done {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 3px solid #16a34a;
            background: #16a34a;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
            flex-shrink: 0;
        }

        .step-circle-inactive {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2.5px solid #d1d5db;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
            flex-shrink: 0;
        }

        .step-circle-inactive::after {
            content: '';
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #d1d5db;
        }

        .step-line {
            width: 2px;
            height: 44px;
            background: #e5e7eb;
            margin: 2px 0;
        }

        .step-line-done {
            width: 2px;
            height: 44px;
            background: #16a34a;
            margin: 2px 0;
        }

        @keyframes pulse-ring {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.40);
            }

            70% {
                box-shadow: 0 0 0 8px rgba(37, 99, 235, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(37, 99, 235, 0);
            }
        }

        /* ── Tambah Sampah btn ── */
        .btn-tambah {
            width: 100%;
            padding: 13px 0;
            border-radius: 12px;
            border: 2px dashed #16a34a;
            color: #16a34a;
            font-size: 14px;
            font-weight: 700;
            background: #f0fdf4;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: background 0.18s;
        }

        .btn-tambah:hover {
            background: #dcfce7;
        }

        /* ── Kalkulasi Card ── */
        .kalkulasi-card {
            background: #fff;
            border-radius: 18px;
            margin: 0 16px 14px;
            box-shadow: 0 2px 14px rgba(0, 0, 0, 0.07);
            overflow: hidden;
        }

        .kalk-header {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            padding: 14px 18px 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 1px solid #bbf7d0;
        }

        .kalk-body {
            padding: 16px 18px;
        }

        /* Weight row pill */
        .weight-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 11px 14px;
            border-radius: 12px;
            margin-bottom: 8px;
        }

        .weight-row:last-of-type {
            margin-bottom: 0;
        }

        .weight-badge {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .weight-icon {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        /* Manual price input row */
        .price-input-wrap {
            margin-top: 14px;
            background: #fafafa;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
        }

        .price-input-label-row {
            padding: 10px 14px 0;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .price-input-field {
            width: 100%;
            padding: 8px 14px 12px;
            border: none;
            background: transparent;
            font-size: 18px;
            font-weight: 700;
            color: #111827;
            outline: none;
        }

        .price-input-field::placeholder {
            color: #d1d5db;
            font-weight: 600;
        }

        .price-input-field:focus+.price-underline {
            opacity: 1;
        }

        .price-input-wrap:focus-within {
            border-color: #16a34a;
            background: #f0fdf4;
        }

        /* Divider */
        .kalk-divider {
            height: 1px;
            background: #f3f4f6;
            margin: 14px 0;
        }

        /* Total row */
        .total-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 14px;
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border-radius: 12px;
        }

        /* ── Tips banner ── */
        .tips-banner {
            background: #fef9c3;
            border-left: 4px solid #f59e0b;
            border-radius: 10px;
            margin: 0 16px 14px;
            padding: 14px 16px;
        }

        /* ── Bottom bar ── */
        .bottom-bar {
            background: #fff;
            border-top: 1px solid #e5e7eb;
            padding: 14px 16px;
            flex-shrink: 0;
        }

        .btn-main {
            width: 100%;
            padding: 15px 0;
            border-radius: 50px;
            border: none;
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            background: linear-gradient(135deg, #2ecc71 0%, #16a34a 100%);
            cursor: pointer;
            transition: opacity 0.18s, transform 0.1s;
        }

        .btn-main:hover {
            opacity: 0.9;
        }

        .btn-main:active {
            transform: scale(0.98);
        }

        /* ── Modal overlay ── */
        .modal-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            display: flex;
            align-items: flex-end;
            justify-content: center;
            z-index: 100;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s;
        }

        .modal-overlay.active {
            opacity: 1;
            pointer-events: all;
        }

        .modal-sheet {
            background: #fff;
            border-radius: 24px 24px 0 0;
            width: 100%;
            padding: 20px 20px 36px;
            transform: translateY(100%);
            transition: transform 0.32s cubic-bezier(0.32, 0.72, 0, 1);
        }

        .modal-overlay.active .modal-sheet {
            transform: translateY(0);
        }

        .modal-handle {
            width: 40px;
            height: 4px;
            background: #e5e7eb;
            border-radius: 99px;
            margin: 0 auto 22px;
        }

        /* ── Form ── */
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex: 1;
        }

        .form-label {
            font-size: 11.5px;
            font-weight: 600;
            color: #6b7280;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        .form-input {
            width: 100%;
            padding: 13px 14px;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            color: #111827;
            outline: none;
            transition: border-color 0.18s, background 0.18s;
            background: #fafafa;
            appearance: none;
            -webkit-appearance: none;
        }

        .form-input:focus {
            border-color: #16a34a;
            background: #f0fdf4;
        }

        select.form-input {
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' fill='none' stroke='%236b7280' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 38px;
        }

        .btn-simpan {
            width: 100%;
            padding: 15px 0;
            border-radius: 14px;
            border: none;
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            background: linear-gradient(135deg, #2ecc71 0%, #16a34a 100%);
            cursor: pointer;
            margin-top: 22px;
            transition: opacity 0.18s, transform 0.1s;
            letter-spacing: 0.2px;
        }

        .btn-simpan:hover {
            opacity: 0.9;
        }

        .btn-simpan:active {
            transform: scale(0.98);
        }

        /* ── Toast ── */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateX(-50%) translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="phone-wrapper" id="app">

        <!-- ── HEADER ── -->
        <div class="header-green">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:5px;">
                <button style="background:none;border:none;cursor:pointer;padding:0;display:flex;align-items:center;">
                    <svg width="22" height="22" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <p style="font-size:20px;font-weight:800;color:#fff;">Proses Jemput</p>
            </div>
            <p style="font-size:13px;color:rgba(255,255,255,0.88);font-weight:500;padding-left:34px;">Order {{ $pesanan->nomor_pesanan }}</p>
        </div>

        <!-- ── SCROLL AREA ── -->
        <div class="scroll-area" id="scrollArea">
            <div style="padding-bottom:20px;">

                <!-- Customer Card -->
                <div class="white-card">
                    <p style="font-size:17px;font-weight:800;color:#111827;margin-bottom:8px;">{{ $pesanan->pengguna->name ?? 'Pelanggan' }}</p>
                    <div style="display:flex;align-items:flex-start;gap:6px;">
                        <svg width="15" height="15" fill="none" stroke="#ef4444" stroke-width="2" viewBox="0 0 24 24"
                            style="flex-shrink:0;margin-top:3px;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <p style="font-size:13px;color:#6b7280;line-height:1.65;">{{ $pesanan->alamat_jemput }}</p>
                    </div>
                    @php
                        if ($pesanan->latitude && $pesanan->longitude) {
                            $mapUrl = "https://www.google.com/maps/dir/?api=1&destination={$pesanan->latitude},{$pesanan->longitude}";
                        } else {
                            $mapUrl = "https://maps.google.com/?q=" . urlencode($pesanan->alamat_jemput);
                        }
                    @endphp
                    <a href="{{ $mapUrl }}" target="_blank" class="btn-navigasi" style="text-decoration:none;">
                        <svg width="17" height="17" fill="none" stroke="#fff" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Navigasi ke Lokasi
                    </a>
                </div>

                <!-- Status Card -->
                <div class="white-card" style="padding:20px 20px 24px;">
                    <p style="font-size:16px;font-weight:700;color:#111827;margin-bottom:22px;">Status Pengambilan</p>

                    <!-- Step 1: Menuju Lokasi -->
                    <div style="display:flex;gap:16px;align-items:flex-start;">
                        <div style="display:flex;flex-direction:column;align-items:center;flex-shrink:0;">
                            <div id="circle1" class="step-circle-active"></div>
                            <div id="line1" class="step-line"></div>
                        </div>
                        <div style="padding-top:4px;padding-bottom:16px;">
                            <p style="font-size:14px;font-weight:700;color:#111827;margin-bottom:3px;">Menuju Lokasi</p>
                            <p id="sub1" style="font-size:12.5px;color:#2563eb;font-weight:500;">Sedang berlangsung...
                            </p>
                        </div>
                    </div>

                    <!-- Step 2: Sampai Lokasi -->
                    <div style="display:flex;gap:16px;align-items:flex-start;">
                        <div style="display:flex;flex-direction:column;align-items:center;flex-shrink:0;">
                            <div id="circle2" class="step-circle-inactive"></div>
                            <div id="line2" class="step-line"></div>
                        </div>
                        <div style="padding-top:6px;padding-bottom:16px;">
                            <p id="label2" style="font-size:14px;font-weight:600;color:#9ca3af;">Sampai Lokasi</p>
                            <p id="sub2" style="font-size:12.5px;color:#2563eb;font-weight:500;display:none;">Sedang
                                berlangsung...</p>
                        </div>
                    </div>

                    <!-- Step 3: Mengambil Sampah -->
                    <div style="display:flex;gap:16px;align-items:flex-start;">
                        <div style="display:flex;flex-direction:column;align-items:center;flex-shrink:0;">
                            <div id="circle3" class="step-circle-inactive"></div>
                            <div id="line3" class="step-line"></div>
                        </div>
                        <div style="padding-top:6px;padding-bottom:16px;">
                            <p id="label3" style="font-size:14px;font-weight:600;color:#9ca3af;">Mengambil Sampah</p>
                            <p id="sub3" style="font-size:12.5px;color:#2563eb;font-weight:500;display:none;">Sedang
                                berlangsung...</p>
                        </div>
                    </div>

                    <!-- Step 4: Selesai -->
                    <div style="display:flex;gap:16px;align-items:flex-start;">
                        <div style="display:flex;flex-direction:column;align-items:center;flex-shrink:0;">
                            <div id="circle4" class="step-circle-inactive"></div>
                        </div>
                        <div style="padding-top:6px;">
                            <p id="label4" style="font-size:14px;font-weight:600;color:#9ca3af;">Selesai</p>
                        </div>
                    </div>
                </div>

                <!-- Tambah Sampah button (hidden initially) -->
                <div id="tambahArea" style="display:none;margin:0 16px 14px;">
                    <button class="btn-tambah" onclick="openModal()">
                        <svg width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Sampah
                    </button>
                </div>

                <!-- ── KALKULASI CARD (hidden initially) ── -->
                <div id="kalkulasiArea" style="display:none;">
                    <div class="kalkulasi-card">

                            <!-- Card Header -->
                            <div class="kalk-header">
                                <div
                                    style="width:30px;height:30px;background:#16a34a;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                    <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2.2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 7H6a2 2 0 00-2 2v9a2 2 0 002 2h9a2 2 0 002-2v-3M16 3h5m0 0v5m0-5l-7 7" />
                                    </svg>
                                </div>
                                <div>
                                    <p style="font-size:13px;font-weight:700;color:#166534;">Ringkasan Sampah</p>
                                    <p style="font-size:11px;color:#16a34a;font-weight:500;" id="itemCount">0 item
                                        ditambahkan</p>
                                </div>
                            </div>

                            <div class="kalk-body">

                                <!-- Weight rows -->
                                <div id="weightRows"></div>

                                <!-- ── DIVIDER + Harga Anorganik ── -->
                                <div id="anorganikPriceSection" style="display:none;">
                                    <div class="kalk-divider"></div>

                                    <!-- Section label -->
                                    <div style="display:flex;align-items:center;gap:6px;margin-bottom:10px;">
                                        <svg width="14" height="14" fill="none" stroke="#6b7280" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <line x1="12" y1="1" x2="12" y2="23" />
                                            <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" />
                                        </svg>
                                        <p
                                            style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:0.4px;">
                                            Harga Pembelian Anorganik
                                        </p>
                                    </div>

                                    <!-- Manual Rp input -->
                                    <div class="price-input-wrap" id="priceInputWrap">
                                        <div class="price-input-label-row">
                                            <span style="font-size:13px;font-weight:700;color:#9ca3af;">Rp</span>
                                            <span
                                                style="font-size:11px;color:#9ca3af;font-weight:500;margin-left:auto;">Masukkan
                                                harga manual</span>
                                        </div>
                                        <input type="number" id="inputHargaAnorganik" class="price-input-field"
                                            placeholder="0" min="0" oninput="renderTotal()" />
                                    </div>

                                    <!-- helper text -->
                                    <p style="font-size:11px;color:#9ca3af;margin-top:7px;padding-left:2px;">
                                        💡 Sesuaikan dengan harga yang disepakati bersama pelanggan
                                    </p>
                                </div>

                                <!-- ── TOTAL ── -->
                                <div id="totalSection" style="display:none;">
                                    <div class="kalk-divider"></div>
                                    <div class="total-row">
                                        <div>
                                            <p style="font-size:11.5px;color:#16a34a;font-weight:600;margin-bottom:2px;">
                                                Total Pembayaran</p>
                                            <p style="font-size:11px;color:#6b7280;">ke pelanggan</p>
                                        </div>
                                        <p id="totalHarga" style="font-size:20px;font-weight:800;color:#16a34a;">Rp 0</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                </div>
                <!-- ── END KALKULASI ── -->

                <!-- Tips Banner -->
                <div class="tips-banner">
                    <p style="font-size:13px;color:#374151;line-height:1.65;">
                        <span style="font-weight:700;color:#b45309;">Tips:</span>
                        Pastikan mengambil semua sampah dan mengkonfirmasi dengan pelanggan sebelum menyelesaikan order.
                    </p>
                </div>

                <!-- ── METODE PEMBAYARAN PELANGGAN ── -->
                <div id="metodePembayaranSection" style="display:none;margin:16px 16px 14px;">
                    <div style="background:#fff;border-radius:18px;padding:20px;box-shadow:0 2px 14px rgba(0,0,0,0.07);">
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;">
                            <div style="width:30px;height:30px;background:#6366f1;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                            <div>
                                <p style="font-size:13px;font-weight:700;color:#312e81;">Metode Pembayaran ke Pelanggan</p>
                                <p style="font-size:11px;color:#6b7280;font-weight:500;">Pilih cara pembayaran pendapatan</p>
                            </div>
                        </div>

                        <div style="display:flex;gap:10px;">
                            <!-- Tunai -->
                            <label id="labelTunai" onclick="selectMetode('tunai')" style="flex:1;cursor:pointer;border:2px solid #e5e7eb;border-radius:14px;padding:14px 12px;text-align:center;transition:all 0.2s;background:#f9fafb;">
                                <div style="width:36px;height:36px;background:#fef3c7;border-radius:10px;display:flex;align-items:center;justify-content:center;margin:0 auto 8px;">
                                    <svg width="18" height="18" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <p style="font-size:13px;font-weight:700;color:#374151;">Tunai</p>
                                <p style="font-size:10px;color:#9ca3af;margin-top:2px;">Bayar langsung</p>
                            </label>

                            <!-- Saldo -->
                            <label id="labelSaldo" onclick="selectMetode('saldo')" style="flex:1;cursor:pointer;border:2px solid #e5e7eb;border-radius:14px;padding:14px 12px;text-align:center;transition:all 0.2s;background:#f9fafb;">
                                <div style="width:36px;height:36px;background:#dbeafe;border-radius:10px;display:flex;align-items:center;justify-content:center;margin:0 auto 8px;">
                                    <svg width="18" height="18" fill="none" stroke="#2563eb" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                </div>
                                <p style="font-size:13px;font-weight:700;color:#374151;">Saldo</p>
                                <p style="font-size:10px;color:#9ca3af;margin-top:2px;">Masuk ke saldo</p>
                            </label>
                        </div>

                        <p id="metodeHint" style="font-size:11px;color:#6366f1;margin-top:10px;padding-left:2px;display:none;"></p>
                    </div>
                </div>


            </div>
        </div><!-- end scroll-area -->

        <!-- ── BOTTOM BAR ── -->
        <div class="bottom-bar">
            <button class="btn-main" id="mainBtn" onclick="handleMainBtn()">Mulai Perjalanan</button>
        </div>

        <!-- ── MODAL ── -->
        <div class="modal-overlay" id="modalOverlay" onclick="closeModalOutside(event)">
            <div class="modal-sheet">
                <div class="modal-handle"></div>

                <!-- Modal Header -->
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                    <div>
                        <p style="font-size:16px;font-weight:800;color:#111827;">Tambah Data Sampah</p>
                        <p style="font-size:12px;color:#9ca3af;margin-top:2px;">Isi jumlah dan jenis sampah</p>
                    </div>
                    <button type="button" onclick="closeModal()"
                        style="width:32px;height:32px;border-radius:50%;background:#f3f4f6;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                        <svg width="14" height="14" fill="none" stroke="#6b7280" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Two-col inputs -->
                @php
                    $kategoris = \App\Models\KategoriSampah::where('aktif', true)->get();
                @endphp
                <div style="display:flex;gap:12px;">
                    <div class="form-group">
                        <label class="form-label">Jumlah</label>
                        <div style="position:relative;">
                            <input type="number" id="inputKg" class="form-input" placeholder="0.0" min="0" step="0.1"
                                style="padding-right:42px;" />
                            <span
                                style="position:absolute;right:14px;top:50%;transform:translateY(-50%);font-size:13px;font-weight:700;color:#9ca3af;">kg</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jenis Sampah</label>
                        <select id="inputJenis" class="form-input">
                            <option value="" disabled selected>Pilih</option>
                            @foreach($kategoris as $k)
                                <option value="{{ $k->nama }}">{{ $k->ikon }} {{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="button" class="btn-simpan" onclick="simpanSampah()">
                    <span style="display:flex;align-items:center;justify-content:center;gap:8px;">
                        <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan
                    </span>
                </button>
            </div>
        </div>

    </div>

    <script>
        const statusOrder = '{{ $pesanan->status }}';
        let state = 0;   // 0=menuju, 1=sampai, 2=mengambil, 3=done
        let trashItems = [];   // { kg, jenis }
        let selectedMetode = ''; // tunai or saldo

        if (statusOrder === 'dalam_perjalanan') {
            state = 1;
        } else if (statusOrder === 'tiba' || statusOrder === 'penimbangan') {
            state = 2;
        } else if (statusOrder === 'selesai') {
            state = 3;
        }

        const mainBtn = document.getElementById('mainBtn');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const updateUrl = '{{ route("juru-angkut.order.update-status", $pesanan->id) }}';

        // Init UI based on state
        window.onload = () => {
            if (state >= 1) {
                document.getElementById('sub1').style.display = 'none';
                markDone('circle1', 'line1');
                markActive('circle2', 'label2', 'sub2');
                mainBtn.textContent = 'Saya Sudah Sampai';
            }
            if (state >= 2) {
                document.getElementById('sub2').style.display = 'none';
                markDone('circle2', 'line2');
                markActive('circle3', 'label3', 'sub3');
                document.getElementById('tambahArea').style.display = 'block';
                mainBtn.textContent = 'Selesaikan Order';
            }
            if (state >= 3) {
                document.getElementById('sub3').style.display = 'none';
                markDone('circle3', 'line3');
                markDone('circle4', null);
                document.getElementById('label4').style.color = '#111827';
                document.getElementById('label4').style.fontWeight = '700';
                document.getElementById('tambahArea').style.display = 'none';
                document.getElementById('kalkulasiArea').style.display = 'none';
                mainBtn.style.background = 'linear-gradient(135deg,#d1fae5,#bbf7d0)';
                mainBtn.style.color = '#16a34a';
                mainBtn.style.cursor = 'default';
                mainBtn.textContent = '✓ Order Selesai';
                mainBtn.onclick = null;
            }
        };

        /* ── State machine ── */
        function handleMainBtn() {
            if (state === 0) goToSampaiLokasi();
            else if (state === 1) goToMengambilSampah();
            else if (state === 2) selesaikanOrder();
        }

        function markDone(circleId, lineId) {
            const c = document.getElementById(circleId);
            c.className = 'step-circle-done';
            c.innerHTML = `<svg width="16" height="16" fill="none" stroke="#fff" stroke-width="3" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>`;
            if (lineId) document.getElementById(lineId).className = 'step-line-done';
        }

        function markActive(circleId, labelId, subId) {
            const c = document.getElementById(circleId);
            c.className = 'step-circle-active';
            c.innerHTML = '';
            document.getElementById(labelId).style.color = '#111827';
            document.getElementById(subId).style.display = 'block';
        }

        async function updateStatus(newStatus) {
            try {
                const res = await fetch(updateUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ status: newStatus })
                });
                return res.ok;
            } catch (err) {
                console.error(err);
                return false;
            }
        }

        async function goToSampaiLokasi() {
            mainBtn.disabled = true;
            mainBtn.textContent = 'Memproses...';
            const success = await updateStatus('dalam_perjalanan');
            if (success) {
                state = 1;
                document.getElementById('sub1').style.display = 'none';
                markDone('circle1', 'line1');
                markActive('circle2', 'label2', 'sub2');
                mainBtn.textContent = 'Saya Sudah Sampai';
                mainBtn.disabled = false;
                scrollBottom();
            } else {
                mainBtn.disabled = false;
                mainBtn.textContent = 'Mulai Perjalanan';
                showToast('Gagal update status!');
            }
        }

        async function goToMengambilSampah() {
            mainBtn.disabled = true;
            mainBtn.textContent = 'Memproses...';
            const success = await updateStatus('tiba');
            if (success) {
                state = 2;
                document.getElementById('sub2').style.display = 'none';
                markDone('circle2', 'line2');
                markActive('circle3', 'label3', 'sub3');
                document.getElementById('tambahArea').style.display = 'block';
                mainBtn.textContent = 'Selesaikan Order';
                mainBtn.disabled = false;
                scrollBottom();
            } else {
                mainBtn.disabled = false;
                mainBtn.textContent = 'Saya Sudah Sampai';
                showToast('Gagal update status!');
            }
        }

        /* ── Modal ── */
        function openModal() {
            document.getElementById('modalOverlay').classList.add('active');
            document.getElementById('inputKg').value = '';
            document.getElementById('inputJenis').value = '';
        }

        function closeModal() {
            document.getElementById('modalOverlay').classList.remove('active');
        }

        function closeModalOutside(e) {
            if (e.target === document.getElementById('modalOverlay')) closeModal();
        }

        function simpanSampah() {
            const kg = parseFloat(document.getElementById('inputKg').value);
            const jenis = document.getElementById('inputJenis').value;
            if (!kg || kg <= 0) { showToast('⚠️ Masukkan jumlah kg yang valid!'); return; }
            if (!jenis) { showToast('⚠️ Pilih jenis sampah terlebih dahulu!'); return; }

            trashItems.push({ kg, jenis });
            renderKalkulasi();
            closeModal();
            showToast(`✅ ${jenis} ${kg} kg berhasil ditambahkan`);
        }

        
        
        function hapusSampah(jenis) {
            // Filter out items of this type
            const oldLength = trashItems.length;
            trashItems = trashItems.filter(item => item.jenis.toLowerCase() !== jenis.toLowerCase());
            
            if (oldLength !== trashItems.length) {
                renderKalkulasi();
                showToast(`🗑️ Sampah ${jenis} dihapus`);
            }
            
            if (trashItems.length === 0) {
                document.getElementById('weightRows').innerHTML = '<p style="font-size:12px;color:#9ca3af;text-align:center;padding:10px 0;">Belum ada sampah yang dicatat</p>';
                document.getElementById('itemCount').textContent = `0 item ditambahkan`;
                document.getElementById('anorganikPriceSection').style.display = 'none';
                document.getElementById('totalSection').style.display = 'none';
                document.getElementById('metodePembayaranSection').style.display = 'none';
                document.getElementById('inputHargaAnorganik').value = '';
            }
        }

        /* ── Kalkulasi rendering ── */


                        function renderKalkulasi() {
            document.getElementById('kalkulasiArea').style.display = 'block';

            // Aggregate by type
            let organikKg = 0;
            let anorganikKg = 0;
            let campuranKg = 0;
            trashItems.forEach(i => {
                if (i.jenis.toLowerCase() === 'organik') organikKg += parseFloat(i.kg);
                else if (i.jenis.toLowerCase() === 'anorganik') anorganikKg += parseFloat(i.kg);
                else campuranKg += parseFloat(i.kg);
            });

            let rowsHTML = '';

            const makeRow = (jenisStr, kgVal, bgRow, bgIcon, iconChar, isLast) => {
                const margin = isLast ? '0' : '8px';
                return `
                <div class="weight-row" style="background:${bgRow};margin-bottom:${margin};">
                  <div class="weight-badge">
                    <div class="weight-icon" style="background:${bgIcon}; font-size:14px;">${iconChar}</div>
                    <div>
                      <p style="font-size:12px;color:#6b7280;font-weight:500;">${jenisStr}</p>
                    </div>
                  </div>
                  <div style="display:flex;align-items:center;gap:12px;">
                    <div style="text-align:right;">
                      <p style="font-size:18px;font-weight:800;color:#111827;line-height:1;">${kgVal.toFixed(1)}</p>
                      <p style="font-size:11px;color:#9ca3af;font-weight:500;">kg</p>
                    </div>
                    <button type="button" onclick="hapusSampah('${jenisStr}')" style="background:none;border:none;cursor:pointer;padding:4px;display:flex;align-items:center;justify-content:center;border-radius:6px;transition:background 0.2s;" onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='none'">
                        <svg width="18" height="18" fill="none" stroke="#ef4444" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                  </div>
                </div>`;
            };

            const itemsArr = [];
            if (organikKg > 0) itemsArr.push({ jenis: 'Organik', kg: organikKg, bgRow: '#f0fdf4', bgIcon: '#d1fae5', icon: '🌿' });
            if (anorganikKg > 0) itemsArr.push({ jenis: 'Anorganik', kg: anorganikKg, bgRow: '#eff6ff', bgIcon: '#dbeafe', icon: '♻️' });
            if (campuranKg > 0) itemsArr.push({ jenis: 'Campuran', kg: campuranKg, bgRow: '#f3f4f6', bgIcon: '#e5e7eb', icon: '🗑️' });

            itemsArr.forEach((item, index) => {
                rowsHTML += makeRow(item.jenis, item.kg, item.bgRow, item.bgIcon, item.icon, index === itemsArr.length - 1);
            });

            document.getElementById('weightRows').innerHTML = rowsHTML;
            document.getElementById('itemCount').textContent = trashItems.length + ' item ditambahkan';

            const showAnorganik = anorganikKg > 0;
            document.getElementById('anorganikPriceSection').style.display = showAnorganik ? 'block' : 'none';
            document.getElementById('totalSection').style.display = showAnorganik ? 'block' : 'none';
            document.getElementById('metodePembayaranSection').style.display = showAnorganik ? 'block' : 'none';

            renderTotal();
            scrollBottom();
        }

        function renderTotal() {
            const raw = document.getElementById('inputHargaAnorganik').value;
            const val = parseInt(raw) || 0;
            document.getElementById('totalHarga').textContent = formatRp(val);
        }

        function formatKg(val) {
            return parseFloat(val.toFixed(1)).toString();
        }

        function formatRp(val) {
            return 'Rp ' + val.toLocaleString('id-ID');
        }

        function scrollBottom() {
            setTimeout(() => {
                const s = document.getElementById('scrollArea');
                s.scrollTo({ top: s.scrollHeight, behavior: 'smooth' });
            }, 120);
        }

        function selectMetode(metode) {
            selectedMetode = metode;
            const labelTunai = document.getElementById('labelTunai');
            const labelSaldo = document.getElementById('labelSaldo');
            const hint = document.getElementById('metodeHint');

            // Reset both
            labelTunai.style.border = '2px solid #e5e7eb';
            labelTunai.style.background = '#f9fafb';
            labelSaldo.style.border = '2px solid #e5e7eb';
            labelSaldo.style.background = '#f9fafb';

            if (metode === 'tunai') {
                labelTunai.style.border = '2px solid #d97706';
                labelTunai.style.background = '#fffbeb';
                hint.textContent = '💵 Pendapatan akan diberikan langsung secara tunai ke pelanggan';
                hint.style.color = '#d97706';
            } else {
                labelSaldo.style.border = '2px solid #2563eb';
                labelSaldo.style.background = '#eff6ff';
                hint.textContent = '💳 Pendapatan akan otomatis masuk ke saldo akun pelanggan';
                hint.style.color = '#2563eb';
            }
            hint.style.display = 'block';
        }

        function selesaikanOrder() {
            if (trashItems.length === 0) {
                showToast('⚠️ Tambahkan minimal 1 data sampah dulu!');
                return;
            }

            // Check if anorganik has price => need payment method
            const hasAnorganik = trashItems.some(i => i.jenis.toLowerCase() === 'anorganik');
            const hargaAnorganik = document.getElementById('inputHargaAnorganik') ? parseInt(document.getElementById('inputHargaAnorganik').value) || 0 : 0;

            if (hasAnorganik && hargaAnorganik > 0 && !selectedMetode) {
                showToast('⚠️ Pilih metode pembayaran ke pelanggan!');
                document.getElementById('metodePembayaranSection').scrollIntoView({ behavior: 'smooth' });
                return;
            }
            
            // Set the hidden input values
            document.getElementById('trashItemsInput').value = JSON.stringify(trashItems);
            
            const rawHarga = document.getElementById('inputHargaAnorganik') ? document.getElementById('inputHargaAnorganik').value : '';
            document.getElementById('hargaManualInput').value = rawHarga;
            document.getElementById('metodePembayaranInput').value = selectedMetode || '';

            const form = document.getElementById('selesaikanForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            
            mainBtn.textContent = 'Menyimpan...';
            mainBtn.disabled = true;
            form.submit();
        }

        function showToast(msg) {
            const old = document.getElementById('_toast');
            if (old) old.remove();
            const t = document.createElement('div');
            t.id = '_toast';
            t.style.cssText = `
      position:absolute; bottom:86px; left:50%; transform:translateX(-50%);
      background:rgba(17,24,39,0.90); color:#fff; padding:10px 20px;
      border-radius:50px; font-size:12.5px; font-weight:600; z-index:300;
      white-space:nowrap; box-shadow:0 4px 20px rgba(0,0,0,0.22);
      animation: fadeInUp 0.28s ease;
    `;
            t.textContent = msg;
            document.body.appendChild(t);
            setTimeout(() => t.remove(), 2800);
        }
    </script>

    <form id="selesaikanForm" action="{{ route('juru-angkut.order.selesaikan', $pesanan->id) }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="trash_items" id="trashItemsInput">
        <input type="hidden" name="harga_manual" id="hargaManualInput">
        <input type="hidden" name="metode_pembayaran_pelanggan" id="metodePembayaranInput">
    </form>
</body>

</html>
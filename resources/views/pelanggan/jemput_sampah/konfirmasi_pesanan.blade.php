<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Konfirmasi Pesanan</title>
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

        /* Header */
        .page-header {
            background: linear-gradient(135deg, #2ecc71 0%, #1aab57 60%, #168a45 100%);
            padding: 18px 20px 22px;
            display: flex;
            align-items: center;
            gap: 14px;
            flex-shrink: 0;
        }

        /* Scroll */
        .scroll-area {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
        }

        .scroll-area::-webkit-scrollbar {
            display: none;
        }

        /* Detail card */
        .detail-card {
            background: #fff;
            border-radius: 20px;
            padding: 20px 20px 8px;
            margin: 16px 16px 0;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.07);
        }

        /* Detail row */
        .detail-row {
            display: flex;
            align-items: flex-start;
            gap: 13px;
            padding: 14px 0;
        }

        .detail-row+.detail-row {
            border-top: 1px solid #f3f4f6;
        }

        .detail-icon {
            width: 34px;
            height: 34px;
            background: #f0fdf4;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* Payment summary card */
        .ringkasan-card {
            background: #f0fdf4;
            border: 1.5px solid #86efac;
            border-radius: 20px;
            padding: 18px 20px;
            margin: 14px 16px 0;
            transition: all 0.3s;
        }

        /* Simulasi toggle */
        .simulasi-wrap {
            background: #fff;
            border: 1.5px solid #e5e7eb;
            border-radius: 16px;
            padding: 14px 16px;
            margin: 14px 16px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .toggle-track {
            width: 48px;
            height: 27px;
            border-radius: 50px;
            background: #d1d5db;
            position: relative;
            cursor: pointer;
            transition: background 0.25s;
            flex-shrink: 0;
        }

        .toggle-track.on {
            background: #22c55e;
        }

        .toggle-thumb {
            width: 21px;
            height: 21px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
            position: absolute;
            top: 3px;
            left: 3px;
            transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .toggle-track.on .toggle-thumb {
            transform: translateX(21px);
        }

        /* Lanjut button */
        .lanjut-btn {
            width: 100%;
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            border: none;
            border-radius: 16px;
            padding: 17px;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s;
            margin: 14px 0 0;
            display: block;
        }

        .lanjut-btn:active {
            transform: scale(0.98);
            opacity: 0.9;
        }

        /* Nav */
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
        }

        /* Animations */
        @keyframes fadeSlide {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeSlide 0.25s ease forwards;
        }

        /* Strike through */
        .line-through {
            text-decoration: line-through;
        }
    </style>
</head>

<body>
    <div class="phone-wrapper">

        <!-- ── HEADER ── -->
        <div class="page-header">
            <a href="{{ route('pelanggan.jemput-sampah') }}"
                style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 style="font-size:18px;font-weight:800;color:#fff;">Konfirmasi Pesanan</h1>
        </div>

        <!-- ── SCROLL AREA ── -->
        <div class="scroll-area">
            <div style="padding: 0 0 28px;">

                <!-- ── DETAIL PESANAN ── -->
                <div class="detail-card">
                    <p style="font-size:15px;font-weight:800;color:#111827;margin-bottom:4px;">Detail Pesanan</p>

                    <!-- Jenis Sampah -->
                    <div class="detail-row">
                        <div class="detail-icon">
                            <svg width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:11.5px;color:#9ca3af;font-weight:500;margin-bottom:3px;">Jenis Sampah</p>
                            <p style="font-size:14px;font-weight:700;color:#111827;">{{ $kategoriList->pluck('nama')->join(', ') }}</p>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="detail-row">
                        <div class="detail-icon">
                            <svg width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:11.5px;color:#9ca3af;font-weight:500;margin-bottom:3px;">Alamat
                                Penjemputan</p>
                            <p style="font-size:14px;font-weight:700;color:#111827;line-height:1.4;">{{ $draft['alamat_jemput'] }}</p>
                        </div>
                    </div>

                    <!-- Tanggal -->
                    <div class="detail-row">
                        <div class="detail-icon">
                            <svg width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:11.5px;color:#9ca3af;font-weight:500;margin-bottom:3px;">Tanggal</p>
                            <p style="font-size:14px;font-weight:700;color:#111827;">{{ \Carbon\Carbon::parse($draft['tanggal_jemput'])->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>

                    <!-- Waktu -->
                    <div class="detail-row">
                        <div class="detail-icon">
                            <svg width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:11.5px;color:#9ca3af;font-weight:500;margin-bottom:3px;">Waktu</p>
                            <p style="font-size:14px;font-weight:700;color:#111827;">{{ $draft['jam_jemput'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- ── STATUS INFO ── -->
                <div style="margin: 14px 16px 0;">
                    <div style="background:#fff;border:1.5px solid #e5e7eb;border-radius:16px;padding:14px 16px;display:flex;align-items:center;gap:12px;">
                        <div style="width:42px;height:42px;border-radius:12px;background:#e0f2fe;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <span style="font-size:20px;">🚚</span>
                        </div>
                        <div>
                            <p style="font-size:13px;font-weight:700;color:#111827;">Juru angkut akan menjemput pesananmu</p>
                            <p style="font-size:11px;color:#9ca3af;margin-top:2px;">Setelah pesanan dikonfirmasi</p>
                        </div>
                    </div>
                </div>

                <!-- ── METODE PEMBAYARAN ── -->
                <div
                    style="background:#fff;border-radius:20px;margin:14px 16px 0;box-shadow:0 2px 16px rgba(0,0,0,0.07);overflow:hidden;">
                    <div style="padding:14px 18px 6px;">
                        <p
                            style="font-size:10.5px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.06em;">
                            Metode Pembayaran</p>
                    </div>
                    <div onclick="openPaymentModal()" id="payRow"
                        style="display:flex;align-items:center;gap:14px;padding:12px 18px 18px;cursor:pointer;transition:background 0.15s;">
                        <div id="payIconWrap"
                            style="width:42px;height:42px;background:#16a34a;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <div style="flex:1;">
                            <p style="font-size:11px;color:#9ca3af;font-weight:500;margin-bottom:2px;">Metode dipilih
                            </p>
                            <p style="font-size:14px;font-weight:700;color:#111827;" id="selectedPayLabel">GoPay</p>
                        </div>
                        <svg width="18" height="18" fill="none" stroke="#9ca3af" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>

                <!-- ── RINGKASAN PEMBAYARAN ── -->
                <div class="ringkasan-card" id="ringkasanCard">
                    <p style="font-size:14px;font-weight:800;color:#111827;margin-bottom:14px;">Ringkasan Pembayaran</p>

                    <!-- Biaya Jemput -->
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                        <span style="font-size:13px;color:#374151;font-weight:500;">Biaya Jemput Sampah</span>
                        <span style="font-size:13px;font-weight:700;color:#111827;">{{ $isBerlangganan ? 'GRATIS' : 'Rp ' . number_format($draft['biaya_jemput'], 0, ',', '.') }}</span>
                    </div>

                    <!-- Biaya Layanan -->
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
                        <span style="font-size:13px;color:#374151;font-weight:500;">Biaya Layanan</span>
                        <span style="font-size:13px;font-weight:700;color:#111827;">Rp 1.000</span>
                    </div>

                    @if($isBerlangganan)
                    <div style="margin-bottom:14px;">
                        <div style="background:#dcfce7;border:1px solid #86efac;border-radius:10px;padding:10px 12px;display:flex;gap:8px;align-items:center;">
                            <span style="font-size:14px;flex-shrink:0;">🎉</span>
                            <p style="font-size:11px;font-weight:600;color:#15803d;line-height:1.5;">Biaya jemput gratis karena kamu berlangganan!</p>
                        </div>
                    </div>
                    @endif

                    <!-- Divider -->
                    <div style="border-top:1.5px solid #86efac;margin-bottom:14px;"></div>

                    <!-- Total -->
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:15px;font-weight:800;color:#111827;">Total</span>
                        <span style="font-size:20px;font-weight:800;color:#16a34a;">Rp {{ number_format($draft['biaya_jemput'] + 1000, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- ── PESAN SEKARANG ── -->
                <div style="padding: 0 16px;">
                    <form id="formKonfirmasi" action="{{ route('pelanggan.confirm-pesanan') }}" method="POST">
                        @csrf
                        <button type="button" class="lanjut-btn" onclick="pesanSekarang()">Pesan Sekarang</button>
                    </form>
                </div>

            </div>
        </div><!-- end scroll-area -->

        <!-- ── BOTTOM NAV ── -->
        <div class="nav-bottom">
            <div class="nav-btn">
                <svg width="22" height="22" fill="#9ca3af" viewBox="0 0 24 24">
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                </svg>
                <span style="font-size:10px;font-weight:500;color:#9ca3af;">Home</span>
            </div>
            <div class="nav-btn">
                <svg width="22" height="22" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span style="font-size:10px;font-weight:700;color:#16a34a;">Order</span>
            </div>
            <div class="nav-btn">
                <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span style="font-size:10px;font-weight:500;color:#9ca3af;">History</span>
            </div>
            <div class="nav-btn">
                <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                <span style="font-size:10px;font-weight:500;color:#9ca3af;">Wallet</span>
            </div>
            <div class="nav-btn">
                <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span style="font-size:10px;font-weight:500;color:#9ca3af;">Profile</span>
            </div>
        </div>

        <!-- ── PAYMENT MODAL ── -->
        <div id="paymentModal"
            style="position:absolute;inset:0;background:rgba(0,0,0,0.48);z-index:200;display:flex;align-items:flex-end;opacity:0;pointer-events:none;transition:opacity 0.25s;">
            <div id="payModalSheet"
                style="width:100%;background:#fff;border-radius:24px 24px 0 0;padding:20px 20px 36px;transform:translateY(100%);transition:transform 0.3s cubic-bezier(0.4,0,0.2,1);">

                <!-- Handle -->
                <div style="display:flex;justify-content:center;margin-bottom:16px;">
                    <div style="width:40px;height:4px;background:#e5e7eb;border-radius:4px;"></div>
                </div>
                <p style="font-size:16px;font-weight:800;color:#111827;margin-bottom:4px;">Pilih Metode Pembayaran</p>
                <p style="font-size:12px;color:#9ca3af;margin-bottom:18px;">Semua transaksi dilindungi &amp; terenkripsi
                    🔒</p>

                <!-- E-Wallet -->
                <p
                    style="font-size:10px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:10px;">
                    E-Wallet</p>

                <div class="pay-opt selected" data-label="GoPay" data-color="#00AED6" data-letter="G"
                    onclick="selectPayment(this)">
                    <div
                        style="width:42px;height:42px;border-radius:12px;background:#00AED6;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <span style="color:#fff;font-weight:800;font-size:15px;">G</span>
                    </div>
                    <div style="flex:1;">
                        <p style="font-size:13px;font-weight:700;color:#111827;">GoPay</p>
                        <p style="font-size:11px;color:#9ca3af;">Saldo: Rp 85.000</p>
                    </div>
                    <div class="pay-radio">
                        <div class="pay-dot"></div>
                    </div>
                </div>

                <div class="pay-opt" data-label="OVO" data-color="#4C3494" data-letter="O"
                    onclick="selectPayment(this)">
                    <div
                        style="width:42px;height:42px;border-radius:12px;background:#4C3494;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <span style="color:#fff;font-weight:800;font-size:15px;">O</span>
                    </div>
                    <div style="flex:1;">
                        <p style="font-size:13px;font-weight:700;color:#111827;">OVO</p>
                        <p style="font-size:11px;color:#9ca3af;">Saldo: Rp 120.000</p>
                    </div>
                    <div class="pay-radio">
                        <div class="pay-dot"></div>
                    </div>
                </div>

                <div class="pay-opt" data-label="DANA" data-color="#108BE3" data-letter="D"
                    onclick="selectPayment(this)">
                    <div
                        style="width:42px;height:42px;border-radius:12px;background:#108BE3;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <span style="color:#fff;font-weight:800;font-size:15px;">D</span>
                    </div>
                    <div style="flex:1;">
                        <p style="font-size:13px;font-weight:700;color:#111827;">DANA</p>
                        <p style="font-size:11px;color:#9ca3af;">Saldo: Rp 50.000</p>
                    </div>
                    <div class="pay-radio">
                        <div class="pay-dot"></div>
                    </div>
                </div>

                <!-- Lainnya -->
                <p
                    style="font-size:10px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.06em;margin:16px 0 10px;">
                    Lainnya</p>

                <div class="pay-opt" data-label="Saldo GoGarbage" data-color="#22c55e" onclick="selectPayment(this)">
                    <div
                        style="width:42px;height:42px;border-radius:12px;background:#22c55e;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <div style="flex:1;">
                        <p style="font-size:13px;font-weight:700;color:#111827;">Saldo GoGarbage</p>
                        <p style="font-size:11px;color:#9ca3af;">Saldo: Rp 245.000</p>
                    </div>
                    <div class="pay-radio">
                        <div class="pay-dot"></div>
                    </div>
                </div>

                <div class="pay-opt" data-label="Transfer Bank" data-color="#f59e0b" onclick="selectPayment(this)">
                    <div
                        style="width:42px;height:42px;border-radius:12px;background:#f59e0b;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                        </svg>
                    </div>
                    <div style="flex:1;">
                        <p style="font-size:13px;font-weight:700;color:#111827;">Transfer Bank</p>
                        <p style="font-size:11px;color:#9ca3af;">BCA, Mandiri, BNI, BRI</p>
                    </div>
                    <div class="pay-radio">
                        <div class="pay-dot"></div>
                    </div>
                </div>

                <div class="pay-opt" data-label="Tunai" data-color="#6b7280" onclick="selectPayment(this)">
                    <div
                        style="width:42px;height:42px;border-radius:12px;background:#6b7280;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div style="flex:1;">
                        <p style="font-size:13px;font-weight:700;color:#111827;">Tunai</p>
                        <p style="font-size:11px;color:#9ca3af;">Bayar langsung ke juru angkut</p>
                    </div>
                    <div class="pay-radio">
                        <div class="pay-dot"></div>
                    </div>
                </div>

                <button onclick="confirmPayment()"
                    style="width:100%;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;font-size:14px;font-weight:700;padding:15px;border-radius:14px;border:none;cursor:pointer;margin-top:18px;transition:opacity 0.2s;">
                    Gunakan Metode Ini
                </button>
            </div>
        </div>

    </div>

    <style>
        .pay-opt {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 13px 14px;
            border-radius: 14px;
            border: 1.5px solid #e5e7eb;
            cursor: pointer;
            transition: all 0.18s;
            margin-bottom: 10px;
            background: #fff;
        }

        .pay-opt.selected {
            border-color: #22c55e;
            background: #f0fdf4;
        }

        .pay-radio {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid #d1d5db;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.18s;
        }

        .pay-opt.selected .pay-radio {
            border-color: #22c55e;
            background: #22c55e;
        }

        .pay-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #fff;
            display: none;
        }

        .pay-opt.selected .pay-dot {
            display: block;
        }
    </style>

    <script>
        function pesanSekarang() {
            if (confirm('Apakah pesanan sudah sesuai? Klik OK untuk melanjutkan.')) {
                document.getElementById('formKonfirmasi').submit();
            }
        }

        // ── Payment Modal ──
        let pendingPayment = { label: 'GoPay', color: '#00AED6', letter: 'G', svg: null };

        function openPaymentModal() {
            const modal = document.getElementById('paymentModal');
            const sheet = document.getElementById('payModalSheet');
            modal.style.opacity = '1';
            modal.style.pointerEvents = 'all';
            sheet.style.transform = 'translateY(0)';
        }

        function closePaymentModal() {
            const modal = document.getElementById('paymentModal');
            const sheet = document.getElementById('payModalSheet');
            sheet.style.transform = 'translateY(100%)';
            setTimeout(() => {
                modal.style.opacity = '0';
                modal.style.pointerEvents = 'none';
            }, 280);
        }

        document.getElementById('paymentModal').addEventListener('click', function (e) {
            if (e.target === this) closePaymentModal();
        });

        function selectPayment(el) {
            document.querySelectorAll('.pay-opt').forEach(o => o.classList.remove('selected'));
            el.classList.add('selected');
            pendingPayment = {
                label: el.dataset.label,
                color: el.dataset.color || '#22c55e',
                letter: el.dataset.letter || null,
                svg: el.querySelector('svg') ? el.querySelector('svg').outerHTML : null
            };
        }

        function confirmPayment() {
            const label = pendingPayment.label;
            const color = pendingPayment.color;
            const iconWrap = document.getElementById('payIconWrap');
            const labelEl = document.getElementById('selectedPayLabel');

            // Update icon in main row
            if (pendingPayment.letter) {
                iconWrap.style.background = color;
                iconWrap.innerHTML = `<span style="color:#fff;font-weight:800;font-size:15px;">${pendingPayment.letter}</span>`;
            } else if (pendingPayment.svg) {
                iconWrap.style.background = color;
                iconWrap.innerHTML = pendingPayment.svg;
                iconWrap.querySelector('svg').setAttribute('width', '20');
                iconWrap.querySelector('svg').setAttribute('height', '20');
            }
            labelEl.textContent = label;
            closePaymentModal();
        }
    </script>
</body>

</html>
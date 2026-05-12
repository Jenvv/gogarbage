<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Go Garbage – Home</title>
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
        }

        .scroll-area::-webkit-scrollbar {
            display: none;
        }

        /* Green header */
        .header-green {
            background: linear-gradient(150deg, #2ecc71 0%, #1aab57 50%, #168a45 100%);
            padding: 30px 20px 68px;
        }

        /* Mini balance cards */
        .balance-card {
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.28);
            border-radius: 14px;
            padding: 13px 16px;
            flex: 1;
        }

        /* Menu floating card */
        .menu-card {
            background: #fff;
            border-radius: 22px;
            margin: -46px 16px 0;
            padding: 22px 20px 26px;
            box-shadow: 0 6px 28px rgba(0, 0, 0, 0.09);
            position: relative;
            z-index: 10;
        }

        /* Service icon box */
        .svc-box {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.15s;
            text-decoration: none;
        }

        .svc-box:active {
            transform: scale(0.93);
        }

        /* Promo blue */
        .promo-blue {
            background: linear-gradient(130deg, #2563EB 0%, #1e40af 100%);
            border-radius: 20px;
            margin: 14px 16px 0;
            padding: 24px 20px 26px;
        }

        /* Aktivitas card */
        .aktiv-card {
            background: #fff;
            border-radius: 20px;
            margin: 14px 16px 0;
            padding: 18px 18px 8px;
            box-shadow: 0 2px 14px rgba(0, 0, 0, 0.06);
        }

        .aktiv-item {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 14px 0;
        }

        .aktiv-item+.aktiv-item {
            border-top: 1px solid #f3f4f6;
        }

        .aktiv-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* Bottom nav */
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
    </style>
</head>

<body>
    <div class="phone-wrapper">

        <div class="scroll-area">
            <div style="padding-bottom: 28px;">

                <!-- ── GREEN HEADER ── -->
                <div class="header-green">
                    <!-- Top Row -->
                    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:22px;">
                        <div>
                            <p style="font-size:13px;color:rgba(255,255,255,0.8);font-weight:500;margin-bottom:4px;">
                                Selamat Datang,</p>
                            <p style="font-size:21px;font-weight:800;color:#fff;line-height:1.15;">Pengguna Go Garbage
                            </p>
                        </div>
                        <!-- Bell -->
                        <div style="position:relative;margin-top:4px;">
                            <div
                                style="width:44px;height:44px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                <svg width="22" height="22" fill="none" stroke="#fff" stroke-width="2.2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </div>
                            <div
                                style="position:absolute;top:-1px;right:-2px;width:20px;height:20px;background:#ef4444;border-radius:50%;border:2px solid #1aab57;display:flex;align-items:center;justify-content:center;">
                                <span style="font-size:9px;font-weight:800;color:#fff;">3</span>
                            </div>
                        </div>
                    </div>

                    <!-- Saldo + Poin -->
                    <div style="display:flex;gap:12px;">
                        <div class="balance-card">
                            <div style="display:flex;align-items:center;gap:7px;margin-bottom:7px;">
                                <svg width="15" height="15" fill="none" stroke="rgba(255,255,255,0.8)"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                <span style="font-size:12px;color:rgba(255,255,255,0.8);font-weight:500;">Saldo</span>
                            </div>
                            <p style="font-size:19px;font-weight:800;color:#fff;">Rp 150.000</p>
                        </div>
                        <div class="balance-card">
                            <div style="display:flex;align-items:center;gap:7px;margin-bottom:7px;">
                                <svg width="15" height="15" fill="none" stroke="rgba(255,255,255,0.8)"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                                <span style="font-size:12px;color:rgba(255,255,255,0.8);font-weight:500;">Poin</span>
                            </div>
                            <p style="font-size:19px;font-weight:800;color:#fff;">2.500 Poin</p>
                        </div>
                    </div>
                </div>
                <!-- ── END HEADER ── -->

                <!-- ── MENU LAYANAN ── -->
                <div class="menu-card">
                    <p style="font-size:16px;font-weight:700;color:#111827;margin-bottom:20px;">Menu Layanan</p>

                    <!-- Grid 3 kolom -->
                    <div
                        style="display:grid;grid-template-columns:repeat(3,1fr);row-gap:20px;column-gap:4px;text-align:center;">

                        {{-- ── Jemput Sampah → route: jemput-sampah.index ── --}}
                        <div style="display:flex;flex-direction:column;align-items:center;gap:9px;">
                            <a href="{{ route('pelanggan.jemput-sampah') }}" class="svc-box"
                                style="background:#d1fae5;">
                                <svg width="28" height="28" fill="none" stroke="#059669" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </a>
                            <p style="font-size:11.5px;font-weight:600;color:#374151;line-height:1.35;">
                                Jemput<br />Sampah</p>
                        </div>

                        {{-- ── Jual Sampah → route: jual-sampah.index ── --}}
                        <div style="display:flex;flex-direction:column;align-items:center;gap:9px;">
                            <a href="" class="svc-box" style="background:#dbeafe;">
                                <svg width="28" height="28" fill="none" stroke="#2563eb" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </a>
                            <p style="font-size:11.5px;font-weight:600;color:#374151;line-height:1.35;">Jual<br />Sampah
                            </p>
                        </div>

                        {{-- ── Paket Langganan → route: langganan.index ── --}}
                        <div style="display:flex;flex-direction:column;align-items:center;gap:9px;">
                            <a href="{{ route('pelanggan.langganan') }}" class="svc-box" style="background:#ede9fe;">
                                <svg width="28" height="28" fill="none" stroke="#7c3aed" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </a>
                            <p style="font-size:11.5px;font-weight:600;color:#374151;line-height:1.35;">
                                Paket<br />Langganan</p>
                        </div>

                        {{-- ── Riwayat → route: riwayat.index ── --}}
                        <div style="display:flex;flex-direction:column;align-items:center;gap:9px;">
                            <a href="{{ route('pelanggan.riwayat') }}" class="svc-box" style="background:#ffedd5;">
                                <svg width="28" height="28" fill="none" stroke="#ea580c" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </a>
                            <p style="font-size:11.5px;font-weight:600;color:#374151;line-height:1.35;">Riwayat</p>
                        </div>

                        {{-- ── Poin & Reward → route: poin.index ── --}}
                        <div style="display:flex;flex-direction:column;align-items:center;gap:9px;">
                            <a href="" class="svc-box" style="background:#fef9c3;">
                                <svg width="28" height="28" fill="none" stroke="#ca8a04" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            </a>
                            <p style="font-size:11.5px;font-weight:600;color:#374151;line-height:1.35;">Poin
                                &<br />Reward</p>
                        </div>

                        {{-- ── Berita → route: berita.index ── --}}
                        <div style="display:flex;flex-direction:column;align-items:center;gap:9px;">
                            <a href="" class="svc-box" style="background:#fce7f3;">
                                <svg width="28" height="28" fill="none" stroke="#be185d" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                            </a>
                            <p style="font-size:11.5px;font-weight:600;color:#374151;line-height:1.35;">Berita</p>
                        </div>

                    </div>
                </div>
                <!-- ── END MENU ── -->

                <!-- ── PROMO SPESIAL ── -->
                <div class="promo-blue">
                    <p style="font-size:17px;font-weight:800;color:#fff;margin-bottom:8px;">Promo Spesial! 🎉</p>
                    <p style="font-size:13px;color:rgba(255,255,255,0.88);line-height:1.65;margin-bottom:20px;">
                        Dapatkan
                        bonus poin 2x untuk setiap<br />jemput sampah hari ini</p>
                    <button
                        style="background:rgba(255,255,255,0.18);border:1.5px solid rgba(255,255,255,0.65);color:#fff;font-size:13px;font-weight:700;padding:10px 24px;border-radius:11px;cursor:pointer;transition:background 0.2s;"
                        onmouseover="this.style.background='rgba(255,255,255,0.28)'"
                        onmouseout="this.style.background='rgba(255,255,255,0.18)'">
                        Lihat Detail
                    </button>
                </div>
                <!-- ── END PROMO ── -->

                <!-- ── AKTIVITAS TERAKHIR ── -->
                <div class="aktiv-card">
                    <div style="display:flex;align-items:center;justify-content:space-between;padding-bottom:4px;">
                        <p style="font-size:15px;font-weight:700;color:#111827;">Aktivitas Terakhir</p>
                        <a href=""
                            style="font-size:12px;font-weight:600;color:#16a34a;text-decoration:none;">Lihat Semua</a>
                    </div>

                    <!-- Item 1 -->
                    <div class="aktiv-item">
                        <div class="aktiv-icon" style="background:#d1fae5;">
                            <svg width="20" height="20" fill="none" stroke="#059669" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                        <div style="flex:1;">
                            <p style="font-size:13px;font-weight:700;color:#111827;">Jemput Sampah</p>
                            <p style="font-size:11px;color:#9ca3af;margin-top:3px;">12 April 2026</p>
                        </div>
                        <span style="font-size:13px;font-weight:700;color:#16a34a;">Selesai</span>
                    </div>

                    <!-- Item 2 -->
                    <div class="aktiv-item">
                        <div class="aktiv-icon" style="background:#dbeafe;">
                            <svg width="20" height="20" fill="none" stroke="#2563eb" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div style="flex:1;">
                            <p style="font-size:13px;font-weight:700;color:#111827;">Jual Sampah Plastik</p>
                            <p style="font-size:11px;color:#9ca3af;margin-top:3px;">10 April 2026</p>
                        </div>
                        <span style="font-size:13px;font-weight:700;color:#16a34a;">+Rp 25.000</span>
                    </div>
                </div>
                <!-- ── END AKTIVITAS ── -->

            </div>
        </div><!-- end scroll-area -->

        <!-- ── BOTTOM NAV ── -->
        <div class="nav-bottom">
            <a href="" class="nav-btn" style="text-decoration:none;">
                <svg width="22" height="22" fill="#16a34a" viewBox="0 0 24 24">
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                </svg>
                <span style="font-size:10px;font-weight:700;color:#16a34a;">Home</span>
            </a>
            <a href="" class="nav-btn" style="text-decoration:none;">
                <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span style="font-size:10px;font-weight:500;color:#9ca3af;">Order</span>
            </a>
            <a href="" class="nav-btn" style="text-decoration:none;">
                <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span style="font-size:10px;font-weight:500;color:#9ca3af;">History</span>
            </a>
            <a href="" class="nav-btn" style="text-decoration:none;">
                <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                <span style="font-size:10px;font-weight:500;color:#9ca3af;">Wallet</span>
            </a>
            <a href="" class="nav-btn" style="text-decoration:none;">
                <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span style="font-size:10px;font-weight:500;color:#9ca3af;">Profile</span>
            </a>
        </div>

    </div>
</body>

</html>

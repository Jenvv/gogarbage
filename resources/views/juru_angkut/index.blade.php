<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - Juru Angkut</title>
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

        .header-green {
            background: linear-gradient(150deg, #2ecc71 0%, #1aab57 50%, #168a45 100%);
            padding: 30px 20px 68px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.28);
            border-radius: 14px;
            padding: 13px 16px;
            flex: 1;
        }

        .menu-card {
            background: #fff;
            border-radius: 22px;
            margin: -46px 16px 0;
            padding: 22px 20px 26px;
            box-shadow: 0 6px 28px rgba(0, 0, 0, 0.09);
            position: relative;
            z-index: 10;
        }

        .svc-box {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.15s;
            position: relative;
        }

        .svc-box:active {
            transform: scale(0.93);
        }

        .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ef4444;
            color: white;
            border-radius: 9999px;
            width: 20px;
            height: 20px;
            font-size: 10px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
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

        .order-card {
            background: #fff;
            border-radius: 16px;
            padding: 14px 16px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: background 0.15s;
            text-decoration: none;
        }

        .order-card:active {
            background: #f9fafb;
        }

        .order-card:last-child {
            margin-bottom: 0;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: 0.4
            }
        }
    </style>
</head>

<body>
    <div class="phone-wrapper">
        <div class="scroll-area">
            <div style="padding-bottom: 28px;">

                <!-- GREEN HEADER -->
                <div class="header-green">
                    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:22px;">
                        <div>
                            <p style="font-size:22px;font-weight:800;color:#fff;line-height:1.15;">Selamat Datang!</p>
                            <p style="font-size:13px;color:rgba(255,255,255,0.85);font-weight:500;margin-top:5px;">
                                {{ $user ? $user->name : 'Juru Angkut' }}
                            </p>
                        </div>
                        <div
                            style="width:44px;height:44px;background:rgba(255,255,255,0.22);border-radius:50%;display:flex;align-items:center;justify-content:center;margin-top:4px;">
                            <svg width="22" height="22" fill="none" stroke="#fff" stroke-width="2.2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                    <div style="display:flex;gap:12px;">
                        <div class="stat-card">
                            <div style="display:flex;align-items:center;gap:7px;margin-bottom:7px;">
                                <span style="font-size:11.5px;color:rgba(255,255,255,0.85);font-weight:500;">Pendapatan
                                    Hari Ini</span>
                            </div>
                            <p style="font-size:19px;font-weight:800;color:#fff;">Rp
                                {{ number_format($pendapatanHariIni, 0, ',', '.') }}</p>
                        </div>
                        <div class="stat-card">
                            <div style="display:flex;align-items:center;gap:7px;margin-bottom:7px;">
                                <svg width="15" height="15" fill="none" stroke="rgba(255,255,255,0.85)"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="4" width="18" height="18" rx="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                    <line x1="3" y1="10" x2="21" y2="10" />
                                </svg>
                                <span style="font-size:11.5px;color:rgba(255,255,255,0.85);font-weight:500;">Order Hari
                                    Ini</span>
                            </div>
                            <p style="font-size:19px;font-weight:800;color:#fff;">{{ $orderHariIni }}</p>
                        </div>
                    </div>
                </div>

                <!-- MENU CARD -->
                <div class="menu-card">
                    <p style="font-size:16px;font-weight:700;color:#111827;margin-bottom:20px;">Menu Utama</p>
                    <div
                        style="display:grid;grid-template-columns:repeat(3,1fr);row-gap:20px;column-gap:4px;text-align:center;">

                        <a href="{{ route('juru-angkut.order.index') }}"
                            style="display:flex;flex-direction:column;align-items:center;gap:9px;text-decoration:none;">
                            <div class="svc-box" style="background:#d1fae5;">
                                <svg width="28" height="28" fill="none" stroke="#059669" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 11H4L5 9z" />
                                </svg>
                                @if ($orderMenunggu->count() > 0)
                                    <span class="badge">{{ $orderMenunggu->count() }}</span>
                                @endif
                            </div>
                            <p style="font-size:11.5px;font-weight:600;color:#374151;line-height:1.35;">Order<br />Masuk
                            </p>
                        </a>

                        <div style="display:flex;flex-direction:column;align-items:center;gap:9px;">
                            <div class="svc-box" style="background:#dbeafe;">
                                <svg width="28" height="28" fill="none" stroke="#2563eb" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <rect x="3" y="4" width="18" height="18" rx="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                    <line x1="3" y1="10" x2="21" y2="10" />
                                </svg>
                            </div>
                            <p style="font-size:11.5px;font-weight:600;color:#374151;">Jadwal</p>
                        </div>

                        <div style="display:flex;flex-direction:column;align-items:center;gap:9px;">
                            <div class="svc-box" style="background:#fef3c7;">
                                <svg width="28" height="28" fill="none" stroke="#d97706" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <rect x="2" y="5" width="20" height="14" rx="2" />
                                    <line x1="2" y1="10" x2="22" y2="10" />
                                </svg>
                            </div>
                            <p style="font-size:11.5px;font-weight:600;color:#374151;">Saldo</p>
                        </div>

                        <a href="{{ route('juru-angkut.riwayat') }}"
                            style="display:flex;flex-direction:column;align-items:center;gap:9px;text-decoration:none;">
                            <div class="svc-box" style="background:#ede9fe;">
                                <svg width="28" height="28" fill="none" stroke="#7c3aed" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p style="font-size:11.5px;font-weight:600;color:#374151;">Riwayat</p>
                        </a>

                        <div style="display:flex;flex-direction:column;align-items:center;gap:9px;">
                            <div class="svc-box" style="background:#fee2e2;">
                                <svg width="28" height="28" fill="none" stroke="#dc2626" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <p style="font-size:11.5px;font-weight:600;color:#374151;">Profil</p>
                        </div>

                        <a href="{{ route('juru-angkut.langganan-tunai') }}" style="display:flex;flex-direction:column;align-items:center;gap:9px;text-decoration:none;">
                            <div class="svc-box" style="background:#fef3c7;">
                                <svg width="28" height="28" fill="none" stroke="#d97706" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                @if($langgananTunaiCount > 0)
                                    <span class="badge">{{ $langgananTunaiCount }}</span>
                                @endif
                            </div>
                            <p style="font-size:11.5px;font-weight:600;color:#374151;line-height:1.35;">
                                Tunai<br />Langganan</p>
                        </a>

                    </div>
                </div>

                <!-- ORDER MENUNGGU -->
                <div style="margin: 18px 16px 0;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                        <p style="font-size:14px;font-weight:700;color:#111827;">Order Menunggu</p>
                        @if ($orderMenunggu->count() > 0)
                            <div
                                style="display:flex;align-items:center;gap:5px;background:#dcfce7;border-radius:20px;padding:3px 10px;">
                                <div
                                    style="width:7px;height:7px;background:#16a34a;border-radius:50%;animation:pulse 1.5s ease-in-out infinite;">
                                </div>
                                <span
                                    style="font-size:11px;font-weight:700;color:#15803d;">{{ $orderMenunggu->count() }}
                                    baru</span>
                            </div>
                        @endif
                    </div>

                    @forelse($orderMenunggu as $order)
                        <a href="{{ route('juru-angkut.order.show', $order->id) }}" class="order-card">
                            <div
                                style="width:44px;height:44px;background:#d1fae5;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <svg width="22" height="22" fill="none" stroke="#059669" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </div>
                            <div style="flex:1;min-width:0;">
                                <div style="display:flex;align-items:center;gap:7px;margin-bottom:3px;">
                                    <p style="font-size:13.5px;font-weight:700;color:#111827;">
                                        {{ $order->pengguna->name ?? 'Pelanggan' }}</p>
                                    @foreach ($order->detailPesanan as $detail)
                                        <span
                                            style="font-size:10px;font-weight:700;color:#16a34a;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:6px;padding:1px 7px;">{{ $detail->kategoriSampah->nama ?? '-' }}</span>
                                    @break
                                @endforeach
                            </div>
                            <p
                                style="font-size:11.5px;color:#6b7280;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $order->alamat_jemput }} &middot;
                                {{ $order->tanggal_jemput ? $order->tanggal_jemput->format('d M Y') : '-' }}
                            </p>
                        </div>
                        <svg width="18" height="18" fill="none" stroke="#d1d5db" stroke-width="2.5"
                            viewBox="0 0 24 24" style="flex-shrink:0;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                @empty
                    <div
                        style="background:#fff;border-radius:16px;padding:24px 16px;box-shadow:0 2px 12px rgba(0,0,0,0.06);text-align:center;">
                        <svg width="40" height="40" fill="none" stroke="#d1d5db" stroke-width="1.5"
                            viewBox="0 0 24 24" style="margin:0 auto 10px;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p style="font-size:13px;color:#9ca3af;font-weight:500;">Belum ada order menunggu</p>
                    </div>
                @endforelse
            </div>

            <!-- RIWAYAT PENGANGKUTAN -->
            <div style="margin: 18px 16px 0;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                    <p style="font-size:14px;font-weight:700;color:#111827;">Riwayat Pengangkutan</p>
                    <a href="{{ route('juru-angkut.riwayat') }}"
                        style="font-size:12px;font-weight:600;color:#16a34a;text-decoration:none;">Lihat
                        Riwayat</a>
                </div>

                <div
                    style="background:#fff;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,0.06);overflow:hidden;">
                    @forelse($riwayat as $item)
                        <div
                            style="display:flex;align-items:center;gap:12px;padding:13px 16px;{{ !$loop->last ? 'border-bottom:1px solid #f3f4f6;' : '' }}">
                            <div
                                style="width:38px;height:38px;background:#d1fae5;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <svg width="16" height="16" fill="none" stroke="#059669"
                                    stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div style="flex:1;">
                                <p style="font-size:13px;font-weight:700;color:#111827;">
                                    {{ $item->pengguna->name ?? 'Pelanggan' }}</p>
                                <p style="font-size:11px;color:#9ca3af;margin-top:2px;">
                                    {{ $item->diselesaikan_pada ? $item->diselesaikan_pada->format('d M Y') : '-' }}
                                    &middot;
                                    @foreach ($item->detailPesanan as $detail)
                                        {{ $detail->kategoriSampah->nama ?? '-' }}@if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </p>
                            </div>
                            <span style="font-size:13px;font-weight:700;color:#16a34a;">+Rp
                                {{ number_format($item->komisi_pengangkut ?? 0, 0, ',', '.') }}</span>
                        </div>
                    @empty
                        <div style="padding:24px 16px;text-align:center;">
                            <p style="font-size:13px;color:#9ca3af;font-weight:500;">Belum ada riwayat pengangkutan
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div><!-- end scroll-area -->

    <!-- FLOATING ACTIVE ORDER BAR (Juru Angkut) -->
    @if(isset($orderAktifJA) && $orderAktifJA)
    <div style="position:absolute;bottom:64px;left:0;right:0;z-index:60;padding:0 12px 8px;">
        <a href="{{ route('juru-angkut.order.proses-jemput', $orderAktifJA->id) }}" style="text-decoration:none;display:flex;align-items:center;gap:12px;background:linear-gradient(135deg,#22c55e 0%,#16a34a 100%);border-radius:16px;padding:12px 16px;box-shadow:0 4px 20px rgba(22,163,74,0.35);">
            <div style="position:relative;flex-shrink:0;">
                <div style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                    <svg width="18" height="18" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                    </svg>
                </div>
                <span style="position:absolute;top:-2px;right:-2px;width:10px;height:10px;background:#fbbf24;border-radius:50%;border:2px solid #16a34a;animation:pulseDotJA 1.5s infinite;"></span>
            </div>
            <div style="flex:1;min-width:0;">
                <p style="font-size:12px;font-weight:700;color:#fff;margin-bottom:1px;">Order Sedang Berjalan</p>
                <p style="font-size:10.5px;color:rgba(255,255,255,0.8);font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $orderAktifJA->pengguna->name ?? 'Pelanggan' }} · {{ ucfirst(str_replace('_', ' ', $orderAktifJA->status)) }}</p>
            </div>
            <div style="background:rgba(255,255,255,0.25);border-radius:10px;padding:7px 14px;flex-shrink:0;">
                <span style="font-size:12px;font-weight:700;color:#fff;">Lihat</span>
            </div>
        </a>
    </div>
    <style>
        @keyframes pulseDotJA {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.3); }
        }
    </style>
    @endif

    <!-- BOTTOM NAV -->
    <div class="nav-bottom">
        <a href="{{ route('juru-angkut.index') }}" class="nav-btn">
            <svg width="22" height="22" fill="#16a34a" viewBox="0 0 24 24">
                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
            </svg>
            <span style="font-size:10px;font-weight:700;color:#16a34a;">Home</span>
        </a>
        <a href="{{ route('juru-angkut.order.index') }}" class="nav-btn">
            <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 11H4L5 9z" />
            </svg>
            <span style="font-size:10px;font-weight:500;color:#9ca3af;">Order</span>
        </a>
        <a href="{{ route('juru-angkut.riwayat') }}" class="nav-btn">
            <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span style="font-size:10px;font-weight:500;color:#9ca3af;">History</span>
        </a>
        <a href="{{ route('juru-angkut.profil') }}" class="nav-btn">
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

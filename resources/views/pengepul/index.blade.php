<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Go Garbage – Dashboard Pengepul</title>
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

        .header-green {
            background: linear-gradient(150deg, #2ecc71 0%, #1aab57 50%, #168a45 100%);
            padding: 36px 20px 72px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 16px;
            padding: 14px 18px;
            flex: 1;
        }

        .menu-card {
            background: #fff;
            border-radius: 22px;
            margin: -48px 16px 0;
            padding: 20px 16px 22px;
            box-shadow: 0 6px 28px rgba(0, 0, 0, 0.09);
            position: relative;
            z-index: 10;
        }

        .menu-box {
            width: 58px;
            height: 58px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.15s;
            position: relative;
        }

        .menu-box:active {
            transform: scale(0.93);
        }

        .badge {
            position: absolute;
            top: -6px;
            right: -6px;
            width: 20px;
            height: 20px;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            font-weight: 800;
            color: #fff;
        }

        .section-wrap {
            margin: 18px 16px 0;
        }

        .request-card {
            background: #fff;
            border-radius: 16px;
            padding: 16px 16px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            margin-bottom: 10px;
            text-decoration: none;
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

        .badge-blue {
            background: #eff6ff;
            color: #3b82f6;
            font-size: 11.5px;
            font-weight: 700;
            padding: 5px 13px;
            border-radius: 99px;
            white-space: nowrap;
        }

        .tx-card {
            background: #fff;
            border-radius: 16px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            margin-bottom: 10px;
            text-decoration: none;
        }

        .tx-check {
            width: 34px;
            height: 34px;
            background: #d1fae5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
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
    </style>
</head>

<body>
    <div class="phone-wrapper">

        <div class="scroll-area">
            <div style="padding-bottom:28px;">

                <!-- ── GREEN HEADER ── -->
                <div class="header-green">
                    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:22px;">
                        <div>
                            <p style="font-size:13px;color:rgba(255,255,255,0.85);font-weight:500;margin-bottom:4px;">
                                Selamat Datang,</p>
                            <p style="font-size:22px;font-weight:800;color:#fff;line-height:1.2;">
                                {{ $user->name ?? 'Pengepul' }}</p>
                        </div>
                        <div
                            style="width:46px;height:46px;border:2px solid rgba(255,255,255,0.6);border-radius:50%;display:flex;align-items:center;justify-content:center;margin-top:2px;">
                            <svg width="24" height="24" fill="none" stroke="#fff" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                    <div style="display:flex;gap:12px;">
                        <div class="stat-card">
                            <p style="font-size:12px;color:rgba(255,255,255,0.82);font-weight:500;margin-bottom:6px;">
                                Total Pembelian</p>
                            <p style="font-size:24px;font-weight:800;color:#fff;">{{ $totalPembelian }}</p>
                        </div>
                        <div class="stat-card">
                            <p style="font-size:12px;color:rgba(255,255,255,0.82);font-weight:500;margin-bottom:6px;">
                                Total Berat</p>
                            <p style="font-size:24px;font-weight:800;color:#fff;">{{ number_format($totalBerat, 1, ',', '.') }} kg</p>
                        </div>
                    </div>
                </div>

                <!-- ── FLOATING MENU CARD ── -->
                <div class="menu-card">
                    <div style="display:grid;grid-template-columns:repeat(4,1fr);text-align:center;gap:8px;">

                        <!-- Stok Gudang -->
                        <a href="{{ route('pengepul.stok') }}" style="display:flex;flex-direction:column;align-items:center;gap:8px;text-decoration:none;">
                            <div class="menu-box" style="background:#e8faf0;">
                                <svg width="26" height="26" fill="none" stroke="#16a34a" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <p style="font-size:11px;font-weight:600;color:#374151;line-height:1.3;">Stok<br />Gudang</p>
                        </a>

                        <!-- Request Ambil -->
                        <a href="{{ route('pengepul.request') }}" style="display:flex;flex-direction:column;align-items:center;gap:8px;text-decoration:none;">
                            <div class="menu-box" style="background:#eff6ff;">
                                <svg width="26" height="26" fill="none" stroke="#3b82f6" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M12 11v4m0 0l-2-2m2 2l2-2" />
                                </svg>
                                @if($requestAktif->count() > 0)
                                    <span class="badge">{{ $requestAktif->count() }}</span>
                                @endif
                            </div>
                            <p style="font-size:11px;font-weight:600;color:#374151;line-height:1.3;">Request<br />Ambil</p>
                        </a>

                        <!-- Riwayat -->
                        <a href="{{ route('pengepul.riwayat') }}" style="display:flex;flex-direction:column;align-items:center;gap:8px;text-decoration:none;">
                            <div class="menu-box" style="background:#f5f3ff;">
                                <svg width="26" height="26" fill="none" stroke="#7c3aed" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p style="font-size:11px;font-weight:600;color:#374151;line-height:1.3;">Riwayat</p>
                        </a>

                        <!-- Profil -->
                        <div style="display:flex;flex-direction:column;align-items:center;gap:8px;">
                            <div class="menu-box" style="background:#fff1f2;">
                                <svg width="26" height="26" fill="none" stroke="#f43f5e" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <p style="font-size:11px;font-weight:600;color:#374151;line-height:1.3;">Profil</p>
                        </div>

                    </div>
                </div>

                <!-- ── REQUEST AKTIF ── -->
                <div class="section-wrap">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                        <p style="font-size:16px;font-weight:800;color:#111827;">Request Aktif</p>
                        @if($requestAktif->count() > 0)
                            <span style="font-size:12px;font-weight:700;color:#16a34a;background:#d1fae5;padding:4px 12px;border-radius:99px;">{{ $requestAktif->count() }} aktif</span>
                        @endif
                    </div>

                    @forelse($requestAktif as $req)
                        <a href="{{ route('pengepul.request', ['status' => $req->status]) }}" class="request-card">
                            <div style="width:44px;height:44px;background:#16a34a;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <svg width="22" height="22" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div style="flex:1;">
                                <p style="font-size:14px;font-weight:800;color:#111827;">{{ $req->nomor_invoice }}</p>
                                <p style="font-size:11.5px;color:#9ca3af;margin-top:3px;font-weight:500;">
                                    {{ $req->detail->count() }} item · Est. {{ number_format($req->total_berat, 1, ',', '.') }} kg
                                </p>
                            </div>
                            @if($req->status === 'menunggu')
                                <span class="badge-yellow">Menunggu</span>
                            @elseif($req->status === 'disetujui')
                                <span class="badge-blue">Disetujui</span>
                            @endif
                        </a>
                    @empty
                        <div style="background:#fff;border-radius:16px;padding:24px 16px;box-shadow:0 2px 12px rgba(0,0,0,0.06);text-align:center;">
                            <svg width="40" height="40" fill="none" stroke="#d1d5db" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 10px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <p style="font-size:13px;color:#9ca3af;font-weight:500;">Belum ada request aktif</p>
                        </div>
                    @endforelse
                </div>

                <!-- ── TRANSAKSI TERAKHIR ── -->
                <div class="section-wrap">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                        <p style="font-size:16px;font-weight:800;color:#111827;">Transaksi Terakhir</p>
                        <a href="{{ route('pengepul.riwayat') }}" style="font-size:12px;font-weight:700;color:#16a34a;text-decoration:none;">Lihat Semua</a>
                    </div>

                    @forelse($transaksiTerakhir as $tx)
                        <a href="{{ route('pengepul.riwayat.show', $tx->id) }}" class="tx-card">
                            <div class="tx-check">
                                <svg width="16" height="16" fill="none" stroke="#16a34a" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div style="flex:1;">
                                <p style="font-size:13px;font-weight:700;color:#111827;">{{ $tx->nomor_invoice }}</p>
                                <p style="font-size:11.5px;color:#9ca3af;margin-top:2px;">{{ $tx->created_at->format('d M Y') }}</p>
                            </div>
                            <span style="font-size:14px;font-weight:800;color:#16a34a;">Rp {{ number_format($tx->total_harga, 0, ',', '.') }}</span>
                        </a>
                    @empty
                        <div style="background:#fff;border-radius:16px;padding:24px 16px;box-shadow:0 2px 12px rgba(0,0,0,0.06);text-align:center;">
                            <p style="font-size:13px;color:#9ca3af;font-weight:500;">Belum ada transaksi</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>

        @include('pengepul.partials.navigation')

    </div>
</body>

</html>

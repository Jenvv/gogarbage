<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Riwayat Order</title>
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
            padding: 20px 20px 24px;
            flex-shrink: 0;
        }

        /* Scroll — hidden scrollbar */
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

        /* Order card */
        .order-card {
            background: #fff;
            border-radius: 18px;
            margin: 0 14px 12px;
            padding: 16px 16px 14px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        /* Status row */
        .status-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        /* Meta grid */
        .meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-top: 10px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Payment chip */
        .pay-chip {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            padding: 9px 14px;
            margin-top: 12px;
        }

        /* Divider */
        .card-divider {
            border: none;
            border-top: 1px solid #f3f4f6;
            margin: 12px 0 0;
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
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="phone-wrapper">

        <!-- HEADER -->
        <div class="page-header">
            <div style="display:flex;align-items:center;gap:14px;margin-bottom:5px;">
                <a href="{{ route('juru-angkut.index') }}"
                    style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;text-decoration:none;">
                    <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 style="font-size:19px;font-weight:800;color:#fff;">Riwayat Order</h1>
            </div>
            <p style="font-size:12.5px;color:rgba(255,255,255,0.78);font-weight:500;padding-left:50px;">
                {{ $orders->count() }} order selesai
            </p>
        </div>

        <!-- SCROLL AREA -->
        <div class="scroll-area">
            <div style="padding: 14px 0 24px;">

                @forelse($orders as $order)
                    <div class="order-card">
                        <!-- Status + amount -->
                        <div class="status-row">
                            <div style="display:flex;align-items:center;gap:6px;">
                                <svg width="16" height="16" fill="none" stroke="#16a34a" stroke-width="2.5"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span style="font-size:12.5px;font-weight:700;color:#16a34a;">Selesai</span>
                            </div>
                            <span style="font-size:14px;font-weight:800;color:#16a34a;">
                                Rp {{ number_format($order->komisi_pengangkut ?? 0, 0, ',', '.') }}
                            </span>
                        </div>
                        <p style="font-size:11px;color:#9ca3af;font-weight:500;margin-bottom:12px;">
                            Order {{ $order->nomor_pesanan }}
                        </p>

                        <hr class="card-divider" style="margin-bottom:12px;" />

                        <!-- Name -->
                        <p style="font-size:15px;font-weight:800;color:#111827;margin-bottom:8px;">
                            {{ $order->pengguna->name ?? 'Pelanggan' }}
                        </p>

                        <!-- Address -->
                        <div style="display:flex;align-items:flex-start;gap:6px;margin-bottom:2px;">
                            <svg width="14" height="14" fill="none" stroke="#16a34a" stroke-width="2"
                                viewBox="0 0 24 24" style="flex-shrink:0;margin-top:2px;">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <p style="font-size:12px;color:#6b7280;font-weight:500;">{{ $order->alamat_jemput }}</p>
                        </div>

                        <!-- Meta grid -->
                        <div class="meta-grid">
                            <div>
                                <div class="meta-item" style="margin-bottom:3px;">
                                    <svg width="13" height="13" fill="none" stroke="#16a34a" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span style="font-size:10px;color:#9ca3af;font-weight:600;">Tanggal</span>
                                </div>
                                <p style="font-size:12.5px;font-weight:700;color:#111827;padding-left:19px;">
                                    {{ $order->diselesaikan_pada ? $order->diselesaikan_pada->format('d M Y') : ($order->tanggal_jemput ? $order->tanggal_jemput->format('d M Y') : '-') }}
                                </p>
                            </div>
                            <div>
                                <div class="meta-item" style="margin-bottom:3px;">
                                    <svg width="13" height="13" fill="none" stroke="#16a34a" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span style="font-size:10px;color:#9ca3af;font-weight:600;">Jenis</span>
                                </div>
                                <p style="font-size:12.5px;font-weight:700;color:#111827;padding-left:19px;">
                                    @foreach ($order->detailPesanan as $detail)
                                        {{ $detail->kategoriSampah->nama ?? '-' }}@if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </p>
                            </div>
                        </div>

                        <!-- Berat -->
                        <div class="meta-grid" style="margin-top:8px;">
                            <div>
                                <div class="meta-item" style="margin-bottom:3px;">
                                    <svg width="13" height="13" fill="none" stroke="#16a34a" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                    </svg>
                                    <span style="font-size:10px;color:#9ca3af;font-weight:600;">Berat</span>
                                </div>
                                <p style="font-size:12.5px;font-weight:700;color:#111827;padding-left:19px;">
                                    {{ number_format($order->total_berat ?? 0, 1) }} Kg
                                </p>
                            </div>
                        </div>

                        <!-- Payment -->
                        <div class="pay-chip">
                            <div style="display:flex;align-items:center;gap:7px;">
                                <svg width="14" height="14" fill="none" stroke="#16a34a" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                <span style="font-size:12px;color:#6b7280;font-weight:500;">Biaya Jemput</span>
                            </div>
                            <span style="font-size:12.5px;font-weight:800;color:#16a34a;">
                                @if ($order->biaya_jemput > 0)
                                    Rp {{ number_format($order->biaya_jemput, 0, ',', '.') }}
                                @else
                                    Gratis
                                @endif
                            </span>
                        </div>

                        {{-- Pendapatan pelanggan dari sampah terjual --}}
                        @if($order->total_pendapatan > 0)
                        <div style="margin-top:10px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:14px;padding:12px 14px;">
                            <div style="display:flex;align-items:center;gap:7px;margin-bottom:10px;">
                                <svg width="15" height="15" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span style="font-size:12px;font-weight:700;color:#15803d;">Pendapatan Pelanggan</span>
                            </div>

                            @foreach($order->detailPesanan as $detail)
                                @if($detail->subtotal > 0)
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0;{{ !$loop->last ? 'border-bottom:1px solid #dcfce7;' : '' }}">
                                    <div>
                                        <p style="font-size:12px;font-weight:600;color:#374151;">{{ $detail->kategoriSampah->nama ?? '-' }}</p>
                                        <p style="font-size:10.5px;color:#9ca3af;">{{ number_format($detail->berat, 1) }} kg × Rp {{ number_format($detail->harga_per_kg, 0, ',', '.') }}</p>
                                    </div>
                                    <span style="font-size:12px;font-weight:700;color:#16a34a;">+Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                                </div>
                                @endif
                            @endforeach

                            <div style="border-top:1.5px solid #86efac;margin-top:8px;padding-top:8px;display:flex;justify-content:space-between;align-items:center;">
                                <span style="font-size:12.5px;font-weight:700;color:#111827;">Total Pendapatan</span>
                                <span style="font-size:14px;font-weight:800;color:#16a34a;">+Rp {{ number_format($order->total_pendapatan, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                    @empty
                        <div style="margin:40px 16px;text-align:center;">
                            <svg width="56" height="56" fill="none" stroke="#d1d5db" stroke-width="1.5"
                                viewBox="0 0 24 24" style="margin:0 auto 16px;">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p style="font-size:16px;font-weight:700;color:#6b7280;margin-bottom:6px;">Belum Ada Riwayat
                            </p>
                            <p style="font-size:13px;color:#9ca3af;">Riwayat order yang sudah selesai<br>akan muncul di
                                sini.</p>
                        </div>
                    @endforelse

                </div>
            </div><!-- end scroll-area -->

            <!-- NAV -->
            <div class="nav-bottom">
                <a href="{{ route('juru-angkut.index') }}" class="nav-btn">
                    <svg width="22" height="22" fill="#9ca3af" viewBox="0 0 24 24">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                    </svg>
                    <span style="font-size:10px;font-weight:500;color:#9ca3af;">Home</span>
                </a>
                <a href="{{ route('juru-angkut.order.index') }}" class="nav-btn">
                    <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span style="font-size:10px;font-weight:500;color:#9ca3af;">Order</span>
                </a>
                <a href="{{ route('juru-angkut.riwayat') }}" class="nav-btn">
                    <svg width="22" height="22" fill="none" stroke="#16a34a" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span style="font-size:10px;font-weight:700;color:#16a34a;">History</span>
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

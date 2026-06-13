<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Order Masuk</title>
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

        /* Header */
        .header-green {
            background: linear-gradient(150deg, #2ecc71 0%, #1aab57 50%, #168a45 100%);
            padding: 44px 20px 22px;
            flex-shrink: 0;
        }

        /* Order card */
        .order-card {
            background: #fff;
            border-radius: 18px;
            margin: 0 16px 14px;
            padding: 18px 18px 16px;
            box-shadow: 0 2px 14px rgba(0, 0, 0, 0.07);
        }

        .order-card:first-child {
            margin-top: 16px;
        }

        /* Harga row */
        .harga-row {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            padding: 11px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        /* Buttons */
        .btn-tolak {
            flex: 1;
            padding: 12px 0;
            border-radius: 50px;
            border: 2px solid #ef4444;
            color: #ef4444;
            font-size: 14px;
            font-weight: 700;
            background: transparent;
            cursor: pointer;
            transition: background 0.18s, color 0.18s;
        }

        .btn-tolak:hover {
            background: #fef2f2;
        }

        .btn-terima {
            flex: 1;
            padding: 12px 0;
            border-radius: 50px;
            border: none;
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            background: linear-gradient(135deg, #2ecc71 0%, #16a34a 100%);
            cursor: pointer;
            transition: opacity 0.18s;
        }

        .btn-terima:hover {
            opacity: 0.9;
        }

        /* Info pill row */
        .info-row {
            display: flex;
            gap: 28px;
            margin-bottom: 14px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        /* Kategori badges */
        .kategori-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-bottom: 14px;
        }

        .kategori-badge {
            font-size: 10px;
            font-weight: 700;
            border-radius: 6px;
            padding: 2px 8px;
        }
    </style>
</head>

<body>
    <div class="phone-wrapper">

        <!-- GREEN HEADER -->
        <div class="header-green">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:6px;">
                <a href="{{ route('juru-angkut.index') }}"
                    style="background:none;border:none;cursor:pointer;padding:0;display:flex;align-items:center;text-decoration:none;">
                    <svg width="22" height="22" fill="none" stroke="#fff" stroke-width="2.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <p style="font-size:20px;font-weight:800;color:#fff;">Order Masuk</p>
            </div>
            <p style="font-size:13px;color:rgba(255,255,255,0.88);font-weight:500;padding-left:34px;">
                {{ $orders->count() }} order menunggu konfirmasi
            </p>
        </div>

        <!-- SCROLL AREA -->
        <div class="scroll-area">
            <div style="padding-bottom: 24px;">

                @forelse($orders as $order)
                    <a href="{{ route('juru-angkut.order.show', $order->id) }}" style="text-decoration:none;">
                        <div class="order-card" @if ($loop->first) style="margin-top:16px;" @endif>
                            <!-- Name -->
                            <p style="font-size:17px;font-weight:800;color:#111827;margin-bottom:6px;">
                                {{ $order->pengguna->name ?? 'Pelanggan' }}
                            </p>
                            <!-- Address -->
                            <div style="display:flex;align-items:center;gap:5px;margin-bottom:14px;">
                                <svg width="14" height="14" fill="none" stroke="#ef4444" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <p style="font-size:12.5px;color:#6b7280;font-weight:400;">{{ $order->alamat_jemput }}
                                </p>
                            </div>

                            <!-- Kategori Sampah Badges -->
                            <div class="kategori-badges">
                                @foreach ($order->detailPesanan as $detail)
                                    <span class="kategori-badge"
                                        style="color:#16a34a;background:#f0fdf4;border:1px solid #bbf7d0;">
                                        {{ $detail->kategoriSampah->nama ?? '-' }}
                                    </span>
                                @endforeach
                            </div>

                            <!-- Jenis + Waktu -->
                            <div class="info-row">
                                <div class="info-item">
                                    <div style="display:flex;align-items:center;gap:5px;">
                                        <svg width="13" height="13" fill="none" stroke="#6b7280"
                                            stroke-width="2" viewBox="0 0 24 24">
                                            <rect x="3" y="4" width="18" height="18" rx="2" />
                                            <line x1="16" y1="2" x2="16" y2="6" />
                                            <line x1="8" y1="2" x2="8" y2="6" />
                                            <line x1="3" y1="10" x2="21" y2="10" />
                                        </svg>
                                        <span style="font-size:11.5px;color:#9ca3af;font-weight:500;">Tanggal</span>
                                    </div>
                                    <p style="font-size:13.5px;font-weight:700;color:#111827;padding-left:18px;">
                                        {{ $order->tanggal_jemput ? $order->tanggal_jemput->format('d M Y') : '-' }}
                                    </p>
                                </div>
                                <div class="info-item">
                                    <div style="display:flex;align-items:center;gap:5px;">
                                        <svg width="13" height="13" fill="none" stroke="#6b7280"
                                            stroke-width="2" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="10" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                                        </svg>
                                        <span style="font-size:11.5px;color:#9ca3af;font-weight:500;">Waktu</span>
                                    </div>
                                    <p style="font-size:13.5px;font-weight:700;color:#111827;padding-left:18px;">
                                        {{ $order->jam_jemput ? \Carbon\Carbon::parse($order->jam_jemput)->format('H:i') : '-' }}
                                    </p>
                                </div>
                            </div>
                            <!-- Harga -->
                            <div class="harga-row">
                                <span style="font-size:13px;color:#374151;font-weight:500;">Biaya Jemput</span>
                                <div style="display:flex;align-items:center;gap:6px;">                        
                                    <span style="font-size:15px;font-weight:800;color:#16a34a;">
                                        @if ($order->biaya_jemput > 0)
                                            Rp {{ number_format($order->biaya_jemput, 0, ',', '.') }}
                                        @else
                                            Gratis
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <!-- Catatan -->
                            @if ($order->catatan)
                                <div
                                    style="background:#fffbeb;border:1px solid #fde68a;border-radius:10px;padding:10px 14px;margin-bottom:14px;">
                                    <p style="font-size:11px;color:#92400e;font-weight:600;margin-bottom:2px;">Catatan:
                                    </p>
                                    <p style="font-size:12px;color:#78350f;">{{ $order->catatan }}</p>
                                </div>
                            @endif

                            <!-- Buttons -->
                            {{-- <div style="display:flex;gap:12px;">
                                <form action="{{ route('juru-angkut.order.tolak', $order->id) }}" method="POST"
                                    style="flex:1;">
                                    @csrf
                                    <button type="submit" class="btn-tolak" style="width:100%;"
                                        onclick="return confirm('Yakin ingin menolak order ini?')">Tolak</button>
                                </form>
                                <form action="{{ route('juru-angkut.order.terima', $order->id) }}" method="POST"
                                    style="flex:1;">
                                    @csrf
                                    <button type="submit" class="btn-terima" style="width:100%;">Terima</button>
                                </form>
                            </div> --}}
                        </div>
                    </a>
                @empty
                    <div style="margin:40px 16px;text-align:center;">
                        <svg width="56" height="56" fill="none" stroke="#d1d5db" stroke-width="1.5"
                            viewBox="0 0 24 24" style="margin:0 auto 16px;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p style="font-size:16px;font-weight:700;color:#6b7280;margin-bottom:6px;">Tidak Ada Order</p>
                        <p style="font-size:13px;color:#9ca3af;">Belum ada order masuk saat ini.<br>Silakan cek kembali
                            nanti.</p>
                    </div>
                @endforelse

            </div>
        </div><!-- end scroll-area -->

    </div>
</body>

</html>

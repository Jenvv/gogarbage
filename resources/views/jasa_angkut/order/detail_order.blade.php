<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detail Order</title>
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

        /* Main detail card */
        .detail-card {
            background: #fff;
            border-radius: 18px;
            margin: 16px 16px 14px;
            padding: 0;
            box-shadow: 0 2px 14px rgba(0, 0, 0, 0.07);
            overflow: hidden;
        }

        /* Each row inside detail card */
        .detail-row {
            padding: 18px 20px;
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .detail-row+.detail-row {
            border-top: 1px solid #f3f4f6;
        }

        .detail-icon {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 2px;
        }

        /* Total Harga box */
        .harga-box {
            background: #f0fdf4;
            border-radius: 14px;
            margin: 0 20px 20px;
            padding: 16px 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Info banner */
        .info-banner {
            background: #f0fdf4;
            border-left: 4px solid #16a34a;
            border-radius: 10px;
            margin: 0 16px 14px;
            padding: 14px 16px;
        }

        /* Bottom bar */
        .bottom-bar {
            height: 76px;
            background: #fff;
            border-top: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 16px;
            flex-shrink: 0;
        }

        .btn-kembali {
            flex: 1;
            padding: 13px 0;
            border-radius: 50px;
            border: 1.5px solid #d1d5db;
            color: #374151;
            font-size: 14px;
            font-weight: 700;
            background: #fff;
            cursor: pointer;
            transition: background 0.18s;
            text-decoration: none;
            text-align: center;
            display: block;
        }

        .btn-kembali:hover {
            background: #f9fafb;
        }

        .btn-terima {
            flex: 1.4;
            padding: 13px 0;
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

        /* Kategori badge */
        .kategori-list { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 6px; }
        .kategori-chip {
            font-size: 11px; font-weight: 600; color: #16a34a; background: #f0fdf4;
            border: 1px solid #bbf7d0; border-radius: 8px; padding: 3px 10px;
        }
    </style>
</head>

<body>
    <div class="phone-wrapper">

        <!-- GREEN HEADER -->
        <div class="header-green">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:5px;">
                <a href="{{ route('jasa-angkut.order.index') }}" style="background:none;border:none;cursor:pointer;padding:0;display:flex;align-items:center;text-decoration:none;">
                    <svg width="22" height="22" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <p style="font-size:20px;font-weight:800;color:#fff;">Detail Order</p>
            </div>
            <p style="font-size:13px;color:rgba(255,255,255,0.88);font-weight:500;padding-left:34px;">
                Order {{ $pesanan->nomor_pesanan }}
            </p>
        </div>

        <!-- SCROLL AREA -->
        <div class="scroll-area">
            <div style="padding-bottom: 16px;">

                <!-- DETAIL CARD -->
                <div class="detail-card">

                    <!-- Nama Pelanggan -->
                    <div class="detail-row">
                        <div class="detail-icon" style="background:#d1fae5;">
                            <svg width="20" height="20" fill="none" stroke="#059669" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:11.5px;color:#9ca3af;font-weight:500;margin-bottom:4px;">Nama Pelanggan</p>
                            <p style="font-size:15px;font-weight:700;color:#111827;">
                                {{ $pesanan->pengguna->name ?? 'Pelanggan' }}
                            </p>
                            @if($pesanan->pengguna && $pesanan->pengguna->telepon)
                            <p style="font-size:12px;color:#6b7280;margin-top:3px;">
                                📞 {{ $pesanan->pengguna->telepon }}
                            </p>
                            @endif
                        </div>
                    </div>

                    <!-- Alamat Lengkap -->
                    <div class="detail-row">
                        <div class="detail-icon" style="background:#fee2e2;">
                            <svg width="20" height="20" fill="none" stroke="#ef4444" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:11.5px;color:#9ca3af;font-weight:500;margin-bottom:4px;">Alamat Penjemputan</p>
                            <p style="font-size:14px;font-weight:500;color:#111827;line-height:1.6;">
                                {{ $pesanan->alamat_jemput }}
                            </p>
                        </div>
                    </div>

                    <!-- Jenis Sampah -->
                    <div class="detail-row">
                        <div class="detail-icon" style="background:#d1fae5;">
                            <svg width="20" height="20" fill="none" stroke="#059669" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:11.5px;color:#9ca3af;font-weight:500;margin-bottom:4px;">Jenis Sampah</p>
                            <div class="kategori-list">
                                @foreach($pesanan->detailPesanan as $detail)
                                <span class="kategori-chip">{{ $detail->kategoriSampah->nama ?? '-' }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Tipe Pesanan -->
                    <div class="detail-row">
                        <div class="detail-icon" style="background:#ede9fe;">
                            <svg width="20" height="20" fill="none" stroke="#7c3aed" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:11.5px;color:#9ca3af;font-weight:500;margin-bottom:4px;">Tipe Pesanan</p>
                            <p style="font-size:15px;font-weight:700;color:#111827;">
                                {{ $pesanan->tipe_pesanan === 'langganan' ? '🌟 Langganan' : 'Reguler' }}
                            </p>
                        </div>
                    </div>

                    <!-- Tanggal + Waktu -->
                    <div class="detail-row" style="gap:0;">
                        <!-- Tanggal -->
                        <div style="display:flex;align-items:flex-start;gap:14px;flex:1;">
                            <div class="detail-icon" style="background:#dbeafe;">
                                <svg width="20" height="20" fill="none" stroke="#2563eb" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <rect x="3" y="4" width="18" height="18" rx="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                    <line x1="3" y1="10" x2="21" y2="10" />
                                </svg>
                            </div>
                            <div>
                                <p style="font-size:11.5px;color:#9ca3af;font-weight:500;margin-bottom:4px;">Tanggal</p>
                                <p style="font-size:15px;font-weight:700;color:#111827;line-height:1.4;">
                                    {{ $pesanan->tanggal_jemput ? $pesanan->tanggal_jemput->format('d M Y') : '-' }}
                                </p>
                            </div>
                        </div>
                        <!-- Waktu -->
                        <div style="display:flex;align-items:flex-start;gap:14px;flex:1;">
                            <div class="detail-icon" style="background:#fef3c7;">
                                <svg width="20" height="20" fill="none" stroke="#d97706" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                                </svg>
                            </div>
                            <div>
                                <p style="font-size:11.5px;color:#9ca3af;font-weight:500;margin-bottom:4px;">Waktu</p>
                                <p style="font-size:15px;font-weight:700;color:#111827;">
                                    {{ $pesanan->jam_jemput ? \Carbon\Carbon::parse($pesanan->jam_jemput)->format('H:i') : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Biaya Jemput -->
                    <div class="harga-box">
                        <div
                            style="width:34px;height:34px;background:#d1fae5;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg width="16" height="16" fill="none" stroke="#16a34a" stroke-width="2.2"
                                viewBox="0 0 24 24">
                                <line x1="12" y1="1" x2="12" y2="23" />
                                <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" />
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:11.5px;color:#6b7280;font-weight:500;margin-bottom:3px;">Biaya Jemput</p>
                            <p style="font-size:22px;font-weight:800;color:#16a34a;">
                                @if($pesanan->biaya_jemput > 0)
                                Rp {{ number_format($pesanan->biaya_jemput, 0, ',', '.') }}
                                @else
                                Gratis (Langganan)
                                @endif
                            </p>
                        </div>
                    </div>

                </div>
                <!-- END DETAIL CARD -->

                <!-- CATATAN -->
                @if($pesanan->catatan)
                <div style="background:#fffbeb;border-left:4px solid #f59e0b;border-radius:10px;margin:0 16px 14px;padding:14px 16px;">
                    <p style="font-size:13px;color:#374151;line-height:1.65;">
                        <span style="font-weight:700;color:#b45309;">Catatan Pelanggan:</span>
                        {{ $pesanan->catatan }}
                    </p>
                </div>
                @endif

                <!-- INFO BANNER -->
                <div class="info-banner">
                    <p style="font-size:13px;color:#374151;line-height:1.65;">
                        <span style="font-weight:700;color:#16a34a;">Info:</span>
                        Pastikan untuk datang tepat waktu dan bawa perlengkapan yang diperlukan.
                    </p>
                </div>

            </div>
        </div><!-- end scroll-area -->

        <!-- BOTTOM BAR -->
        @if($pesanan->status === 'menunggu')
        <div class="bottom-bar">
            <a href="{{ route('jasa-angkut.order.index') }}" class="btn-kembali">Kembali</a>
            <form action="{{ route('jasa-angkut.order.terima', $pesanan->id) }}" method="POST" style="flex:1.4;">
                @csrf
                <button type="submit" class="btn-terima" style="width:100%;">Terima Order</button>
            </form>
        </div>
        @elseif(in_array($pesanan->status, ['diklaim', 'dalam_perjalanan', 'tiba', 'penimbangan']))
        <div class="bottom-bar">
            <a href="{{ route('jasa-angkut.order.proses-jemput', $pesanan->id) }}" class="btn-terima" style="flex:1;text-align:center;text-decoration:none;display:block;padding:13px 0;">
                Proses Jemput
            </a>
        </div>
        @endif

    </div>
</body>

</html>
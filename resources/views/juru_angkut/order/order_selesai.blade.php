<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Order Selesai</title>
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
            background: #d4d4d4;
            display: flex;
            justify-content: center;
            min-height: 100vh;
        }

        .phone-wrapper {
            width: 390px;
            height: 100vh;
            background: linear-gradient(160deg, #34d978 0%, #1aab57 45%, #0f7a3a 100%);
            position: relative;
            overflow: hidden;
            box-shadow: 0 0 56px rgba(0, 0, 0, 0.22);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 28px 24px 36px;
        }

        @media (max-width: 390px) {
            body {
                background: linear-gradient(160deg, #34d978 0%, #1aab57 45%, #0f7a3a 100%);
            }

            .phone-wrapper {
                width: 100%;
                box-shadow: none;
            }
        }

        /* ── Check circle ── */
        .check-wrap {
            position: relative;
            width: 110px;
            height: 110px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            z-index: 1;
        }

        .check-outer {
            width: 94px;
            height: 94px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: popIn 0.55s cubic-bezier(0.34, 1.56, 0.64, 1) 0.15s both;
        }

        .check-inner {
            width: 72px;
            height: 72px;
            background: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        /* SVG checkmark draw */
        .check-path {
            stroke-dasharray: 36;
            stroke-dashoffset: 36;
            animation: drawCheck 0.45s ease-out 0.65s forwards;
        }

        @keyframes drawCheck {
            to {
                stroke-dashoffset: 0;
            }
        }

        /* ── Staggered slide-up for content ── */
        .slide-up {
            opacity: 0;
            transform: translateY(22px);
            animation: slideUp 0.5s ease-out forwards;
        }

        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ── Info card ── */
        .info-card {
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.28);
            border-radius: 22px;
            padding: 20px;
            width: 100%;
            margin-top: 24px;
            backdrop-filter: blur(8px);
        }

        .info-divider {
            border: none;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            margin: 14px 0;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        /* ── Buttons ── */
        .btn-dashboard {
            width: 100%;
            background: rgba(255, 255, 255, 0.18);
            border: 1.5px solid rgba(255, 255, 255, 0.5);
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 700;
            padding: 14px;
            border-radius: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.2s, transform 0.15s;
            margin-top: 12px;
            text-decoration: none;
        }

        .btn-dashboard:hover {
            background: rgba(255, 255, 255, 0.28);
        }

        .btn-dashboard:active {
            transform: scale(0.97);
        }

        .btn-riwayat {
            width: 100%;
            background: #fff;
            color: #16a34a;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 700;
            padding: 14px;
            border-radius: 14px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: opacity 0.2s, transform 0.15s;
            margin-top: 10px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
            text-decoration: none;
        }

        .btn-riwayat:hover {
            opacity: 0.92;
        }

        .btn-riwayat:active {
            transform: scale(0.97);
        }

        /* ── Amount counter ── */
        #amountDisplay {
            font-size: 28px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 14px;
        }

        @keyframes popIn {
            0% {
                transform: scale(0.4);
                opacity: 0;
            }

            60% {
                transform: scale(1.12);
            }

            80% {
                transform: scale(0.96);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div class="phone-wrapper" id="phoneWrapper">

        <!-- ── Check icon ── -->
        <div class="check-wrap">
            <div class="check-outer">
                <div class="check-inner">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none">
                        <path class="check-path" d="M5 13l4 4L19 7" stroke="#16a34a" stroke-width="2.8"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- ── Title ── -->
        <p class="slide-up"
            style="font-size:27px;font-weight:800;color:#fff;text-align:center;margin-bottom:7px;animation-delay:0.7s;position:relative;z-index:1;">
            Order Selesai!
        </p>
        <p class="slide-up"
            style="font-size:13px;color:rgba(255,255,255,0.85);text-align:center;margin-bottom:4px;animation-delay:0.85s;">
            Terima kasih atas kerja kerasnya
        </p>
        <p class="slide-up" style="font-size:12px;color:rgba(255,255,255,0.6);font-weight:600;animation-delay:0.95s;">
            Order {{ $pesanan->nomor_pesanan }}
        </p>

        <!-- ── Info card ── -->
        <div class="info-card slide-up" style="animation-delay:1.05s;">
            <p
                style="font-size:10.5px;color:rgba(255,255,255,0.65);font-weight:700;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:7px;">
                Komisi Pengangkut
            </p>
            <div id="amountDisplay">Rp {{ number_format($pesanan->komisi_pengangkut ?? 0, 0, ',', '.') }}</div>

            <hr class="info-divider" />

            <div class="info-row">
                <span style="font-size:13px;color:rgba(255,255,255,0.7);">Pelanggan</span>
                <span style="font-size:13px;font-weight:700;color:#fff;">{{ $pesanan->pengguna->name ?? 'Pelanggan' }}</span>
            </div>
            <div class="info-row">
                <span style="font-size:13px;color:rgba(255,255,255,0.7);">Jenis Sampah</span>
                <span style="font-size:13px;font-weight:700;color:#fff;">
                    @foreach($pesanan->detailPesanan as $detail)
                        {{ $detail->kategoriSampah->nama ?? '-' }}@if(!$loop->last), @endif
                    @endforeach
                </span>
            </div>
            <div class="info-row">
                <span style="font-size:13px;color:rgba(255,255,255,0.7);">Total Berat</span>
                <span style="font-size:13px;font-weight:700;color:#fff;">{{ number_format($pesanan->total_berat ?? 0, 1) }} Kg</span>
            </div>

            <div class="info-row">
                <span style="font-size:13px;color:rgba(255,255,255,0.7);">Order ID</span>
                <span style="font-size:13px;font-weight:700;color:#fff;">{{ $pesanan->nomor_pesanan }}</span>
            </div>
        </div>

        <!-- ── Buttons ── -->
        <div style="width:100%;z-index:1;" class="slide-up" style="animation-delay:1.25s;">
            <a href="{{ route('juru-angkut.index') }}" class="btn-dashboard slide-up" style="animation-delay:1.2s;">
                <svg width="18" height="18" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Kembali ke Dashboard
            </a>
            <a href="{{ route('juru-angkut.riwayat') }}" class="btn-riwayat slide-up" style="animation-delay:1.35s;">
                <svg width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M9 14h6m-6 4h3" />
                </svg>
                Lihat Riwayat
            </a>
        </div>

    </div>

</body>

</html>

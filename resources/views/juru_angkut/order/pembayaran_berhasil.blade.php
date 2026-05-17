<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pembayaran Berhasil</title>
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
            padding: 18px 20px 22px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            flex-shrink: 0;
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

        .info-row {
            padding: 14px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .info-row:last-child {
            border-bottom: none;
        }
    </style>
</head>

<body>
    <div class="phone-wrapper">

        <!-- HEADER -->
        <div class="page-header">
            <div style="display:flex;align-items:center;gap:14px;">
                <a href="#"
                    style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 style="font-size:18px;font-weight:800;color:#fff;">Pembayaran</h1>
            </div>
            <p style="font-size:12px;color:rgba(255,255,255,0.75);font-weight:500;padding-left:50px;margin-top:2px;">
                Order #{{ $pesanan->nomor_pesanan }}</p>
        </div>

        <!-- SCROLL AREA -->
        <div class="scroll-area">
            <div style="padding:20px 16px 28px;">

                <!-- Success title -->
                <div style="text-align:center;margin-bottom:24px;">
                    <div
                        style="width:64px;height:64px;background:#dcfce7;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                        <svg width="32" height="32" fill="none" stroke="#16a34a" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p style="font-size:20px;font-weight:800;color:#111827;margin-bottom:6px;">Pembayaran Berhasil!</p>
                    <p style="font-size:13px;color:#6b7280;line-height:1.6;">Pembayaran dari pelanggan
                        telah<br />diterima</p>
                </div>

                <!-- Detail card -->
                <div
                    style="background:#fff;border-radius:20px;padding:20px;box-shadow:0 2px 16px rgba(0,0,0,0.07);margin-bottom:16px;">

                    <!-- Pelanggan -->
                    <div class="info-row">
                        <p style="font-size:11px;color:#9ca3af;font-weight:500;margin-bottom:4px;">Pelanggan</p>
                        <p style="font-size:15px;font-weight:700;color:#111827;">{{ $pesanan->pengguna->name ?? 'Pelanggan' }}</p>
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="info-row">
                        <p style="font-size:11px;color:#9ca3af;font-weight:500;margin-bottom:8px;">Metode Pembayaran</p>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div
                                style="width:38px;height:38px;background:#f0fdf4;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <svg width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            </div>
                            <p style="font-size:15px;font-weight:700;color:#111827;">Saldo</p>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="info-row">
                        <p style="font-size:11px;color:#9ca3af;font-weight:500;margin-bottom:8px;">Status Pembayaran</p>
                        <div style="display:flex;align-items:center;gap:7px;">
                            <div style="width:8px;height:8px;background:#22c55e;border-radius:50%;flex-shrink:0;"></div>
                            <p style="font-size:14px;font-weight:700;color:#16a34a;">Sudah Dibayar</p>
                        </div>
                    </div>
                </div>

                <!-- Total pendapatan card -->
                <div
                    style="background:#f0fdf4;border:1.5px solid #86efac;border-radius:18px;padding:18px 20px;margin-bottom:28px;">
                    <p style="font-size:11.5px;color:#6b7280;font-weight:500;margin-bottom:6px;">Total Pendapatan</p>
                    <p style="font-size:26px;font-weight:800;color:#16a34a;">Rp {{ number_format($pesanan->total_pendapatan ?? 0, 0, ',', '.') }}</p>
                </div>

                <!-- Button -->
                <button onclick="window.location.href='{{ route('juru-angkut.order.selesai', $pesanan->id) }}'"
                    style="width:100%;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;font-size:15px;font-weight:700;padding:17px;border-radius:16px;border:none;cursor:pointer;transition:opacity 0.2s,transform 0.15s;"
                    onmousedown="this.style.transform='scale(0.98)'" onmouseup="this.style.transform='scale(1)'">
                    Lanjutkan
                </button>

            </div>
        </div>

    </div>
</body>

</html>
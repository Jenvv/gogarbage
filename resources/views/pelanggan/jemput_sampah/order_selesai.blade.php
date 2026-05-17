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
            padding-bottom: 80px;
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

        /* Success icon pulse ring */
        .success-ring {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            border: 3px solid #22c55e;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            margin-bottom: 24px;
            animation: popIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        .success-ring::before {
            content: '';
            position: absolute;
            inset: -8px;
            border-radius: 50%;
            border: 2px solid rgba(34, 197, 94, 0.2);
            animation: pulseRing 2s ease-out infinite;
        }

        @keyframes pulseRing {
            0% { transform: scale(1); opacity: 0.6; }
            100% { transform: scale(1.18); opacity: 0; }
        }

        @keyframes popIn {
            from { transform: scale(0.6); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        /* Checkmark draw */
        .check-svg {
            animation: fadeCheck 0.4s ease 0.3s both;
        }

        @keyframes fadeCheck {
            from { opacity: 0; transform: scale(0.5); }
            to { opacity: 1; transform: scale(1); }
        }

        /* Content fade up */
        .content-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            padding: 80px 20px 40px;
            animation: fadeUp 0.5s ease 0.15s both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>
    <div class="phone-wrapper">
        <div class="scroll-area">
            <div class="content-wrap">

                <!-- Success Icon -->
                <div class="success-ring">
                    <div class="check-svg">
                        <svg width="42" height="42" fill="none" stroke="#22c55e" stroke-width="3"
                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>

                <h1 style="font-size:22px;font-weight:800;color:#111827;text-align:center;margin-bottom:8px;">Pembayaran Selesai!</h1>
                <p style="font-size:13px;color:#6b7280;text-align:center;line-height:1.6;margin-bottom:24px;">
                    Pesanan telah selesai dan pendapatan<br/>telah masuk ke saldo Anda
                </p>

                <!-- Detail card -->
                <div style="width:100%;background:#fff;border-radius:20px;padding:20px;box-shadow:0 2px 16px rgba(0,0,0,0.07);margin-bottom:16px;">

                    <!-- No. Order -->
                    <div class="info-row">
                        <p style="font-size:11px;color:#9ca3af;font-weight:500;margin-bottom:4px;">No. Order#</p>
                        <p style="font-size:14px;font-weight:700;color:#111827;">{{ $pesanan->nomor_pesanan }}</p>
                    </div>

                    <!-- Juru Angkut -->
                    <div class="info-row">
                        <p style="font-size:11px;color:#9ca3af;font-weight:500;margin-bottom:4px;">Juru Angkut</p>
                        <p style="font-size:14px;font-weight:700;color:#111827;">{{ $pesanan->jasaAngkut->name ?? 'Juru Angkut' }}</p>
                    </div>

                    <!-- Tanggal Pesan -->
                    <div class="info-row">
                        <p style="font-size:11px;color:#9ca3af;font-weight:500;margin-bottom:4px;">Tanggal Pesan</p>
                        <p style="font-size:14px;font-weight:700;color:#111827;">{{ $pesanan->created_at ? $pesanan->created_at->format('d M Y, H:i') : '-' }}</p>
                    </div>

                    <!-- Metode & Status -->
                    <div class="info-row" style="display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <p style="font-size:11px;color:#9ca3af;font-weight:500;margin-bottom:6px;">Metode Pembayaran</p>
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div style="width:32px;height:32px;background:#f0fdf4;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                    <svg width="16" height="16" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                </div>
                                <p style="font-size:14px;font-weight:700;color:#111827;">Saldo</p>
                            </div>
                        </div>
                        <div style="text-align:right;">
                            <p style="font-size:11px;color:#9ca3af;font-weight:500;margin-bottom:6px;">Status Pembayaran</p>
                            <div style="display:flex;align-items:center;gap:6px;justify-content:flex-end;">
                                <div style="width:8px;height:8px;background:#22c55e;border-radius:50%;"></div>
                                <p style="font-size:13px;font-weight:700;color:#16a34a;">Sudah Dibayar</p>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Sampah -->
                    <div class="info-row" style="border-bottom:none; padding-bottom:0;">
                        <p style="font-size:11px;color:#9ca3af;font-weight:500;margin-bottom:10px;">Sampah Dipesan</p>
                        @if($pesanan->detailPesanan && $pesanan->detailPesanan->count() > 0)
                            <div style="display:flex; flex-direction:column; gap:8px;">
                            @foreach($pesanan->detailPesanan as $detail)
                                <div style="display:flex; justify-content:space-between; align-items:center; background:#f9fafb; padding:10px 12px; border-radius:12px; border: 1px solid #f3f4f6;">
                                    <div style="display:flex; align-items:center; gap:10px;">
                                        <div style="width:32px; height:32px; background:#e5e7eb; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                                            <svg width="16" height="16" fill="none" stroke="#6b7280" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p style="font-size:13px; font-weight:700; color:#111827;">{{ $detail->kategoriSampah->nama ?? 'Sampah' }}</p>
                                            <p style="font-size:11px; color:#6b7280;">Rp {{ number_format($detail->harga_per_kg ?? 0, 0, ',', '.') }} / kg</p>
                                        </div>
                                    </div>
                                    <p style="font-size:13px; font-weight:700; color:#16a34a;">{{ $detail->berat ?? 0 }} kg</p>
                                </div>
                            @endforeach
                            </div>
                        @else
                            <p style="font-size:13px; color:#6b7280; font-style:italic;">Belum ada detail sampah.</p>
                        @endif
                    </div>
                </div>

                <!-- Total pendapatan card -->
                <div style="width:100%;background:#f0fdf4;border:1.5px solid #86efac;border-radius:18px;padding:16px 20px;margin-bottom:24px;display:flex;justify-content:space-between;align-items:center;">
                    <p style="font-size:12px;color:#16a34a;font-weight:600;">Total Pendapatan</p>
                    <p style="font-size:20px;font-weight:800;color:#16a34a;">Rp {{ number_format($pesanan->total_pendapatan ?? 0, 0, ',', '.') }}</p>
                </div>

                <!-- Button -->
                <button onclick="window.location.href='{{ route('pelanggan.index') }}'"
                    style="width:100%;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;font-size:15px;font-weight:700;padding:16px;border-radius:16px;border:none;cursor:pointer;transition:opacity 0.2s,transform 0.15s;"
                    onmousedown="this.style.transform='scale(0.98)'" onmouseup="this.style.transform='scale(1)'">
                    Kembali ke Beranda
                </button>

            </div>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="refresh" content="5;url={{ route('pelanggan.tracking-pesanan', $pesanan->id) }}">
    <title>Go Garbage – Pesanan Berhasil</title>
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
            overflow: hidden;
            background: #f2f3f7;
            position: relative;
            box-shadow: 0 0 48px rgba(0, 0, 0, 0.18);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
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

        /* Success icon pulse ring */
        .success-ring {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 3px solid #22c55e;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            margin-bottom: 28px;
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
            0% {
                transform: scale(1);
                opacity: 0.6;
            }

            100% {
                transform: scale(1.18);
                opacity: 0;
            }
        }

        @keyframes popIn {
            from {
                transform: scale(0.6);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Checkmark draw */
        .check-svg {
            animation: fadeCheck 0.4s ease 0.3s both;
        }

        @keyframes fadeCheck {
            from {
                opacity: 0;
                transform: scale(0.5);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Content fade up */
        .content-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            animation: fadeUp 0.5s ease 0.15s both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Order info card */
        .order-card {
            width: 100%;
            background: #fff;
            border: 1.5px solid #e5e7eb;
            border-radius: 18px;
            padding: 18px 20px;
            margin: 24px 0 0;
        }

        .order-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .order-row+.order-row {
            margin-top: 12px;
        }

        .order-label {
            font-size: 13px;
            color: #6b7280;
            font-weight: 500;
            width: 90px;
            flex-shrink: 0;
        }

        /* Status badge */
        .badge-yellow {
            background: #fef9c3;
            color: #a16207;
            font-size: 12px;
            font-weight: 700;
            padding: 5px 14px;
            border-radius: 99px;
        }

        /* Teks Countdown */
        .countdown-text {
            margin-top: 32px;
            font-size: 12px;
            color: #9ca3af;
            text-align: center;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div class="phone-wrapper">

        <div class="content-wrap">

            <!-- Success Icon -->
            <div class="success-ring">
                <div class="check-svg">
                    <svg width="46" height="46" fill="none" stroke="#22c55e" stroke-width="3"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>

            <!-- Title & Desc -->
            <h1 style="font-size:22px;font-weight:800;color:#111827;text-align:center;margin-bottom:12px;">Pesanan
                Berhasil!</h1>
            <p style="font-size:13px;color:#6b7280;text-align:center;line-height:1.75;font-weight:400;">
                Pesanan Anda telah berhasil<br />diproses.<br />
                Juru angkut sedang menuju lokasi<br />Anda.
            </p>

            <!-- Order Info Card -->
            <div class="order-card">
                <div class="order-row">
                    <span class="order-label">No. Pesanan</span>
                    <span style="font-size:13px;font-weight:800;color:#111827;">#{{ $pesanan->nomor_pesanan }}</span>
                </div>
                <div class="order-row">
                    <span class="order-label">Status</span>
                    <span class="badge-yellow">Menunggu Juru Angkut</span>
                </div>
            </div>

            <!-- Teks Notifikasi Redirect -->
            <div class="countdown-text">
                Kamu akan dialihkan dalam <span id="timer"
                    style="color:#111827; font-weight:700;">5</span> detik...
            </div>

        </div>

    </div>

    <!-- Script Hitung Mundur -->
    <script>
        let timeLeft = 5;
        const timerElement = document.getElementById('timer');

        const countdown = setInterval(function() {
            timeLeft--;
            if (timeLeft > 0) {
                timerElement.innerText = timeLeft;
            } else {
                clearInterval(countdown);
            }
        }, 1000); // Eksekusi setiap 1 detik (1000ms)
    </script>
</body>

</html>

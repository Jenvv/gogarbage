<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Go Garbage – Masuk</title>
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
            min-height: 100vh;
            background: #f2f3f7;
            position: relative;
            box-shadow: 0 0 48px rgba(0, 0, 0, 0.18);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 24px 40px;
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

        .input-field {
            width: 100%;
            background: #fff;
            border: 1.5px solid #e5e7eb;
            border-radius: 14px;
            padding: 14px 16px 14px 50px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            color: #111827;
            outline: none;
            transition: border-color 0.2s;
        }

        .input-field::placeholder {
            color: #9ca3af;
            font-weight: 400;
        }

        .input-field:focus {
            border-color: #22c55e;
        }

        .input-wrap {
            position: relative;
            width: 100%;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        .btn-primary {
            width: 100%;
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            border: none;
            border-radius: 16px;
            padding: 17px;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s;
        }

        .btn-primary:active {
            transform: scale(0.98);
            opacity: 0.9;
        }

        .btn-outline {
            width: 100%;
            background: #fff;
            color: #16a34a;
            font-size: 15px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            border: 2px solid #22c55e;
            border-radius: 16px;
            padding: 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: background 0.2s, transform 0.15s;
        }

        .btn-outline:active {
            transform: scale(0.98);
            background: #f0fdf4;
        }
    </style>
</head>

<body>
    <div class="phone-wrapper">

        <!-- Logo -->
        <div style="display:flex;flex-direction:column;align-items:center;margin-bottom:28px;">
            <!-- Logo circle -->
            <div
                style="width:90px;height:90px;background:linear-gradient(135deg,#2ecc71 0%,#16a34a 100%);border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:16px;box-shadow:0 8px 24px rgba(34,197,94,0.28);">
                <!-- Leaf icon -->
                <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M22 8C22 8 10 14 10 26C10 32.627 15.373 38 22 38C28.627 38 34 32.627 34 26C34 14 22 8 22 8Z"
                        fill="rgba(255,255,255,0.25)" />
                    <path
                        d="M22 8C22 8 10 14 10 26C10 32.627 15.373 38 22 38C28.627 38 34 32.627 34 26C34 14 22 8 22 8Z"
                        stroke="white" stroke-width="2" stroke-linejoin="round" />
                    <path d="M22 38V22" stroke="white" stroke-width="2" stroke-linecap="round" />
                    <path d="M22 28C22 28 27 23 32 22" stroke="white" stroke-width="2" stroke-linecap="round" />
                    <path d="M22 24C22 24 17 20 12 20" stroke="white" stroke-width="2" stroke-linecap="round" />
                </svg>
            </div>
            <p style="font-size:22px;font-weight:800;color:#16a34a;letter-spacing:0.01em;">Go Garbage</p>
            <p style="font-size:13px;color:#6b7280;font-weight:400;margin-top:2px;">Solusi Sampah Pintar</p>
        </div>

        <!-- Card -->
        <div
            style="width:100%;background:#fff;border-radius:24px;padding:28px 24px 28px;box-shadow:0 2px 24px rgba(0,0,0,0.08);">

            <h2 style="font-size:20px;font-weight:800;color:#111827;margin-bottom:22px;">Masuk Go Garbage</h2>

            <!-- Nomor HP -->
            <div style="margin-bottom:16px;">
                <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:8px;">Nomor
                    HP</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <svg width="18" height="18" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </span>
                    <input type="tel" class="input-field" placeholder="08xxxxxxxxxx" />
                </div>
            </div>

            <!-- Password -->
            <div style="margin-bottom:10px;">
                <label
                    style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:8px;">Password</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <svg width="18" height="18" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </span>
                    <input type="password" class="input-field" placeholder="••••••••" />
                </div>
            </div>

            <!-- Lupa Password -->
            <div style="text-align:right;margin-bottom:24px;">
                <a href="#" style="font-size:13px;font-weight:600;color:#22c55e;text-decoration:none;">Lupa
                    Password?</a>
            </div>

            <!-- Masuk sebagai Pengguna -->
            <button class="btn-primary" style="margin-bottom:14px;">Masuk sebagai Pengguna</button>

            <!-- Masuk sebagai Juru Angkut -->
            <button class="btn-outline">
                <svg width="20" height="20" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
                Masuk sebagai Juru Angkut
            </button>

        </div>

        <!-- Daftar -->
        <p style="font-size:13px;color:#6b7280;margin-top:24px;text-align:center;">
            Belum punya akun? <a href="#" style="font-weight:700;color:#22c55e;text-decoration:none;">Daftar</a>
        </p>

    </div>
</body>

</html>
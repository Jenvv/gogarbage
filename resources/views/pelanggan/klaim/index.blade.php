<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Go Garbage – Poin & Reward</title>
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

        /* Header */
        .header-green {
            background: linear-gradient(150deg, #2ecc71 0%, #1aab57 55%, #168a45 100%);
            padding: 22px 20px 68px;
        }

        /* Poin balance card */
        .poin-card {
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            padding: 20px 20px 18px;
            margin-top: 16px;
        }

        /* Floating info card */
        .info-card {
            background: #fff;
            border-radius: 20px;
            margin: -44px 16px 0;
            padding: 18px 20px;
            box-shadow: 0 6px 28px rgba(0, 0, 0, 0.09);
            position: relative;
            z-index: 10;
        }

        /* Reward grid card */
        .reward-card {
            background: #fff;
            border-radius: 16px;
            padding: 16px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .reward-icon-wrap {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .tukar-btn {
            width: 100%;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            border: none;
            border-radius: 10px;
            padding: 11px;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s;
            margin-top: 4px;
        }

        .tukar-btn:active {
            transform: scale(0.97);
        }

        /* Riwayat item */
        .riwayat-card {
            background: #fff;
            border-radius: 14px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 10px;
        }

        /* Bottom nav */
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

        /* ── MODAL ── */
        #confirmModal {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.48);
            z-index: 300;
            display: flex;
            align-items: flex-end;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s;
        }

        #confirmModal.active {
            opacity: 1;
            pointer-events: all;
        }

        .modal-sheet {
            width: 100%;
            background: #fff;
            border-radius: 28px 28px 0 0;
            padding: 0 22px 36px;
            transform: translateY(100%);
            transition: transform 0.32s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #confirmModal.active .modal-sheet {
            transform: translateY(0);
        }

        .modal-confirm-btn {
            width: 100%;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            border: none;
            border-radius: 16px;
            padding: 17px;
            cursor: pointer;
            margin-top: 14px;
            transition: opacity 0.2s, transform 0.15s;
        }

        .modal-confirm-btn:active {
            transform: scale(0.98);
        }

        .modal-cancel-btn {
            width: 100%;
            background: #f3f4f6;
            color: #6b7280;
            font-size: 14px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            border: none;
            border-radius: 16px;
            padding: 15px;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.18s;
        }

        .modal-cancel-btn:hover {
            background: #e5e7eb;
        }

        /* Success state */
        #successState {
            display: none;
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

        .pop-in {
            animation: popIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }
    </style>
</head>

<body>
    <div class="phone-wrapper">

        <!-- SCROLL AREA -->
        <div class="scroll-area">
            <div style="padding-bottom: 32px;">

                <!-- HEADER -->
                <div class="header-green">
                    <div style="display:flex;align-items:center;gap:14px;margin-bottom:4px;">
                        <a href="#"
                            style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                            <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <h1 style="font-size:20px;font-weight:800;color:#fff;">Poin & Reward</h1>
                    </div>

                    <!-- Poin card -->
                    <div class="poin-card">
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;">
                            <svg width="18" height="18" fill="none" stroke="rgba(255,255,255,0.9)"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                            <span style="font-size:13px;color:rgba(255,255,255,0.88);font-weight:600;">Total Poin
                                Anda</span>
                        </div>
                        <p style="font-size:40px;font-weight:800;color:#fff;line-height:1.1;margin-bottom:8px;">2.500
                        </p>
                        <p style="font-size:12.5px;color:rgba(255,255,255,0.8);line-height:1.5;">Kumpulkan lebih banyak
                            poin untuk<br />hadiah menarik!</p>
                    </div>
                </div>

                <!-- CARA MENDAPATKAN POIN -->
                <div class="info-card">
                    <p style="font-size:14px;font-weight:800;color:#111827;margin-bottom:10px;">Cara Mendapatkan Poin:
                    </p>
                    <div style="display:flex;flex-direction:column;gap:7px;">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:6px;height:6px;border-radius:50%;background:#22c55e;flex-shrink:0;"></div>
                            <p style="font-size:13px;color:#374151;">Jemput Sampah: <strong>+50 poin</strong></p>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:6px;height:6px;border-radius:50%;background:#22c55e;flex-shrink:0;"></div>
                            <p style="font-size:13px;color:#374151;">Jual Sampah: <strong>+100 poin</strong> per
                                transaksi</p>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:6px;height:6px;border-radius:50%;background:#22c55e;flex-shrink:0;"></div>
                            <p style="font-size:13px;color:#374151;">Langganan Bulanan: <strong>+100 poin</strong> bonus
                            </p>
                        </div>
                    </div>
                </div>

                <!-- TUKAR POIN -->
                <div style="margin: 20px 16px 0;">
                    <p style="font-size:16px;font-weight:800;color:#111827;margin-bottom:14px;">Tukar Poin</p>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">

                        <!-- Pulsa 10k -->
                        <div class="reward-card">
                            <div class="reward-icon-wrap" style="background:#e0f2fe;">
                                <svg width="24" height="24" fill="none" stroke="#0284c7" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <p style="font-size:13px;font-weight:700;color:#111827;">Pulsa Rp 10.000</p>
                            <div style="display:flex;align-items:center;gap:5px;">
                                <svg width="13" height="13" fill="none" stroke="#22c55e" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                                <span style="font-size:13px;font-weight:700;color:#16a34a;">500</span>
                            </div>
                            <button class="tukar-btn" onclick="openModal('Pulsa Rp 10.000','500','📱')">Tukar</button>
                        </div>

                        <!-- Pulsa 25k -->
                        <div class="reward-card">
                            <div class="reward-icon-wrap" style="background:#dbeafe;">
                                <svg width="24" height="24" fill="none" stroke="#3b82f6" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <p style="font-size:13px;font-weight:700;color:#111827;">Pulsa Rp 25.000</p>
                            <div style="display:flex;align-items:center;gap:5px;">
                                <svg width="13" height="13" fill="none" stroke="#22c55e" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                                <span style="font-size:13px;font-weight:700;color:#16a34a;">1200</span>
                            </div>
                            <button class="tukar-btn" onclick="openModal('Pulsa Rp 25.000','1200','📱')">Tukar</button>
                        </div>

                        <!-- Diskon 50% -->
                        <div class="reward-card">
                            <div class="reward-icon-wrap" style="background:#f5f3ff;">
                                <svg width="24" height="24" fill="none" stroke="#7c3aed" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                            <p style="font-size:13px;font-weight:700;color:#111827;">Diskon 50%<br />Jemput...</p>
                            <div style="display:flex;align-items:center;gap:5px;">
                                <svg width="13" height="13" fill="none" stroke="#22c55e" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                                <span style="font-size:13px;font-weight:700;color:#16a34a;">800</span>
                            </div>
                            <button class="tukar-btn"
                                onclick="openModal('Diskon 50% Jemput Sampah','800','🏷️')">Tukar</button>
                        </div>

                        <!-- Saldo 20k -->
                        <div class="reward-card">
                            <div class="reward-icon-wrap" style="background:#dcfce7;">
                                <svg width="24" height="24" fill="none" stroke="#16a34a" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            </div>
                            <p style="font-size:13px;font-weight:700;color:#111827;">Saldo Rp 20.000</p>
                            <div style="display:flex;align-items:center;gap:5px;">
                                <svg width="13" height="13" fill="none" stroke="#22c55e" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                                <span style="font-size:13px;font-weight:700;color:#16a34a;">1000</span>
                            </div>
                            <button class="tukar-btn"
                                onclick="openModal('Saldo Rp 20.000','1000','💳')">Tukar</button>
                        </div>

                        <!-- Saldo 50k -->
                        <div class="reward-card">
                            <div class="reward-icon-wrap" style="background:#dcfce7;">
                                <svg width="24" height="24" fill="none" stroke="#16a34a" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            </div>
                            <p style="font-size:13px;font-weight:700;color:#111827;">Saldo Rp 50.000</p>
                            <div style="display:flex;align-items:center;gap:5px;">
                                <svg width="13" height="13" fill="none" stroke="#22c55e" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                                <span style="font-size:13px;font-weight:700;color:#16a34a;">2500</span>
                            </div>
                            <button class="tukar-btn"
                                onclick="openModal('Saldo Rp 50.000','2500','💳')">Tukar</button>
                        </div>

                        <!-- Bonus Poin -->
                        <div class="reward-card">
                            <div class="reward-icon-wrap" style="background:#fef9c3;">
                                <svg width="24" height="24" fill="none" stroke="#ca8a04" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            </div>
                            <p style="font-size:13px;font-weight:700;color:#111827;">Bonus Poin 500</p>
                            <div style="display:flex;align-items:center;gap:5px;">
                                <svg width="13" height="13" fill="none" stroke="#22c55e" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                                <span style="font-size:13px;font-weight:700;color:#16a34a;">2000</span>
                            </div>
                            <button class="tukar-btn" onclick="openModal('Bonus Poin 500','2000','🎁')">Tukar</button>
                        </div>

                    </div>
                </div>

                <!-- RIWAYAT PENUKARAN -->
                <div style="margin: 24px 16px 0;">
                    <p style="font-size:16px;font-weight:800;color:#111827;margin-bottom:14px;">Riwayat Penukaran</p>

                    <div class="riwayat-card">
                        <div>
                            <p style="font-size:13px;font-weight:700;color:#111827;">Pulsa Rp 10.000</p>
                            <p style="font-size:11.5px;color:#9ca3af;margin-top:3px;">10 April 2026</p>
                        </div>
                        <span style="font-size:13px;font-weight:800;color:#ef4444;">-500 poin</span>
                    </div>

                    <div class="riwayat-card">
                        <div>
                            <p style="font-size:13px;font-weight:700;color:#111827;">Diskon 20%</p>
                            <p style="font-size:11.5px;color:#9ca3af;margin-top:3px;">5 April 2026</p>
                        </div>
                        <span style="font-size:13px;font-weight:800;color:#ef4444;">-300 poin</span>
                    </div>

                </div>

            </div>
        </div><!-- end scroll-area -->

        <!-- BOTTOM NAV -->
        @include('pelanggan.partials.navigation')

        <!-- ── CONFIRM MODAL ── -->
        <div id="confirmModal" onclick="handleOverlayClick(event)">
            <div class="modal-sheet">
                <!-- Handle -->
                <div style="display:flex;justify-content:center;padding:14px 0 10px;">
                    <div style="width:40px;height:4px;background:#e5e7eb;border-radius:4px;"></div>
                </div>

                <!-- CONFIRM STATE -->
                <div id="confirmState">
                    <!-- Icon -->
                    <div style="text-align:center;margin-bottom:18px;">
                        <div
                            style="width:68px;height:68px;background:#f0fdf4;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                            <span id="modalEmoji" style="font-size:30px;">📱</span>
                        </div>
                        <h2 style="font-size:18px;font-weight:800;color:#111827;" id="modalTitle">Tukar Poin</h2>
                        <p style="font-size:13px;color:#6b7280;margin-top:6px;">Konfirmasi penukaran reward ini?</p>
                    </div>

                    <!-- Detail box -->
                    <div style="background:#f9fafb;border-radius:16px;padding:16px 18px;margin-bottom:6px;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                            <span style="font-size:13px;color:#6b7280;font-weight:500;">Reward</span>
                            <span style="font-size:13px;font-weight:700;color:#111827;" id="modalReward">—</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                            <span style="font-size:13px;color:#6b7280;font-weight:500;">Poin digunakan</span>
                            <div style="display:flex;align-items:center;gap:5px;">
                                <svg width="13" height="13" fill="none" stroke="#ef4444" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                                <span style="font-size:13px;font-weight:800;color:#ef4444;" id="modalPoin">—</span>
                            </div>
                        </div>
                        <div
                            style="border-top:1px solid #e5e7eb;padding-top:10px;display:flex;justify-content:space-between;align-items:center;">
                            <span style="font-size:13px;color:#6b7280;font-weight:500;">Sisa poin</span>
                            <div style="display:flex;align-items:center;gap:5px;">
                                <svg width="13" height="13" fill="none" stroke="#22c55e" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                                <span style="font-size:13px;font-weight:800;color:#16a34a;" id="modalSisa">—</span>
                            </div>
                        </div>
                    </div>

                    <button class="modal-confirm-btn" onclick="confirmTukar()">Ya, Tukar Sekarang</button>
                    <button class="modal-cancel-btn" onclick="closeModal()">Batal</button>
                </div>

                <!-- SUCCESS STATE -->
                <div id="successState" style="text-align:center;padding:10px 0 8px;">
                    <div class="pop-in"
                        style="width:76px;height:76px;background:#dcfce7;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                        <svg width="36" height="36" fill="none" stroke="#16a34a" stroke-width="3"
                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h2 style="font-size:20px;font-weight:800;color:#111827;margin-bottom:8px;">Penukaran Berhasil!
                    </h2>
                    <p style="font-size:13px;color:#6b7280;line-height:1.6;" id="successDesc">Reward kamu sedang
                        diproses.</p>
                    <button class="modal-confirm-btn" onclick="closeModal()" style="margin-top:20px;">Tutup</button>
                </div>

            </div>
        </div>

    </div>

    <script>
        let currentPoin = 2500;

        function openModal(name, poin, emoji) {
            const sisa = currentPoin - parseInt(poin);
            document.getElementById('modalEmoji').textContent = emoji;
            document.getElementById('modalTitle').textContent = name;
            document.getElementById('modalReward').textContent = name;
            document.getElementById('modalPoin').textContent = poin + ' poin';
            document.getElementById('modalSisa').textContent = (sisa >= 0 ? sisa : 0) + ' poin';

            document.getElementById('confirmState').style.display = 'block';
            document.getElementById('successState').style.display = 'none';

            const modal = document.getElementById('confirmModal');
            modal.style.opacity = '1';
            modal.style.pointerEvents = 'all';
            modal.querySelector('.modal-sheet').style.transform = 'translateY(0)';

            // store for confirm
            modal.dataset.poin = poin;
            modal.dataset.name = name;
            modal.dataset.emoji = emoji;
        }

        function closeModal() {
            const modal = document.getElementById('confirmModal');
            modal.querySelector('.modal-sheet').style.transform = 'translateY(100%)';
            setTimeout(() => {
                modal.style.opacity = '0';
                modal.style.pointerEvents = 'none';
            }, 300);
        }

        function confirmTukar() {
            const modal = document.getElementById('confirmModal');
            const poin = parseInt(modal.dataset.poin);
            const name = modal.dataset.name;

            currentPoin = Math.max(0, currentPoin - poin);

            document.getElementById('confirmState').style.display = 'none';
            document.getElementById('successState').style.display = 'block';
            document.getElementById('successDesc').textContent =
                name + ' berhasil ditukarkan!\nSisa poin kamu: ' + currentPoin + ' poin';
        }

        function handleOverlayClick(e) {
            if (e.target === document.getElementById('confirmModal')) closeModal();
        }
    </script>
</body>

</html>

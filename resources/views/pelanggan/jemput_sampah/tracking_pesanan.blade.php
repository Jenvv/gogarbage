<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tracking Pesanan</title>
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
            padding: 18px 20px 22px;
            display: flex;
            align-items: center;
            gap: 14px;
            flex-shrink: 0;
        }

        /* Map section */
        .map-section {
            background: linear-gradient(160deg, #d4f5e2 0%, #b6edcc 60%, #9de6bb 100%);
            height: 200px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        /* Canvas map placeholder */
        #mapCanvas {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0.35;
        }

        .map-pin {
            position: absolute;
            display: flex;
            flex-direction: column;
            align-items: center;
            z-index: 10;
        }

        .map-pin-icon {
            width: 56px;
            height: 56px;
            background: #16a34a;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(22, 163, 74, 0.45);
            animation: pinBounce 2s ease-in-out infinite;
        }

        @keyframes pinBounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-6px);
            }
        }

        .map-driver-dot {
            position: absolute;
            top: 38px;
            right: 70px;
            width: 44px;
            height: 44px;
            background: #16a34a;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 3px 12px rgba(22, 163, 74, 0.4);
            border: 3px solid #fff;
            z-index: 10;
        }

        .map-pin-label {
            margin-top: 8px;
            font-size: 12px;
            font-weight: 600;
            color: #166534;
            background: rgba(255, 255, 255, 0.85);
            padding: 3px 10px;
            border-radius: 20px;
        }

        /* Driver card */
        .driver-card {
            background: #fff;
            border-radius: 20px;
            padding: 14px 16px;
            margin: 14px 16px 0;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.07);
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .driver-avatar {
            width: 46px;
            height: 46px;
            background: #16a34a;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .call-btn {
            width: 44px;
            height: 44px;
            background: #3b82f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(59, 130, 246, 0.35);
            transition: transform 0.15s, opacity 0.15s;
        }

        .call-btn:active {
            transform: scale(0.93);
            opacity: 0.85;
        }

        /* Status card */
        .status-card {
            background: #fff;
            border-radius: 20px;
            padding: 18px 18px 20px;
            margin: 14px 16px 0;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.07);
        }

        /* Timeline */
        .timeline-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            position: relative;
        }

        .timeline-dot {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            z-index: 2;
        }

        .timeline-dot.done {
            background: #16a34a;
        }

        .timeline-dot.pending {
            background: #d1d5db;
        }

        .timeline-dot.active-menunggu {
            background: #f59e0b;
            box-shadow: 0 0 0 5px rgba(245, 158, 11, 0.15);
            animation: pulse-menunggu 2s ease-in-out infinite;
        }

        @keyframes pulse-menunggu {

            0%,
            100% {
                box-shadow: 0 0 0 5px rgba(245, 158, 11, 0.15);
            }

            50% {
                box-shadow: 0 0 0 10px rgba(245, 158, 11, 0.08);
            }
        }

        .timeline-dot.active-menuju {
            background: #3b82f6;
            box-shadow: 0 0 0 5px rgba(59, 130, 246, 0.15);
            animation: pulse-menuju 2s ease-in-out infinite;
        }

        @keyframes pulse-menuju {

            0%,
            100% {
                box-shadow: 0 0 0 5px rgba(59, 130, 246, 0.15);
            }

            50% {
                box-shadow: 0 0 0 10px rgba(59, 130, 246, 0.08);
            }
        }

        .timeline-dot.active-mengambil {
            background: #8b5cf6;
            box-shadow: 0 0 0 5px rgba(139, 92, 246, 0.15);
            animation: pulse-mengambil 2s ease-in-out infinite;
        }

        @keyframes pulse-mengambil {

            0%,
            100% {
                box-shadow: 0 0 0 5px rgba(139, 92, 246, 0.15);
            }

            50% {
                box-shadow: 0 0 0 10px rgba(139, 92, 246, 0.08);
            }
        }

        .timeline-dot.active-selesai {
            background: #16a34a;
            box-shadow: 0 0 0 5px rgba(22, 163, 74, 0.15);
            animation: pulse-selesai 2s ease-in-out infinite;
        }

        @keyframes pulse-selesai {

            0%,
            100% {
                box-shadow: 0 0 0 5px rgba(22, 163, 74, 0.15);
            }

            50% {
                box-shadow: 0 0 0 10px rgba(22, 163, 74, 0.08);
            }
        }

        .timeline-line {

            position: absolute;
            left: 16px;
            top: 34px;
            width: 2px;
            height: 62px;
            z-index: 1;
        }

        .timeline-line.done {
            background: #16a34a;
        }

        .timeline-line.pending {
            background: #e5e7eb;
        }

        .timeline-content {
            padding-top: 5px;
            padding-bottom: 32px;
        }

        /* Scroll */
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

        /* Buttons */
        .btn-update {
            width: 100%;
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            border: none;
            border-radius: 16px;
            padding: 16px;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s;
        }

        .btn-update:active {
            transform: scale(0.98);
            opacity: 0.9;
        }

        .btn-home {
            width: 100%;
            background: #fff;
            color: #16a34a;
            font-size: 14px;
            font-weight: 700;
            border: 2px solid #16a34a;
            border-radius: 16px;
            padding: 15px;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s;
            margin-top: 10px;
        }

        .btn-home:active {
            transform: scale(0.98);
            background: #f0fdf4;
        }

        /* Nav */
        .nav-bottom {
            height: 64px;
            background: #fff;
            border-top: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-around;
            
            position: absolute;
            bottom: 0;
            width: 100%;
            z-index: 50;
        }

        .nav-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            padding-top: 4px;
            cursor: pointer;
        }

        @keyframes fadeSlide {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeSlide 0.3s ease forwards;
        }

        /* Status pulse for "Sedang berlangsung" */
        .status-live {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .live-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #16a34a;
            animation: livePulse 1.4s ease-in-out infinite;
        }

        @keyframes livePulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.5;
                transform: scale(1.5);
            }
        }
    </style>
</head>

<body>
    <div class="phone-wrapper">

        <!-- ── HEADER ── -->
        <div class="page-header">
            <a href="#"
                style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 style="font-size:18px;font-weight:800;color:#fff;">Tracking Pesanan</h1>
        </div>

        <!-- ── SCROLL AREA ── -->
        <div class="scroll-area">
            <div style="padding-bottom: 28px;">

                <!-- ── MAP SECTION ── -->
                {{-- <div class="map-section">
                    <!-- Canvas for decorative map background (can be replaced with real Google Maps) -->
                    <canvas id="mapCanvas"></canvas>

                    <!-- Driver dot (moving avatar) -->
                    <div class="map-driver-dot">
                        <svg width="22" height="22" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>

                    <!-- Location pin -->
                    <div class="map-pin">
                        <div class="map-pin-icon">
                            <svg width="28" height="28" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="map-pin-label">Peta Lokasi Juru Angkut</div>
                    </div>
                </div> --}}

                <!-- ── DRIVER CARD ── -->
                <div class="driver-card">
                    <div class="driver-avatar">
                        <svg width="24" height="24" fill="none" stroke="#fff" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div style="flex:1;">
                        <p style="font-size:15px;font-weight:800;color:#111827;">
                            {{ $pesanan->pengangkut->name ?? 'Menunggu Juru Angkut' }}</p>
                        <p style="font-size:12px;color:#9ca3af;font-weight:500;">Juru Angkut</p>
                        <p style="font-size:11px;color:#9ca3af;font-weight:500;">B 1234 XYZ</p>
                    </div>
                    <div class="call-btn">
                        <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                </div>

                <!-- ── STATUS PESANAN ── -->
                <div class="status-card">
                    <p style="font-size:15px;font-weight:800;color:#111827;margin-bottom:16px;">Status Pesanan</p>

                    <!-- Step 1: Pesanan Dikonfirmasi -->
                    <div class="timeline-item" style="position:relative;" id="step1">
                        <div style="position:relative;flex-shrink:0;">
                            <div class="timeline-dot pending" id="dot1">
                                <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="3"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="timeline-line pending" id="line1"></div>
                        </div>
                        <div class="timeline-content">
                            <p id="label1" style="font-size:14px;font-weight:700;color:#111827;">Pesanan Dikonfirmasi
                            </p>
                            <p style="font-size:12px;color:#9ca3af;margin-top:2px;">{{ $pesanan->created_at->format('H:i') }}</p>
                            <p id="desc1" style="font-size:12px;color:#6b7280;margin-top:4px;font-weight:500;">
                                Pesanan kamu telah
                                dikonfirmasi oleh sistem.</p>
                        </div>
                    </div>

                    <!-- Step 2: Menuju Lokasi -->
                    <div class="timeline-item" style="position:relative;" id="step2">
                        <div style="position:relative;flex-shrink:0;">
                            <div class="timeline-dot done" id="dot2">
                                <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="3"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="timeline-line done" id="line2"></div>
                        </div>
                        <div class="timeline-content">
                            <p style="font-size:14px;font-weight:700;color:#111827;" id="label2">Menuju Lokasi</p>
                            <p style="font-size:12px;color:#9ca3af;margin-top:2px;" id="time2">{{ $pesanan->jam_jemput ? substr($pesanan->jam_jemput, 0, 5) : '--:--' }}</p>
                            <p id="live2"
                                style="display:none;font-size:12px;color:#16a34a;font-weight:600;margin-top:3px;">
                                <span class="status-live"><span class="live-dot"></span>Sedang berlangsung...</span>
                            </p>
                            <p style="font-size:12px;color:#6b7280;margin-top:4px;font-weight:500;" id="desc2">Juru
                                angkut sedang dalam perjalanan menuju lokasimu. Estimasi tiba pukul {{ $pesanan->jam_jemput ? substr($pesanan->jam_jemput, 0, 5) : '--:--' }}.</p>
                        </div>
                    </div>

                    <!-- Step 3: Mengambil Sampah -->
                    <div class="timeline-item" style="position:relative;" id="step3">
                        <div style="position:relative;flex-shrink:0;">
                            <div class="timeline-dot pending" id="dot3"></div>
                            <div class="timeline-line pending" id="line3"></div>
                        </div>
                        <div class="timeline-content">
                            <p style="font-size:14px;font-weight:700;color:#9ca3af;" id="label3">Mengambil Sampah
                            </p>
                            <p id="live3"
                                style="display:none;font-size:12px;color:#16a34a;font-weight:600;margin-top:3px;">
                                <span class="status-live"><span class="live-dot"></span>Sedang berlangsung...</span>
                            </p>
                            <p style="font-size:12px;color:#9ca3af;margin-top:4px;font-weight:500;" id="desc3">
                                Juru
                                angkut akan mengambil sampah di lokasi kamu.</p>
                        </div>
                    </div>

                    <!-- Step 4: Selesai -->
                    <div class="timeline-item" id="step4">
                        <div style="flex-shrink:0;">
                            <div class="timeline-dot pending" id="dot4"></div>
                        </div>
                        <div class="timeline-content" style="padding-bottom:6px;">
                            <p style="font-size:14px;font-weight:700;color:#9ca3af;" id="label4">Selesai</p>
                            <p style="font-size:12px;color:#9ca3af;margin-top:4px;font-weight:500;" id="desc4">
                                Sampah
                                berhasil diambil. Terima kasih!</p>
                        </div>
                    </div>

                </div>

                <!-- ── ACTION BUTTONS ── -->
                <div style="padding: 14px 16px 0;">
                    <button class="btn-home" onclick="window.location.href=''">Kembali ke Beranda</button>
                </div>

            </div>
        </div><!-- end scroll-area -->

        <!-- ── BOTTOM NAV ── -->
        @include('pelanggan.partials.navigation')

    </div>

    <script>
        let currentStatus = '{{ $pesanan->status }}';
        const pesananId = '{{ $pesanan->id }}';

        const icons = {
            menunggu: `<svg width="18" height="18" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"></path></svg>`,
            menuju: `<svg width="18" height="18" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>`,
            mengambil: `<svg width="18" height="18" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>`,
            selesai: `<svg width="18" height="18" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>`,
            check: `<svg width="16" height="16" fill="none" stroke="#fff" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>`
        };

        function setDot(id, state) {
            const el = document.getElementById(id);
            if (!el) return;

            // Map the state to dot class
            el.className = 'timeline-dot';
            if (state === 'pending') {
                el.classList.add('pending');
                el.innerHTML = '';
            } else if (state === 'done') {
                el.classList.add('done');
                el.innerHTML = icons.check;
            } else {
                // state is like 'active-menunggu', 'active-menuju', etc.
                el.classList.add(state);

                if (state.includes('menunggu')) el.innerHTML = icons.menunggu;
                else if (state.includes('menuju')) el.innerHTML = icons.menuju;
                else if (state.includes('mengambil')) el.innerHTML = icons.mengambil;
                else if (state.includes('selesai')) el.innerHTML = icons.selesai;
            }
        }

        function setLine(id, state) {
            const el = document.getElementById(id);
            if (!el) return;
            el.className = 'timeline-line ' + state;
        }

        function initUI(statusOrder) {
            // Reset all
            ['dot1', 'dot2', 'dot3', 'dot4'].forEach(id => setDot(id, 'pending'));
            ['line1', 'line2', 'line3'].forEach(id => setLine(id, 'pending'));

            if (statusOrder === 'menunggu') {
                setDot('dot1', 'active-menunggu');
                document.getElementById('label1').textContent = 'Menunggu Konfirmasi';
                document.getElementById('desc1').textContent = 'Menunggu Juru Angkut mengonfirmasi pesanan kamu.';

                document.getElementById('label2').style.color = '#9ca3af';
                document.getElementById('desc2').style.color = '#9ca3af';
                document.getElementById('live2').style.display = 'none';
                document.getElementById('time2').style.display = 'none';
            } else if (statusOrder === 'diklaim') {
                setDot('dot1', 'done');
                setLine('line1', 'done');

                // Still waiting for journey to start
                setDot('dot2', 'pending');
                document.getElementById('label2').style.color = '#9ca3af';
                document.getElementById('desc2').style.color = '#9ca3af';
                document.getElementById('live2').style.display = 'none';
                document.getElementById('time2').style.display = 'none';
            } else if (statusOrder === 'dalam_perjalanan') {
                setDot('dot1', 'done');
                setLine('line1', 'done');
                setDot('dot2', 'active-menuju');

                document.getElementById('label2').style.color = '#111827';
                document.getElementById('desc2').style.color = '#6b7280';
                document.getElementById('live2').style.display = 'block';
                document.getElementById('time2').style.display = 'none';
            } else if (statusOrder === 'tiba' || statusOrder === 'penimbangan') {
                setDot('dot1', 'done');
                setLine('line1', 'done');
                setDot('dot2', 'done');
                setLine('line2', 'done');
                setDot('dot3', 'active-mengambil');

                document.getElementById('label2').style.color = '#111827';
                document.getElementById('desc2').style.color = '#6b7280';
                document.getElementById('live2').style.display = 'none';
                document.getElementById('time2').style.display = 'block';

                document.getElementById('label3').style.color = '#111827';
                document.getElementById('desc3').style.color = '#6b7280';
                document.getElementById('live3').style.display = 'block';
            } else if (statusOrder === 'selesai') {
                setDot('dot1', 'done');
                setLine('line1', 'done');
                setDot('dot2', 'done');
                setLine('line2', 'done');
                setDot('dot3', 'done');
                setLine('line3', 'done');
                setDot('dot4', 'active-selesai'); // using pulse-selesai animation

                document.getElementById('label2').style.color = '#111827';
                document.getElementById('desc2').style.color = '#6b7280';
                document.getElementById('live2').style.display = 'none';
                document.getElementById('time2').style.display = 'block';

                document.getElementById('label3').style.color = '#111827';
                document.getElementById('desc3').style.color = '#6b7280';
                document.getElementById('live3').style.display = 'none';

                document.getElementById('label4').style.color = '#111827';
                document.getElementById('desc4').style.color = '#6b7280';
            }
        }

        initUI(currentStatus);

        // AJAX Polling every 3 seconds
        setInterval(() => {
            fetch(`/api/pesanan/${pesananId}/status`)
                .then(response => response.json())
                .then(data => {
                    if (data.status && data.status !== currentStatus) {
                        currentStatus = data.status;
                        initUI(currentStatus);

                        // Check if order is completed successfully, redirect to receipt
                        if (currentStatus === 'selesai') {
                            setTimeout(() => {
                                window.location.href =
                                    `/pelanggan/jemput-sampah/${pesananId}/order_selesai`;
                            }, 2500);
                        }
                    }
                })
                .catch(err => console.error('Error fetching status:', err));
        }, 3000);
    </script>
</body>

</html>

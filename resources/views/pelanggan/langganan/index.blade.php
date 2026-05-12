<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Paket Langganan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
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
            min-height: 100vh;
            background: #f2f3f7;
            position: relative;
            box-shadow: 0 0 48px rgba(0, 0, 0, 0.15);
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

        /* Scroll */
        .scroll-area {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
        }

        .scroll-area::-webkit-scrollbar {
            display: none;
        }

        /* Info banner */
        .info-banner {
            background: #fff;
            border-radius: 14px;
            padding: 13px 15px;
            margin: 16px 16px 0;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            border: 1px solid #e5e7eb;
        }

        /* Package card */
        .pkg-card {
            background: #fff;
            border-radius: 20px;
            margin: 14px 16px 0;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.07);
            overflow: hidden;
            animation: fadeUp 0.3s ease both;
        }

        .pkg-card:nth-child(3) {
            animation-delay: 0.07s;
        }

        .pkg-card:nth-child(4) {
            animation-delay: 0.14s;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Package header */
        .pkg-header {
            padding: 20px 20px 18px;
            position: relative;
        }

        .pkg-header-green {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 55%, #15803d 100%);
        }

        .pkg-header-purple {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 55%, #a855f7 100%);
        }

        /* Badge */
        .pkg-badge {
            position: absolute;
            top: 14px;
            right: 14px;
            background: #f59e0b;
            color: #fff;
            font-size: 9.5px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 20px;
            letter-spacing: 0.04em;
        }

        /* Package body */
        .pkg-body {
            padding: 16px 20px 20px;
        }

        /* Feature item */
        .feat {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 0;
        }

        .feat+.feat {
            border-top: 1px solid #f3f4f6;
        }

        /* Inline pill */
        .pill {
            font-size: 10px;
            font-weight: 500;
            color: #fff;
            padding: 2px 8px;
            border-radius: 6px;
            margin-left: 4px;
            flex-shrink: 0;
        }

        /* CTA Button */
        .btn-pilih {
            width: 100%;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 13.5px;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
            margin-top: 16px;
            font-family: 'Poppins', sans-serif;
            letter-spacing: 0.01em;
            transition: transform 0.15s, opacity 0.2s;
        }

        .btn-pilih:active {
            transform: scale(0.98);
            opacity: 0.88;
        }

        .btn-green {
            background: linear-gradient(135deg, #22c55e, #16a34a);
        }

        .btn-purple {
            background: linear-gradient(135deg, #6366f1, #a855f7);
        }

        /* Aktif card */
        .aktif-card {
            background: #fff;
            border-radius: 20px;
            margin: 14px 16px 0;
            padding: 16px 20px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
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
        }

        /* Modal */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 300;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s;
        }

        .modal-overlay.show {
            opacity: 1;
            pointer-events: all;
        }

        .modal-sheet {
            width: 390px;
            background: #fff;
            border-radius: 24px 24px 0 0;
            padding: 20px 22px 40px;
            transform: translateY(100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modal-overlay.show .modal-sheet {
            transform: translateY(0);
        }

        @media (max-width: 390px) {
            .modal-sheet {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="phone-wrapper">

        <!-- HEADER -->
        <div class="page-header">
            <a href="{{ route('pelanggan.index') }}"
                style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 style="font-size:17px;font-weight:600;color:#fff;letter-spacing:0.01em;">Paket Langganan</h1>
        </div>

        <!-- SCROLL AREA -->
        <div class="scroll-area">
            <div style="padding-bottom:32px;">

                {{-- Error / Success messages --}}
                @if ($errors->any())
                    <div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:12px;padding:12px 16px;margin:12px 16px 0;">
                        @foreach ($errors->all() as $error)
                            <p style="font-size:12px;color:#dc2626;font-weight:500;">⚠️ {{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                @if (session('success'))
                    <div style="background:#dcfce7;border:1px solid #86efac;border-radius:12px;padding:12px 16px;margin:12px 16px 0;">
                        <p style="font-size:12px;color:#15803d;font-weight:600;">{{ session('success') }}</p>
                    </div>
                @endif

                <!-- Info banner -->
                <div class="info-banner">
                    <span style="font-size:18px;flex-shrink:0;margin-top:1px;">🔥</span>
                    <p style="font-size:12.5px;font-weight:400;color:#4b5563;line-height:1.6;">Hemat lebih banyak dengan
                        paket langganan! Pilih paket yang sesuai kebutuhan Anda.</p>
                </div>

                {{-- Langganan Aktif (jika ada) --}}
                @if ($langgananAktif)
                <div class="aktif-card" style="border:1.5px solid #22c55e;">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;">
                        <span style="font-size:16px;">✅</span>
                        <p style="font-size:14px;font-weight:600;color:#15803d;">Langganan Aktif</p>
                    </div>
                    <p style="font-size:12px;font-weight:400;color:#6b7280;margin-bottom:14px;">{{ $langgananAktif->paket->nama ?? '-' }}</p>
                    <div style="display:flex;align-items:stretch;">
                        <div style="flex:1;">
                            <p style="font-size:11px;font-weight:400;color:#9ca3af;margin-bottom:4px;">Mulai</p>
                            <p style="font-size:13.5px;font-weight:600;color:#111827;">{{ $langgananAktif->tanggal_mulai->translatedFormat('d M Y') }}</p>
                        </div>
                        <div style="width:1px;background:#e5e7eb;margin:0 16px;"></div>
                        <div style="flex:1;">
                            <p style="font-size:11px;font-weight:400;color:#9ca3af;margin-bottom:4px;">Berakhir</p>
                            <p style="font-size:13.5px;font-weight:600;color:#16a34a;">{{ $langgananAktif->tanggal_selesai->translatedFormat('d M Y') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Paket dari database --}}
                @php $colors = ['green', 'purple', 'green', 'purple']; @endphp
                @foreach ($paketList as $i => $paket)
                @php $theme = $colors[$i % 2]; @endphp
                <div class="pkg-card">
                    <div class="pkg-header pkg-header-{{ $theme }}">
                        @if ($i === 1)
                            <div class="pkg-badge">⭐ Terbaik</div>
                        @endif
                        <p style="font-size:18px;font-weight:700;color:#fff;margin-bottom:3px;">{{ $paket->nama }}</p>
                        <p style="font-size:12px;font-weight:400;color:rgba(255,255,255,0.75);margin-bottom:13px;">{{ $paket->frekuensi_jemput }}x jemput/{{ $paket->satuan_frekuensi }} &nbsp;·&nbsp; {{ $paket->durasi_hari }} hari</p>
                        <div style="display:flex;align-items:baseline;gap:5px;">
                            <span style="font-size:27px;font-weight:700;color:#fff;letter-spacing:-0.5px;">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                        </div>
                        @if ($paket->info_tong)
                        <div style="margin-top:9px;display:inline-flex;align-items:center;background:rgba(255,255,255,0.15);border-radius:20px;padding:3px 10px;gap:4px;">
                            <span style="font-size:10px;font-weight:500;color:rgba(255,255,255,0.9);">🗑️ {{ $paket->info_tong }}</span>
                        </div>
                        @endif
                    </div>
                    <div class="pkg-body">
                        <div class="feat">
                            <svg width="16" height="16" fill="none" stroke="#16a34a" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span style="font-size:13px;font-weight:400;color:#374151;">{{ $paket->frekuensi_jemput }}x penjemputan per {{ $paket->satuan_frekuensi }}</span>
                        </div>
                        <div class="feat">
                            <svg width="16" height="16" fill="none" stroke="#16a34a" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span style="font-size:13px;font-weight:400;color:#374151;">Gratis biaya jemput</span>
                        </div>
                        @if ($paket->info_tong)
                        <div class="feat">
                            <svg width="16" height="16" fill="none" stroke="#16a34a" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span style="font-size:13px;font-weight:400;color:#374151;">{{ $paket->info_tong }}</span>
                            <span class="pill" style="background:{{ $theme === 'purple' ? 'linear-gradient(135deg,#6366f1,#a855f7)' : '#16a34a' }};">Gratis</span>
                        </div>
                        @endif
                        @if ($paket->deskripsi)
                        <div class="feat">
                            <svg width="16" height="16" fill="none" stroke="#16a34a" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span style="font-size:13px;font-weight:400;color:#374151;">{{ $paket->deskripsi }}</span>
                        </div>
                        @endif
                        @if ($langgananAktif)
                            <button class="btn-pilih" style="background:#9ca3af;cursor:not-allowed;" disabled>Sudah Berlangganan</button>
                        @else
                            <button class="btn-pilih btn-{{ $theme }}" onclick="openModal({{ $paket->id }}, '{{ $paket->nama }}', '{{ number_format($paket->harga, 0, ',', '.') }}', '{{ $theme }}')">Pilih Paket</button>
                        @endif
                    </div>
                </div>
                @endforeach

            </div>
        </div>

        <!-- BOTTOM NAV -->
        <div class="nav-bottom">
            <div class="nav-btn">
                <svg width="22" height="22" fill="#9ca3af" viewBox="0 0 24 24">
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                </svg>
                <span style="font-size:10px;font-weight:400;color:#9ca3af;">Home</span>
            </div>
            <div class="nav-btn">
                <svg width="22" height="22" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span style="font-size:10px;font-weight:600;color:#16a34a;">Order</span>
            </div>
            <div class="nav-btn">
                <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span style="font-size:10px;font-weight:400;color:#9ca3af;">History</span>
            </div>
            <div class="nav-btn">
                <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                <span style="font-size:10px;font-weight:400;color:#9ca3af;">Wallet</span>
            </div>
            <div class="nav-btn">
                <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span style="font-size:10px;font-weight:400;color:#9ca3af;">Profile</span>
            </div>
        </div>

    </div>

    <!-- MODAL -->
    <div class="modal-overlay" id="modalOverlay" onclick="handleOverlayClick(event)">
        <div class="modal-sheet" id="modalSheet">
            <div style="display:flex;justify-content:center;margin-bottom:18px;">
                <div style="width:38px;height:4px;background:#e5e7eb;border-radius:4px;"></div>
            </div>
            <div style="width:52px;height:52px;border-radius:14px;margin:0 auto 14px;display:flex;align-items:center;justify-content:center;"
                id="modalIcon"></div>
            <p style="font-size:16px;font-weight:600;color:#111827;text-align:center;margin-bottom:5px;"
                id="modalTitle"></p>
            <p style="font-size:12.5px;font-weight:400;color:#6b7280;text-align:center;line-height:1.6;margin-bottom:20px;"
                id="modalDesc"></p>

            <div
                style="background:#f9fafb;border-radius:12px;padding:14px 16px;margin-bottom:18px;border:1px solid #e5e7eb;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                    <span style="font-size:12.5px;font-weight:400;color:#6b7280;">Harga Paket</span>
                    <span style="font-size:13px;font-weight:600;color:#111827;" id="modalPrice"></span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                    <span style="font-size:12.5px;font-weight:400;color:#6b7280;">Biaya Layanan</span>
                    <span style="font-size:13px;font-weight:500;color:#16a34a;">Gratis</span>
                </div>
                <div style="border-top:1px dashed #e5e7eb;margin:10px 0;"></div>
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <span style="font-size:13px;font-weight:600;color:#111827;">Total</span>
                    <span style="font-size:15px;font-weight:700;color:#111827;" id="modalTotal"></span>
                </div>
            </div>

            <form id="formLangganan" action="{{ route('pelanggan.langganan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="paket_id" id="inputPaketId" value="">
                <button type="submit" id="modalBtn"
                    style="width:100%;border:none;border-radius:12px;padding:15px;font-size:13.5px;font-weight:600;color:#fff;cursor:pointer;font-family:'Poppins',sans-serif;letter-spacing:0.01em;transition:opacity 0.2s;">
                    Konfirmasi Berlangganan
                </button>
            </form>
            <button onclick="closeModal()"
                style="width:100%;border:none;background:transparent;color:#9ca3af;font-size:12px;font-weight:400;padding:12px;cursor:pointer;font-family:'Poppins',sans-serif;margin-top:2px;">
                Batal
            </button>
        </div>
    </div>

    <script>
        const gradients = {
            green: 'linear-gradient(135deg,#22c55e,#16a34a)',
            purple: 'linear-gradient(135deg,#6366f1,#a855f7)'
        };

        function openModal(paketId, nama, harga, theme) {
            document.getElementById('inputPaketId').value = paketId;
            document.getElementById('modalTitle').textContent = nama;
            document.getElementById('modalDesc').textContent = 'Kamu akan berlangganan ' + nama + '. Nikmati semua benefit paket ini!';
            document.getElementById('modalPrice').textContent = 'Rp ' + harga;
            document.getElementById('modalTotal').textContent = 'Rp ' + harga;
            const icon = document.getElementById('modalIcon');
            icon.style.background = gradients[theme];
            icon.innerHTML = '<span style="font-size:24px;">' + (theme === 'purple' ? '⭐' : '🌿') + '</span>';
            document.getElementById('modalBtn').style.background = gradients[theme];
            document.getElementById('modalOverlay').classList.add('show');
        }

        function closeModal() {
            document.getElementById('modalOverlay').classList.remove('show');
        }

        function handleOverlayClick(e) {
            if (e.target === document.getElementById('modalOverlay')) closeModal();
        }
    </script>
</body>

</html>
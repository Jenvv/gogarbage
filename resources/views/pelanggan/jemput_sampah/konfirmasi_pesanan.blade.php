<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Konfirmasi Pesanan</title>
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
            padding-bottom: 80px;
        }

        .scroll-area::-webkit-scrollbar {
            display: none;
        }

        /* Detail card */
        .detail-card {
            background: #fff;
            border-radius: 20px;
            padding: 20px 20px 8px;
            margin: 16px 16px 0;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.07);
        }

        /* Detail row */
        .detail-row {
            display: flex;
            align-items: flex-start;
            gap: 13px;
            padding: 14px 0;
        }

        .detail-row+.detail-row {
            border-top: 1px solid #f3f4f6;
        }

        .detail-icon {
            width: 34px;
            height: 34px;
            background: #f0fdf4;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* Payment summary card */
        .ringkasan-card {
            background: #f0fdf4;
            border: 1.5px solid #86efac;
            border-radius: 20px;
            padding: 18px 20px;
            margin: 14px 16px 0;
            transition: all 0.3s;
        }

        /* Simulasi toggle */
        .simulasi-wrap {
            background: #fff;
            border: 1.5px solid #e5e7eb;
            border-radius: 16px;
            padding: 14px 16px;
            margin: 14px 16px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .toggle-track {
            width: 48px;
            height: 27px;
            border-radius: 50px;
            background: #d1d5db;
            position: relative;
            cursor: pointer;
            transition: background 0.25s;
            flex-shrink: 0;
        }

        .toggle-track.on {
            background: #22c55e;
        }

        .toggle-thumb {
            width: 21px;
            height: 21px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
            position: absolute;
            top: 3px;
            left: 3px;
            transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .toggle-track.on .toggle-thumb {
            transform: translateX(21px);
        }

        /* Lanjut button */
        .lanjut-btn {
            width: 100%;
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            border: none;
            border-radius: 16px;
            padding: 17px;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s;
            margin: 14px 0 0;
            display: block;
        }

        .lanjut-btn:active {
            transform: scale(0.98);
            opacity: 0.9;
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

        /* Animations */
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
            animation: fadeSlide 0.25s ease forwards;
        }

        /* Strike through */
        .line-through {
            text-decoration: line-through;
        }
    </style>
</head>

<body>
    <div class="phone-wrapper">

        <!-- ── HEADER ── -->
        <div class="page-header">
            <a href="{{ route('pelanggan.jemput-sampah') }}"
                style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 style="font-size:18px;font-weight:800;color:#fff;">Konfirmasi Pesanan</h1>
        </div>

        <!-- ── SCROLL AREA ── -->
        <div class="scroll-area">
            <div style="padding: 0 0 28px;">

                <!-- ── DETAIL PESANAN ── -->
                <div class="detail-card">
                    <p style="font-size:15px;font-weight:800;color:#111827;margin-bottom:4px;">Detail Pesanan</p>



                    <!-- Alamat -->
                    <div class="detail-row">
                        <div class="detail-icon">
                            <svg width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:11.5px;color:#9ca3af;font-weight:500;margin-bottom:3px;">Alamat
                                Penjemputan</p>
                            <p style="font-size:14px;font-weight:700;color:#111827;line-height:1.4;">
                                {{ $draft['alamat_jemput'] }}</p>
                        </div>
                    </div>

                    <!-- Tanggal -->
                    <div class="detail-row">
                        <div class="detail-icon">
                            <svg width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:11.5px;color:#9ca3af;font-weight:500;margin-bottom:3px;">Tanggal</p>
                            <p style="font-size:14px;font-weight:700;color:#111827;">
                                {{ \Carbon\Carbon::parse($draft['tanggal_jemput'])->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>

                    <!-- Waktu -->
                    <div class="detail-row">
                        <div class="detail-icon">
                            <svg width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:11.5px;color:#9ca3af;font-weight:500;margin-bottom:3px;">Waktu</p>
                            <p style="font-size:14px;font-weight:700;color:#111827;">{{ $draft['jam_jemput'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- ── STATUS INFO ── -->
                <div style="margin: 14px 16px 0;">
                    <div
                        style="background:#fff;border:1.5px solid #e5e7eb;border-radius:16px;padding:14px 16px;display:flex;align-items:center;gap:12px;">
                        <div
                            style="width:42px;height:42px;border-radius:12px;background:#e0f2fe;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <span style="font-size:20px;">🚚</span>
                        </div>
                        <div>
                            <p style="font-size:13px;font-weight:700;color:#111827;">Juru angkut akan menjemput
                                pesananmu</p>
                            <p style="font-size:11px;color:#9ca3af;margin-top:2px;">Setelah pesanan dikonfirmasi</p>
                        </div>
                    </div>
                </div>

                <!-- ── METODE PEMBAYARAN ── -->
                @if (!$isBerlangganan)
                <div
                    style="background:#fff;border-radius:20px;margin:14px 16px 0;box-shadow:0 2px 16px rgba(0,0,0,0.07);overflow:hidden;">
                    <div style="padding:14px 18px 6px;">
                        <p
                            style="font-size:10.5px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.06em;">
                            Metode Pembayaran</p>
                    </div>
                    <div onclick="openPaymentModal()" id="payRow"
                        style="display:flex;align-items:center;gap:14px;padding:12px 18px 18px;cursor:pointer;transition:background 0.15s;">
                        <div id="payIconWrap"
                            style="width:42px;height:42px;background:#6b7280;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div style="flex:1;">
                            <p style="font-size:11px;color:#9ca3af;font-weight:500;margin-bottom:2px;">Metode dipilih</p>
                            <p style="font-size:14px;font-weight:700;color:#111827;" id="selectedPayLabel">Tunai</p>
                        </div>
                        <svg width="18" height="18" fill="none" stroke="#9ca3af" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
                @endif

                <!-- ── RINGKASAN PEMBAYARAN ── -->
                <div class="ringkasan-card" id="ringkasanCard">
                    <p style="font-size:14px;font-weight:800;color:#111827;margin-bottom:14px;">Ringkasan Pembayaran</p>

                    <!-- Jarak -->
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                        <span style="font-size:13px;color:#374151;font-weight:500;">Jarak Penjemputan</span>
                        <span style="font-size:13px;font-weight:700;color:#111827;">{{ $draft['jarak_km'] }} KM</span>
                    </div>

                    <!-- Ongkir Juru Angkut -->
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                        <span style="font-size:13px;color:#374151;font-weight:500;">Ongkir Jemput</span>
                        <span style="font-size:13px;font-weight:700;color:#111827;">
                            {{ $isBerlangganan ? 'GRATIS' : 'Rp ' . number_format($draft['ongkir_juru_angkut'], 0, ',', '.') }}
                        </span>
                    </div>

                    @if (!$isBerlangganan)
                    <!-- Biaya Admin -->
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
                        <span style="font-size:13px;color:#374151;font-weight:500;">Biaya Layanan</span>
                        <span style="font-size:13px;font-weight:700;color:#111827;">Rp {{ number_format($draft['biaya_admin'], 0, ',', '.') }}</span>
                    </div>
                    @endif

                    @if ($isBerlangganan)
                        <div style="margin-bottom:14px;">
                            <div style="background:#dcfce7;border:1px solid #86efac;border-radius:10px;padding:10px 12px;display:flex;gap:8px;align-items:center;">
                                <span style="font-size:14px;flex-shrink:0;">🎉</span>
                                <p style="font-size:11px;font-weight:600;color:#15803d;line-height:1.5;">Biaya jemput dan layanan gratis karena kamu berlangganan!</p>
                            </div>
                        </div>
                    @endif

                    <div style="border-top:1.5px solid #86efac;margin-bottom:14px;"></div>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:15px;font-weight:800;color:#111827;">Total</span>
                        <span style="font-size:20px;font-weight:800;color:#16a34a;">{{ $isBerlangganan ? 'Rp 0 (GRATIS)' : 'Rp ' . number_format($draft['biaya_jemput'], 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- ── PESAN SEKARANG ── -->
                <div style="padding: 0 16px;">
                    <form id="formKonfirmasi" action="{{ route('pelanggan.confirm-pesanan') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="metode_pembayaran" id="inputMetodeBayar" value="{{ $isBerlangganan ? 'saldo' : 'tunai' }}">
                        <input type="file" name="bukti_pembayaran" id="inputBuktiPesanan" accept="image/*" style="display:none;">
                        <button type="button" class="lanjut-btn" id="btnPesan" onclick="pesanSekarang()">Pesan Sekarang</button>
                    </form>
                </div>

            </div>
        </div><!-- end scroll-area -->

        <!-- ── BOTTOM NAV ── -->
        @include('pelanggan.partials.navigation')

        <!-- ── PAYMENT MODAL ── -->
        <div id="paymentModal"
            style="position:absolute;inset:0;background:rgba(0,0,0,0.48);z-index:200;display:flex;align-items:flex-end;opacity:0;pointer-events:none;transition:opacity 0.25s;">
            <div id="payModalSheet"
                style="width:100%;background:#fff;border-radius:24px 24px 0 0;padding:20px 20px 36px;transform:translateY(100%);transition:transform 0.3s cubic-bezier(0.4,0,0.2,1);max-height:85vh;overflow-y:auto;">

                <div style="display:flex;justify-content:center;margin-bottom:16px;">
                    <div style="width:40px;height:4px;background:#e5e7eb;border-radius:4px;"></div>
                </div>
                <p style="font-size:16px;font-weight:800;color:#111827;margin-bottom:4px;">Pilih Metode Pembayaran</p>
                <p style="font-size:12px;color:#9ca3af;margin-bottom:18px;">Semua transaksi dilindungi &amp; terenkripsi 🔒</p>

                <!-- Saldo GoGarbage -->
                <p style="font-size:10px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:10px;">Saldo</p>
                <div class="pay-opt" data-value="saldo" onclick="selectPayment(this)">
                    <div style="width:42px;height:42px;border-radius:12px;background:#22c55e;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <div style="flex:1;">
                        <p style="font-size:13px;font-weight:700;color:#111827;">Saldo GoGarbage</p>
                        <p style="font-size:11px;color:#9ca3af;">Sisa: Rp {{ number_format(Auth::user()->saldo ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="pay-radio"><div class="pay-dot"></div></div>
                </div>

                <!-- Saldo Error -->
                <p id="modalSaldoError" style="font-size:11.5px;color:#dc2626;margin:0 0 10px 56px;display:none;font-weight:500;">⚠️ Saldo tidak mencukupi</p>

                <!-- Transfer Bank -->
                <p style="font-size:10px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.06em;margin:16px 0 10px;">Transfer</p>
                <div class="pay-opt" data-value="transfer" onclick="selectPayment(this)">
                    <div style="width:42px;height:42px;border-radius:12px;background:#f59e0b;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                        </svg>
                    </div>
                    <div style="flex:1;">
                        <p style="font-size:13px;font-weight:700;color:#111827;">Transfer Bank</p>
                        <p style="font-size:11px;color:#9ca3af;">BCA, Mandiri, BRI</p>
                    </div>
                    <div class="pay-radio"><div class="pay-dot"></div></div>
                </div>

                <!-- Transfer Info (hidden) -->
                <div id="modalTransferInfo" style="display:none;margin:-4px 0 10px;">
                    <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:12px;padding:14px 16px;margin-bottom:12px;">
                        <p style="font-size:11px;font-weight:700;color:#92400e;margin-bottom:8px;">Transfer ke salah satu rekening:</p>
                        <div style="display:flex;flex-direction:column;gap:5px;">
                            <div style="display:flex;justify-content:space-between;"><span style="font-size:12px;font-weight:600;color:#78350f;">BCA</span><span style="font-size:12px;font-weight:700;color:#111827;">1234 5678 90</span></div>
                            <div style="display:flex;justify-content:space-between;"><span style="font-size:12px;font-weight:600;color:#78350f;">Mandiri</span><span style="font-size:12px;font-weight:700;color:#111827;">0987 6543 21</span></div>
                            <div style="display:flex;justify-content:space-between;"><span style="font-size:12px;font-weight:600;color:#78350f;">BRI</span><span style="font-size:12px;font-weight:700;color:#111827;">1122 3344 5566</span></div>
                        </div>
                        <p style="font-size:10.5px;color:#92400e;margin-top:6px;">a.n. <strong>PT GoGarbage Indonesia</strong></p>
                    </div>
                    <p style="font-size:12px;font-weight:600;color:#374151;margin-bottom:8px;">Upload Bukti Transfer</p>
                    <label id="uploadLabelPesanan" style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;border:2px dashed #d1d5db;border-radius:12px;padding:18px;cursor:pointer;background:#f9fafb;transition:all 0.2s;">
                        <svg width="28" height="28" fill="none" stroke="#9ca3af" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span style="font-size:12px;color:#9ca3af;font-weight:500;" id="uploadTextPesanan">Ketuk untuk upload bukti transfer</span>
                        <input type="file" accept="image/*" style="display:none;" id="modalBuktiInput" onchange="handleBuktiChange(this)">
                    </label>
                </div>

                <!-- Tunai -->
                <p style="font-size:10px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.06em;margin:16px 0 10px;">Lainnya</p>
                <div class="pay-opt selected" data-value="tunai" onclick="selectPayment(this)">
                    <div style="width:42px;height:42px;border-radius:12px;background:#6b7280;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div style="flex:1;">
                        <p style="font-size:13px;font-weight:700;color:#111827;">Tunai</p>
                        <p style="font-size:11px;color:#9ca3af;">Bayar langsung ke juru angkut</p>
                    </div>
                    <div class="pay-radio"><div class="pay-dot"></div></div>
                </div>

                <button id="btnConfirmPay" onclick="confirmPayment()"
                    style="width:100%;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;font-size:14px;font-weight:700;padding:15px;border-radius:14px;border:none;cursor:pointer;margin-top:18px;transition:opacity 0.2s;">
                    Gunakan Metode Ini
                </button>
            </div>
        </div>

    </div>

    <style>
        .pay-opt {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 13px 14px;
            border-radius: 14px;
            border: 1.5px solid #e5e7eb;
            cursor: pointer;
            transition: all 0.18s;
            margin-bottom: 10px;
            background: #fff;
        }
        .pay-opt.selected {
            border-color: #22c55e;
            background: #f0fdf4;
        }
        .pay-radio {
            width: 20px; height: 20px; border-radius: 50%;
            border: 2px solid #d1d5db;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; transition: all 0.18s;
        }
        .pay-opt.selected .pay-radio {
            border-color: #22c55e; background: #22c55e;
        }
        .pay-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: #fff; display: none;
        }
        .pay-opt.selected .pay-dot { display: block; }
    </style>

    <script>
        const isBerlangganan = {{ $isBerlangganan ? 'true' : 'false' }};
        const totalBiaya = {{ $isBerlangganan ? 0 : $draft['biaya_jemput'] + 1000 }};
        const saldoUser = {{ Auth::user()->saldo ?? 0 }};
        let selectedMetode = isBerlangganan ? 'saldo' : 'tunai';

        // ── Payment Modal ──
        function openPaymentModal() {
            if (isBerlangganan) return; // No modal needed for subscribers
            const modal = document.getElementById('paymentModal');
            const sheet = document.getElementById('payModalSheet');
            modal.style.opacity = '1';
            modal.style.pointerEvents = 'all';
            sheet.style.transform = 'translateY(0)';
        }

        function closePaymentModal() {
            const modal = document.getElementById('paymentModal');
            const sheet = document.getElementById('payModalSheet');
            sheet.style.transform = 'translateY(100%)';
            setTimeout(() => {
                modal.style.opacity = '0';
                modal.style.pointerEvents = 'none';
            }, 280);
        }

        document.getElementById('paymentModal').addEventListener('click', function(e) {
            if (e.target === this) closePaymentModal();
        });

        function selectPayment(el) {
            document.querySelectorAll('.pay-opt').forEach(o => o.classList.remove('selected'));
            el.classList.add('selected');
            selectedMetode = el.dataset.value;

            // Saldo check
            const saldoErr = document.getElementById('modalSaldoError');
            const confirmBtn = document.getElementById('btnConfirmPay');
            if (selectedMetode === 'saldo' && saldoUser < totalBiaya) {
                saldoErr.style.display = 'block';
                confirmBtn.disabled = true;
                confirmBtn.style.opacity = '0.5';
                confirmBtn.style.cursor = 'not-allowed';
            } else {
                saldoErr.style.display = 'none';
                confirmBtn.disabled = false;
                confirmBtn.style.opacity = '1';
                confirmBtn.style.cursor = 'pointer';
            }

            // Transfer info
            document.getElementById('modalTransferInfo').style.display = selectedMetode === 'transfer' ? 'block' : 'none';
        }

        function handleBuktiChange(input) {
            const label = document.getElementById('uploadTextPesanan');
            const wrap = document.getElementById('uploadLabelPesanan');
            if (input.files.length > 0) {
                label.textContent = '✅ ' + input.files[0].name;
                label.style.color = '#16a34a';
                wrap.style.borderColor = '#22c55e';
                wrap.style.background = '#f0fdf4';
                // Copy file to the actual form
                const dt = new DataTransfer();
                dt.items.add(input.files[0]);
                document.getElementById('inputBuktiPesanan').files = dt.files;
            } else {
                label.textContent = 'Ketuk untuk upload bukti transfer';
                label.style.color = '#9ca3af';
                wrap.style.borderColor = '#d1d5db';
                wrap.style.background = '#f9fafb';
            }
        }

        function confirmPayment() {
            const labels = { saldo: 'Saldo GoGarbage', transfer: 'Transfer Bank', tunai: 'Tunai' };
            const colors = { saldo: '#22c55e', transfer: '#f59e0b', tunai: '#6b7280' };
            const icons = {
                saldo: '<svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>',
                transfer: '<svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>',
                tunai: '<svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>'
            };

            document.getElementById('selectedPayLabel').textContent = labels[selectedMetode];
            const iconWrap = document.getElementById('payIconWrap');
            iconWrap.style.background = colors[selectedMetode];
            iconWrap.innerHTML = icons[selectedMetode];
            document.getElementById('inputMetodeBayar').value = selectedMetode;

            // Update pesan button state
            const btn = document.getElementById('btnPesan');
            if (selectedMetode === 'saldo' && saldoUser < totalBiaya) {
                btn.disabled = true;
                btn.style.opacity = '0.5';
                btn.style.cursor = 'not-allowed';
            } else {
                btn.disabled = false;
                btn.style.opacity = '1';
                btn.style.cursor = 'pointer';
            }

            closePaymentModal();
        }

        function pesanSekarang() {
            const metode = document.getElementById('inputMetodeBayar').value;
            let msg = 'Apakah pesanan sudah sesuai? Klik OK untuk melanjutkan.';
            if (metode === 'saldo') {
                msg = 'Saldo kamu akan dipotong Rp ' + totalBiaya.toLocaleString('id-ID') + '. Lanjutkan?';
            }
            if (confirm(msg)) {
                document.getElementById('formKonfirmasi').submit();
            }
        }
    </script>
</body>

</html>

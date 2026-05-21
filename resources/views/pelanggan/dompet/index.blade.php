<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dompet Saya</title>
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
            box-shadow: 0 0 48px rgba(0, 0, 0, .18);
            display: flex;
            flex-direction: column;
        }

        @media(max-width:390px) {
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
            padding-bottom: 80px;
        }

        .scroll-area::-webkit-scrollbar {
            display: none;
        }

        /* Bottom nav */
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

        .header-green {
            background: linear-gradient(145deg, #2ecc71 0%, #1aab57 55%, #148a40 100%);
            padding: 20px 20px 56px;
            flex-shrink: 0;
        }

        .balance-card {
            background: rgba(255, 255, 255, .16);
            border: 1px solid rgba(255, 255, 255, .28);
            border-radius: 18px;
            padding: 18px 20px 20px;
        }

        .action-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 12px 0;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: opacity .2s, transform .15s;
            border: none;
        }

        .action-btn:active {
            transform: scale(.97);
            opacity: .88;
        }

        .btn-topup {
            background: #fff;
            color: #16a34a;
        }

        .btn-tarik {
            background: rgba(255, 255, 255, .2);
            color: #fff;
            border: 1.5px solid rgba(255, 255, 255, .5) !important;
        }

        .white-card {
            background: #fff;
            border-radius: 24px 24px 0 0;
            margin-top: -28px;
            padding: 22px 20px 28px;
            position: relative;
            z-index: 5;
            min-height: 420px;
        }

        .txn-item {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 13px 0;
            border-bottom: 1px solid #f3f4f6;
            cursor: pointer;
            transition: background .15s;
            border-radius: 8px;
        }

        .txn-item:last-child {
            border-bottom: none;
        }

        .txn-item:active {
            background: #f9fafb;
        }

        .txn-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* MODALS */
        .overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, .5);
            z-index: 100;
            display: flex;
            align-items: flex-end;
            opacity: 0;
            pointer-events: none;
            transition: opacity .28s;
        }

        .overlay.open {
            opacity: 1;
            pointer-events: all;
        }

        .sheet {
            width: 100%;
            background: #fff;
            border-radius: 24px 24px 0 0;
            padding: 10px 20px 36px;
            transform: translateY(100%);
            transition: transform .32s cubic-bezier(.4, 0, .2, 1);
            max-height: 88vh;
            overflow-y: auto;
            scrollbar-width: none;
        }

        .sheet::-webkit-scrollbar {
            display: none;
        }

        .overlay.open .sheet {
            transform: translateY(0);
        }

        .handle {
            width: 40px;
            height: 4px;
            background: #e5e7eb;
            border-radius: 4px;
            margin: 10px auto 18px;
        }

        /* Inputs */
        .field-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1.5px solid #e5e7eb;
            border-radius: 13px;
            padding: 13px 16px;
            background: #fff;
            transition: border-color .2s;
        }

        .field-wrap:focus-within {
            border-color: #22c55e;
        }

        .field-wrap input,
        .field-wrap select {
            flex: 1;
            border: none;
            outline: none;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            font-weight: 600;
            color: #111827;
            background: transparent;
        }

        .field-wrap input::placeholder,
        .field-wrap select option:first-child {
            color: #9ca3af;
        }

        .quick-chip {
            flex: 1;
            padding: 10px 0;
            text-align: center;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            cursor: pointer;
            background: #fff;
            transition: all .18s;
        }

        .quick-chip.active {
            border-color: #22c55e;
            background: #f0fdf4;
            color: #16a34a;
        }

        .green-btn {
            width: 100%;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            font-weight: 700;
            padding: 15px;
            border-radius: 13px;
            border: none;
            cursor: pointer;
            transition: opacity .2s, transform .15s;
            margin-top: 16px;
        }

        .green-btn:active {
            transform: scale(.98);
            opacity: .9;
        }

        .green-btn:disabled {
            opacity: .4;
            cursor: not-allowed;
        }

        .outline-btn {
            width: 100%;
            background: #fff;
            color: #374151;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 600;
            padding: 14px;
            border-radius: 13px;
            border: 1.5px solid #e5e7eb;
            cursor: pointer;
            transition: all .2s;
            margin-top: 10px;
        }

        .outline-btn:active {
            background: #f9fafb;
        }

        .pay-opt {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 13px 14px;
            border-radius: 13px;
            border: 1.5px solid #e5e7eb;
            cursor: pointer;
            transition: all .18s;
            margin-bottom: 9px;
            background: #fff;
        }

        .pay-opt.selected {
            border-color: #22c55e;
            background: #f0fdf4;
        }

        .pay-radio {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid #d1d5db;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-left: auto;
            transition: all .18s;
        }

        .pay-opt.selected .pay-radio {
            border-color: #22c55e;
            background: #22c55e;
        }

        .pay-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #fff;
            display: none;
        }

        .pay-opt.selected .pay-dot {
            display: block;
        }

        .pay-icon-box {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* Upload area */
        .upload-area {
            border: 2px dashed #d1d5db;
            border-radius: 13px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all .2s;
            background: #fafafa;
        }

        .upload-area:hover,
        .upload-area.has-file {
            border-color: #22c55e;
            background: #f0fdf4;
        }

        /* Bank detail box */
        .bank-detail {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 13px;
            padding: 16px;
            margin-bottom: 14px;
        }

        .bank-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .bank-row:last-child {
            margin-bottom: 0;
        }

        .copy-btn {
            font-size: 11px;
            font-weight: 700;
            color: #16a34a;
            background: #dcfce7;
            border: none;
            border-radius: 6px;
            padding: 3px 9px;
            cursor: pointer;
        }

        /* Status badges */
        .badge-success {
            background: #dcfce7;
            color: #15803d;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .badge-pending {
            background: #fef9c3;
            color: #92400e;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .badge-debit {
            background: #fee2e2;
            color: #b91c1c;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .badge-rejected {
            background: #fee2e2;
            color: #b91c1c;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
        }

        /* Animations */
        @keyframes popIn {
            0% {
                transform: scale(.4);
                opacity: 0;
            }

            65% {
                transform: scale(1.12);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .pop-in {
            animation: popIn .5s cubic-bezier(.34, 1.56, .64, 1) forwards;
        }

        .su1 {
            animation: slideUp .35s ease .1s both;
        }

        .su2 {
            animation: slideUp .35s ease .2s both;
        }

        .su3 {
            animation: slideUp .35s ease .3s both;
        }

        .su4 {
            animation: slideUp .35s ease .4s both;
        }

        .section-label {
            font-size: 10.5px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: .06em;
            margin: 14px 0 10px;
        }

        /* Toast */
        .toast {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #16a34a;
            color: #fff;
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            z-index: 999;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            animation: toastIn 0.3s ease, toastOut 0.3s ease 2.5s forwards;
        }

        .toast.error {
            background: #ef4444;
        }

        @keyframes toastIn {
            from { opacity: 0; transform: translateX(-50%) translateY(-10px); }
            to { opacity: 1; transform: translateX(-50%) translateY(0); }
        }

        @keyframes toastOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }

        /* Form input for rekening */
        .rek-input {
            width: 100%;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px 14px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 600;
            color: #111827;
            outline: none;
            transition: border-color .2s;
            background: #fff;
            margin-bottom: 10px;
        }

        .rek-input:focus {
            border-color: #22c55e;
        }
    </style>
</head>

<body>
    {{-- Toast Notifications --}}
    @if(session('success'))
        <div class="toast">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="toast error">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="toast error">{{ $errors->first() }}</div>
    @endif

    <div class="phone-wrapper" id="pw">

        <div class="scroll-area">
            <div style="padding-bottom:24px;">

                <!-- GREEN HEADER -->
                <div class="header-green">
                    <div style="display:flex;align-items:center;gap:14px;margin-bottom:18px;">
                        <a href="{{ route('pelanggan.index') }}"
                            style="width:36px;height:36px;background:rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                            <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <h1 style="font-size:19px;font-weight:800;color:#fff;">Dompet Saya</h1>
                    </div>
                    <div class="balance-card">
                        <div style="display:flex;align-items:center;gap:7px;margin-bottom:7px;">
                            <svg width="15" height="15" fill="none" stroke="rgba(255,255,255,.8)"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            <span style="font-size:12px;color:rgba(255,255,255,.82);font-weight:500;">Saldo
                                Tersedia</span>
                        </div>
                        <p style="font-size:28px;font-weight:800;color:#fff;margin-bottom:16px;">Rp {{ number_format($user->saldo, 0, ',', '.') }}</p>
                        <div style="display:flex;gap:11px;">
                            <button class="action-btn btn-topup" onclick="openTopup()">
                                <svg width="15" height="15" fill="none" stroke="#16a34a" stroke-width="2.5"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                Top Up
                            </button>
                            <button class="action-btn btn-tarik" onclick="openTarik()">
                                <svg width="15" height="15" fill="none" stroke="#fff" stroke-width="2.5"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7 17L17 7M17 7H7m10 0v10" />
                                </svg>
                                Tarik
                            </button>
                        </div>
                    </div>
                </div>

                <!-- WHITE CARD -->
                <div class="white-card">
                    <p style="font-size:15px;font-weight:800;color:#111827;margin-bottom:4px;">Riwayat Transaksi</p>

                    <div id="txnList">
                        @forelse($riwayat as $trx)
                            @php
                                $isPending = $trx['status'] === 'pending';
                                $isRejected = $trx['status'] === 'rejected';
                                $isIncome = $trx['type'] === 'topup' || $trx['type'] === 'income';
                                $iconBg = $isPending ? '#fef9c3' : ($isRejected ? '#fee2e2' : ($isIncome ? '#dcfce7' : '#fee2e2'));
                                $iconStroke = $isPending ? '#ca8a04' : ($isRejected ? '#ef4444' : ($isIncome ? '#16a34a' : '#ef4444'));
                                $amtColor = $isPending ? '#ca8a04' : ($isRejected ? '#9ca3af' : ($isIncome ? '#16a34a' : '#ef4444'));
                                $txnData = json_encode([
                                    'id' => $trx['id'],
                                    'type' => $trx['type'],
                                    'title' => $trx['title'],
                                    'date' => $trx['date'],
                                    'amount' => $trx['amount'],
                                    'status' => $trx['status'],
                                    'method' => $trx['method'],
                                    'alasan_penolakan' => $trx['alasan_penolakan'],
                                ]);
                            @endphp
                            <div class="txn-item" data-txn="{!! htmlspecialchars($txnData, ENT_QUOTES, 'UTF-8') !!}">
                                <div class="txn-icon" style="background:{{ $iconBg }};">
                                    @if($isPending)
                                        <svg width="18" height="18" fill="none" stroke="{{ $iconStroke }}" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @elseif($isRejected)
                                        <svg width="18" height="18" fill="none" stroke="{{ $iconStroke }}" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    @elseif($isIncome)
                                        <svg width="18" height="18" fill="none" stroke="{{ $iconStroke }}" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                        </svg>
                                    @else
                                        <svg width="18" height="18" fill="none" stroke="{{ $iconStroke }}" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7M12 3v18" />
                                        </svg>
                                    @endif
                                </div>
                                <div style="flex:1;">
                                    <p style="font-size:13px;font-weight:700;color:#111827;">{{ $trx['title'] }}</p>
                                    <p style="font-size:11px;color:#9ca3af;margin-top:2px;">{{ $trx['date'] }}</p>
                                </div>
                                <div style="text-align:right;">
                                    <p style="font-size:13px;font-weight:700;color:{{ $amtColor }};{{ $isRejected ? 'text-decoration:line-through;' : '' }}">{{ $trx['amount'] }}</p>
                                    @if($isPending)
                                        <span class="badge-pending" style="font-size:10px;">Proses</span>
                                    @elseif($isRejected)
                                        <span class="badge-rejected" style="font-size:10px;">Ditolak</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div style="text-align:center;padding:40px 0;">
                                <svg width="48" height="48" fill="none" stroke="#d1d5db" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 12px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                <p style="font-size:14px;font-weight:700;color:#9ca3af;">Belum ada transaksi</p>
                                <p style="font-size:12px;color:#d1d5db;margin-top:4px;">Lakukan top up atau jual sampah untuk memulai</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div><!-- scroll-area -->

        <!-- NAV -->
        @include('pelanggan.partials.navigation')

        <!-- ════ MODAL 1: TOP UP NOMINAL ════ -->
        <div class="overlay" id="m_topup" onclick="backdropClose(event,'m_topup')">
            <div class="sheet">
                <div class="handle"></div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;">
                    <p style="font-size:17px;font-weight:800;color:#111827;">Top Up Saldo</p>
                    <button onclick="closeM('m_topup')"
                        style="width:32px;height:32px;border-radius:50%;background:#f3f4f6;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                        <svg width="16" height="16" fill="none" stroke="#6b7280" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <p style="font-size:12px;font-weight:600;color:#6b7280;margin-bottom:8px;">Nominal</p>
                <div class="field-wrap">
                    <span style="font-size:15px;font-weight:700;color:#9ca3af;">Rp</span>
                    <input type="number" id="nominalInput" placeholder="0" min="0" oninput="onNominal()" />
                </div>
                <div style="display:flex;gap:8px;margin-top:12px;">
                    <button class="quick-chip" onclick="setNominal(10000,this)">10K</button>
                    <button class="quick-chip" onclick="setNominal(25000,this)">25K</button>
                    <button class="quick-chip" onclick="setNominal(50000,this)">50K</button>
                    <button class="quick-chip" onclick="setNominal(100000,this)">100K</button>
                </div>
                <button class="green-btn" id="btnNextTopup" onclick="openPayMethod()" disabled>Top Up
                    Sekarang</button>
            </div>
        </div>

        <!-- ════ MODAL 2: PILIH METODE ════ -->
        <div class="overlay" id="m_paymethod" onclick="backdropClose(event,'m_paymethod')">
            <div class="sheet">
                <div class="handle"></div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;">
                    <p style="font-size:17px;font-weight:800;color:#111827;">Pilih Metode Pembayaran</p>
                    <button onclick="closeM('m_paymethod')"
                        style="width:32px;height:32px;border-radius:50%;background:#f3f4f6;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                        <svg width="16" height="16" fill="none" stroke="#6b7280" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <p style="font-size:12px;color:#9ca3af;margin-bottom:16px;" id="pm_subtitle">Top Up Rp 0</p>

                <p class="section-label">E-Wallet</p>
                <div class="pay-opt" onclick="selectMethod(this,'GoPay')">
                    <div class="pay-icon-box" style="background:#00AED6;"><span style="color:#fff;font-weight:800;font-size:15px;">G</span></div>
                    <div>
                        <p style="font-size:13px;font-weight:700;color:#111827;">GoPay</p>
                        <p style="font-size:11px;color:#9ca3af;">E-Wallet</p>
                    </div>
                    <div class="pay-radio"><div class="pay-dot"></div></div>
                </div>
                <div class="pay-opt" onclick="selectMethod(this,'OVO')">
                    <div class="pay-icon-box" style="background:#4C3494;"><span style="color:#fff;font-weight:800;font-size:15px;">O</span></div>
                    <div>
                        <p style="font-size:13px;font-weight:700;color:#111827;">OVO</p>
                        <p style="font-size:11px;color:#9ca3af;">E-Wallet</p>
                    </div>
                    <div class="pay-radio"><div class="pay-dot"></div></div>
                </div>
                <div class="pay-opt" onclick="selectMethod(this,'DANA')">
                    <div class="pay-icon-box" style="background:#108BE3;"><span style="color:#fff;font-weight:800;font-size:15px;">D</span></div>
                    <div>
                        <p style="font-size:13px;font-weight:700;color:#111827;">DANA</p>
                        <p style="font-size:11px;color:#9ca3af;">E-Wallet</p>
                    </div>
                    <div class="pay-radio"><div class="pay-dot"></div></div>
                </div>

                <p class="section-label">Transfer Bank</p>
                <div class="pay-opt" onclick="selectMethod(this,'BCA Virtual Account')">
                    <div class="pay-icon-box" style="background:#0066AE;"><span style="color:#fff;font-weight:800;font-size:11px;">BCA</span></div>
                    <div>
                        <p style="font-size:13px;font-weight:700;color:#111827;">BCA Virtual Account</p>
                        <p style="font-size:11px;color:#9ca3af;">Transfer antar bank</p>
                    </div>
                    <div class="pay-radio"><div class="pay-dot"></div></div>
                </div>
                <div class="pay-opt" onclick="selectMethod(this,'Mandiri Virtual Account')">
                    <div class="pay-icon-box" style="background:#003D79;"><span style="color:#fff;font-weight:800;font-size:9px;">MANDIRI</span></div>
                    <div>
                        <p style="font-size:13px;font-weight:700;color:#111827;">Mandiri Virtual Account</p>
                        <p style="font-size:11px;color:#9ca3af;">Transfer antar bank</p>
                    </div>
                    <div class="pay-radio"><div class="pay-dot"></div></div>
                </div>

                <button class="green-btn" id="btnBayar" onclick="openBankDetail()" disabled>Lanjut Bayar</button>
            </div>
        </div>

        <!-- ════ MODAL 3: DETAIL BANK + UPLOAD BUKTI ════ -->
        <div class="overlay" id="m_bankdetail" onclick="backdropClose(event,'m_bankdetail')">
            <div class="sheet">
                <div class="handle"></div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                    <p style="font-size:17px;font-weight:800;color:#111827;">Tujuan Pembayaran</p>
                    <button onclick="closeM('m_bankdetail')"
                        style="width:32px;height:32px;border-radius:50%;background:#f3f4f6;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                        <svg width="16" height="16" fill="none" stroke="#6b7280" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Nominal badge -->
                <div
                    style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:13px 16px;margin-bottom:16px;display:flex;justify-content:space-between;align-items:center;">
                    <span style="font-size:12px;color:#6b7280;font-weight:500;">Total Transfer</span>
                    <span style="font-size:17px;font-weight:800;color:#16a34a;" id="bd_amount">Rp 0</span>
                </div>

                <!-- Bank detail box -->
                <div class="bank-detail" id="bankDetailBox"></div>

                <!-- Warning -->
                <div
                    style="background:#fffbeb;border:1px solid #fde68a;border-radius:11px;padding:11px 14px;margin-bottom:16px;display:flex;gap:9px;align-items:flex-start;">
                    <span style="font-size:15px;flex-shrink:0;">⚠️</span>
                    <p style="font-size:11.5px;color:#92400e;line-height:1.55;">Pastikan nominal transfer
                        <strong>tepat</strong> sesuai jumlah di atas. Setelah transfer, upload bukti pembayaran di bawah
                        ini.</p>
                </div>

                <!-- Upload -->
                <form id="topupForm" action="{{ route('pelanggan.dompet.topup') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="jumlah" id="formTopupJumlah" />
                    <input type="hidden" name="metode_pembayaran" id="formTopupMetode" />

                    <p style="font-size:12px;font-weight:600;color:#374151;margin-bottom:8px;">Upload Bukti Pembayaran</p>
                    <div class="upload-area" id="uploadArea" onclick="document.getElementById('fileInput').click()">
                        <input type="file" id="fileInput" name="bukti_pembayaran" accept="image/*" style="display:none;"
                            onchange="onFileSelect(event)" />
                        <div id="uploadPlaceholder">
                            <svg width="28" height="28" fill="none" stroke="#9ca3af" stroke-width="1.8"
                                viewBox="0 0 24 24" style="margin:0 auto 8px;display:block;">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p style="font-size:12.5px;font-weight:600;color:#6b7280;">Tap untuk pilih foto / screenshot
                            </p>
                            <p style="font-size:11px;color:#9ca3af;margin-top:3px;">JPG, PNG maks. 5MB</p>
                        </div>
                        <div id="uploadPreview" style="display:none;">
                            <svg width="24" height="24" fill="none" stroke="#16a34a" stroke-width="2.5"
                                viewBox="0 0 24 24" style="margin:0 auto 6px;display:block;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <p style="font-size:12.5px;font-weight:700;color:#16a34a;" id="fileName">foto.jpg</p>
                            <p style="font-size:11px;color:#9ca3af;margin-top:2px;">Tap untuk ganti</p>
                        </div>
                    </div>

                    <button type="submit" class="green-btn" id="btnKonfirmasi" disabled>Konfirmasi Pembayaran</button>
                </form>
            </div>
        </div>

        <!-- ════ MODAL 4: SUKSES TOP UP ════ -->
        <div class="overlay" id="m_success">
            <div class="sheet" style="text-align:center;padding-bottom:44px;">
                <div class="handle"></div>
                <div class="pop-in"
                    style="width:76px;height:76px;background:#fef9c3;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:10px auto 18px;">
                    <svg width="36" height="36" fill="none" stroke="#ca8a04" stroke-width="2.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="su1" style="font-size:19px;font-weight:800;color:#111827;margin-bottom:5px;">Permintaan
                    Dikirim!</p>
                <p class="su2" style="font-size:13px;color:#6b7280;margin-bottom:3px;" id="s_amount">Top up sedang
                    menunggu konfirmasi admin</p>
                <p class="su3" style="font-size:12px;color:#9ca3af;margin-bottom:22px;" id="s_method">via GoPay
                </p>
                <div class="su4"
                    style="background:#fffbeb;border:1px solid #fde68a;border-radius:13px;padding:14px 18px;margin-bottom:22px;">
                    <p style="font-size:11px;color:#92400e;margin-bottom:4px;">⏳ Estimasi Proses</p>
                    <p style="font-size:14px;font-weight:800;color:#92400e;">1×24 jam kerja</p>
                </div>
                <button class="green-btn" style="margin-top:0;" onclick="closeM('m_success')">Kembali ke Dompet</button>
            </div>
        </div>

        <!-- ════ MODAL 5: DETAIL TRANSAKSI ════ -->
        <div class="overlay" id="m_txndetail" onclick="backdropClose(event,'m_txndetail')">
            <div class="sheet">
                <div class="handle"></div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;">
                    <p style="font-size:17px;font-weight:800;color:#111827;">Detail Transaksi</p>
                    <button onclick="closeM('m_txndetail')"
                        style="width:32px;height:32px;border-radius:50%;background:#f3f4f6;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                        <svg width="16" height="16" fill="none" stroke="#6b7280" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div id="txnDetailContent"></div>
            </div>
        </div>

        <!-- ════ MODAL 6: TARIK SALDO ════ -->
        <div class="overlay" id="m_tarik" onclick="backdropClose(event,'m_tarik')">
            <div class="sheet">
                <div class="handle"></div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;">
                    <p style="font-size:17px;font-weight:800;color:#111827;">Tarik Saldo</p>
                    <button onclick="closeM('m_tarik')"
                        style="width:32px;height:32px;border-radius:50%;background:#f3f4f6;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                        <svg width="16" height="16" fill="none" stroke="#6b7280" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div
                    style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:12px 16px;margin-bottom:18px;display:flex;justify-content:space-between;">
                    <span style="font-size:12px;color:#6b7280;">Saldo Tersedia</span>
                    <span style="font-size:13px;font-weight:800;color:#16a34a;">Rp {{ number_format($user->saldo, 0, ',', '.') }}</span>
                </div>

                @if($rekening)
                    <!-- Punya rekening — tampilkan info -->
                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:14px 16px;margin-bottom:16px;">
                        <p style="font-size:11px;color:#9ca3af;font-weight:600;margin-bottom:6px;">Tujuan Penarikan</p>
                        <p style="font-size:14px;font-weight:700;color:#111827;">{{ $rekening->nama_bank }} — {{ $rekening->nomor_rekening }}</p>
                        <p style="font-size:12px;color:#6b7280;">{{ $rekening->nama_rekening }}</p>
                    </div>

                    <form action="{{ route('pelanggan.dompet.tarik') }}" method="POST" id="tarikForm">
                        @csrf
                        <p style="font-size:12px;font-weight:600;color:#6b7280;margin-bottom:8px;">Jumlah Penarikan</p>
                        <div class="field-wrap">
                            <span style="font-size:15px;font-weight:700;color:#9ca3af;">Rp</span>
                            <input type="number" id="tarikInput" name="jumlah" placeholder="0" min="10000"
                                max="{{ $user->saldo }}" oninput="onTarikChange()" />
                        </div>
                        <div style="display:flex;gap:8px;margin-top:12px;">
                            <button type="button" class="quick-chip" onclick="setTarik(25000,this)">25K</button>
                            <button type="button" class="quick-chip" onclick="setTarik(50000,this)">50K</button>
                            <button type="button" class="quick-chip" onclick="setTarik(100000,this)">100K</button>
                            <button type="button" class="quick-chip" onclick="setTarikAll(this)">Semua</button>
                        </div>

                        <button type="submit" class="green-btn" id="btnTarik" disabled>Tarik Saldo</button>
                    </form>
                @else
                    <!-- Belum punya rekening — form tambah rekening -->
                    <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:12px;padding:14px;margin-bottom:16px;display:flex;gap:9px;align-items:flex-start;">
                        <span style="font-size:16px;flex-shrink:0;">⚠️</span>
                        <p style="font-size:12px;color:#92400e;line-height:1.5;">Anda belum memiliki rekening terdaftar. Silakan tambahkan rekening terlebih dahulu untuk melakukan penarikan saldo.</p>
                    </div>
                    <form action="{{ route('pelanggan.dompet.rekening') }}" method="POST">
                        @csrf
                        <p style="font-size:12px;font-weight:600;color:#6b7280;margin-bottom:8px;">Tambah Rekening</p>
                        <select name="nama_bank" class="rek-input" required>
                            <option value="">Pilih Bank</option>
                            <option value="BCA">BCA</option>
                            <option value="Mandiri">Mandiri</option>
                            <option value="BNI">BNI</option>
                            <option value="BRI">BRI</option>
                            <option value="CIMB Niaga">CIMB Niaga</option>
                            <option value="DANA">DANA</option>
                            <option value="GoPay">GoPay</option>
                            <option value="OVO">OVO</option>
                        </select>
                        <input type="text" name="nomor_rekening" class="rek-input" placeholder="Nomor Rekening" required />
                        <input type="text" name="nama_rekening" class="rek-input" placeholder="Nama Pemilik Rekening" required />
                        <button type="submit" class="green-btn" style="margin-top:8px;">Simpan Rekening</button>
                    </form>
                @endif
            </div>
        </div>

        <!-- ════ MODAL 7: TARIK PROSES ════ -->
        <div class="overlay" id="m_tarikproses">
            <div class="sheet" style="text-align:center;padding-bottom:44px;">
                <div class="handle"></div>
                <div class="pop-in"
                    style="width:76px;height:76px;background:#fef9c3;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:10px auto 18px;">
                    <svg width="36" height="36" fill="none" stroke="#ca8a04" stroke-width="2.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="su1" style="font-size:19px;font-weight:800;color:#111827;margin-bottom:6px;">Permintaan
                    Dikirim!</p>
                <p class="su2" style="font-size:13px;color:#6b7280;margin-bottom:18px;line-height:1.6;">Penarikan
                    saldo sedang diproses dan<br />menunggu persetujuan admin.</p>
                @if($rekening)
                <div class="su3"
                    style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:13px;padding:13px 18px;margin-bottom:22px;">
                    <p style="font-size:11px;color:#6b7280;margin-bottom:4px;">Tujuan</p>
                    <p style="font-size:13px;font-weight:700;color:#111827;">{{ $rekening->nama_bank }} — {{ $rekening->nomor_rekening }}</p>
                    <p style="font-size:11px;color:#9ca3af;">{{ $rekening->nama_rekening }}</p>
                </div>
                @endif
                <button class="green-btn su4" style="margin-top:0;" onclick="closeM('m_tarikproses')">Kembali ke
                    Dompet</button>
            </div>
        </div>

        <!-- ════ MODAL: EDIT REKENING ════ -->
        <div class="overlay" id="m_editrek" onclick="backdropClose(event,'m_editrek')">
            <div class="sheet">
                <div class="handle"></div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;">
                    <p style="font-size:17px;font-weight:800;color:#111827;">Edit Rekening</p>
                    <button onclick="closeM('m_editrek')"
                        style="width:32px;height:32px;border-radius:50%;background:#f3f4f6;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                        <svg width="16" height="16" fill="none" stroke="#6b7280" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form action="{{ route('pelanggan.dompet.rekening') }}" method="POST">
                    @csrf
                    <select name="nama_bank" class="rek-input" required>
                        <option value="">Pilih Bank</option>
                        <option value="BCA" {{ ($rekening->nama_bank ?? '') === 'BCA' ? 'selected' : '' }}>BCA</option>
                        <option value="Mandiri" {{ ($rekening->nama_bank ?? '') === 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                        <option value="BNI" {{ ($rekening->nama_bank ?? '') === 'BNI' ? 'selected' : '' }}>BNI</option>
                        <option value="BRI" {{ ($rekening->nama_bank ?? '') === 'BRI' ? 'selected' : '' }}>BRI</option>
                        <option value="CIMB Niaga" {{ ($rekening->nama_bank ?? '') === 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                        <option value="DANA" {{ ($rekening->nama_bank ?? '') === 'DANA' ? 'selected' : '' }}>DANA</option>
                        <option value="GoPay" {{ ($rekening->nama_bank ?? '') === 'GoPay' ? 'selected' : '' }}>GoPay</option>
                        <option value="OVO" {{ ($rekening->nama_bank ?? '') === 'OVO' ? 'selected' : '' }}>OVO</option>
                    </select>
                    <input type="text" name="nomor_rekening" class="rek-input" placeholder="Nomor Rekening" value="{{ $rekening->nomor_rekening ?? '' }}" required />
                    <input type="text" name="nama_rekening" class="rek-input" placeholder="Nama Pemilik Rekening" value="{{ $rekening->nama_rekening ?? '' }}" required />
                    <button type="submit" class="green-btn" style="margin-top:8px;">Simpan Perubahan</button>
                </form>
            </div>
        </div>

    </div><!-- phone-wrapper -->

    <script>
        const balance = {{ $user->saldo }};
        let topupAmount = 0;
        let selectedPayLabel = '';

        const fmt = n => 'Rp ' + n.toLocaleString('id-ID');

        function openM(id) {
            document.getElementById(id).classList.add('open');
        }

        function closeM(id) {
            document.getElementById(id).classList.remove('open');
        }

        function backdropClose(e, id) {
            if (e.target === document.getElementById(id)) closeM(id);
        }

        /* ── TOP UP ── */
        function openTopup() {
            document.getElementById('nominalInput').value = '';
            topupAmount = 0;
            document.getElementById('btnNextTopup').disabled = true;
            document.querySelectorAll('#m_topup .quick-chip').forEach(c => c.classList.remove('active'));
            openM('m_topup');
        }

        function onNominal() {
            topupAmount = parseInt(document.getElementById('nominalInput').value) || 0;
            document.getElementById('btnNextTopup').disabled = topupAmount < 10000;
            document.querySelectorAll('#m_topup .quick-chip').forEach(c => c.classList.remove('active'));
        }

        function setNominal(v, el) {
            topupAmount = v;
            document.getElementById('nominalInput').value = v;
            document.getElementById('btnNextTopup').disabled = false;
            document.querySelectorAll('#m_topup .quick-chip').forEach(c => c.classList.remove('active'));
            el.classList.add('active');
        }

        /* ── PAY METHOD ── */
        function openPayMethod() {
            if (topupAmount < 10000) return;
            closeM('m_topup');
            selectedPayLabel = '';
            document.querySelectorAll('#m_paymethod .pay-opt').forEach(o => o.classList.remove('selected'));
            document.getElementById('btnBayar').disabled = true;
            document.getElementById('pm_subtitle').textContent = 'Top Up ' + fmt(topupAmount);
            setTimeout(() => openM('m_paymethod'), 180);
        }

        function selectMethod(el, label) {
            selectedPayLabel = label;
            document.querySelectorAll('#m_paymethod .pay-opt').forEach(o => o.classList.remove('selected'));
            el.classList.add('selected');
            document.getElementById('btnBayar').disabled = false;
        }

        /* ── BANK DETAIL ── */
        const bankInfo = {
            'GoPay': { type: 'ewallet', acc: '081234567890', holder: 'GoGarbage Official', note: 'Kirim ke nomor GoPay di atas' },
            'OVO': { type: 'ewallet', acc: '082234567890', holder: 'GoGarbage Official', note: 'Kirim ke nomor OVO di atas' },
            'DANA': { type: 'ewallet', acc: '083234567890', holder: 'GoGarbage Official', note: 'Kirim ke nomor DANA di atas' },
            'BCA Virtual Account': { type: 'bank', acc: '8001234567890', holder: 'GoGarbage Indonesia', note: 'Kode bank BCA: 014' },
            'Mandiri Virtual Account': { type: 'bank', acc: '8911234567890', holder: 'GoGarbage Indonesia', note: 'Kode bank Mandiri: 008' },
        };

        function openBankDetail() {
            closeM('m_paymethod');
            const info = bankInfo[selectedPayLabel];
            document.getElementById('bd_amount').textContent = fmt(topupAmount);
            document.getElementById('formTopupJumlah').value = topupAmount;
            document.getElementById('formTopupMetode').value = selectedPayLabel;
            const isBank = info.type === 'bank';
            document.getElementById('bankDetailBox').innerHTML = `
      <p style="font-size:13px;font-weight:700;color:#111827;margin-bottom:12px;">${selectedPayLabel}</p>
      <div class="bank-row">
        <div><p style="font-size:10.5px;color:#9ca3af;">${isBank?'No. Virtual Account':'Nomor Akun'}</p><p style="font-size:14px;font-weight:800;color:#111827;letter-spacing:.03em;">${info.acc}</p></div>
        <button class="copy-btn" onclick="copyText('${info.acc}',this)">Salin</button>
      </div>
      <div class="bank-row">
        <div><p style="font-size:10.5px;color:#9ca3af;">Atas Nama</p><p style="font-size:13px;font-weight:700;color:#111827;">${info.holder}</p></div>
      </div>
      <div class="bank-row">
        <div><p style="font-size:10.5px;color:#9ca3af;">Nominal Transfer</p><p style="font-size:13px;font-weight:800;color:#16a34a;">${fmt(topupAmount)}</p></div>
        <button class="copy-btn" onclick="copyText('${topupAmount}',this)">Salin</button>
      </div>
      <div style="background:#f0fdf4;border-radius:8px;padding:8px 10px;margin-top:8px;">
        <p style="font-size:11px;color:#16a34a;font-weight:600;">ℹ️ ${info.note}</p>
      </div>`;
            // reset upload
            document.getElementById('uploadPlaceholder').style.display = 'block';
            document.getElementById('uploadPreview').style.display = 'none';
            document.getElementById('uploadArea').classList.remove('has-file');
            document.getElementById('btnKonfirmasi').disabled = true;
            setTimeout(() => openM('m_bankdetail'), 180);
        }

        function copyText(txt, btn) {
            navigator.clipboard.writeText(txt).catch(() => {});
            btn.textContent = '✓ Disalin';
            setTimeout(() => btn.textContent = 'Salin', 1800);
        }

        function onFileSelect(e) {
            const f = e.target.files[0];
            if (!f) return;
            document.getElementById('uploadPlaceholder').style.display = 'none';
            document.getElementById('fileName').textContent = f.name;
            document.getElementById('uploadPreview').style.display = 'block';
            document.getElementById('uploadArea').classList.add('has-file');
            document.getElementById('btnKonfirmasi').disabled = false;
        }

        /* ── TXN DETAIL ── */
        function showTxnDetail(el) {
            const d = JSON.parse(el.getAttribute('data-txn'));
            const isPending = d.status === 'pending';
            const isRejected = d.status === 'rejected';
            const isIncome = d.type === 'income' || d.type === 'topup';
            const amtColor = isPending ? '#ca8a04' : (isRejected ? '#9ca3af' : (isIncome ? '#16a34a' : '#ef4444'));
            const badge = isPending
                ? `<span class="badge-pending">Menunggu Persetujuan Admin</span>`
                : (isRejected
                    ? `<span class="badge-rejected">Ditolak</span>`
                    : (isIncome ? `<span class="badge-success">Berhasil</span>` : `<span class="badge-debit">Selesai</span>`));

            let infoBox = '';
            if (isPending) {
                infoBox = `<div style="background:#fffbeb;border:1px solid #fde68a;border-radius:12px;padding:13px 15px;margin-top:14px;">
        <div style="display:flex;gap:9px;align-items:flex-start;">
          <span style="font-size:16px;flex-shrink:0;">⏳</span>
          <div>
            <p style="font-size:13px;font-weight:700;color:#92400e;margin-bottom:4px;">Sedang Diproses</p>
            <p style="font-size:12px;color:#92400e;line-height:1.6;">Transaksi ini sedang menunggu konfirmasi dari admin. Estimasi proses 1×24 jam kerja.</p>
          </div>
        </div>
      </div>`;
            }
            if (isRejected && d.alasan_penolakan) {
                infoBox = `<div style="background:#fee2e2;border:1px solid #fca5a5;border-radius:12px;padding:13px 15px;margin-top:14px;">
        <div style="display:flex;gap:9px;align-items:flex-start;">
          <span style="font-size:16px;flex-shrink:0;">❌</span>
          <div>
            <p style="font-size:13px;font-weight:700;color:#b91c1c;margin-bottom:4px;">Ditolak</p>
            <p style="font-size:12px;color:#b91c1c;line-height:1.6;">Alasan: ${d.alasan_penolakan}</p>
          </div>
        </div>
      </div>`;
            }

            document.getElementById('txnDetailContent').innerHTML = `
      <div style="text-align:center;margin-bottom:20px;">
        <div style="width:60px;height:60px;background:${isPending?'#fef9c3':(isRejected?'#fee2e2':(isIncome?'#dcfce7':'#fee2e2'))};border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
          <svg width="26" height="26" fill="none" stroke="${amtColor}" stroke-width="2.5" viewBox="0 0 24 24">
            ${isPending?'<path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>'
              :isRejected?'<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>'
              :isIncome?'<path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>'
              :'<path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7M12 3v18"/>'}
          </svg>
        </div>
        <p style="font-size:22px;font-weight:800;color:${amtColor};${isRejected?'text-decoration:line-through;':''}">${d.amount}</p>
        <p style="font-size:13px;color:#6b7280;margin-top:3px;">${d.title}</p>
      </div>
      <div style="background:#f8fafc;border-radius:14px;padding:16px;">
        <div style="display:flex;justify-content:space-between;align-items:center;padding:9px 0;border-bottom:1px solid #f1f5f9;">
          <span style="font-size:12px;color:#9ca3af;">ID Transaksi</span>
          <span style="font-size:12.5px;font-weight:700;color:#111827;">#${d.id}</span>
        </div>
        <div style="display:flex;justify-content:space-between;align-items:center;padding:9px 0;border-bottom:1px solid #f1f5f9;">
          <span style="font-size:12px;color:#9ca3af;">Tanggal</span>
          <span style="font-size:12.5px;font-weight:700;color:#111827;">${d.date}</span>
        </div>
        <div style="display:flex;justify-content:space-between;align-items:center;padding:9px 0;border-bottom:1px solid #f1f5f9;">
          <span style="font-size:12px;color:#9ca3af;">Metode</span>
          <span style="font-size:12.5px;font-weight:700;color:#111827;">${d.method}</span>
        </div>
        <div style="display:flex;justify-content:space-between;align-items:center;padding:9px 0;">
          <span style="font-size:12px;color:#9ca3af;">Status</span>
          ${badge}
        </div>
      </div>
      ${infoBox}`;
            openM('m_txndetail');
        }

        /* ── TARIK SALDO ── */
        function openTarik() {
            const tarikInput = document.getElementById('tarikInput');
            if (tarikInput) {
                tarikInput.value = '';
            }
            const btnTarik = document.getElementById('btnTarik');
            if (btnTarik) {
                btnTarik.disabled = true;
            }
            document.querySelectorAll('#m_tarik .quick-chip').forEach(c => c.classList.remove('active'));
            openM('m_tarik');
        }

        function onTarikChange() {
            const val = parseInt(document.getElementById('tarikInput').value) || 0;
            checkTarikBtn(val);
            document.querySelectorAll('#m_tarik .quick-chip').forEach(c => c.classList.remove('active'));
        }

        function setTarik(v, el) {
            const actual = Math.min(v, balance);
            document.getElementById('tarikInput').value = actual;
            document.querySelectorAll('#m_tarik .quick-chip').forEach(c => c.classList.remove('active'));
            el.classList.add('active');
            checkTarikBtn(actual);
        }

        function setTarikAll(el) {
            document.getElementById('tarikInput').value = balance;
            document.querySelectorAll('#m_tarik .quick-chip').forEach(c => c.classList.remove('active'));
            el.classList.add('active');
            checkTarikBtn(balance);
        }

        function checkTarikBtn(val) {
            const btn = document.getElementById('btnTarik');
            if (btn) {
                btn.disabled = !(val >= 10000 && val <= balance);
            }
        }
        /* ── CLICK DELEGATION for txn items ── */
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.txn-item[data-txn]').forEach(function(el) {
                el.addEventListener('click', function() {
                    showTxnDetail(this);
                });
            });
        });
    </script>
</body>

</html>

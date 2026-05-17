<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Konfirmasi Tunai Langganan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <style>
        * { font-family: 'Poppins', sans-serif; box-sizing: border-box; margin: 0; padding: 0; }
        body { background: #e8e8e8; display: flex; justify-content: center; min-height: 100vh; }
        .phone-wrapper { width: 390px; height: 100vh; background: #f2f3f7; position: relative; overflow: hidden; box-shadow: 0 0 48px rgba(0,0,0,0.18); display: flex; flex-direction: column; }
        @media (max-width: 390px) { body { background: #f2f3f7; } .phone-wrapper { width: 100%; box-shadow: none; } }
        .page-header { background: linear-gradient(135deg, #2ecc71 0%, #1aab57 60%, #168a45 100%); padding: 20px 20px 24px; flex-shrink: 0; }
        .scroll-area { flex: 1; overflow-y: auto; overflow-x: hidden; -webkit-overflow-scrolling: touch; scrollbar-width: none; }
        .scroll-area::-webkit-scrollbar { display: none; }
        .nav-bottom { height: 64px; background: #fff; border-top: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: space-around; flex-shrink: 0; }
        .nav-btn { display: flex; flex-direction: column; align-items: center; gap: 3px; padding-top: 4px; cursor: pointer; text-decoration: none; }
    </style>
</head>

<body>
    <div class="phone-wrapper">

        <!-- HEADER -->
        <div class="page-header">
            <div style="display:flex;align-items:center;gap:14px;">
                <a href="{{ route('juru-angkut.index') }}"
                    style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;text-decoration:none;">
                    <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 style="font-size:17px;font-weight:700;color:#fff;">Langganan Tunai</h1>
                    <p style="font-size:11.5px;color:rgba(255,255,255,0.78);font-weight:500;">Konfirmasi pembayaran tunai pelanggan</p>
                </div>
            </div>
        </div>

        <!-- SUCCESS MESSAGE -->
        @if(session('success'))
        <div style="margin:12px 14px 0;background:#dcfce7;border:1px solid #86efac;border-radius:12px;padding:12px 16px;display:flex;align-items:center;gap:10px;">
            <svg width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p style="font-size:12px;font-weight:600;color:#15803d;">{{ session('success') }}</p>
        </div>
        @endif

        <!-- SCROLL AREA -->
        <div class="scroll-area">
            <div style="padding: 14px 0 24px;">

                @forelse($langgananTunai as $item)
                <div style="background:#fff;border-radius:18px;margin:0 14px 12px;padding:16px;box-shadow:0 2px 12px rgba(0,0,0,0.06);">
                    <!-- Header -->
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:38px;height:38px;background:#fef3c7;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                                <svg width="18" height="18" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p style="font-size:13px;font-weight:700;color:#111827;">{{ $item->pengguna->name ?? 'Pelanggan' }}</p>
                                <p style="font-size:10.5px;color:#9ca3af;font-weight:500;">{{ $item->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        <span style="font-size:10.5px;font-weight:700;color:#d97706;background:#fef3c7;padding:4px 10px;border-radius:20px;">Menunggu Tunai</span>
                    </div>

                    <!-- Paket Info -->
                    <div style="background:#f9fafb;border-radius:12px;padding:12px 14px;margin-bottom:12px;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                            <span style="font-size:12px;color:#6b7280;font-weight:500;">Paket</span>
                            <span style="font-size:13px;font-weight:700;color:#111827;">{{ $item->paket->nama ?? '-' }}</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                            <span style="font-size:12px;color:#6b7280;font-weight:500;">Durasi</span>
                            <span style="font-size:13px;font-weight:600;color:#111827;">{{ $item->paket->durasi_hari ?? '-' }} hari</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;">
                            <span style="font-size:12px;color:#6b7280;font-weight:500;">Jumlah Bayar</span>
                            <span style="font-size:14px;font-weight:800;color:#16a34a;">Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Confirm Button -->
                    <form action="{{ route('juru-angkut.langganan-tunai.konfirmasi', $item->id) }}" method="POST"
                        onsubmit="return confirm('Konfirmasi bahwa pelanggan {{ $item->pengguna->name ?? '' }} sudah membayar Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }} secara tunai?')">
                        @csrf
                        <button type="submit"
                            style="width:100%;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;font-size:13px;font-weight:700;padding:13px;border-radius:12px;border:none;cursor:pointer;transition:opacity 0.2s;">
                            ✅ Konfirmasi Tunai Diterima
                        </button>
                    </form>
                </div>
                @empty
                <div style="margin:50px 16px;text-align:center;">
                    <svg width="56" height="56" fill="none" stroke="#d1d5db" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p style="font-size:16px;font-weight:700;color:#6b7280;margin-bottom:6px;">Tidak Ada Pembayaran Tunai</p>
                    <p style="font-size:13px;color:#9ca3af;">Semua pembayaran langganan tunai<br>sudah dikonfirmasi.</p>
                </div>
                @endforelse

            </div>
        </div><!-- end scroll-area -->

        <!-- NAV -->
        <div class="nav-bottom">
            <a href="{{ route('juru-angkut.index') }}" class="nav-btn">
                <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                </svg>
                <span style="font-size:10px;font-weight:500;color:#9ca3af;">Home</span>
            </a>
            <a href="{{ route('juru-angkut.order.index') }}" class="nav-btn">
                <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 11H4L5 9z"/>
                </svg>
                <span style="font-size:10px;font-weight:500;color:#9ca3af;">Order</span>
            </a>
            <a href="{{ route('juru-angkut.riwayat') }}" class="nav-btn">
                <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span style="font-size:10px;font-weight:500;color:#9ca3af;">History</span>
            </a>
            <a href="#" class="nav-btn">
                <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span style="font-size:10px;font-weight:500;color:#9ca3af;">Profile</span>
            </a>
        </div>

    </div>
</body>

</html>

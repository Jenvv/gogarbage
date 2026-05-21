<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Go Garbage – Riwayat Transaksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <style>
        * { font-family: 'Poppins', sans-serif; box-sizing: border-box; margin: 0; padding: 0; }
        body { background: #e8e8e8; display: flex; justify-content: center; min-height: 100vh; }
        .phone-wrapper { width: 390px; height: 100vh; background: #f2f3f7; position: relative; overflow: hidden; box-shadow: 0 0 48px rgba(0,0,0,0.18); display: flex; flex-direction: column; }
        @media (max-width: 390px) { body { background: #f2f3f7; } .phone-wrapper { width: 100%; box-shadow: none; } }
        .scroll-area { flex: 1; overflow-y: auto; overflow-x: hidden; -webkit-overflow-scrolling: touch; scrollbar-width: none; }
        .scroll-area::-webkit-scrollbar { display: none; }
        .header-green { background: linear-gradient(135deg, #2ecc71 0%, #1aab57 60%, #168a45 100%); padding: 24px 20px 72px; }
        .stat-card { background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); border-radius: 14px; padding: 12px 14px; flex: 1; }
        .float-card { background: #fff; border-radius: 22px; margin: -48px 16px 0; padding: 20px 18px 22px; box-shadow: 0 6px 28px rgba(0,0,0,0.09); position: relative; z-index: 10; }
        .tx-card { background: #fff; border-radius: 16px; padding: 16px 16px 14px; margin: 10px 16px 0; box-shadow: 0 2px 12px rgba(0,0,0,0.06); text-decoration: none; display: block; }
        .chip { display: inline-block; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 99px; background: #f3f4f6; color: #374151; }
        .chip-green { background: #dcfce7; color: #16a34a; }
        .chip-blue { background: #dbeafe; color: #2563eb; }
        .chip-orange { background: #ffedd5; color: #ea580c; }
        .chip-purple { background: #f3e8ff; color: #7c3aed; }
        .lunas-badge { display: inline-flex; align-items: center; gap: 5px; font-size: 11.5px; font-weight: 700; color: #16a34a; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 99px; padding: 4px 12px; }
        .belum-badge { display: inline-flex; align-items: center; gap: 5px; font-size: 11.5px; font-weight: 700; color: #dc2626; background: #fee2e2; border-radius: 99px; padding: 4px 12px; }
        .nav-bottom { height: 64px; background: #fff; border-top: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: space-around; flex-shrink: 0; }
        .nav-btn { display: flex; flex-direction: column; align-items: center; gap: 3px; padding-top: 4px; cursor: pointer; text-decoration: none; }
    </style>
</head>

<body>
    <div class="phone-wrapper">

        <div class="scroll-area">
            <div style="padding-bottom:28px;">

                <!-- ── GREEN HEADER ── -->
                <div class="header-green">
                    <div style="display:flex;align-items:center;gap:14px;margin-bottom:6px;">
                        <a href="{{ route('pengepul.index') }}"
                            style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;text-decoration:none;">
                            <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <h1 style="font-size:20px;font-weight:800;color:#fff;">Riwayat Transaksi</h1>
                    </div>
                    <p style="font-size:13px;color:rgba(255,255,255,0.82);padding-left:50px;margin-bottom:22px;">Semua transaksi selesai</p>

                    <div style="display:flex;gap:10px;">
                        <div class="stat-card">
                            <p style="font-size:11px;color:rgba(255,255,255,0.8);font-weight:500;margin-bottom:4px;">Bulan Ini</p>
                            <p style="font-size:22px;font-weight:800;color:#fff;line-height:1.1;">{{ $countBulanIni }}</p>
                            <p style="font-size:10px;color:rgba(255,255,255,0.7);margin-top:4px;">Transaksi</p>
                        </div>
                        <div class="stat-card">
                            <p style="font-size:11px;color:rgba(255,255,255,0.8);font-weight:500;margin-bottom:4px;">Total Berat</p>
                            <p style="font-size:22px;font-weight:800;color:#fff;line-height:1.1;">{{ number_format($beratBulanIni, 1, ',', '.') }}</p>
                            <p style="font-size:10px;color:rgba(255,255,255,0.7);margin-top:4px;">kg</p>
                        </div>
                        <div class="stat-card">
                            <p style="font-size:11px;color:rgba(255,255,255,0.8);font-weight:500;margin-bottom:4px;">Pengeluaran</p>
                            @php
                                $pengeluaranFormatted = $pengeluaranBulanIni >= 1000000
                                    ? 'Rp ' . number_format($pengeluaranBulanIni / 1000000, 1, ',', '.') . ' Jt'
                                    : 'Rp ' . number_format($pengeluaranBulanIni, 0, ',', '.');
                            @endphp
                            <p style="font-size:22px;font-weight:800;color:#fff;line-height:1.1;">{{ $pengeluaranFormatted }}</p>
                            <p style="font-size:10px;color:rgba(255,255,255,0.7);margin-top:4px;">Total</p>
                        </div>
                    </div>
                </div>

                <!-- ── SECTION LABEL ── -->
                @php
                    $grouped = $transaksi->groupBy(fn($t) => $t->created_at->translatedFormat('F Y'));
                @endphp

                @forelse($grouped as $bulan => $items)
                    <p style="font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.06em;margin:18px 16px 0;">
                        {{ $bulan }}
                    </p>

                    @php
                        $chipColors = ['chip-green', 'chip-blue', 'chip-orange', 'chip-purple'];
                    @endphp

                    @foreach($items as $tx)
                        <a href="{{ route('pengepul.riwayat.show', $tx->id) }}" class="tx-card">
                            <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:8px;">
                                <p style="font-size:14px;font-weight:800;color:#111827;">{{ $tx->nomor_invoice }}</p>
                                <span style="font-size:11.5px;color:#9ca3af;font-weight:500;white-space:nowrap;margin-top:2px;">{{ $tx->created_at->format('d M Y') }}</span>
                            </div>
                            <div style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:10px;">
                                @foreach($tx->detail as $di => $d)
                                    <span class="chip {{ $chipColors[$di % count($chipColors)] }}">{{ $d->kategori->nama ?? '-' }} {{ number_format($d->berat, 1, ',', '.') }}kg</span>
                                @endforeach
                            </div>
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                                <span style="font-size:12.5px;color:#6b7280;font-weight:500;">{{ number_format($tx->total_berat, 1, ',', '.') }} kg total</span>
                                <span style="font-size:15px;font-weight:800;color:#16a34a;">Rp {{ number_format($tx->total_harga, 0, ',', '.') }}</span>
                            </div>
                            @if($tx->status_pembayaran === 'lunas')
                                <span class="lunas-badge">
                                    <svg width="12" height="12" fill="none" stroke="#16a34a" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    Lunas
                                </span>
                            @else
                                <span class="belum-badge">Belum Bayar</span>
                            @endif
                        </a>
                    @endforeach
                @empty
                    <div style="background:#fff;border-radius:16px;padding:40px 16px;margin:16px;box-shadow:0 2px 12px rgba(0,0,0,0.06);text-align:center;">
                        <svg width="48" height="48" fill="none" stroke="#d1d5db" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 12px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p style="font-size:14px;color:#9ca3af;font-weight:600;">Belum ada riwayat transaksi</p>
                    </div>
                @endforelse

            </div>
        </div>

        @include('pengepul.partials.navigation')

    </div>
</body>

</html>

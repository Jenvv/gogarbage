<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Go Garbage – Stok Gudang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <style>
        * { font-family: 'Poppins', sans-serif; box-sizing: border-box; margin: 0; padding: 0; }
        body { background: #e8e8e8; display: flex; justify-content: center; min-height: 100vh; }
        .phone-wrapper { width: 390px; height: 100vh; background: #f2f3f7; position: relative; overflow: hidden; box-shadow: 0 0 48px rgba(0,0,0,0.18); display: flex; flex-direction: column; }
        @media (max-width: 390px) { body { background: #f2f3f7; } .phone-wrapper { width: 100%; box-shadow: none; } }
        .page-header { background: linear-gradient(135deg, #2ecc71 0%, #1aab57 60%, #168a45 100%); padding: 20px 20px 26px; display: flex; flex-direction: column; gap: 4px; flex-shrink: 0; }
        .scroll-area { flex: 1; overflow-y: auto; overflow-x: hidden; -webkit-overflow-scrolling: touch; scrollbar-width: none; }
        .scroll-area::-webkit-scrollbar { display: none; }
        .stat-bar { background: #fff; border-radius: 16px; margin: 16px 16px 0; padding: 14px 18px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .stat-item { display: flex; flex-direction: column; gap: 4px; }
        .stat-divider { width: 1px; height: 36px; background: #e5e7eb; }
        .cat-card { background: #fff; border-radius: 20px; padding: 18px 18px 16px; margin: 12px 16px 0; box-shadow: 0 2px 14px rgba(0,0,0,0.07); }
        .prog-track { height: 6px; background: #f3f4f6; border-radius: 99px; margin-top: 10px; overflow: hidden; flex: 1; }
        .prog-fill { height: 100%; border-radius: 99px; }
        .req-btn { width: 100%; background: #fff; font-size: 13px; font-weight: 700; font-family: 'Poppins', sans-serif; border-radius: 12px; padding: 12px; cursor: pointer; margin-top: 14px; display: flex; align-items: center; justify-content: center; gap: 6px; transition: opacity 0.2s, transform 0.15s; }
        .req-btn:active { transform: scale(0.97); }
        .nav-bottom { height: 64px; background: #fff; border-top: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: space-around; flex-shrink: 0; }
        .nav-btn { display: flex; flex-direction: column; align-items: center; gap: 3px; padding-top: 4px; cursor: pointer; text-decoration: none; }
    </style>
</head>

<body>
    <div class="phone-wrapper">

        <!-- ── HEADER ── -->
        <div class="page-header">
            <div style="display:flex;align-items:center;gap:14px;margin-bottom:4px;">
                <a href="{{ route('pengepul.index') }}"
                    style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;text-decoration:none;">
                    <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 style="font-size:20px;font-weight:800;color:#fff;">Stok Gudang</h1>
            </div>
            <p style="font-size:13px;color:rgba(255,255,255,0.82);font-weight:400;padding-left:50px;">Lihat ketersediaan stok sampah</p>
        </div>

        <!-- ── SCROLL AREA ── -->
        <div class="scroll-area">
            <div style="padding-bottom:28px;">

                <!-- ── STAT BAR ── -->
                <div class="stat-bar">
                    <div class="stat-item">
                        <span style="font-size:11px;color:#9ca3af;font-weight:500;">Total Kategori</span>
                        <span style="font-size:18px;font-weight:800;color:#111827;">{{ $kategori->count() }}</span>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <span style="font-size:11px;color:#9ca3af;font-weight:500;">Stok Tersedia</span>
                        <span style="font-size:18px;font-weight:800;color:#111827;">{{ number_format($totalStok, 1, ',', '.') }} kg</span>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <span style="font-size:11px;color:#9ca3af;font-weight:500;">Update</span>
                        <span style="font-size:18px;font-weight:800;color:#111827;">Hari ini</span>
                    </div>
                </div>

                <!-- ── KATEGORI SAMPAH ── -->
                <p style="font-size:16px;font-weight:800;color:#111827;margin:20px 16px 4px;">Kategori Sampah</p>

                @php
                    // Warna per index (cycle)
                    $colors = [
                        ['bg' => '#16a34a', 'text' => '#16a34a', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
                        ['bg' => '#3b82f6', 'text' => '#3b82f6', 'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'],
                        ['bg' => '#f97316', 'text' => '#f97316', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
                        ['bg' => '#7c3aed', 'text' => '#7c3aed', 'icon' => 'M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18'],
                    ];
                    $maxStok = $kategori->max(fn($k) => $k->stokGudang?->stok_kg ?? 0) ?: 1;
                @endphp

                @forelse($kategori as $idx => $kat)
                    @php
                        $c = $colors[$idx % count($colors)];
                        $stok = $kat->stokGudang?->stok_kg ?? 0;
                        $persen = round(($stok / $maxStok) * 100);
                    @endphp
                    <div class="cat-card">
                        <div style="display:flex;align-items:center;gap:14px;">
                            <div style="width:52px;height:52px;background:{{ $c['bg'] }};border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <svg width="26" height="26" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $c['icon'] }}" />
                                </svg>
                            </div>
                            <div style="flex:1;">
                                <div style="display:flex;align-items:center;justify-content:space-between;">
                                    <div>
                                        <p style="font-size:15px;font-weight:800;color:#111827;">{{ $kat->nama }}</p>
                                        <p style="font-size:11.5px;color:#9ca3af;font-weight:500;margin-top:2px;">Rp {{ number_format($kat->harga_per_kg, 0, ',', '.') }}/kg</p>
                                    </div>
                                    <span style="font-size:16px;font-weight:800;color:{{ $c['text'] }};">{{ number_format($stok, 1, ',', '.') }} kg</span>
                                </div>
                                <div style="display:flex;align-items:center;gap:10px;margin-top:10px;">
                                    <div class="prog-track">
                                        <div class="prog-fill" style="width:{{ $persen }}%;background:{{ $c['bg'] }};"></div>
                                    </div>
                                    <span style="font-size:10px;color:#9ca3af;font-weight:500;white-space:nowrap;">{{ $persen }}%</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('pengepul.request') }}" class="req-btn" style="border:2px solid {{ $c['text'] }};color:{{ $c['text'] }};text-decoration:none;">
                            <svg width="16" height="16" fill="none" stroke="{{ $c['text'] }}" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Request Ambil
                        </a>
                    </div>
                @empty
                    <div style="background:#fff;border-radius:16px;padding:24px 16px;margin:12px 16px;box-shadow:0 2px 12px rgba(0,0,0,0.06);text-align:center;">
                        <p style="font-size:13px;color:#9ca3af;font-weight:500;">Belum ada kategori sampah</p>
                    </div>
                @endforelse

            </div>
        </div>

        @include('pengepul.partials.navigation')

    </div>
</body>

</html>

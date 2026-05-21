<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Go Garbage – Detail Transaksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <style>
        * { font-family: 'Poppins', sans-serif; box-sizing: border-box; margin: 0; padding: 0; }
        body { background: #e8e8e8; display: flex; justify-content: center; min-height: 100vh; }
        .phone-wrapper { width: 390px; height: 100vh; background: #f2f3f7; position: relative; overflow: hidden; box-shadow: 0 0 48px rgba(0,0,0,0.18); display: flex; flex-direction: column; }
        @media (max-width: 390px) { body { background: #f2f3f7; } .phone-wrapper { width: 100%; box-shadow: none; } }
        .page-header { background: linear-gradient(135deg, #2ecc71 0%, #1aab57 60%, #168a45 100%); padding: 20px 20px 22px; flex-shrink: 0; }
        .scroll-area { flex: 1; overflow-y: auto; overflow-x: hidden; -webkit-overflow-scrolling: touch; scrollbar-width: none; }
        .scroll-area::-webkit-scrollbar { display: none; }
    </style>
</head>

<body>
    <div class="phone-wrapper">

        <!-- ── HEADER ── -->
        <div class="page-header">
            <div style="display:flex;align-items:center;gap:14px;">
                <a href="{{ route('pengepul.riwayat') }}"
                    style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;text-decoration:none;">
                    <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 style="font-size:20px;font-weight:800;color:#fff;">Detail Transaksi</h1>
            </div>
        </div>

        <!-- ── SCROLL AREA ── -->
        <div class="scroll-area">
            <div style="padding-bottom:28px;">

                <!-- ── INVOICE HEADER CARD ── -->
                <div style="background:#fff;border-radius:18px;margin:16px;padding:20px;box-shadow:0 4px 20px rgba(0,0,0,0.08);">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                        <p style="font-size:16px;font-weight:800;color:#111827;">{{ $penjualan->nomor_invoice }}</p>
                    </div>
                    <p style="font-size:12px;color:#9ca3af;font-weight:500;margin-bottom:14px;">
                        {{ $penjualan->created_at->format('d M Y · H:i') }} WIB
                    </p>

                    <!-- Status pills -->
                    <div style="display:flex;gap:8px;margin-bottom:16px;">
                        @php
                            $statusLabel = match($penjualan->status) {
                                'menunggu' => 'Menunggu',
                                'disetujui' => 'Disetujui',
                                'selesai' => 'Selesai',
                                'ditolak' => 'Ditolak',
                                default => ucfirst($penjualan->status),
                            };
                            $statusBg = match($penjualan->status) {
                                'menunggu' => '#fef3c7',
                                'disetujui' => '#dbeafe',
                                'selesai' => '#f3f4f6',
                                'ditolak' => '#fee2e2',
                                default => '#f3f4f6',
                            };
                            $statusColor = match($penjualan->status) {
                                'menunggu' => '#d97706',
                                'disetujui' => '#2563eb',
                                'selesai' => '#6b7280',
                                'ditolak' => '#dc2626',
                                default => '#6b7280',
                            };
                        @endphp
                        <span style="font-size:11.5px;font-weight:700;padding:5px 13px;border-radius:99px;background:{{ $statusBg }};color:{{ $statusColor }};">{{ $statusLabel }}</span>
                        @if($penjualan->status_pembayaran === 'lunas')
                            <span style="display:inline-flex;align-items:center;gap:4px;font-size:11.5px;font-weight:700;padding:5px 13px;border-radius:99px;background:#dcfce7;color:#16a34a;">
                                <svg width="12" height="12" fill="none" stroke="#16a34a" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Lunas
                            </span>
                        @else
                            <span style="font-size:11.5px;font-weight:700;padding:5px 13px;border-radius:99px;background:#fee2e2;color:#dc2626;">Belum Bayar</span>
                        @endif
                    </div>

                    <!-- Divider -->
                    <div style="height:1px;background:#f3f4f6;margin-bottom:14px;"></div>

                    <!-- Info row -->
                    <div style="display:flex;justify-content:space-between;">
                        <div>
                            <p style="font-size:11px;color:#9ca3af;font-weight:500;">Admin</p>
                            <p style="font-size:13px;font-weight:700;color:#111827;">{{ $penjualan->admin->name ?? '-' }}</p>
                        </div>
                        <div style="text-align:right;">
                            <p style="font-size:11px;color:#9ca3af;font-weight:500;">Metode</p>
                            <p style="font-size:13px;font-weight:700;color:#111827;">{{ ucfirst($penjualan->metode_pembayaran ?? 'tunai') }}</p>
                        </div>
                    </div>
                </div>

                <!-- ── DETAIL ITEM CARD ── -->
                <div style="background:#fff;border-radius:18px;margin:0 16px;padding:0;box-shadow:0 4px 20px rgba(0,0,0,0.08);overflow:hidden;">
                    <!-- Header strip -->
                    <div style="background:#f0fdf4;padding:14px 18px;display:flex;align-items:center;justify-content:space-between;">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <svg width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <p style="font-size:14px;font-weight:800;color:#111827;">Detail Item</p>
                        </div>
                        <span style="font-size:12px;font-weight:600;color:#6b7280;">{{ $penjualan->detail->count() }} item</span>
                    </div>

                    <!-- Item rows -->
                    @foreach($penjualan->detail as $d)
                        <div style="padding:14px 18px;{{ !$loop->last ? 'border-bottom:1px solid #f3f4f6;' : '' }}">
                            <div style="display:flex;align-items:center;justify-content:space-between;">
                                <div>
                                    <p style="font-size:13px;font-weight:700;color:#111827;">{{ $d->kategori?->nama ?? '-' }}</p>
                                    <p style="font-size:11px;color:#9ca3af;margin-top:2px;">{{ number_format($d->berat, 1, ',', '.') }} kg × Rp {{ number_format($d->harga_per_kg, 0, ',', '.') }}/kg</p>
                                </div>
                                <p style="font-size:14px;font-weight:800;color:#111827;">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach

                    <!-- Summary footer -->
                    <div style="background:linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);padding:14px 18px;">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                            <span style="font-size:12px;color:#6b7280;font-weight:500;">Total Berat</span>
                            <span style="font-size:14px;font-weight:800;color:#111827;">{{ number_format($penjualan->total_berat, 1, ',', '.') }} kg</span>
                        </div>
                        <div style="display:flex;align-items:center;justify-content:space-between;">
                            <span style="font-size:12px;color:#6b7280;font-weight:500;">Total Harga</span>
                            <span style="font-size:18px;font-weight:800;color:#16a34a;">Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- ── CATATAN CARD ── -->
                @if($penjualan->catatan)
                    <div style="background:#fff;border-radius:16px;margin:12px 16px 0;padding:14px 18px;box-shadow:0 2px 12px rgba(0,0,0,0.06);">
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;">
                            <svg width="16" height="16" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                            <span style="font-size:12px;font-weight:600;color:#9ca3af;">Catatan</span>
                        </div>
                        <p style="font-size:13px;color:#6b7280;font-style:italic;">{{ $penjualan->catatan }}</p>
                    </div>
                @endif

            </div>
        </div>

    </div>
</body>

</html>

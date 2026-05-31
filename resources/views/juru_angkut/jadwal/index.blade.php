<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Jadwal Jemput - Juru Angkut</title>
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
            body { background: #f2f3f7; }
            .phone-wrapper { width: 100%; box-shadow: none; }
        }

        .scroll-area {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 80px;
        }

        .scroll-area::-webkit-scrollbar { display: none; }

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
            text-decoration: none;
        }

        .date-chip {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 8px 14px;
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.2s;
            min-width: 52px;
            text-decoration: none;
        }

        .date-chip.active {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: #fff;
            box-shadow: 0 4px 12px rgba(22, 197, 94, 0.35);
        }

        .date-chip:not(.active) {
            background: #fff;
            border: 1.5px solid #e5e7eb;
        }
    </style>
</head>

<body>
    <div class="phone-wrapper">

        <!-- ── HEADER ── -->
        <div style="background: linear-gradient(150deg, #2ecc71 0%, #1aab57 50%, #168a45 100%); padding: 18px 20px 22px; display: flex; align-items: center; gap: 14px; flex-shrink: 0;">
            <a href="{{ route('juru-angkut.index') }}"
                style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 style="font-size:18px;font-weight:800;color:#fff;">Jadwal Jemput</h1>
                <p style="font-size:11px;color:rgba(255,255,255,0.7);font-weight:500;">Jadwal penjemputan langganan</p>
            </div>
        </div>

        <!-- ── SCROLL AREA ── -->
        <div class="scroll-area">
            <div style="padding-bottom: 28px;">

                {{-- Flash Messages --}}
                @if(session('success'))
                    <div style="background:#dcfce7;border:1px solid #86efac;border-radius:12px;padding:12px 16px;margin:12px 20px 0;font-size:12px;font-weight:600;color:#15803d;display:flex;align-items:center;gap:8px;">
                        ✅ {{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:12px;padding:12px 16px;margin:12px 20px 0;">
                        <ul style="font-size:11px;color:#dc2626;font-weight:500;list-style:none;margin:0;padding:0;">
                            @foreach($errors->all() as $error)
                                <li style="margin-bottom:4px;">⚠️ {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- ── SUMMARY CARDS ── -->
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;padding:16px 20px 0;">
                    <div style="background:#fff;border-radius:14px;padding:14px;text-align:center;box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                        <p style="font-size:22px;font-weight:800;color:#2563eb;">{{ $terjadwalHariIni }}</p>
                        <p style="font-size:10px;font-weight:600;color:#6b7280;margin-top:2px;">Terjadwal</p>
                    </div>
                    <div style="background:#fff;border-radius:14px;padding:14px;text-align:center;box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                        <p style="font-size:22px;font-weight:800;color:#16a34a;">{{ $selesaiHariIni }}</p>
                        <p style="font-size:10px;font-weight:600;color:#6b7280;margin-top:2px;">Selesai</p>
                    </div>
                    <div style="background:#fff;border-radius:14px;padding:14px;text-align:center;box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                        <p style="font-size:22px;font-weight:800;color:#f59e0b;">{{ $dilewatiHariIni }}</p>
                        <p style="font-size:10px;font-weight:600;color:#6b7280;margin-top:2px;">Dilewati</p>
                    </div>
                </div>

                <!-- ── DATE STRIP ── -->
                <div style="padding:16px 20px 0;">
                    <p style="font-size:13px;font-weight:700;color:#111827;margin-bottom:10px;">📅 Pilih Tanggal</p>
                    <div style="display:flex;gap:8px;overflow-x:auto;padding-bottom:4px;">
                        @for($i = 0; $i < 7; $i++)
                            @php
                                $date = now()->addDays($i);
                                $dateStr = $date->toDateString();
                                $isActive = $dateStr === $tanggal;
                                $hariLabels = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
                            @endphp
                            <a href="{{ route('juru-angkut.jadwal', ['tanggal' => $dateStr]) }}"
                               class="date-chip {{ $isActive ? 'active' : '' }}">
                                <span style="font-size:10px;font-weight:600;{{ $isActive ? 'color:#fff;' : 'color:#9ca3af;' }}">{{ $hariLabels[$date->dayOfWeek] }}</span>
                                <span style="font-size:16px;font-weight:800;{{ $isActive ? 'color:#fff;' : 'color:#374151;' }}">{{ $date->format('d') }}</span>
                            </a>
                        @endfor
                    </div>
                </div>

                <!-- ── JADWAL HARI INI ── -->
                <div style="padding:20px 20px 0;">
                    <p style="font-size:14px;font-weight:700;color:#111827;margin-bottom:12px;">
                        🗓️ Jadwal {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d M Y') }}
                    </p>

                    @forelse($jadwalHariIni as $jadwal)
                        <div style="background:#fff;border-radius:16px;padding:16px;margin-bottom:12px;box-shadow:0 2px 8px rgba(0,0,0,0.04);border:1.5px solid #e5e7eb;">
                            <!-- Header -->
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <div style="width:40px;height:40px;background:#dbeafe;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                                        <span style="font-size:18px;">👤</span>
                                    </div>
                                    <div>
                                        <p style="font-size:13px;font-weight:700;color:#111827;">{{ $jadwal->pelanggan->name ?? 'Pelanggan' }}</p>
                                        <p style="font-size:11px;color:#6b7280;font-weight:500;">{{ $jadwal->langganan->paket->nama ?? 'Paket' }}</p>
                                    </div>
                                </div>
                                <div style="background:#dbeafe;border:1px solid #93c5fd;border-radius:8px;padding:3px 10px;">
                                    <span style="font-size:10px;font-weight:700;color:#2563eb;">⏰ {{ $jadwal->jam_jemput }}</span>
                                </div>
                            </div>

                            <!-- Alamat -->
                            @php
                                $pesananTerakhir = \App\Models\Pesanan::where('user_id', $jadwal->user_id)->whereNotNull('alamat_jemput')->latest()->first();
                                $alamat = $pesananTerakhir->alamat_jemput ?? $jadwal->pelanggan->alamat ?? 'Alamat belum diatur';
                            @endphp
                            <div style="background:#f9fafb;border-radius:10px;padding:10px 12px;margin-bottom:14px;">
                                <div style="display:flex;align-items:flex-start;gap:8px;">
                                    <span style="font-size:14px;">📍</span>
                                    <p style="font-size:12px;color:#374151;font-weight:500;line-height:1.4;">{{ Str::limit($alamat, 80) }}</p>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div style="display:flex;gap:8px;">
                                <form action="{{ route('juru-angkut.jadwal.mulai', $jadwal->id) }}" method="POST" style="flex:1;">
                                    @csrf
                                    <button type="submit" style="width:100%;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;font-size:12px;font-weight:700;padding:11px;border-radius:10px;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:5px;">
                                        🚛 Mulai Jemput
                                    </button>
                                </form>
                                <button type="button" onclick="showSkipModal({{ $jadwal->id }})" style="background:#fff;border:1.5px solid #fbbf24;color:#f59e0b;font-size:12px;font-weight:700;padding:11px 16px;border-radius:10px;cursor:pointer;display:flex;align-items:center;gap:5px;">
                                    ⏭️ Lewati
                                </button>
                            </div>
                        </div>
                    @empty
                        <div style="background:#fff;border-radius:16px;padding:32px 20px;text-align:center;box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                            <span style="font-size:40px;">📭</span>
                            <p style="font-size:14px;font-weight:700;color:#374151;margin-top:10px;">Tidak ada jadwal</p>
                            <p style="font-size:12px;color:#9ca3af;margin-top:4px;">Belum ada jadwal penjemputan untuk tanggal ini</p>
                        </div>
                    @endforelse
                </div>

                <!-- ── JADWAL MENDATANG ── -->
                @if($jadwalMendatang->isNotEmpty())
                <div style="padding:8px 20px 0;">
                    <p style="font-size:14px;font-weight:700;color:#111827;margin-bottom:12px;">📋 Jadwal Mendatang</p>

                    @foreach($jadwalMendatang->groupBy(fn($j) => $j->tanggal_jemput->format('Y-m-d')) as $tgl => $jadwals)
                        <p style="font-size:11px;font-weight:700;color:#6b7280;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.5px;">
                            {{ \Carbon\Carbon::parse($tgl)->translatedFormat('l, d M Y') }} · {{ $jadwals->count() }} jadwal
                        </p>
                        @foreach($jadwals as $jadwal)
                            <div style="background:#fff;border-radius:14px;padding:14px;margin-bottom:8px;display:flex;align-items:center;gap:12px;box-shadow:0 1px 4px rgba(0,0,0,0.03);border:1px solid #f3f4f6;">
                                <div style="width:36px;height:36px;background:#ede9fe;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <span style="font-size:14px;">👤</span>
                                </div>
                                <div style="flex:1;min-width:0;">
                                    <p style="font-size:12px;font-weight:700;color:#111827;">{{ $jadwal->pelanggan->name ?? 'Pelanggan' }}</p>
                                    <p style="font-size:11px;color:#9ca3af;">{{ $jadwal->langganan->paket->nama ?? '' }} · {{ $jadwal->jam_jemput }}</p>
                                </div>
                                <div style="background:#f0fdf4;border-radius:8px;padding:4px 10px;">
                                    <span style="font-size:10px;font-weight:700;color:#16a34a;">Terjadwal</span>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
                @endif

            </div>
        </div><!-- end scroll-area -->

        <!-- ── SKIP MODAL ── -->
        <div id="skipModal"
            style="position:absolute;inset:0;background:rgba(0,0,0,0.5);z-index:200;display:none;align-items:flex-end;">
            <div style="width:100%;background:#fff;border-radius:24px 24px 0 0;padding:20px;">
                <div style="display:flex;justify-content:center;margin-bottom:16px;">
                    <div style="width:40px;height:4px;background:#d1d5db;border-radius:4px;"></div>
                </div>
                <p style="font-size:15px;font-weight:700;color:#111827;margin-bottom:6px;">⏭️ Lewati Jadwal</p>
                <p style="font-size:12px;color:#6b7280;margin-bottom:16px;">Jadwal akan dijadwalkan ulang ke minggu depan</p>
                <form id="skipForm" method="POST" action="">
                    @csrf
                    <div style="margin-bottom:14px;">
                        <label style="font-size:12px;font-weight:600;color:#374151;margin-bottom:6px;display:block;">Alasan (opsional)</label>
                        <textarea name="alasan" rows="2" placeholder="Contoh: Pelanggan tidak di rumah"
                            style="width:100%;border:1.5px solid #e5e7eb;border-radius:12px;padding:12px;font-size:13px;font-family:Poppins;resize:none;outline:none;"></textarea>
                    </div>
                    <div style="display:flex;gap:10px;">
                        <button type="button" onclick="closeSkipModal()"
                            style="flex:1;background:#f3f4f6;color:#374151;font-size:13px;font-weight:600;padding:13px;border-radius:12px;border:none;cursor:pointer;">
                            Batal
                        </button>
                        <button type="submit"
                            style="flex:1;background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;font-size:13px;font-weight:700;padding:13px;border-radius:12px;border:none;cursor:pointer;">
                            Lewati & Reschedule
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ── BOTTOM NAV ── -->
        <div class="nav-bottom">
            <a href="{{ route('juru-angkut.index') }}" class="nav-btn">
                <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                </svg>
                <span style="font-size:10px;font-weight:500;color:#9ca3af;">Home</span>
            </a>
            <a href="{{ route('juru-angkut.order.index') }}" class="nav-btn">
                <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 11H4L5 9z" />
                </svg>
                <span style="font-size:10px;font-weight:500;color:#9ca3af;">Order</span>
            </a>
            <a href="{{ route('juru-angkut.jadwal') }}" class="nav-btn" style="position:relative;">
                <svg width="22" height="22" fill="#2563eb" viewBox="0 0 24 24">
                    <path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zM5 8V6h14v2H5z"/>
                </svg>
                <span style="font-size:10px;font-weight:700;color:#2563eb;">Jadwal</span>
                @if($terjadwalHariIni > 0)
                    <span style="position:absolute;top:-2px;right:2px;min-width:16px;height:16px;background:#ef4444;border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid #fff;">
                        <span style="font-size:8px;font-weight:800;color:#fff;">{{ $terjadwalHariIni }}</span>
                    </span>
                @endif
            </a>
            <a href="{{ route('juru-angkut.riwayat') }}" class="nav-btn">
                <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span style="font-size:10px;font-weight:500;color:#9ca3af;">History</span>
            </a>
            <a href="{{ route('juru-angkut.profil') }}" class="nav-btn">
                <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span style="font-size:10px;font-weight:500;color:#9ca3af;">Profile</span>
            </a>
        </div>

    </div>

    <script>
        function showSkipModal(jadwalId) {
            const modal = document.getElementById('skipModal');
            const form = document.getElementById('skipForm');
            form.action = `/juru-angkut/jadwal/${jadwalId}/skip`;
            modal.style.display = 'flex';
        }

        function closeSkipModal() {
            document.getElementById('skipModal').style.display = 'none';
        }

        document.getElementById('skipModal').addEventListener('click', function(e) {
            if (e.target === this) closeSkipModal();
        });
    </script>
</body>

</html>

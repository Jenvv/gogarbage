<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Jadwal Jemput - Juru Angkut</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <style>
        * { font-family: 'Poppins', sans-serif; box-sizing: border-box; margin: 0; padding: 0; }
        body { background: #e8e8e8; display: flex; justify-content: center; min-height: 100vh; }
        .phone-wrapper { width: 390px; height: 100vh; background: #f2f3f7; position: relative; overflow: hidden; box-shadow: 0 0 48px rgba(0,0,0,0.18); display: flex; flex-direction: column; }
        @media (max-width: 390px) { body { background: #f2f3f7; } .phone-wrapper { width: 100%; box-shadow: none; } }
        .scroll-area { flex: 1; overflow-y: auto; overflow-x: hidden; -webkit-overflow-scrolling: touch; padding-bottom: 80px; }
        .scroll-area::-webkit-scrollbar { display: none; }
        .nav-bottom { height: 64px; background: #fff; border-top: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: space-around; position: absolute; bottom: 0; width: 100%; z-index: 50; }
        .nav-btn { display: flex; flex-direction: column; align-items: center; gap: 3px; padding-top: 4px; cursor: pointer; text-decoration: none; }

        .tab-btn { flex: 1; padding: 10px 0; font-size: 12px; font-weight: 700; border: none; cursor: pointer; transition: all 0.2s; border-radius: 10px; }
        .tab-btn.active { background: #16a34a; color: #fff; box-shadow: 0 2px 8px rgba(22,163,74,0.3); }
        .tab-btn:not(.active) { background: transparent; color: #6b7280; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }

        .modal-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.5); z-index: 200; display: none; align-items: flex-end; }
        .modal-overlay.show { display: flex; }
        .modal-sheet { width: 100%; background: #fff; border-radius: 20px 20px 0 0; max-height: 75vh; display: flex; flex-direction: column; }
        .modal-header { padding: 16px 20px 12px; border-bottom: 1px solid #f3f4f6; flex-shrink: 0; }
        .modal-body { padding: 0 20px 20px; overflow-y: auto; flex: 1; }
        .modal-body::-webkit-scrollbar { display: none; }
    </style>
</head>
<body>
<div class="phone-wrapper">

    <!-- HEADER -->
    <div style="background: linear-gradient(150deg, #2ecc71 0%, #1aab57 50%, #168a45 100%); padding: 18px 20px 20px; display: flex; align-items: center; gap: 14px; flex-shrink: 0;">
        <a href="{{ route('juru-angkut.index') }}" style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;">
            <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
        </a>
        <div>
            <h1 style="font-size:18px;font-weight:800;color:#fff;">Jadwal Jemput</h1>
            <p style="font-size:11px;color:rgba(255,255,255,0.7);font-weight:500;">Kelola jadwal penjemputan</p>
        </div>
    </div>

    <!-- SCROLL -->
    <div class="scroll-area">
        <div style="padding: 16px 16px 28px;">

            {{-- Flash --}}
            @if(session('success'))
                <div style="background:#dcfce7;border:1px solid #86efac;border-radius:10px;padding:10px 14px;margin-bottom:12px;font-size:11px;font-weight:600;color:#15803d;">✅ {{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:10px;padding:10px 14px;margin-bottom:12px;">
                    @foreach($errors->all() as $e)<p style="font-size:11px;color:#dc2626;font-weight:500;">⚠️ {{ $e }}</p>@endforeach
                </div>
            @endif

            <!-- TABS -->
            <div style="display:flex;gap:6px;background:#f3f4f6;border-radius:12px;padding:4px;margin-bottom:16px;">
                <button class="tab-btn active" onclick="switchTab('reguler')" id="tabReguler">🗑️ Pesanan Reguler <span style="font-size:10px;opacity:0.8;">({{ $totalPesananReguler }})</span></button>
                <button class="tab-btn" onclick="switchTab('langganan')" id="tabLangganan">📦 Langganan <span style="font-size:10px;opacity:0.8;">({{ $totalLanggananAktif }})</span></button>
            </div>

            <!-- ═══ TAB: PESANAN REGULER ═══ -->
            <div class="tab-content active" id="contentReguler">
                @forelse($pesananReguler->groupBy(fn($p) => $p->tanggal_jemput->format('Y-m-d')) as $tgl => $orders)
                    <p style="font-size:10px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;margin-top:{{ $loop->first ? '0' : '12px' }};">
                        {{ \Carbon\Carbon::parse($tgl)->translatedFormat('l, d M Y') }}
                    </p>
                    @foreach($orders as $order)
                        @php
                            $jenis = $order->detailPesanan->pluck('kategoriSampah.nama')->filter()->implode(', ') ?: 'Sampah';
                            $isToday = \Carbon\Carbon::parse($order->tanggal_jemput)->isToday();
                        @endphp
                        <div style="background:#fff;border-radius:12px;padding:12px;margin-bottom:6px;display:flex;align-items:center;gap:10px;box-shadow:0 1px 4px rgba(0,0,0,0.03);">
                            <div style="width:34px;height:34px;background:#d1fae5;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <span style="font-size:14px;">🗑️</span>
                            </div>
                            <div style="flex:1;min-width:0;">
                                <p style="font-size:12px;font-weight:700;color:#111827;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $order->pengguna->name ?? 'Pelanggan' }}</p>
                                <p style="font-size:10px;color:#9ca3af;margin-top:1px;">{{ Str::limit($order->alamat_jemput ?? '-', 35) }} · {{ $order->jam_jemput ? \Carbon\Carbon::parse($order->jam_jemput)->format('H:i') : '08:00' }}</p>
                            </div>
                            @if($isToday)
                                <form action="{{ route('juru-angkut.order.terima', $order->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="background:#16a34a;color:#fff;font-size:10px;font-weight:700;padding:6px 12px;border-radius:8px;border:none;cursor:pointer;white-space:nowrap;">Terima</button>
                                </form>
                            @else
                                <span style="font-size:9px;font-weight:600;color:#92400e;background:#fef3c7;border-radius:6px;padding:4px 8px;white-space:nowrap;">{{ \Carbon\Carbon::parse($order->tanggal_jemput)->format('d M') }}</span>
                            @endif
                        </div>
                    @endforeach
                @empty
                    <div style="text-align:center;padding:40px 16px;">
                        <span style="font-size:32px;">📭</span>
                        <p style="font-size:13px;font-weight:600;color:#374151;margin-top:8px;">Tidak ada pesanan terjadwal</p>
                        <p style="font-size:11px;color:#9ca3af;margin-top:2px;">Pesanan mendatang akan muncul di sini</p>
                    </div>
                @endforelse
            </div>

            <!-- ═══ TAB: LANGGANAN ═══ -->
            <div class="tab-content" id="contentLangganan">
                @forelse($langgananAktif as $idx => $lg)
                    <div onclick="openJadwalModal({{ $idx }})" style="background:#fff;border-radius:12px;padding:14px;margin-bottom:8px;cursor:pointer;box-shadow:0 1px 4px rgba(0,0,0,0.03);transition:background 0.15s;" onmousedown="this.style.background='#f9fafb'" onmouseup="this.style.background='#fff'">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:38px;height:38px;background:#ede9fe;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <span style="font-size:16px;">👤</span>
                            </div>
                            <div style="flex:1;min-width:0;">
                                <p style="font-size:12.5px;font-weight:700;color:#111827;">{{ $lg->nama_pelanggan }}</p>
                                <p style="font-size:10.5px;color:#6b7280;margin-top:1px;">{{ $lg->paket_nama }} · {{ $lg->frekuensi }}x/{{ $lg->satuan }}</p>
                            </div>
                            <div style="text-align:right;flex-shrink:0;">
                                <p style="font-size:11px;font-weight:800;color:#16a34a;">{{ $lg->selesai }}/{{ $lg->total_jadwal }}</p>
                                <p style="font-size:9px;color:#9ca3af;margin-top:1px;">selesai</p>
                            </div>
                            <svg width="16" height="16" fill="none" stroke="#d1d5db" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </div>
                        @if($lg->next_tanggal)
                            <div style="margin-top:8px;background:#f0fdf4;border-radius:8px;padding:6px 10px;display:flex;align-items:center;gap:6px;">
                                <span style="font-size:10px;">📅</span>
                                <span style="font-size:10px;font-weight:600;color:#15803d;">Jemput berikutnya: {{ $lg->next_tanggal }}</span>
                            </div>
                        @endif
                    </div>
                @empty
                    <div style="text-align:center;padding:40px 16px;">
                        <span style="font-size:32px;">📦</span>
                        <p style="font-size:13px;font-weight:600;color:#374151;margin-top:8px;">Belum ada langganan aktif</p>
                        <p style="font-size:11px;color:#9ca3af;margin-top:2px;">Pelanggan berlangganan akan muncul di sini</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    <!-- ═══ MODAL: JADWAL DETAIL ═══ -->
    <div class="modal-overlay" id="jadwalModal">
        <div class="modal-sheet">
            <div class="modal-header">
                <div style="display:flex;justify-content:center;margin-bottom:10px;"><div style="width:36px;height:4px;background:#d1d5db;border-radius:4px;"></div></div>
                <div style="display:flex;align-items:center;justify-content:space-between;">
                    <div>
                        <p style="font-size:15px;font-weight:700;color:#111827;" id="modalNama">-</p>
                        <p style="font-size:11px;color:#6b7280;" id="modalPaket">-</p>
                    </div>
                    <button onclick="closeJadwalModal()" style="width:32px;height:32px;background:#f3f4f6;border-radius:50%;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                        <svg width="16" height="16" fill="none" stroke="#6b7280" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div style="display:flex;gap:12px;margin-top:10px;">
                    <div style="background:#f0fdf4;border-radius:8px;padding:6px 12px;flex:1;text-align:center;">
                        <p style="font-size:14px;font-weight:800;color:#16a34a;" id="modalSelesai">0</p>
                        <p style="font-size:9px;color:#6b7280;font-weight:600;">Selesai</p>
                    </div>
                    <div style="background:#dbeafe;border-radius:8px;padding:6px 12px;flex:1;text-align:center;">
                        <p style="font-size:14px;font-weight:800;color:#2563eb;" id="modalTerjadwal">0</p>
                        <p style="font-size:9px;color:#6b7280;font-weight:600;">Terjadwal</p>
                    </div>
                    <div style="background:#f3f4f6;border-radius:8px;padding:6px 12px;flex:1;text-align:center;">
                        <p style="font-size:14px;font-weight:800;color:#374151;" id="modalTotal">0</p>
                        <p style="font-size:9px;color:#6b7280;font-weight:600;">Total</p>
                    </div>
                </div>
            </div>
            <div class="modal-body" id="modalJadwalList" style="padding-top:12px;">
                <!-- Filled by JS -->
            </div>
        </div>
    </div>

    <!-- ═══ SKIP MODAL ═══ -->
    <div class="modal-overlay" id="skipModal">
        <div style="width:100%;background:#fff;border-radius:20px 20px 0 0;padding:20px;">
            <div style="display:flex;justify-content:center;margin-bottom:14px;"><div style="width:36px;height:4px;background:#d1d5db;border-radius:4px;"></div></div>
            <p style="font-size:14px;font-weight:700;color:#111827;margin-bottom:4px;">⏭️ Lewati Jadwal</p>
            <p style="font-size:11px;color:#6b7280;margin-bottom:14px;">Akan dijadwalkan ulang ke minggu depan</p>
            <form id="skipForm" method="POST" action="">
                @csrf
                <textarea name="alasan" rows="2" placeholder="Alasan (opsional)" style="width:100%;border:1.5px solid #e5e7eb;border-radius:10px;padding:10px;font-size:12px;font-family:Poppins;resize:none;outline:none;margin-bottom:12px;"></textarea>
                <div style="display:flex;gap:8px;">
                    <button type="button" onclick="closeSkipModal()" style="flex:1;background:#f3f4f6;color:#374151;font-size:12px;font-weight:600;padding:11px;border-radius:10px;border:none;cursor:pointer;">Batal</button>
                    <button type="submit" style="flex:1;background:#d97706;color:#fff;font-size:12px;font-weight:700;padding:11px;border-radius:10px;border:none;cursor:pointer;">Lewati</button>
                </div>
            </form>
        </div>
    </div>

    <!-- BOTTOM NAV -->
    <div class="nav-bottom">
        <a href="{{ route('juru-angkut.index') }}" class="nav-btn">
            <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" /></svg>
            <span style="font-size:10px;font-weight:500;color:#9ca3af;">Home</span>
        </a>
        <a href="{{ route('juru-angkut.order.index') }}" class="nav-btn">
            <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 11H4L5 9z" /></svg>
            <span style="font-size:10px;font-weight:500;color:#9ca3af;">Order</span>
        </a>
        <a href="{{ route('juru-angkut.jadwal') }}" class="nav-btn" style="position:relative;">
            <svg width="22" height="22" fill="#16a34a" viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zM5 8V6h14v2H5z"/></svg>
            <span style="font-size:10px;font-weight:700;color:#16a34a;">Jadwal</span>
            @if($terjadwalHariIni > 0)
                <span style="position:absolute;top:-2px;right:2px;min-width:16px;height:16px;background:#ef4444;border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid #fff;">
                    <span style="font-size:8px;font-weight:800;color:#fff;">{{ $terjadwalHariIni }}</span>
                </span>
            @endif
        </a>
        <a href="{{ route('juru-angkut.riwayat') }}" class="nav-btn">
            <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span style="font-size:10px;font-weight:500;color:#9ca3af;">History</span>
        </a>
        <a href="{{ route('juru-angkut.profil') }}" class="nav-btn">
            <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            <span style="font-size:10px;font-weight:500;color:#9ca3af;">Profile</span>
        </a>
    </div>

</div>

<script>
// ── Tab Switching ──
function switchTab(tab) {
    document.getElementById('contentReguler').classList.toggle('active', tab === 'reguler');
    document.getElementById('contentLangganan').classList.toggle('active', tab === 'langganan');
    document.getElementById('tabReguler').classList.toggle('active', tab === 'reguler');
    document.getElementById('tabLangganan').classList.toggle('active', tab === 'langganan');
}

// ── Langganan Data (from PHP) ──
const langgananData = @json($langgananAktif);
const today = '{{ today()->toDateString() }}';

function openJadwalModal(idx) {
    const lg = langgananData[idx];
    document.getElementById('modalNama').textContent = lg.nama_pelanggan;
    document.getElementById('modalPaket').textContent = lg.paket_nama + ' · ' + lg.frekuensi + 'x/' + lg.satuan;
    document.getElementById('modalSelesai').textContent = lg.selesai;
    document.getElementById('modalTerjadwal').textContent = lg.terjadwal;
    document.getElementById('modalTotal').textContent = lg.total_jadwal;

    let html = '';
    lg.jadwal_list.forEach(j => {
        const isDone = j.status === 'selesai';
        const isSkipped = j.status === 'dilewati';
        const isPast = j.raw_date < today;
        const isToday = j.raw_date === today;

        let statusBadge, iconBg, icon;
        if (isDone) {
            statusBadge = '<span style="font-size:9px;font-weight:700;color:#16a34a;background:#dcfce7;border-radius:5px;padding:2px 8px;">✅ Selesai</span>';
            iconBg = '#d1fae5'; icon = '✅';
        } else if (isSkipped) {
            statusBadge = '<span style="font-size:9px;font-weight:700;color:#d97706;background:#fef3c7;border-radius:5px;padding:2px 8px;">⏭️ Dilewati</span>';
            iconBg = '#fef3c7'; icon = '⏭️';
        } else if (isToday) {
            statusBadge = `<div style="display:flex;gap:4px;">
                <form action="/juru-angkut/jadwal/${j.id}/mulai" method="POST" style="display:inline;">@csrf<button type="submit" style="font-size:9px;font-weight:700;color:#fff;background:#16a34a;border-radius:5px;padding:3px 8px;border:none;cursor:pointer;">Jemput</button></form>
                <button onclick="event.stopPropagation();showSkipModal(${j.id})" style="font-size:9px;font-weight:700;color:#d97706;background:#fef3c7;border-radius:5px;padding:3px 8px;border:none;cursor:pointer;">Lewati</button>
            </div>`;
            iconBg = '#dbeafe'; icon = '🚛';
        } else {
            statusBadge = '<span style="font-size:9px;font-weight:600;color:#6b7280;background:#f3f4f6;border-radius:5px;padding:2px 8px;">Terjadwal</span>';
            iconBg = '#f3f4f6'; icon = '📅';
        }

        html += `<div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid #f9fafb;${isDone ? 'opacity:0.6;' : ''}">
            <div style="width:30px;height:30px;background:${iconBg};border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:12px;">${icon}</div>
            <div style="flex:1;min-width:0;">
                <p style="font-size:11px;font-weight:600;color:#111827;">${j.hari}, ${j.tanggal}</p>
                <p style="font-size:10px;color:#9ca3af;">Jam ${j.jam}</p>
            </div>
            ${statusBadge}
        </div>`;
    });

    document.getElementById('modalJadwalList').innerHTML = html;
    document.getElementById('jadwalModal').classList.add('show');
}

function closeJadwalModal() {
    document.getElementById('jadwalModal').classList.remove('show');
}

document.getElementById('jadwalModal').addEventListener('click', function(e) {
    if (e.target === this) closeJadwalModal();
});

// ── Skip Modal ──
function showSkipModal(jadwalId) {
    document.getElementById('skipForm').action = `/juru-angkut/jadwal/${jadwalId}/skip`;
    document.getElementById('skipModal').classList.add('show');
}
function closeSkipModal() {
    document.getElementById('skipModal').classList.remove('show');
}
document.getElementById('skipModal').addEventListener('click', function(e) {
    if (e.target === this) closeSkipModal();
});
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Riwayat</title>
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
            height: 100vh;
            overflow: hidden;
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

        /* ── Header ── */
        .page-header {
            background: linear-gradient(135deg, #2ecc71 0%, #1aab57 60%, #168a45 100%);
            padding: 18px 20px 0;
            flex-shrink: 0;
        }

        .header-top {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 16px;
        }

        /* Filter tabs */
        .tabs-wrap {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 14px;
        }

        .tabs-wrap::-webkit-scrollbar {
            display: none;
        }

        .tab {
            flex-shrink: 0;
            padding: 7px 18px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            font-family: 'Poppins', sans-serif;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .tab.active {
            background: #fff;
            color: #16a34a;
            font-weight: 600;
        }

        .tab.inactive {
            background: rgba(255, 255, 255, 0.18);
            color: rgba(255, 255, 255, 0.9);
        }

        .tab.inactive:hover {
            background: rgba(255, 255, 255, 0.28);
        }

        /* ── Scroll ── */
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

        /* ── History card ── */
        .hist-card {
            background: #fff;
            border-radius: 16px;
            padding: 16px;
            margin: 0 16px 12px;
            box-shadow: 0 1px 10px rgba(0, 0, 0, 0.06);
            display: flex;
            gap: 13px;
            align-items: flex-start;
            animation: fadeUp 0.3s ease both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hist-card:nth-child(1) {
            animation-delay: 0.00s;
        }

        .hist-card:nth-child(2) {
            animation-delay: 0.06s;
        }

        .hist-card:nth-child(3) {
            animation-delay: 0.12s;
        }

        .hist-card:nth-child(4) {
            animation-delay: 0.18s;
        }

        /* Icon */
        .hist-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* Status badge */
        .status-badge {
            font-size: 11px;
            font-weight: 500;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .badge-selesai {
            background: #dcfce7;
            color: #16a34a;
        }

        .badge-aktif {
            background: #dbeafe;
            color: #2563eb;
        }

        .badge-proses {
            background: #fef9c3;
            color: #ca8a04;
        }

        .badge-batal {
            background: #fee2e2;
            color: #dc2626;
        }

        /* Detail link */
        .detail-link {
            font-size: 12.5px;
            font-weight: 500;
            color: #6366f1;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 3px;
            text-decoration: none;
            flex-shrink: 0;
        }

        /* Empty state */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
            gap: 12px;
        }

        /* ── Nav ── */
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

        /* ── Detail modal ── */
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
            max-height: 85vh;
            overflow-y: auto;
        }

        .modal-sheet::-webkit-scrollbar {
            display: none;
        }

        .modal-overlay.show .modal-sheet {
            transform: translateY(0);
        }

        @media (max-width: 390px) {
            .modal-sheet {
                width: 100%;
            }
        }

        .modal-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .modal-row:last-child {
            border-bottom: none;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }
    </style>
</head>

<body>
    <div class="phone-wrapper">

        <!-- ── HEADER ── -->
        <div class="page-header">
            <div class="header-top">
                <a href="#"
                    style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 style="font-size:17px;font-weight:600;color:#fff;">Riwayat</h1>
            </div>

            <!-- Filter tabs -->
            <div class="tabs-wrap" id="tabsWrap">
                <button class="tab active" data-filter="semua" onclick="setTab(this,'semua')">Semua</button>
                <button class="tab inactive" data-filter="jemput" onclick="setTab(this,'jemput')">Jemput Sampah</button>
                <button class="tab inactive" data-filter="jual" onclick="setTab(this,'jual')">Jual Sampah</button>
                <button class="tab inactive" data-filter="paket" onclick="setTab(this,'paket')">Langganan</button>
            </div>
        </div>

        <!-- ── SCROLL AREA ── -->
        <div class="scroll-area">
            <div style="padding: 16px 0 24px;" id="listContainer">
                <!-- Cards injected by JS -->
            </div>
        </div>

        <!-- ── BOTTOM NAV ── -->
        @include('pelanggan.partials.navigation')


    </div>

    <!-- ── DETAIL MODAL ── -->
    <div class="modal-overlay" id="modalOverlay" onclick="handleOverlayClick(event)">
        <div class="modal-sheet" id="modalSheet">
            <div style="display:flex;justify-content:center;margin-bottom:18px;">
                <div style="width:38px;height:4px;background:#e5e7eb;border-radius:4px;"></div>
            </div>

            <!-- Icon + title -->
            <div style="display:flex;align-items:center;gap:13px;margin-bottom:18px;">
                <div id="mdlIcon"
                    style="width:48px;height:48px;border-radius:13px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                </div>
                <div>
                    <p id="mdlTitle" style="font-size:15px;font-weight:600;color:#111827;"></p>
                    <p id="mdlBadge" style="margin-top:3px;display:inline-block;"></p>
                </div>
            </div>

            <!-- Rows -->
            <div id="mdlRows"></div>

<div id="mdlActionBtns"></div>
        </div>
    </div>

    <script>
        /* ─── DATA ─── */
        const riwayat = @json($riwayat_data);

        /* ─── ICONS ─── */
        function iconSVG(type, color) {
            if (type === 'trash') return `
      <svg width="22" height="22" fill="none" stroke="${color}" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
      </svg>`;
            if (type === 'cart') return `
      <svg width="22" height="22" fill="none" stroke="${color}" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
      </svg>`;
            if (type === 'box') return `
      <svg width="22" height="22" fill="none" stroke="${color}" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
      </svg>`;
            return '';
        }

        function badgeHTML(status) {
            const map = {
                selesai: ['badge-selesai', 'Selesai'],
                aktif: ['badge-aktif', 'Aktif'],
                proses: ['badge-proses', 'Diproses'],
                batal: ['badge-batal', 'Dibatalkan'],
            };
            const [cls, label] = map[status] || ['badge-selesai', 'Selesai'];
            return `<span class="status-badge ${cls}">${label}</span>`;
        }

        /* ─── RENDER ─── */
        function renderList(filter) {
            const container = document.getElementById('listContainer');
            const items = filter === 'semua' ? riwayat : riwayat.filter(r => r.filter === filter);

            if (!items.length) {
                container.innerHTML = `
        <div class="empty-state">
          <svg width="54" height="54" fill="none" stroke="#d1d5db" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
          </svg>
          <p style="font-size:14px;font-weight:500;color:#9ca3af;">Belum ada riwayat</p>
          <p style="font-size:12px;font-weight:400;color:#d1d5db;text-align:center;">Transaksi kamu akan muncul di sini</p>
        </div>`;
                return;
            }

            container.innerHTML = items.map((r, i) => {
                const isActive = r.status_asli && !['selesai', 'dibatalkan'].includes(r.status_asli);
                const borderStyle = isActive ? 'border-left:3px solid #22c55e;' : '';
                const actionBtn = isActive
                    ? `<a class="detail-link" href="/pelanggan/jemput-sampah/${r.pesanan_id || r.id}/tracking" style="color:#16a34a;font-weight:600;gap:5px;">
                        <span style="width:6px;height:6px;background:#22c55e;border-radius:50%;animation:pulse 1.5s infinite;"></span>
                        Tracking
                        <svg width="13" height="13" fill="none" stroke="#16a34a" stroke-width="2.5" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                      </a>`
                    : `<a class="detail-link" onclick="openModal(${r.id})">
                        Detail
                        <svg width="13" height="13" fill="none" stroke="#6366f1" stroke-width="2.5" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                      </a>`;

                return `
      <div class="hist-card" style="animation-delay:${i * 0.06}s;${borderStyle}">
        <!-- Icon -->
        <div class="hist-icon" style="background:${r.iconBg};">
          ${iconSVG(r.iconType, r.iconColor)}
        </div>

        <!-- Content -->
        <div style="flex:1;min-width:0;">
          <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;margin-bottom:4px;">
            <p style="font-size:13.5px;font-weight:600;color:#111827;line-height:1.4;">${r.title}</p>
            ${badgeHTML(r.status)}
          </div>
          <p style="font-size:11.5px;font-weight:400;color:#9ca3af;margin-bottom:8px;">
            ${r.tanggal}${r.waktu ? ' &nbsp;·&nbsp; ' + r.waktu : ''}
          </p>
          <div style="display:flex;justify-content:space-between;align-items:center;">
            <span style="font-size:15px;font-weight:700;color:${r.nominalSign === 'plus' ? '#16a34a' : '#111827'};">${r.nominal}</span>
            ${actionBtn}
          </div>
        </div>
      </div>
    `;
            }).join('');
        }

        /* ─── TABS ─── */
        let activeFilter = 'semua';

        function setTab(el, filter) {
            document.querySelectorAll('.tab').forEach(t => {
                t.classList.remove('active');
                t.classList.add('inactive');
            });
            el.classList.add('active');
            el.classList.remove('inactive');
            activeFilter = filter;
            renderList(filter);
        }

        /* ─── MODAL ─── */
        function openModal(id) {
            const r = riwayat.find(x => x.id === id);
            if (!r) return;

            document.getElementById('mdlIcon').style.background = r.iconBg;
            document.getElementById('mdlIcon').innerHTML = iconSVG(r.iconType, r.iconColor);
            document.getElementById('mdlTitle').textContent = r.title;
            document.getElementById('mdlBadge').innerHTML = badgeHTML(r.status);

            const rows = Object.entries(r.detail).map(([k, v]) => {
                if (k === 'Alasan Pembatalan') {
                    return `
      <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:12px;padding:12px 14px;margin:8px 0;">
        <p style="font-size:11px;font-weight:600;color:#dc2626;margin-bottom:4px;">⚠️ Alasan Pembatalan</p>
        <p style="font-size:13px;font-weight:500;color:#991b1b;line-height:1.5;">${v}</p>
      </div>`;
                }
                return `
      <div class="modal-row">
        <span style="font-size:12.5px;font-weight:400;color:#6b7280;">${k}</span>
        <span style="font-size:13px;font-weight:600;color:#111827;text-align:right;max-width:55%;">${v}</span>
      </div>`;
            }).join('');
            document.getElementById('mdlRows').innerHTML = rows;

            let footerBtns = `<div style="display:flex;gap:10px;margin-top:20px;">`;
            footerBtns += `<button onclick="window.location.href='/pelanggan/jemput-sampah/${r.id}/tracking'" style="flex:1;border:none;border-radius:12px;padding:12px;font-size:13.5px;font-weight:600;color:#fff;background:#3b82f6;cursor:pointer;">Lihat Tracking</button>`;
            
            if(r.status_asli !== 'selesai' && r.status_asli !== 'dibatalkan' && r.telepon_juru_angkut) {
                 footerBtns += `<a href="tel:${r.telepon_juru_angkut}" style="flex:1;text-align:center;text-decoration:none;border:none;border-radius:12px;padding:12px;font-size:13.5px;font-weight:600;color:#16a34a;background:#dcfce7;cursor:pointer;">Telepon Driver</a>`;
            }

            footerBtns += `</div>`;
            footerBtns += `<button onclick="closeModal()" style="width:100%;border:none;border-radius:12px;padding:12px;font-size:13.5px;font-weight:600;color:#fff;background:linear-gradient(135deg,#22c55e,#16a34a);cursor:pointer;margin-top:10px;">Tutup</button>`;

            document.getElementById('mdlActionBtns').innerHTML = footerBtns;

            document.getElementById('modalOverlay').classList.add('show');
        }

        function closeModal() {
            document.getElementById('modalOverlay').classList.remove('show');
        }

        function handleOverlayClick(e) {
            if (e.target === document.getElementById('modalOverlay')) closeModal();
        }

        /* ─── INIT ─── */
        renderList('semua');
    </script>
</body>

</html>

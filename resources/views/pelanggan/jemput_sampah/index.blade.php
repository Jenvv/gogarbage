<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Jemput Sampah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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

        /* Green header */
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

        /* Form card */
        .form-card {
            background: #fff;
            border-radius: 0;
            padding: 22px 20px;
        }

        /* Label */
        .field-label {
            font-size: 13px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 10px;
            display: block;
        }



        /* Input field */
        .input-wrap {
            display: flex;
            align-items: center;
            gap: 11px;
            border: 1.5px solid #e5e7eb;
            border-radius: 14px;
            padding: 14px 16px;
            background: #fff;
            cursor: pointer;
            transition: border-color 0.2s;
        }

        .input-wrap:focus-within {
            border-color: #22c55e;
        }

        .input-wrap input,
        .input-wrap select,
        .input-wrap textarea {
            flex: 1;
            border: none;
            outline: none;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            font-weight: 500;
            color: #374151;
            background: transparent;
            cursor: pointer;
        }

        .input-wrap input::placeholder,
        .input-wrap textarea::placeholder {
            color: #9ca3af;
        }

        .input-wrap select {
            color: #9ca3af;
        }

        .input-wrap select.selected {
            color: #374151;
        }

        /* Biaya card */
        .biaya-card {
            border: 1.5px solid #bbf7d0;
            border-radius: 14px;
            padding: 16px 18px;
            background: #f0fdf4;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s;
        }

        .biaya-card.gratis {
            background: #f0fdf4;
            border-color: #22c55e;
        }

        /* Simulasi toggle */
        .simulasi-wrap {
            background: #fff;
            border: 1.5px solid #e5e7eb;
            border-radius: 14px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        /* Pesan button */
        .pesan-btn {
            width: 100%;
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            border: none;
            border-radius: 14px;
            padding: 16px;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s;
            letter-spacing: 0.01em;
        }

        .pesan-btn:active {
            transform: scale(0.98);
            opacity: 0.9;
        }

        .pesan-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
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

        /* Divider */
        .section-divider {
            height: 10px;
            background: #f2f3f7;
        }

        /* Gratis badge */
        .gratis-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #dcfce7;
            border: 1px solid #86efac;
            border-radius: 8px;
            padding: 3px 10px;
            font-size: 11px;
            font-weight: 700;
            color: #15803d;
        }

        /* Fade animation */
        @keyframes fadeSlide {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeSlide 0.25s ease forwards;
        }

        /* Error */
        .error-text {
            font-size: 11px;
            color: #ef4444;
            margin-top: 6px;
            font-weight: 500;
        }

        /* Alert success */
        .alert-success {
            background: #dcfce7;
            border: 1px solid #86efac;
            border-radius: 12px;
            padding: 12px 16px;
            margin: 12px 20px 0;
            font-size: 12px;
            font-weight: 600;
            color: #15803d;
            display: flex;
            align-items: center;
            gap: 8px;
        }
    </style>
</head>

<body>
    <div class="phone-wrapper">

        <!-- ── HEADER ── -->
        <div class="page-header">
            <a href="{{ route('pelanggan.index') }}"
                style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 style="font-size:18px;font-weight:800;color:#fff;">Jemput Sampah</h1>
        </div>

        <!-- ── SCROLL AREA ── -->
        <div class="scroll-area">
            <div style="padding-bottom: 28px;">

                {{-- Error messages --}}
                @if ($errors->any())
                    <div
                        style="background:#fef2f2;border:1px solid #fca5a5;border-radius:12px;padding:12px 16px;margin:12px 20px 0;">
                        <ul style="font-size:11px;color:#dc2626;font-weight:500;list-style:none;margin:0;padding:0;">
                            @foreach ($errors->all() as $error)
                                <li style="margin-bottom:4px;">⚠️ {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('pelanggan.jemput-sampah.store') }}" method="POST" id="formJemputSampah">
                    @csrf

                    <div class="form-card">



                        <!-- Lokasi Penjemputan -->
                        <label class="field-label">Lokasi Penjemputan</label>
                        <div style="background:#f9fafb;border-radius:16px;padding:16px;display:flex;align-items:flex-start;gap:12px;box-shadow:0 2px 8px rgba(0,0,0,0.02);border:1px solid #e5e7eb;cursor:pointer;"
                             onclick="pilihPeta()">
                            <div style="width:36px;height:36px;background:#dcfce7;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <span style="font-size:16px;">📍</span>
                            </div>
                            <div style="flex:1;min-width:0;">
                                <p style="font-size:11px;font-weight:600;color:#6b7280;margin-bottom:2px;text-transform:uppercase;letter-spacing:0.5px;" id="lokasiLabel">Lokasi Penjemputan</p>
                                <input type="hidden" name="alamat_jemput" id="lokasiInput" value="{{ old('alamat_jemput') }}">
                                <p style="font-size:13px;color:#111827;font-weight:600;line-height:1.4;margin:0;" id="alamatText">
                                    {{ old('alamat_jemput') ?: 'Ketuk untuk pilih lokasi dari peta' }}
                                </p>
                                <p style="font-size:11px;color:#9ca3af;margin-top:2px;display:none;" id="koordinatText"></p>
                            </div>
                            <div style="color:#6366f1;padding-top:8px;">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <p style="font-size:11px;color:#6b7280;margin-top:6px;text-align:center;">Ketuk untuk memilih lokasi dari peta</p>

                        <!-- Hidden fields for coordinates -->
                        <input type="hidden" name="latitude" id="latitudeInput" value="{{ old('latitude') }}">
                        <input type="hidden" name="longitude" id="longitudeInput" value="{{ old('longitude') }}">

                        <div style="height:20px;"></div>

                        <!-- Tanggal -->
                        <label class="field-label">Tanggal</label>
                        <div class="input-wrap">
                            <svg width="18" height="18" fill="none" stroke="#9ca3af" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <input type="date" name="tanggal_jemput" id="tanggalInput"
                                value="{{ old('tanggal_jemput') }}" min="{{ date('Y-m-d') }}"
                                style="color:{{ old('tanggal_jemput') ? '#374151' : '#9ca3af' }};"
                                onchange="updateDateColor(this)" />
                        </div>

                        <div style="height:20px;"></div>

                        <!-- Jam -->
                        <label class="field-label">Jam</label>
                        <div class="input-wrap">
                            <svg width="18" height="18" fill="none" stroke="#9ca3af" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <select name="jam_jemput" id="jamSelect" onchange="updateSelectColor(this)"
                                class="{{ old('jam_jemput') ? 'selected' : '' }}">
                                <option value="" disabled {{ old('jam_jemput') ? '' : 'selected' }}>Pilih Jam
                                </option>
                                <option value="08:00" {{ old('jam_jemput') == '08:00' ? 'selected' : '' }}>08:00 –
                                    10:00</option>
                                <option value="10:00" {{ old('jam_jemput') == '10:00' ? 'selected' : '' }}>10:00 –
                                    12:00</option>
                                <option value="13:00" {{ old('jam_jemput') == '13:00' ? 'selected' : '' }}>13:00 –
                                    15:00</option>
                                <option value="15:00" {{ old('jam_jemput') == '15:00' ? 'selected' : '' }}>15:00 –
                                    17:00</option>
                            </select>
                        </div>

                        <div style="height:20px;"></div>

                        <!-- Catatan -->
                        <label class="field-label">Catatan <span
                                style="font-weight:400;color:#9ca3af;">(opsional)</span></label>
                        <div class="input-wrap" style="align-items:flex-start;">
                            <svg width="18" height="18" fill="none" stroke="#9ca3af" stroke-width="2"
                                viewBox="0 0 24 24" style="margin-top:2px;">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <textarea name="catatan" rows="2" placeholder="Contoh: Sampah di depan pagar" style="resize:none;">{{ old('catatan') }}</textarea>
                        </div>

                        <div style="height:24px;"></div>

                        <!-- Biaya Jemput -->
                        <div class="biaya-card {{ $isBerlangganan ? 'gratis' : '' }}" id="biayaCard">
                            <div>
                                <p style="font-size:13px;font-weight:700;color:#374151;">Biaya Jemput</p>
                                <p style="font-size:11px;color:#9ca3af;margin-top:2px;" id="biayaSubtext">
                                    @if ($isBerlangganan)
                                        Gratis karena kamu berlangganan 🎉
                                    @else
                                        Dihitung otomatis berdasarkan jarak lokasi
                                    @endif
                                </p>
                            </div>
                            <div id="biayaValue">
                                @if ($isBerlangganan)
                                    <div style="display:flex;flex-direction:column;align-items:flex-end;gap:5px;">
                                        <div class="gratis-badge">GRATIS</div>
                                    </div>
                                @else
                                    <span style="font-size:14px;font-weight:700;color:#16a34a;">📍 Pilih lokasi dulu</span>
                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="section-divider"></div>

                    @if ($isBerlangganan && $langgananAktif)
                        <!-- ── INFO LANGGANAN AKTIF ── -->
                        <div style="background:#fff;padding:16px 20px 20px;">
                            <div
                                style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:12px 14px;display:flex;gap:10px;align-items:flex-start;">
                                <span style="font-size:16px;flex-shrink:0;">✅</span>
                                <div>
                                    <p style="font-size:12px;font-weight:700;color:#15803d;">Paket Langganan Aktif</p>
                                    <p style="font-size:11px;color:#166534;margin-top:2px;line-height:1.55;">
                                        Kamu mendapatkan <strong>jemput sampah gratis</strong> setiap hari sebagai
                                        bagian dari
                                        paket {{ $langgananAktif->paket->nama ?? 'langganan' }}.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="section-divider"></div>
                    @endif

                    <!-- ── PESAN SEKARANG ── -->
                    <div style="background:#fff;padding:16px 20px 20px;">
                        <button type="submit" class="pesan-btn" id="pesanBtn">Lanjutkan Pesanan</button>
                    </div>

                </form>

            </div>
        </div><!-- end scroll-area -->

        <!-- ── BOTTOM NAV ── -->
        @include('pelanggan.partials.navigation')


        <!-- ── MAP MODAL ── -->
        <div id="mapModal"
            style="position:absolute;inset:0;background:rgba(0,0,0,0.5);z-index:200;display:none;align-items:flex-end;">
            <div style="width:100%;background:#fff;border-radius:24px 24px 0 0;padding:20px;max-height:90%;display:flex;flex-direction:column;">
                <div style="display:flex;justify-content:center;margin-bottom:12px;">
                    <div style="width:40px;height:4px;background:#d1d5db;border-radius:4px;"></div>
                </div>
                <p style="font-size:15px;font-weight:700;color:#111827;margin-bottom:12px;">📍 Pilih Lokasi dari Peta</p>

                <!-- Interactive Leaflet Map -->
                <div style="width:100%;height:280px;border-radius:16px;overflow:hidden;margin-bottom:12px;position:relative;border:1.5px solid #e5e7eb;">
                    <div id="modalMap" style="width:100%;height:100%;z-index:1;"></div>
                </div>

                <!-- GPS Button -->
                <button type="button" id="btnGPSModal" onclick="deteksiLokasiGPS()"
                    style="width:100%;display:flex;align-items:center;justify-content:center;gap:8px;background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:12px;padding:12px;font-size:13px;font-weight:600;color:#16a34a;cursor:pointer;margin-bottom:12px;transition:all 0.2s;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span id="labelGPSModal">Gunakan Lokasi Saat Ini</span>
                </button>

                <!-- Location Info -->
                <div style="background:#f9fafb;border:1.5px solid #e5e7eb;border-radius:12px;padding:12px 14px;margin-bottom:16px;">
                    <p style="font-size:11px;color:#9ca3af;margin-bottom:4px;">Lokasi dipilih:</p>
                    <p style="font-size:13px;font-weight:600;color:#374151;line-height:1.4;" id="mapSelectedLoc">Geser marker atau klik peta untuk memilih</p>
                    <p style="font-size:11px;color:#9ca3af;margin-top:4px;display:none;" id="mapKoordinat"></p>
                </div>

                <button type="button" onclick="confirmMap()"
                    style="width:100%;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;font-size:14px;font-weight:700;padding:14px;border-radius:12px;border:none;cursor:pointer;">
                    ✅ Gunakan Lokasi Ini
                </button>
            </div>
        </div>

    </div><!-- end phone-wrapper -->

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // ── Config Variables for frontend calculation ──
        const latBase = {{ $latBase ?? -0.026330 }};
        const lonBase = {{ $lonBase ?? 109.342504 }};
        const baseFee = {{ $baseFee ?? 10000 }};
        const perKm = {{ $perKm ?? 2500 }};
        const isBerlangganan = {{ $isBerlangganan ? 'true' : 'false' }};

        // Map state
        let modalMap = null;
        let modalMarker = null;
        let mapInitialized = false;
        // Temp coordinates while user is picking on the modal
        let tempLat = null;
        let tempLon = null;

        // ── Date & Select color ──
        function updateDateColor(el) {
            el.style.color = el.value ? '#374151' : '#9ca3af';
        }

        function updateSelectColor(el) {
            el.style.color = el.value ? '#374151' : '#9ca3af';
            el.classList.toggle('selected', !!el.value);
        }

        // ── Haversine Formula for JS fallback ──
        function hitungJarakHaversine(lat1, lon1, lat2, lon2) {
            const earthRadius = 6371;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                      Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                      Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return earthRadius * c;
        }

        // ── Dynamic Distance & Cost calculation ──
        function hitungJarakDanBiaya(latUser, lonUser) {
            const subtextEl = document.getElementById('biayaSubtext');
            const valueEl = document.getElementById('biayaValue');

            if (!isBerlangganan && valueEl) {
                valueEl.innerHTML = '<span style="font-size:12px;color:#9ca3af;">⏳ Menghitung ongkir...</span>';
            }

            const bLat = parseFloat(latBase);
            const bLon = parseFloat(lonBase);
            const uLat = parseFloat(latUser);
            const uLon = parseFloat(lonUser);

            fetch(`https://router.project-osrm.org/route/v1/driving/${uLon},${uLat};${bLon},${bLat}?overview=false`)
            .then(r => r.json())
            .then(data => {
                let jarak = 1.0;
                if (data.routes && data.routes[0] && data.routes[0].distance) {
                    jarak = data.routes[0].distance / 1000;
                } else {
                    jarak = hitungJarakHaversine(bLat, bLon, uLat, uLon);
                }
                updateBiayaUI(jarak);
            })
            .catch(() => {
                const jarak = hitungJarakHaversine(bLat, bLon, uLat, uLon);
                updateBiayaUI(jarak);
            });
        }

        function updateBiayaUI(jarak) {
            const subtextEl = document.getElementById('biayaSubtext');
            const valueEl = document.getElementById('biayaValue');
            const jarakKm = parseFloat(jarak.toFixed(2)) || 0;

            let ongkir = baseFee;
            if (jarakKm > 1) {
                const sisaKm = Math.ceil(jarakKm - 1);
                ongkir = baseFee + (sisaKm * perKm);
            }

            if (isBerlangganan) {
                if (subtextEl) subtextEl.innerHTML = `Jarak: <strong>${jarakKm} KM</strong> (Gratis karena berlangganan 🎉)`;
            } else {
                if (subtextEl) subtextEl.innerHTML = `Jarak: <strong>${jarakKm} KM</strong> dari Bank Sampah`;
                if (valueEl) {
                    valueEl.innerHTML = `<span style="font-size:16px;font-weight:800;color:#16a34a;">Rp ${ongkir.toLocaleString('id-ID')}</span>`;
                }
            }
        }

        // ── Reverse Geocode ──
        function reverseGeocode(lat, lon) {
            const lokasiInput = document.getElementById('lokasiInput');
            const alamatText = document.getElementById('alamatText');
            const koordinatText = document.getElementById('koordinatText');
            const lokasiLabel = document.getElementById('lokasiLabel');
            const mapSelectedLoc = document.getElementById('mapSelectedLoc');
            const mapKoordinat = document.getElementById('mapKoordinat');

            if (alamatText) alamatText.textContent = '⏳ Mendapatkan nama tempat...';
            if (mapSelectedLoc) mapSelectedLoc.textContent = '⏳ Mendapatkan nama tempat...';

            hitungJarakDanBiaya(lat, lon);

            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=18&addressdetails=1`, {
                headers: { 'Accept-Language': 'id' }
            })
            .then(r => r.json())
            .then(data => {
                const address = data.display_name || `Titik GPS: ${lat.toFixed(7)}, ${lon.toFixed(7)}`;
                if (lokasiInput) lokasiInput.value = address;
                if (alamatText) alamatText.textContent = address;
                if (lokasiLabel) lokasiLabel.textContent = 'LOKASI DIPILIH ✓';
                if (mapSelectedLoc) mapSelectedLoc.textContent = address;
                if (koordinatText) {
                    koordinatText.textContent = `${lat.toFixed(7)}, ${lon.toFixed(7)}`;
                    koordinatText.style.display = 'block';
                }
                if (mapKoordinat) {
                    mapKoordinat.textContent = `${lat.toFixed(7)}, ${lon.toFixed(7)}`;
                    mapKoordinat.style.display = 'block';
                }
                // Update marker popup
                if (modalMarker) {
                    modalMarker.setPopupContent(`<b>📍 Lokasi Jemput</b><br><span style="font-size:11px">${address}</span>`).openPopup();
                }
            })
            .catch(() => {
                const fallback = `Titik GPS: ${lat.toFixed(7)}, ${lon.toFixed(7)}`;
                if (lokasiInput) lokasiInput.value = fallback;
                if (alamatText) alamatText.textContent = fallback;
                if (lokasiLabel) lokasiLabel.textContent = 'LOKASI DIPILIH ✓';
                if (mapSelectedLoc) mapSelectedLoc.textContent = fallback;
                if (koordinatText) {
                    koordinatText.textContent = `${lat.toFixed(7)}, ${lon.toFixed(7)}`;
                    koordinatText.style.display = 'block';
                }
                if (mapKoordinat) {
                    mapKoordinat.textContent = `${lat.toFixed(7)}, ${lon.toFixed(7)}`;
                    mapKoordinat.style.display = 'block';
                }
            });
        }

        // ── Modal map: called when marker position changes ──
        function onMapLocationSelected(lat, lon) {
            tempLat = lat;
            tempLon = lon;

            // Update hidden inputs immediately
            document.getElementById('latitudeInput').value = lat;
            document.getElementById('longitudeInput').value = lon;

            // Update modal info & main page
            reverseGeocode(lat, lon);
        }

        // ── Initialize or re-center Leaflet map inside modal ──
        function initModalMap(lat, lon) {
            if (!mapInitialized) {
                modalMap = L.map('modalMap', {
                    zoomControl: false
                }).setView([lat, lon], 16);

                L.control.zoom({ position: 'topright' }).addTo(modalMap);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap',
                    maxZoom: 19
                }).addTo(modalMap);

                modalMarker = L.marker([lat, lon], { draggable: true }).addTo(modalMap);
                modalMarker.bindPopup('<b>📍 Lokasi Jemput</b><br>Geser atau klik peta').openPopup();

                // Drag marker
                modalMarker.on('dragend', function(e) {
                    const pos = e.target.getLatLng();
                    onMapLocationSelected(pos.lat, pos.lng);
                });

                // Click map
                modalMap.on('click', function(e) {
                    modalMarker.setLatLng(e.latlng);
                    onMapLocationSelected(e.latlng.lat, e.latlng.lng);
                });

                mapInitialized = true;
            } else {
                modalMap.setView([lat, lon], 16);
                modalMarker.setLatLng([lat, lon]);
            }

            // Fix Leaflet tile rendering in hidden container
            setTimeout(() => { modalMap.invalidateSize(); }, 200);
        }

        // ── Open map modal ──
        function pilihPeta() {
            const modal = document.getElementById('mapModal');
            modal.style.display = 'flex';

            // Determine initial center: saved coordinates or default Pontianak
            let initLat = parseFloat(document.getElementById('latitudeInput').value);
            let initLon = parseFloat(document.getElementById('longitudeInput').value);

            if (isNaN(initLat) || isNaN(initLon)) {
                // No saved location — try GPS first
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function(pos) {
                            initLat = pos.coords.latitude;
                            initLon = pos.coords.longitude;
                            initModalMap(initLat, initLon);
                            onMapLocationSelected(initLat, initLon);
                        },
                        function() {
                            // GPS failed, use default
                            initModalMap(-0.026330, 109.342504);
                        },
                        { enableHighAccuracy: true, timeout: 8000, maximumAge: 0 }
                    );
                } else {
                    initModalMap(-0.026330, 109.342504);
                }
            } else {
                initModalMap(initLat, initLon);
            }
        }

        // ── GPS button inside modal ──
        function deteksiLokasiGPS() {
            const btn = document.getElementById('btnGPSModal');
            const label = document.getElementById('labelGPSModal');

            if (!navigator.geolocation) {
                alert('Browser tidak mendukung Geolocation.');
                return;
            }

            btn.style.opacity = '0.6';
            btn.style.pointerEvents = 'none';
            label.textContent = '⏳ Mendeteksi lokasi...';

            navigator.geolocation.getCurrentPosition(
                function(pos) {
                    const lat = pos.coords.latitude;
                    const lon = pos.coords.longitude;

                    if (modalMap && modalMarker) {
                        modalMarker.setLatLng([lat, lon]);
                        modalMap.setView([lat, lon], 17, { animate: true });
                    }
                    onMapLocationSelected(lat, lon);

                    btn.style.opacity = '1';
                    btn.style.pointerEvents = 'auto';
                    label.textContent = '📍 Lokasi Terdeteksi!';
                    setTimeout(() => { label.textContent = 'Gunakan Lokasi Saat Ini'; }, 2000);
                },
                function(error) {
                    let msg = 'Gagal mengambil lokasi.';
                    if (error.code === 1) msg = 'Izin lokasi ditolak.';
                    else if (error.code === 2) msg = 'Sinyal GPS tidak tersedia.';
                    else if (error.code === 3) msg = 'Waktu habis. Coba lagi.';
                    alert(msg);

                    btn.style.opacity = '1';
                    btn.style.pointerEvents = 'auto';
                    label.textContent = 'Gunakan Lokasi Saat Ini';
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        }

        // ── Confirm selected location ──
        function confirmMap() {
            document.getElementById('mapModal').style.display = 'none';
        }

        // Close on backdrop click
        document.getElementById('mapModal').addEventListener('click', function(e) {
            if (e.target === this) this.style.display = 'none';
        });

        // ── Form Submit ──
        document.getElementById('formJemputSampah').addEventListener('submit', function(e) {
            const lokasi = document.getElementById('lokasiInput').value.trim();
            const tanggal = document.getElementById('tanggalInput').value;
            const jam = document.getElementById('jamSelect').value;

            let errors = [];
            if (!lokasi) errors.push('Pilih lokasi penjemputan dari peta');
            if (!tanggal) errors.push('Pilih tanggal');
            if (!jam) errors.push('Pilih jam');

            if (errors.length > 0) {
                e.preventDefault();
                alert('⚠️ ' + errors.join('\n⚠️ '));
                return;
            }

            document.getElementById('pesanBtn').disabled = true;
            document.getElementById('pesanBtn').textContent = 'Memproses...';
        });

        // ── Auto-load on page load (e.g. after validation error) ──
        document.addEventListener('DOMContentLoaded', function() {
            const lat = document.getElementById('latitudeInput').value;
            const lon = document.getElementById('longitudeInput').value;
            if (lat && lon) {
                const parsedLat = parseFloat(lat);
                const parsedLon = parseFloat(lon);
                if (!isNaN(parsedLat) && !isNaN(parsedLon)) {
                    reverseGeocode(parsedLat, parsedLon);
                }
            }
        });
    </script>
</body>

</html>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Atur Alamat</title>
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

        .page-header {
            background: linear-gradient(135deg, #2ecc71 0%, #1aab57 60%, #168a45 100%);
            padding: 18px 20px 22px;
            flex-shrink: 0;
        }

        .scroll-area {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
        }

        .scroll-area::-webkit-scrollbar {
            display: none;
        }

        .white-card {
            background: #fff;
            border-radius: 18px;
            padding: 22px 20px;
            margin: 16px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        }

        .btn-simpan {
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
        }

        .btn-simpan:active {
            transform: scale(0.98);
            opacity: 0.9;
        }

        .btn-simpan:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-gps {
            width: 100%;
            background: #fff;
            border: 1.5px solid #e5e7eb;
            color: #374151;
            font-size: 13px;
            font-weight: 600;
            padding: 13px;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-gps:hover {
            border-color: #16a34a;
            color: #16a34a;
        }

        #mapContainer {
            border-radius: 14px;
            overflow: hidden;
            border: 1.5px solid #e5e7eb;
        }
    </style>
</head>

<body>
    <div class="phone-wrapper">

        <!-- HEADER -->
        <div class="page-header">
            <h1 style="font-size:18px;font-weight:800;color:#fff;">📍 Atur Alamat Kamu</h1>
            <p style="font-size:12px;color:rgba(255,255,255,0.8);margin-top:4px;">
                Untuk penjemputan langganan, kami butuh lokasi alamatmu
            </p>
        </div>

        <!-- SCROLL -->
        <div class="scroll-area">

            @if ($errors->any())
                <div
                    style="background:#fef2f2;border:1px solid #fca5a5;border-radius:12px;padding:12px 16px;margin:12px 16px 0;">
                    <ul style="font-size:11px;color:#dc2626;font-weight:500;list-style:none;margin:0;padding:0;">
                        @foreach ($errors->all() as $error)
                            <li style="margin-bottom:4px;">⚠️ {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pelanggan.simpan-alamat') }}" method="POST" id="formAlamat">
                @csrf

                <div class="white-card">
                    <!-- Info -->
                    <div
                        style="background:#f0fdf4;border:1px solid #86efac;border-radius:12px;padding:14px 16px;margin-bottom:18px;">
                        <div style="display:flex;align-items:flex-start;gap:10px;">
                            <span style="font-size:20px;">🏠</span>
                            <div>
                                <p style="font-size:13px;font-weight:700;color:#15803d;margin-bottom:2px;">Alamat Wajib
                                    Diisi</p>
                                <p style="font-size:11.5px;color:#6b7280;line-height:1.6;">
                                    Lokasi ini akan digunakan sebagai alamat penjemputan untuk pesanan langganan. Kamu
                                    bisa mengubahnya nanti di profil.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Peta -->
                    <p style="font-size:13px;font-weight:700;color:#111827;margin-bottom:10px;">Pilih Lokasi dari Peta
                    </p>
                    <div id="mapContainer" style="margin-bottom:14px;">
                        <div id="leafletMap" style="height:280px;width:100%;"></div>
                    </div>

                    <!-- GPS Button -->
                    <button type="button" class="btn-gps" onclick="deteksiGPS()" id="btnGps"
                        style="margin-bottom:16px;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span id="gpsLabel">📍 Gunakan Lokasi GPS Saat Ini</span>
                    </button>

                    <!-- Lokasi terpilih -->
                    <div style="background:#f9fafb;border:1.5px solid #e5e7eb;border-radius:12px;padding:14px;margin-bottom:16px;">
                        <p style="font-size:11px;color:#9ca3af;margin-bottom:4px;">Lokasi dipilih:</p>
                        <p style="font-size:13px;font-weight:600;color:#374151;line-height:1.5;" id="alamatText">
                            Geser marker atau klik peta untuk memilih lokasi</p>
                        <p style="font-size:11px;color:#9ca3af;margin-top:4px;display:none;" id="koordinatText"></p>
                    </div>

                    <!-- Hidden fields -->
                    <input type="hidden" name="alamat" id="alamatInput" value="{{ old('alamat', $user->alamat) }}">
                    <input type="hidden" name="latitude" id="latInput" value="{{ old('latitude', $user->latitude) }}">
                    <input type="hidden" name="longitude" id="lonInput"
                        value="{{ old('longitude', $user->longitude) }}">
                </div>

                <!-- Submit -->
                <div style="padding:0 16px 32px;">
                    <button type="submit" class="btn-simpan" id="btnSimpan">
                        ✅ Simpan Alamat & Lanjutkan
                    </button>
                </div>
            </form>
        </div>

    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let map, marker;
        const defaultLat = {{ $user->latitude ?: -0.026330 }};
        const defaultLon = {{ $user->longitude ?: 109.342504 }};

        document.addEventListener('DOMContentLoaded', function() {
            map = L.map('leafletMap', {
                zoomControl: false
            }).setView([defaultLat, defaultLon], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap',
                maxZoom: 19
            }).addTo(map);

            L.control.zoom({
                position: 'bottomright'
            }).addTo(map);

            marker = L.marker([defaultLat, defaultLon], {
                draggable: true
            }).addTo(map);
            marker.bindPopup('<b>📍 Lokasi Alamat</b><br>Geser atau klik peta').openPopup();

            marker.on('dragend', function(e) {
                const pos = e.target.getLatLng();
                onLocationSelected(pos.lat, pos.lng);
            });

            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                onLocationSelected(e.latlng.lat, e.latlng.lng);
            });

            // Jika user sudah punya koordinat
            const existingLat = document.getElementById('latInput').value;
            const existingLon = document.getElementById('lonInput').value;
            if (existingLat && existingLon) {
                const lat = parseFloat(existingLat);
                const lon = parseFloat(existingLon);
                marker.setLatLng([lat, lon]);
                map.setView([lat, lon], 16);
                reverseGeocode(lat, lon);
            }
        });

        function onLocationSelected(lat, lon) {
            document.getElementById('latInput').value = lat;
            document.getElementById('lonInput').value = lon;
            reverseGeocode(lat, lon);
        }

        function deteksiGPS() {
            const btn = document.getElementById('btnGps');
            const label = document.getElementById('gpsLabel');

            if (!navigator.geolocation) {
                alert('Browser tidak mendukung GPS.');
                return;
            }

            btn.disabled = true;
            label.textContent = '⏳ Mendeteksi lokasi...';

            navigator.geolocation.getCurrentPosition(
                function(pos) {
                    const lat = pos.coords.latitude;
                    const lon = pos.coords.longitude;

                    marker.setLatLng([lat, lon]);
                    map.setView([lat, lon], 17, {
                        animate: true
                    });
                    onLocationSelected(lat, lon);

                    btn.disabled = false;
                    label.textContent = '📍 Perbarui Lokasi GPS';
                },
                function(err) {
                    let msg = 'Gagal mendeteksi lokasi.';
                    if (err.code === 1) msg = 'Izin lokasi ditolak.';
                    alert(msg);
                    btn.disabled = false;
                    label.textContent = '📍 Gunakan Lokasi GPS Saat Ini';
                }, {
                    enableHighAccuracy: true,
                    timeout: 15000
                }
            );
        }

        function reverseGeocode(lat, lon) {
            const alamatText = document.getElementById('alamatText');
            const koordinatText = document.getElementById('koordinatText');
            const alamatInput = document.getElementById('alamatInput');

            alamatText.textContent = '⏳ Mendapatkan nama tempat...';

            fetch(
                    `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=18&addressdetails=1`, {
                        headers: {
                            'Accept-Language': 'id'
                        }
                    })
                .then(r => r.json())
                .then(data => {
                    const address = data.display_name || `Titik GPS: ${lat.toFixed(7)}, ${lon.toFixed(7)}`;
                    alamatInput.value = address;
                    alamatText.textContent = address;
                    koordinatText.textContent = `${lat.toFixed(7)}, ${lon.toFixed(7)}`;
                    koordinatText.style.display = 'block';
                    if (marker) {
                        marker.setPopupContent(
                            `<b>📍 Lokasi Alamat</b><br><span style="font-size:11px">${address}</span>`
                        ).openPopup();
                    }
                })
                .catch(() => {
                    const fallback = `Titik GPS: ${lat.toFixed(7)}, ${lon.toFixed(7)}`;
                    alamatInput.value = fallback;
                    alamatText.textContent = fallback;
                    koordinatText.textContent = `${lat.toFixed(7)}, ${lon.toFixed(7)}`;
                    koordinatText.style.display = 'block';
                });
        }
    </script>
</body>

</html>

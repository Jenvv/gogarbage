@extends('admin.layouts.app')
@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Pengaturan Sistem</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola konfigurasi ongkir, biaya, poin, dan lokasi bank sampah</p>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-700 dark:bg-green-500/10 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif

    @php
        $ongkirBaseFee = $configs->firstWhere('kunci', 'ongkir_base_fee');
        $ongkirPerKm = $configs->firstWhere('kunci', 'ongkir_per_km');
        $biayaAdminReguler = $configs->firstWhere('kunci', 'biaya_admin_reguler');
        $komisiAdminPersen = $configs->firstWhere('kunci', 'komisi_admin_persen');
        $poinPerKg = $configs->firstWhere('kunci', 'poin_per_kg');
        $poinPerOrder = $configs->firstWhere('kunci', 'poin_per_order');
        $latBankSampah = $configs->firstWhere('kunci', 'lat_bank_sampah');
        $lonBankSampah = $configs->firstWhere('kunci', 'lon_bank_sampah');
    @endphp

    <form action="{{ route('admin.konfigurasi.update') }}" method="POST">
        @csrf

        {{-- Section: Ongkir --}}
        <h3 class="text-base font-semibold text-gray-700 dark:text-white/80 mb-3">💰 Pengaturan Ongkir</h3>
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-8">
            {{-- Base Ongkir --}}
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-500/10 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white">Base Ongkir</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Tarif dasar ongkir jika jarak ≤ 1 KM</p>
                    </div>
                </div>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-500">Rp</span>
                    <input type="number" name="ongkir_base_fee" value="{{ old('ongkir_base_fee', $ongkirBaseFee->nilai ?? 10000) }}" min="0"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-sm text-gray-800 dark:text-white pl-10 pr-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                @error('ongkir_base_fee')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Ongkir per KM --}}
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-500/10 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white">Tarif per KM</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Tambahan ongkir per KM setelah 1 KM pertama</p>
                    </div>
                </div>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-500">Rp</span>
                    <input type="number" name="ongkir_per_km" value="{{ old('ongkir_per_km', $ongkirPerKm->nilai ?? 2500) }}" min="0"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-sm text-gray-800 dark:text-white pl-10 pr-14 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-semibold text-gray-500">/KM</span>
                </div>
                @error('ongkir_per_km')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Biaya Admin --}}
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-500/10 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white">Biaya Admin</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Platform fee untuk pelanggan reguler (gratis untuk langganan)</p>
                    </div>
                </div>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-500">Rp</span>
                    <input type="number" name="biaya_admin_reguler" value="{{ old('biaya_admin_reguler', $biayaAdminReguler->nilai ?? 2000) }}" min="0"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-sm text-gray-800 dark:text-white pl-10 pr-4 py-3 focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                </div>
                @error('biaya_admin_reguler')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Komisi Admin (Persentase) --}}
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-red-50 dark:bg-red-500/10 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white">Komisi Admin</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Persentase dari biaya jemput reguler yang menjadi komisi admin</p>
                    </div>
                </div>
                <div class="relative">
                    <input type="number" name="komisi_admin_persen" value="{{ old('komisi_admin_persen', $komisiAdminPersen->nilai ?? 10) }}" min="0" max="100" step="0.1"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-sm text-gray-800 dark:text-white pl-4 pr-10 py-3 focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-500">%</span>
                </div>
                <p class="mt-2 text-xs text-gray-400 dark:text-gray-500">Contoh: 10% dari Rp 15.000 = Rp 1.500 untuk admin</p>
                @error('komisi_admin_persen')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Section: Poin --}}
        <h3 class="text-base font-semibold text-gray-700 dark:text-white/80 mb-3">⭐ Pengaturan Poin</h3>
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-8">
            {{-- Poin per KG --}}
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-amber-100 dark:bg-amber-500/10 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white">Poin per Kilogram</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Jumlah poin yang didapat pelanggan per 1 kg sampah</p>
                    </div>
                </div>
                <div class="relative">
                    <input type="number" name="poin_per_kg" value="{{ old('poin_per_kg', $poinPerKg->nilai ?? 10) }}" min="0"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-sm text-gray-800 dark:text-white pl-4 pr-14 py-3 focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-semibold text-gray-500">poin/kg</span>
                </div>
                @error('poin_per_kg')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Poin per Order --}}
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-500/10 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white">Bonus Poin per Order</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Bonus poin yang didapat pelanggan setiap kali order</p>
                    </div>
                </div>
                <div class="relative">
                    <input type="number" name="poin_per_order" value="{{ old('poin_per_order', $poinPerOrder->nilai ?? 5) }}" min="0"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-sm text-gray-800 dark:text-white pl-4 pr-16 py-3 focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-semibold text-gray-500">poin/order</span>
                </div>
                @error('poin_per_order')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Section: Lokasi Bank Sampah --}}
        <h3 class="text-base font-semibold text-gray-700 dark:text-white/80 mb-3">📍 Lokasi Bank Sampah</h3>
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-6 mb-8">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 bg-teal-100 dark:bg-teal-500/10 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white">Titik Lokasi Bank Sampah</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Titik awal perhitungan jarak ongkir ke pelanggan</p>
                </div>
            </div>

            {{-- Current Location Display --}}
            <div id="lokasiInfo" class="rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-4 mb-4">
                @php
                    $latVal = old('lat_bank_sampah', $latBankSampah->nilai ?? '');
                    $lonVal = old('lon_bank_sampah', $lonBankSampah->nilai ?? '');
                    $hasLocation = $latVal && $lonVal;
                @endphp

                @if($hasLocation)
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-green-100 dark:bg-green-500/10 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-green-700 dark:text-green-400 mb-1">Lokasi Tersimpan</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white" id="alamatLokasi">Memuat alamat...</p>
                            <p class="text-xs text-gray-400 mt-1" id="koordinatText">{{ $latVal }}, {{ $lonVal }}</p>
                            <a id="linkMaps" href="https://www.google.com/maps?q={{ $latVal }},{{ $lonVal }}" target="_blank" rel="noopener"
                                class="inline-flex items-center gap-1 mt-2 text-xs font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                Lihat di Google Maps →
                            </a>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-amber-100 dark:bg-amber-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-amber-700 dark:text-amber-400">Lokasi belum diatur</p>
                            <p class="text-xs text-gray-400">Gunakan GPS atau pilih dari peta di bawah</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Interactive Map --}}
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
            <div class="rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 mb-4" style="position: relative;">
                <div id="adminMap" style="height: 350px; width: 100%; z-index: 1;"></div>
                {{-- Map overlay hint --}}
                <div id="mapHint" class="absolute top-3 left-1/2 -translate-x-1/2 z-[1000] bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-full px-4 py-2 shadow-lg border border-gray-200 dark:border-gray-700 pointer-events-none transition-opacity duration-500"
                     style="opacity: 1;">
                    <p class="text-xs font-semibold text-gray-600 dark:text-gray-300 flex items-center gap-1.5">
                        <span>👆</span> Klik pada peta atau geser marker untuk memilih lokasi
                    </p>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                {{-- GPS Button --}}
                <button type="button" id="btnDeteksiLokasi" onclick="deteksiLokasi()"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-teal-600 px-4 py-3 text-sm font-semibold text-white hover:bg-teal-700 active:scale-[0.98] transition-all shadow-sm">
                    <svg class="w-5 h-5" id="iconLokasi" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span id="labelDeteksi">📍 Gunakan Lokasi Saat Ini</span>
                </button>
                {{-- Center Map Button --}}
                <button type="button" id="btnCenterMap" onclick="centerMapToMarker()"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white hover:bg-indigo-700 active:scale-[0.98] transition-all shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    🗺️ Tengahkan ke Marker
                </button>
            </div>
            <p class="text-xs text-gray-400 text-center">Klik pada peta untuk memilih lokasi, atau gunakan GPS untuk deteksi otomatis</p>

            {{-- Hidden Inputs --}}
            <input type="hidden" name="lat_bank_sampah" id="inputLat" value="{{ $latVal }}">
            <input type="hidden" name="lon_bank_sampah" id="inputLon" value="{{ $lonVal }}">

            @error('lat_bank_sampah')
                <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
            @enderror
            @error('lon_bank_sampah')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit --}}
        <div class="flex justify-end">
            <button type="submit"
                class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-6 py-2.5 text-sm font-medium text-white hover:bg-green-700 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Pengaturan
            </button>
        </div>
    </form>

    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let map, marker;
        const defaultLat = {{ $latVal ?: -0.026330 }};
        const defaultLon = {{ $lonVal ?: 109.342504 }};

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize map
            map = L.map('adminMap').setView([defaultLat, defaultLon], 15);

            // Add OpenStreetMap tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                maxZoom: 19
            }).addTo(map);

            // Create draggable marker
            marker = L.marker([defaultLat, defaultLon], {
                draggable: true
            }).addTo(map);

            // Custom popup
            marker.bindPopup('<b>📍 Bank Sampah</b><br>Geser marker atau klik peta untuk pindah').openPopup();

            // When marker is dragged
            marker.on('dragend', function(e) {
                const pos = e.target.getLatLng();
                onLocationSelected(pos.lat, pos.lng);
            });

            // When map is clicked
            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                onLocationSelected(e.latlng.lat, e.latlng.lng);
            });

            // Hide hint after 5 seconds
            setTimeout(() => {
                const hint = document.getElementById('mapHint');
                if (hint) hint.style.opacity = '0';
                setTimeout(() => { if (hint) hint.style.display = 'none'; }, 500);
            }, 5000);

            // Load initial address if coordinates exist
            const lat = document.getElementById('inputLat').value;
            const lon = document.getElementById('inputLon').value;
            if (lat && lon) {
                reverseGeocode(parseFloat(lat), parseFloat(lon));
            }
        });

        function onLocationSelected(lat, lon) {
            // Update hidden inputs
            document.getElementById('inputLat').value = lat;
            document.getElementById('inputLon').value = lon;

            // Update popup
            marker.setPopupContent('<b>📍 Bank Sampah</b><br>Memuat alamat...').openPopup();

            // Update info UI
            updateLokasiUI(lat, lon);
            reverseGeocode(lat, lon);
        }

        function centerMapToMarker() {
            if (marker && map) {
                map.setView(marker.getLatLng(), 17, { animate: true });
                marker.openPopup();
            }
        }

        function deteksiLokasi() {
            const btn = document.getElementById('btnDeteksiLokasi');
            const label = document.getElementById('labelDeteksi');

            if (!navigator.geolocation) {
                alert('Browser Anda tidak mendukung Geolocation.');
                return;
            }

            // Loading state
            btn.disabled = true;
            btn.classList.add('opacity-70');
            label.textContent = '⏳ Mendeteksi lokasi...';

            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;

                    // Set hidden inputs
                    document.getElementById('inputLat').value = lat;
                    document.getElementById('inputLon').value = lon;

                    // Move marker and center map
                    marker.setLatLng([lat, lon]);
                    map.setView([lat, lon], 17, { animate: true });

                    // Update UI
                    updateLokasiUI(lat, lon);
                    reverseGeocode(lat, lon);

                    // Reset button
                    btn.disabled = false;
                    btn.classList.remove('opacity-70');
                    label.textContent = '📍 Perbarui Lokasi';
                },
                function(error) {
                    let msg = 'Gagal mendeteksi lokasi.';
                    if (error.code === 1) msg = 'Izin lokasi ditolak. Silakan izinkan akses lokasi di pengaturan browser.';
                    else if (error.code === 2) msg = 'Sinyal GPS tidak tersedia.';
                    else if (error.code === 3) msg = 'Waktu deteksi habis. Coba lagi.';
                    alert(msg);

                    btn.disabled = false;
                    btn.classList.remove('opacity-70');
                    label.textContent = '📍 Gunakan Lokasi Saat Ini';
                },
                { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
            );
        }

        function updateLokasiUI(lat, lon) {
            const container = document.getElementById('lokasiInfo');
            container.innerHTML = `
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-green-100 dark:bg-green-500/10 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-green-700 dark:text-green-400 mb-1">Lokasi Dipilih ✓</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white" id="alamatLokasi">Memuat alamat...</p>
                        <p class="text-xs text-gray-400 mt-1" id="koordinatText">${lat.toFixed(7)}, ${lon.toFixed(7)}</p>
                        <a id="linkMaps" href="https://www.google.com/maps?q=${lat},${lon}" target="_blank" rel="noopener"
                            class="inline-flex items-center gap-1 mt-2 text-xs font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Lihat di Google Maps →
                        </a>
                    </div>
                </div>
            `;
        }

        function reverseGeocode(lat, lon) {
            const el = document.getElementById('alamatLokasi');
            if (!el) return;

            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=18&addressdetails=1`, {
                headers: { 'Accept-Language': 'id' }
            })
            .then(r => r.json())
            .then(data => {
                const address = data.display_name || `${lat.toFixed(5)}, ${lon.toFixed(5)}`;
                el.textContent = address;
                // Also update marker popup
                if (marker) {
                    marker.setPopupContent(`<b>📍 Bank Sampah</b><br><span style="font-size:11px">${address}</span>`).openPopup();
                }
            })
            .catch(() => {
                el.textContent = `${lat.toFixed(5)}, ${lon.toFixed(5)}`;
            });
        }
    </script>
@endsection

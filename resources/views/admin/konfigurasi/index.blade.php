@extends('admin.layouts.app')
@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Pengaturan Sistem</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola konfigurasi biaya, poin, dan komisi</p>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-700 dark:bg-green-500/10 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif

    @php
        $biayaJemput = $configs->firstWhere('kunci', 'biaya_jemput');
        $poinPerKg = $configs->firstWhere('kunci', 'poin_per_kg');
        $poinPerOrder = $configs->firstWhere('kunci', 'poin_per_order');
        $komisiPersen = $configs->firstWhere('kunci', 'komisi_pengangkut_persen');
    @endphp

    <form action="{{ route('admin.konfigurasi.update') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            {{-- Biaya Jemput --}}
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-500/10 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white">Biaya Jemput</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Biaya jemput sampah untuk pelanggan non-berlangganan</p>
                    </div>
                </div>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-500">Rp</span>
                    <input type="number" name="biaya_jemput" value="{{ old('biaya_jemput', $biayaJemput->nilai ?? 5000) }}" min="0"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-sm text-gray-800 dark:text-white pl-10 pr-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                @error('biaya_jemput')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Komisi Pengangkut --}}
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-500/10 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white">Komisi Juru Angkut</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Persentase dari biaya jemput untuk juru angkut</p>
                    </div>
                </div>
                <div class="relative">
                    <input type="number" name="komisi_pengangkut_persen" value="{{ old('komisi_pengangkut_persen', $komisiPersen->nilai ?? 70) }}" min="0" max="100"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-sm text-gray-800 dark:text-white pl-4 pr-10 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-500">%</span>
                </div>
                <p class="mt-2 text-xs text-gray-400">Sisa {{ 100 - ($komisiPersen->nilai ?? 70) }}% menjadi bagian perusahaan</p>
                @error('komisi_pengangkut_persen')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

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

        {{-- Submit --}}
        <div class="mt-6 flex justify-end">
            <button type="submit"
                class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-6 py-2.5 text-sm font-medium text-white hover:bg-green-700 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Pengaturan
            </button>
        </div>
    </form>
@endsection

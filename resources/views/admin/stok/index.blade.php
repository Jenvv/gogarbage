@extends('admin.layouts.app')
@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Stok Sampah Global</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pantau stok sampah organik & anorganik di gudang</p>
        </div>
    </div>

    <!-- Stok Cards per Kategori -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4 md:gap-6 mb-6">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Plastik</span>
            </div>
            <h4 class="text-2xl font-bold text-gray-800 dark:text-white/90">- kg</h4>
            <p class="text-xs text-gray-400 mt-1">Stok tersedia</p>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Kertas</span>
            </div>
            <h4 class="text-2xl font-bold text-gray-800 dark:text-white/90">- kg</h4>
            <p class="text-xs text-gray-400 mt-1">Stok tersedia</p>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-3 h-3 rounded-full bg-gray-500"></div>
                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Logam</span>
            </div>
            <h4 class="text-2xl font-bold text-gray-800 dark:text-white/90">- kg</h4>
            <p class="text-xs text-gray-400 mt-1">Stok tersedia</p>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-3 h-3 rounded-full bg-cyan-500"></div>
                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Kaca</span>
            </div>
            <h4 class="text-2xl font-bold text-gray-800 dark:text-white/90">- kg</h4>
            <p class="text-xs text-gray-400 mt-1">Stok tersedia</p>
        </div>
    </div>

    <!-- Log Stok -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-5 pt-5 md:px-6 md:pt-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Log Mutasi Stok</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Riwayat stok masuk & keluar gudang</p>
        </div>
        <div class="p-5 md:p-6 overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Kategori</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Tipe</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah (kg)</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Stok Sebelum</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Stok Sesudah</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Sumber</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="7" class="py-8 text-center text-sm text-gray-400">Data akan ditampilkan setelah integrasi</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

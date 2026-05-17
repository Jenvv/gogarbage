@extends('admin.layouts.app')
@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Transaksi Pengepul</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Transaksi terbaru dari juru angkut ke pengepul</p>
        </div>
        <button class="inline-flex items-center gap-2 rounded-lg bg-green-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-green-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Buat Penjualan
        </button>
    </div>

    <!-- Summary Cards (Figma style) -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 md:gap-6 mb-6">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Transaksi</p>
            <h4 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">-</h4>
            <p class="text-xs text-gray-400 mt-1">Bulan ini</p>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Berat</p>
            <h4 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">- kg</h4>
            <p class="text-xs text-gray-400 mt-1">Bulan ini</p>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Pendapatan</p>
            <h4 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">-</h4>
            <p class="text-xs text-gray-400 mt-1">Bulan ini</p>
        </div>
    </div>

    <!-- Transaction Table (Figma style) -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-5 pt-5 md:px-6 md:pt-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Riwayat Transaksi</h3>
        </div>
        <div class="p-5 md:p-6 overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">No. Invoice</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Pengepul</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Jenis Sampah</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Berat</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Harga</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Status</th>
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

@extends('admin.layouts.app')
@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Kelola Langganan</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Verifikasi dan kelola langganan pelanggan</p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 md:gap-6 mb-6">
        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 dark:border-amber-800 dark:bg-amber-500/10">
            <p class="text-sm text-amber-600 dark:text-amber-400 font-medium">Menunggu Verifikasi</p>
            <h4 class="mt-2 text-2xl font-bold text-amber-700 dark:text-amber-300">-</h4>
        </div>
        <div class="rounded-2xl border border-green-200 bg-green-50 p-5 dark:border-green-800 dark:bg-green-500/10">
            <p class="text-sm text-green-600 dark:text-green-400 font-medium">Aktif</p>
            <h4 class="mt-2 text-2xl font-bold text-green-700 dark:text-green-300">-</h4>
        </div>
        <div class="rounded-2xl border border-red-200 bg-red-50 p-5 dark:border-red-800 dark:bg-red-500/10">
            <p class="text-sm text-red-600 dark:text-red-400 font-medium">Dibatalkan</p>
            <h4 class="mt-2 text-2xl font-bold text-red-700 dark:text-red-300">-</h4>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="flex flex-wrap gap-2 mb-6">
        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-green-500 text-white">Semua</span>
        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 cursor-pointer hover:bg-gray-200">Menunggu</span>
        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 cursor-pointer hover:bg-gray-200">Menunggu Tunai</span>
        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 cursor-pointer hover:bg-gray-200">Aktif</span>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="p-5 md:p-6 overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Pelanggan</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Paket</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Metode Bayar</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Status</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Bukti</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Aksi</th>
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

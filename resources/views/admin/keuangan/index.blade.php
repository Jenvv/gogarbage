@extends('admin.layouts.app')
@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Keuangan</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Monitoring transaksi keuangan & penarikan saldo</p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4 md:gap-6 mb-6">
        <div class="rounded-2xl border border-green-200 bg-green-50 p-5 dark:border-green-800 dark:bg-green-500/10">
            <p class="text-sm text-green-600 dark:text-green-400 font-medium">Total Pendapatan</p>
            <h4 class="mt-2 text-2xl font-bold text-green-700 dark:text-green-300">-</h4>
        </div>
        <div class="rounded-2xl border border-blue-200 bg-blue-50 p-5 dark:border-blue-800 dark:bg-blue-500/10">
            <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Komisi JA (Total)</p>
            <h4 class="mt-2 text-2xl font-bold text-blue-700 dark:text-blue-300">-</h4>
        </div>
        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 dark:border-amber-800 dark:bg-amber-500/10">
            <p class="text-sm text-amber-600 dark:text-amber-400 font-medium">Penarikan Menunggu</p>
            <h4 class="mt-2 text-2xl font-bold text-amber-700 dark:text-amber-300">-</h4>
        </div>
        <div class="rounded-2xl border border-purple-200 bg-purple-50 p-5 dark:border-purple-800 dark:bg-purple-500/10">
            <p class="text-sm text-purple-600 dark:text-purple-400 font-medium">Bagian Perusahaan</p>
            <h4 class="mt-2 text-2xl font-bold text-purple-700 dark:text-purple-300">-</h4>
        </div>
    </div>

    <!-- Penarikan Saldo Table -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] mb-6">
        <div class="px-5 pt-5 md:px-6 md:pt-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Permintaan Penarikan Saldo</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Approve atau tolak penarikan saldo</p>
        </div>
        <div class="p-5 md:p-6 overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">User</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Metode</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Rekening</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Status</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" class="py-8 text-center text-sm text-gray-400">Data akan ditampilkan setelah integrasi</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Riwayat Transaksi -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-5 pt-5 md:px-6 md:pt-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Riwayat Transaksi</h3>
        </div>
        <div class="p-5 md:p-6 overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">No. Transaksi</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">User</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Tipe</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Status</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" class="py-8 text-center text-sm text-gray-400">Data akan ditampilkan setelah integrasi</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

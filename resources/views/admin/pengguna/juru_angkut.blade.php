@extends('admin.layouts.app')
@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Data Juru Angkut</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola dan daftarkan akun juru angkut</p>
        </div>
        <button class="inline-flex items-center gap-2 rounded-lg bg-green-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-green-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Juru Angkut
        </button>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="p-5 md:p-6 overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Nama</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Email</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Telepon</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Saldo</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Total Order</th>
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
@endsection

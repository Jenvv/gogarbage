@extends('admin.layouts.app')
@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Data Pelanggan</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola semua akun pelanggan</p>
        </div>
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
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Poin</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggan as $user)
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <td class="py-3 text-sm text-gray-700 dark:text-gray-300">{{ $user->name }}</td>
                            <td class="py-3 text-sm text-gray-700 dark:text-gray-300">{{ $user->email }}</td>
                            <td class="py-3 text-sm text-gray-700 dark:text-gray-300">{{ $user->telepon ?? '-' }}</td>
                            <td class="py-3 text-sm font-semibold text-gray-700 dark:text-gray-300">Rp {{ number_format($user->saldo, 0, ',', '.') }}</td>
                            <td class="py-3 text-sm text-gray-700 dark:text-gray-300">{{ number_format($user->poin) }}</td>
                            <td class="py-3 text-sm text-gray-400">Read-only</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-sm text-gray-400">Belum ada data pelanggan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

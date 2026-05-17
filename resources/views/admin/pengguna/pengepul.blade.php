@extends('admin.layouts.app')
@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Data Pengepul</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola data pengepul sampah</p>
        </div>
        <button class="inline-flex items-center gap-2 rounded-lg bg-green-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-green-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Pengepul
        </button>
    </div>

    <!-- Pengepul Cards (Figma style) -->
    <div class="space-y-4">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-400 dark:text-gray-500">Belum ada data pengepul</p>
                </div>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Data pengepul akan ditampilkan sebagai card dengan informasi kontak, total transaksi, dan total berat sampah yang dibeli.</p>
        </div>
    </div>
@endsection

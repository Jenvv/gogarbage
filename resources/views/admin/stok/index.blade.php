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
        @php
            $dotColors = ['bg-blue-500', 'bg-amber-500', 'bg-gray-500', 'bg-cyan-500', 'bg-green-500', 'bg-pink-500'];
        @endphp
        @foreach ($categories as $i => $cat)
            @php
                $stok = $cat->stokGudang;
                $color = $dotColors[$i % count($dotColors)];
            @endphp
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-3 h-3 rounded-full {{ $color }}"></div>
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $cat->nama }}</span>
                </div>
                <h4 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                    {{ number_format($stok->stok_kg ?? 0, 2, ',', '.') }} kg</h4>
                <p class="text-xs text-gray-400 mt-1">Stok tersedia</p>
            </div>
        @endforeach
    </div>

    <!-- Adjustment Form -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] mb-6">
        <div class="p-5 md:p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Adjustment Stok (opsional)</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Lakukan koreksi manual stok: masuk atau keluar.</p>

            @if (session('success'))
                <div class="mt-4 p-3 rounded bg-green-50 dark:bg-green-900/20 text-green-800 dark:text-green-300">
                    {{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mt-4 p-3 rounded bg-red-50 dark:bg-red-900/20 text-red-800 dark:text-red-300">
                    {{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="mt-4 p-3 rounded bg-yellow-50 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-300">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.stok.adjust') }}" method="post">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-white/90 mb-2">Kategori</label>
                        <select name="kategori_sampah_id" required
                            class="w-full px-4 py-2.5 rounded-lg bg-white dark:bg-gray-800 text-gray-800 dark:text-white/90 shadow-sm dark:shadow-md hover:shadow-md dark:hover:shadow-lg transition-all focus:outline-none focus:ring-2 focus:ring-green-500 dark:focus:ring-green-400 appearance-none cursor-pointer">
                            <option value="" class="text-gray-500">-- Pilih kategori --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                            @endforeach
                        </select>
                        @error('kategori_sampah_id')
                            <p class="text-xs text-red-600 dark:text-red-400 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-white/90 mb-2">Jumlah (kg)</label>
                        <input name="jumlah_kg" type="number" step="0.01" min="0" required placeholder="0.00"
                            class="w-full px-4 py-2.5 rounded-lg bg-white dark:bg-gray-800 text-gray-800 dark:text-white/90 placeholder-gray-400 dark:placeholder-gray-500 shadow-sm dark:shadow-md hover:shadow-md dark:hover:shadow-lg transition-all focus:outline-none focus:ring-2 focus:ring-green-500 dark:focus:ring-green-400" />
                        @error('jumlah_kg')
                            <p class="text-xs text-red-600 dark:text-red-400 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-white/90 mb-2">Tipe</label>
                        <select name="tipe" required
                            class="w-full px-4 py-2.5 rounded-lg bg-white dark:bg-gray-800 text-gray-800 dark:text-white/90 shadow-sm dark:shadow-md hover:shadow-md dark:hover:shadow-lg transition-all focus:outline-none focus:ring-2 focus:ring-green-500 dark:focus:ring-green-400 appearance-none cursor-pointer">
                            <option value="masuk">📥 Masuk</option>
                            <option value="keluar">📤 Keluar</option>
                        </select>
                        @error('tipe')
                            <p class="text-xs text-red-600 dark:text-red-400 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-white/90 mb-2">Deskripsi
                        (opsional)</label>
                    <textarea name="deskripsi" rows="2" placeholder="Catatan tambahan untuk adjustment ini..."
                        class="w-full px-4 py-2.5 rounded-lg bg-white dark:bg-gray-800 text-gray-800 dark:text-white/90 placeholder-gray-400 dark:placeholder-gray-500 shadow-sm dark:shadow-md hover:shadow-md dark:hover:shadow-lg transition-all focus:outline-none focus:ring-2 focus:ring-green-500 dark:focus:ring-green-400 resize-none"></textarea>
                    @error('deskripsi')
                        <p class="text-xs text-red-600 dark:text-red-400 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end">
                    <button type="submit"
                        class="px-8 py-3 rounded-lg font-bold text-white bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 dark:bg-gradient-to-br dark:from-green-600 dark:to-emerald-700 dark:hover:from-green-700 dark:hover:to-emerald-800 shadow-lg dark:shadow-green-900/50 hover:shadow-2xl dark:hover:shadow-green-800/70 focus:outline-none focus:ring-2 focus:ring-green-400 dark:focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-all duration-200 transform hover:scale-105 active:scale-95 inline-flex items-center gap-2.5">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Simpan Adjustment
                    </button>
                </div>
            </form>
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
                    @forelse($logs as $log)
                        <tr>
                            <td class="py-3 text-sm text-gray-700 dark:text-white/80">
                                {{ $log->created_at->format('Y-m-d H:i') }}</td>
                            <td class="py-3 text-sm text-gray-700 dark:text-white/80">{{ $log->kategori->nama ?? '-' }}
                            </td>
                            <td class="py-3 text-sm text-gray-700 dark:text-white/80">{{ ucfirst($log->tipe) }}</td>
                            <td class="py-3 text-sm text-gray-700 dark:text-white/80">
                                {{ number_format($log->jumlah_kg, 2, ',', '.') }}</td>
                            <td class="py-3 text-sm text-gray-700 dark:text-white/80">
                                {{ number_format($log->stok_sebelum, 2, ',', '.') }}</td>
                            <td class="py-3 text-sm text-gray-700 dark:text-white/80">
                                {{ number_format($log->stok_sesudah, 2, ',', '.') }}</td>
                            <td class="py-3 text-sm text-gray-700 dark:text-white/80">
                                {{ $log->sumber_type ? class_basename($log->sumber_type) . ' #' . $log->sumber_id : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-sm text-gray-400">Belum ada log mutasi stok</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

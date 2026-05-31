@extends('admin.layouts.app')
@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Keuangan</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Monitoring transaksi keuangan, top up & penarikan saldo</p>
        </div>
        <button onclick="openModal('koreksiModal')"
            class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Koreksi Saldo
        </button>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-700 dark:bg-green-500/10 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-700 dark:bg-red-500/10 dark:text-red-400">
            {{ session('error') }}
        </div>
    @endif

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5 md:gap-6 mb-6">
        <div class="rounded-2xl border border-green-200 bg-green-50 p-5 dark:border-green-800 dark:bg-green-500/10">
            <p class="text-sm text-green-600 dark:text-green-400 font-medium">Total Pendapatan</p>
            <h4 class="mt-2 text-2xl font-bold text-green-700 dark:text-green-300">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h4>
        </div>
        <div class="rounded-2xl border border-blue-200 bg-blue-50 p-5 dark:border-blue-800 dark:bg-blue-500/10">
            <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Ongkir JA (Total)</p>
            <h4 class="mt-2 text-2xl font-bold text-blue-700 dark:text-blue-300">Rp {{ number_format($totalOngkirJA, 0, ',', '.') }}</h4>
            <p class="mt-1 text-xs text-blue-500 dark:text-blue-400">Subsidi: Rp {{ number_format($totalSubsidiOngkir, 0, ',', '.') }}</p>
        </div>
        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 dark:border-amber-800 dark:bg-amber-500/10">
            <p class="text-sm text-amber-600 dark:text-amber-400 font-medium">Penarikan Menunggu</p>
            <h4 class="mt-2 text-2xl font-bold text-amber-700 dark:text-amber-300">Rp {{ number_format($totalPenarikanMenunggu, 0, ',', '.') }}</h4>
            <p class="mt-1 text-xs text-amber-500 dark:text-amber-400">{{ $jumlahPenarikanMenunggu }} permintaan</p>
        </div>
        <div class="rounded-2xl border border-cyan-200 bg-cyan-50 p-5 dark:border-cyan-800 dark:bg-cyan-500/10">
            <p class="text-sm text-cyan-600 dark:text-cyan-400 font-medium">Top Up Menunggu</p>
            <h4 class="mt-2 text-2xl font-bold text-cyan-700 dark:text-cyan-300">Rp {{ number_format($totalTopUpMenunggu, 0, ',', '.') }}</h4>
            <p class="mt-1 text-xs text-cyan-500 dark:text-cyan-400">{{ $jumlahTopUpMenunggu }} permintaan</p>
        </div>
        <div class="rounded-2xl border border-purple-200 bg-purple-50 p-5 dark:border-purple-800 dark:bg-purple-500/10">
            <p class="text-sm text-purple-600 dark:text-purple-400 font-medium">Biaya Admin (Total)</p>
            <h4 class="mt-2 text-2xl font-bold text-purple-700 dark:text-purple-300">Rp {{ number_format($totalBiayaAdmin, 0, ',', '.') }}</h4>
        </div>
    </div>

    <!-- ═══ TOP UP REQUESTS TABLE ═══ -->
    <div x-data="{ search: '', page: 1, perPage: 10 }" class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] mb-6">
        <div class="px-5 pt-5 md:px-6 md:pt-6 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Permintaan Top Up Saldo</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $topUps->count() }} total permintaan</p>
            </div>
        </div>
        <div class="p-5 md:p-6 overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">No</th>
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jumlah</th>
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Metode</th>
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="pb-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($topUps as $i => $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02] transition-colors">
                            <td class="py-3 pr-4 text-sm text-gray-500 dark:text-gray-400">{{ $i + 1 }}</td>
                            <td class="py-3 pr-4">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $item->pengguna->name ?? '-' }}</p>
                                <p class="text-xs text-gray-400">{{ $item->pengguna->email ?? '' }}</p>
                            </td>
                            <td class="py-3 pr-4 text-sm font-semibold text-green-600 dark:text-green-400">+Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                            <td class="py-3 pr-4">
                                <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">{{ $item->metode_pembayaran }}</span>
                            </td>
                            <td class="py-3 pr-4">
                                @if($item->status === 'menunggu')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Menunggu
                                    </span>
                                @elseif($item->status === 'disetujui')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-semibold text-green-700 dark:bg-green-500/10 dark:text-green-400">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> Disetujui
                                    </span>
                                @elseif($item->status === 'ditolak')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-semibold text-red-700 dark:bg-red-500/10 dark:text-red-400">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg> Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 pr-4 text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $item->created_at->format('d M Y H:i') }}</td>
                            <td class="py-3 text-center">
                                <button onclick="openTopUpModal({{ $item->id }})"
                                    class="inline-flex items-center gap-1 rounded-lg {{ $item->status === 'menunggu' ? 'bg-blue-600 hover:bg-blue-700 text-white' : 'bg-gray-100 hover:bg-gray-200 text-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700' }} px-3 py-1.5 text-xs font-medium transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center">
                                <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                                <p class="text-sm text-gray-400">Belum ada permintaan top up</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ═══ PENARIKAN SALDO TABLE ═══ -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] mb-6">
        <div class="px-5 pt-5 md:px-6 md:pt-6 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Permintaan Penarikan Saldo</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $penarikan->count() }} total permintaan</p>
            </div>
        </div>
        <div class="p-5 md:p-6 overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">No</th>
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jumlah</th>
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tujuan Bank</th>
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="pb-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($penarikan as $i => $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02] transition-colors">
                            <td class="py-3 pr-4 text-sm text-gray-500 dark:text-gray-400">{{ $i + 1 }}</td>
                            <td class="py-3 pr-4">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $item->pengguna->name ?? '-' }}</p>
                                <p class="text-xs text-gray-400">{{ $item->pengguna->email ?? '' }}</p>
                            </td>
                            <td class="py-3 pr-4 text-sm font-semibold text-red-600 dark:text-red-400">-Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                            <td class="py-3 pr-4">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $item->nama_bank ?? '-' }}</p>
                                <p class="text-xs text-gray-400">{{ $item->nomor_rekening }} · {{ $item->nama_rekening }}</p>
                            </td>
                            <td class="py-3 pr-4">
                                @if($item->status === 'menunggu')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Menunggu
                                    </span>
                                @elseif($item->status === 'disetujui' || $item->status === 'selesai')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-semibold text-green-700 dark:bg-green-500/10 dark:text-green-400">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> Disetujui
                                    </span>
                                @elseif($item->status === 'ditolak')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-semibold text-red-700 dark:bg-red-500/10 dark:text-red-400">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg> Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 pr-4 text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $item->created_at->format('d M Y H:i') }}</td>
                            <td class="py-3 text-center">
                                <button onclick="openPenarikanModal({{ $item->id }})"
                                    class="inline-flex items-center gap-1 rounded-lg {{ $item->status === 'menunggu' ? 'bg-blue-600 hover:bg-blue-700 text-white' : 'bg-gray-100 hover:bg-gray-200 text-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700' }} px-3 py-1.5 text-xs font-medium transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center">
                                <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                                <p class="text-sm text-gray-400">Belum ada permintaan penarikan saldo</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ═══ RIWAYAT TRANSAKSI TABLE ═══ -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-5 pt-5 md:px-6 md:pt-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Riwayat Transaksi</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $transaksi->count() }} total transaksi</p>
        </div>
        <div class="p-5 md:p-6 overflow-x-auto" style="max-height:500px; overflow-y:auto;">
            <table class="min-w-full">
                <thead class="sticky top-0 bg-white dark:bg-gray-900 z-10">
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">No. Transaksi</th>
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tipe</th>
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jumlah</th>
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Deskripsi</th>
                        <th class="pb-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($transaksi as $trx)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02] transition-colors">
                            <td class="py-3 pr-4 text-sm font-mono text-gray-700 dark:text-gray-300">{{ $trx->nomor_transaksi }}</td>
                            <td class="py-3 pr-4">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $trx->pengguna->name ?? '-' }}</p>
                                <p class="text-xs text-gray-400">{{ $trx->pengguna->email ?? '' }}</p>
                            </td>
                            <td class="py-3 pr-4">
                                @if($trx->tipe === 'masuk')
                                    <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700 dark:bg-green-500/10 dark:text-green-400">Masuk</span>
                                @elseif($trx->tipe === 'keluar')
                                    <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700 dark:bg-red-500/10 dark:text-red-400">Keluar</span>
                                @elseif($trx->tipe === 'komisi')
                                    <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">Komisi</span>
                                @elseif($trx->tipe === 'topup')
                                    <span class="inline-flex items-center rounded-full bg-cyan-50 px-2.5 py-0.5 text-xs font-medium text-cyan-700 dark:bg-cyan-500/10 dark:text-cyan-400">Top Up</span>
                                @elseif($trx->tipe === 'koreksi')
                                    <span class="inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-medium text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400">Koreksi</span>
                                @endif
                            </td>
                            <td class="py-3 pr-4 text-sm font-semibold text-gray-700 dark:text-gray-300">Rp {{ number_format($trx->jumlah, 0, ',', '.') }}</td>
                            <td class="py-3 pr-4">
                                @if($trx->status === 'selesai')
                                    <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700 dark:bg-green-500/10 dark:text-green-400">Selesai</span>
                                @elseif($trx->status === 'menunggu')
                                    <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-medium text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">Menunggu</span>
                                @elseif($trx->status === 'disetujui')
                                    <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700 dark:bg-green-500/10 dark:text-green-400">Disetujui</span>
                                @elseif($trx->status === 'ditolak')
                                    <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700 dark:bg-red-500/10 dark:text-red-400">Ditolak</span>
                                @endif
                            </td>
                            <td class="py-3 pr-4 text-sm text-gray-500 dark:text-gray-400 max-w-[200px] truncate" title="{{ $trx->deskripsi }}">{{ $trx->deskripsi ?? '-' }}</td>
                            <td class="py-3 text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $trx->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center">
                                <p class="text-sm text-gray-400">Belum ada riwayat transaksi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ═══ SERVER-RENDERED MODALS: TOP UP ═══ -->
    @foreach($topUps as $item)
        <div id="topUpModal_{{ $item->id }}" style="display:none; position:fixed; inset:0; z-index:999999; align-items:center; justify-content:center; padding:1rem;">
            {{-- Backdrop --}}
            <div onclick="closeModal('topUpModal_{{ $item->id }}')"
                style="position:absolute; inset:0; background:rgba(16,24,40,0.55); backdrop-filter:blur(3px); -webkit-backdrop-filter:blur(3px);"></div>

            {{-- Panel --}}
            <div class="relative flex w-full flex-col rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900"
                style="z-index:1; max-width:520px; max-height:90vh; box-shadow:0 20px 24px -4px rgba(16,24,40,.10),0 8px 8px -4px rgba(16,24,40,.04);">

                {{-- Header --}}
                <div class="flex shrink-0 items-center justify-between border-b border-gray-200 dark:border-gray-800 px-5 py-4">
                    <div class="flex items-center gap-3">
                        <span class="flex items-center justify-center rounded-xl bg-cyan-50 dark:bg-cyan-500/10" style="width:36px;height:36px">
                            <svg style="width:20px;height:20px" class="text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </span>
                        <div>
                            <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Detail Top Up</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">#TU{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }} · {{ $item->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeModal('topUpModal_{{ $item->id }}')"
                        class="flex items-center justify-center rounded-lg text-gray-400 transition hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-white/5"
                        style="width:32px;height:32px">
                        <svg style="width:20px;height:20px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Body --}}
                <div class="flex-1 overflow-y-auto px-5 py-5" style="scrollbar-width:thin">
                    <div style="display:flex;flex-direction:column;gap:1rem;">
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
                            <div class="bg-gray-50 dark:bg-white/[0.03] rounded-xl p-3 border border-gray-100 dark:border-gray-800">
                                <p class="text-xs text-gray-400 mb-1">Pengguna</p>
                                <p class="text-sm font-semibold text-gray-800 dark:text-white/90">{{ $item->pengguna->name ?? '-' }}</p>
                                <p class="text-xs text-gray-400">{{ $item->pengguna->email ?? '' }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-white/[0.03] rounded-xl p-3 border border-gray-100 dark:border-gray-800">
                                <p class="text-xs text-gray-400 mb-1">Jumlah Top Up</p>
                                <p class="text-lg font-bold text-green-600 dark:text-green-400">+Rp {{ number_format($item->jumlah, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-white/[0.03] rounded-xl p-3 border border-gray-100 dark:border-gray-800">
                                <p class="text-xs text-gray-400 mb-1">Metode Pembayaran</p>
                                <p class="text-sm font-semibold text-gray-800 dark:text-white/90">{{ $item->metode_pembayaran }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-white/[0.03] rounded-xl p-3 border border-gray-100 dark:border-gray-800">
                                <p class="text-xs text-gray-400 mb-1">Tanggal Request</p>
                                <p class="text-sm font-semibold text-gray-800 dark:text-white/90">{{ $item->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>

                        @if($item->bukti_pembayaran)
                            <div>
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Bukti Pembayaran</p>
                                <a href="{{ asset('storage/' . $item->bukti_pembayaran) }}" target="_blank"
                                    class="block border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-xl p-3 hover:border-blue-400 transition text-center">
                                    <img src="{{ asset('storage/' . $item->bukti_pembayaran) }}" alt="Bukti" class="max-h-48 mx-auto rounded-lg object-contain"/>
                                    <p class="text-xs text-blue-500 mt-2">Klik untuk melihat ukuran penuh →</p>
                                </a>
                            </div>
                        @endif

                        @if($item->status === 'disetujui')
                            <div class="bg-green-50 dark:bg-green-500/10 border border-green-200 dark:border-green-800 rounded-xl p-4">
                                <div class="flex gap-2 items-start">
                                    <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    <div>
                                        <p class="text-sm font-semibold text-green-700 dark:text-green-400">Disetujui</p>
                                        @if($item->penyetuju)
                                            <p class="text-xs text-green-600 dark:text-green-400 mt-1">Oleh {{ $item->penyetuju->name }} · {{ $item->disetujui_pada?->format('d M Y H:i') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @elseif($item->status === 'ditolak')
                            <div class="bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-800 rounded-xl p-4">
                                <div class="flex gap-2 items-start">
                                    <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                    <div>
                                        <p class="text-sm font-semibold text-red-700 dark:text-red-400">Ditolak</p>
                                        @if($item->alasan_penolakan)
                                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">Alasan: {{ $item->alasan_penolakan }}</p>
                                        @endif
                                        @if($item->penyetuju)
                                            <p class="text-xs text-red-500 mt-1">Oleh {{ $item->penyetuju->name }} · {{ $item->disetujui_pada?->format('d M Y H:i') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Footer --}}
                @if($item->status === 'menunggu')
                    <div class="flex shrink-0 flex-col gap-2 border-t border-gray-200 dark:border-gray-800 px-5 py-4">
                        <form method="POST" action="{{ route('admin.keuangan.topup.approve', $item) }}" onsubmit="return confirm('Yakin ingin menyetujui top up ini? Saldo user akan ditambahkan.')">
                            @csrf
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-green-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-green-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Setujui Top Up
                            </button>
                        </form>
                        <div id="topup_reject_{{ $item->id }}" style="display:none;">
                            <form method="POST" action="{{ route('admin.keuangan.topup.reject', $item) }}" onsubmit="return confirm('Yakin ingin menolak top up ini?')">
                                @csrf
                                <textarea name="alasan_penolakan" rows="2" required placeholder="Tuliskan alasan penolakan..."
                                    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 px-3 py-2 text-sm mb-2 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-400 transition"></textarea>
                                <button type="submit" class="w-full rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 transition">
                                    Konfirmasi Penolakan
                                </button>
                            </form>
                        </div>
                        <button type="button" onclick="toggleReject('topup_reject_{{ $item->id }}')"
                            class="w-full inline-flex items-center justify-center gap-2 rounded-lg border border-red-300 bg-white dark:bg-transparent dark:border-red-700 px-4 py-2.5 text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            Tolak Top Up
                        </button>
                    </div>
                @else
                    <div class="flex shrink-0 items-center justify-end border-t border-gray-200 dark:border-gray-800 px-5 py-4">
                        <button type="button" onclick="closeModal('topUpModal_{{ $item->id }}')"
                            class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            Tutup
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endforeach

    <!-- ═══ SERVER-RENDERED MODALS: PENARIKAN ═══ -->
    @foreach($penarikan as $item)
        <div id="penarikanModal_{{ $item->id }}" style="display:none; position:fixed; inset:0; z-index:999999; align-items:center; justify-content:center; padding:1rem;">
            <div onclick="closeModal('penarikanModal_{{ $item->id }}')"
                style="position:absolute; inset:0; background:rgba(16,24,40,0.55); backdrop-filter:blur(3px); -webkit-backdrop-filter:blur(3px);"></div>

            <div class="relative flex w-full flex-col rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900"
                style="z-index:1; max-width:520px; max-height:90vh; box-shadow:0 20px 24px -4px rgba(16,24,40,.10),0 8px 8px -4px rgba(16,24,40,.04);">

                <div class="flex shrink-0 items-center justify-between border-b border-gray-200 dark:border-gray-800 px-5 py-4">
                    <div class="flex items-center gap-3">
                        <span class="flex items-center justify-center rounded-xl bg-amber-50 dark:bg-amber-500/10" style="width:36px;height:36px">
                            <svg style="width:20px;height:20px" class="text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7M12 3v18"/>
                            </svg>
                        </span>
                        <div>
                            <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Detail Penarikan</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">#TK{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }} · {{ $item->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeModal('penarikanModal_{{ $item->id }}')"
                        class="flex items-center justify-center rounded-lg text-gray-400 transition hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-white/5"
                        style="width:32px;height:32px">
                        <svg style="width:20px;height:20px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto px-5 py-5" style="scrollbar-width:thin">
                    <div style="display:flex;flex-direction:column;gap:1rem;">
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
                            <div class="bg-gray-50 dark:bg-white/[0.03] rounded-xl p-3 border border-gray-100 dark:border-gray-800">
                                <p class="text-xs text-gray-400 mb-1">Pengguna</p>
                                <p class="text-sm font-semibold text-gray-800 dark:text-white/90">{{ $item->pengguna->name ?? '-' }}</p>
                                <p class="text-xs text-gray-400">{{ $item->pengguna->email ?? '' }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-white/[0.03] rounded-xl p-3 border border-gray-100 dark:border-gray-800">
                                <p class="text-xs text-gray-400 mb-1">Jumlah Penarikan</p>
                                <p class="text-lg font-bold text-red-600 dark:text-red-400">-Rp {{ number_format($item->jumlah, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-white/[0.03] rounded-xl p-3 border border-gray-100 dark:border-gray-800">
                                <p class="text-xs text-gray-400 mb-1">Metode</p>
                                <p class="text-sm font-semibold text-gray-800 dark:text-white/90">{{ $item->metode === 'transfer_bank' ? 'Transfer Bank' : 'E-Wallet' }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-white/[0.03] rounded-xl p-3 border border-gray-100 dark:border-gray-800">
                                <p class="text-xs text-gray-400 mb-1">Tanggal Request</p>
                                <p class="text-sm font-semibold text-gray-800 dark:text-white/90">{{ $item->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>

                        <div class="bg-blue-50 dark:bg-blue-500/10 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
                            <p class="text-xs font-semibold text-blue-500 uppercase tracking-wider mb-2">Tujuan Transfer</p>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <span class="text-xs font-bold text-blue-600 dark:text-blue-400">{{ strtoupper(substr($item->nama_bank ?? 'BNK', 0, 3)) }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800 dark:text-white/90">{{ $item->nama_bank ?? '-' }} — {{ $item->nomor_rekening }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $item->nama_rekening }}</p>
                                </div>
                            </div>
                        </div>

                        @if(in_array($item->status, ['disetujui', 'selesai']))
                            <div class="bg-green-50 dark:bg-green-500/10 border border-green-200 dark:border-green-800 rounded-xl p-4">
                                <div class="flex gap-2 items-start">
                                    <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    <div>
                                        <p class="text-sm font-semibold text-green-700 dark:text-green-400">Disetujui — Saldo Telah Dikurangi</p>
                                        @if($item->penyetuju)
                                            <p class="text-xs text-green-600 dark:text-green-400 mt-1">Oleh {{ $item->penyetuju->name }} · {{ $item->disetujui_pada?->format('d M Y H:i') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @elseif($item->status === 'ditolak')
                            <div class="bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-800 rounded-xl p-4">
                                <div class="flex gap-2 items-start">
                                    <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                    <div>
                                        <p class="text-sm font-semibold text-red-700 dark:text-red-400">Ditolak</p>
                                        @if($item->alasan_penolakan)
                                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">Alasan: {{ $item->alasan_penolakan }}</p>
                                        @endif
                                        @if($item->penyetuju)
                                            <p class="text-xs text-red-500 mt-1">Oleh {{ $item->penyetuju->name }} · {{ $item->disetujui_pada?->format('d M Y H:i') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                @if($item->status === 'menunggu')
                    <div class="flex shrink-0 flex-col gap-2 border-t border-gray-200 dark:border-gray-800 px-5 py-4">
                        <form method="POST" action="{{ route('admin.keuangan.approve', $item) }}" onsubmit="return confirm('Yakin ingin menyetujui penarikan ini? Saldo user akan dikurangi.')">
                            @csrf
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-green-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-green-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Setujui Penarikan
                            </button>
                        </form>
                        <div id="penarikan_reject_{{ $item->id }}" style="display:none;">
                            <form method="POST" action="{{ route('admin.keuangan.reject', $item) }}" onsubmit="return confirm('Yakin ingin menolak penarikan ini?')">
                                @csrf
                                <textarea name="alasan_penolakan" rows="2" required placeholder="Tuliskan alasan penolakan..."
                                    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 px-3 py-2 text-sm mb-2 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-400 transition"></textarea>
                                <button type="submit" class="w-full rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 transition">
                                    Konfirmasi Penolakan
                                </button>
                            </form>
                        </div>
                        <button type="button" onclick="toggleReject('penarikan_reject_{{ $item->id }}')"
                            class="w-full inline-flex items-center justify-center gap-2 rounded-lg border border-red-300 bg-white dark:bg-transparent dark:border-red-700 px-4 py-2.5 text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            Tolak Penarikan
                        </button>
                    </div>
                @else
                    <div class="flex shrink-0 items-center justify-end border-t border-gray-200 dark:border-gray-800 px-5 py-4">
                        <button type="button" onclick="closeModal('penarikanModal_{{ $item->id }}')"
                            class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            Tutup
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endforeach

    <!-- ═══ MODAL: KOREKSI SALDO ═══ -->
    <div id="koreksiModal" style="display:none; position:fixed; inset:0; z-index:999999; align-items:center; justify-content:center; padding:1rem;">
        <div onclick="closeModal('koreksiModal')"
            style="position:absolute; inset:0; background:rgba(16,24,40,0.55); backdrop-filter:blur(3px); -webkit-backdrop-filter:blur(3px);"></div>
        <div class="relative flex w-full flex-col rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900"
            style="z-index:1; max-width:480px; max-height:90vh; box-shadow:0 20px 24px -4px rgba(16,24,40,.10),0 8px 8px -4px rgba(16,24,40,.04);">
            <div class="flex shrink-0 items-center justify-between border-b border-gray-200 dark:border-gray-800 px-5 py-4">
                <div class="flex items-center gap-3">
                    <span class="flex items-center justify-center rounded-xl bg-indigo-50 dark:bg-indigo-500/10" style="width:36px;height:36px">
                        <svg style="width:20px;height:20px" class="text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </span>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Koreksi Saldo Manual</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Setiap koreksi tercatat di riwayat transaksi</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('koreksiModal')"
                    class="flex items-center justify-center rounded-lg text-gray-400 transition hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-white/5"
                    style="width:32px;height:32px">
                    <svg style="width:20px;height:20px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto px-5 py-5" style="scrollbar-width:thin">
                <form method="POST" action="{{ route('admin.keuangan.koreksi-saldo') }}" id="koreksiForm">
                    @csrf
                    <div style="display:flex;flex-direction:column;gap:1rem;">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Pilih User</label>
                            <select name="user_id" required class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 transition">
                                <option value="">-- Pilih User --</option>
                                @foreach($users as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }} ({{ ucfirst(str_replace('_', ' ', $u->role)) }}) — Saldo: Rp {{ number_format($u->saldo, 0, ',', '.') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Tipe Koreksi</label>
                            <div class="flex gap-3">
                                <label class="flex-1 flex items-center gap-2 rounded-lg border border-gray-200 dark:border-gray-700 p-3 cursor-pointer hover:bg-green-50 dark:hover:bg-green-500/5 transition">
                                    <input type="radio" name="tipe_koreksi" value="tambah" required class="text-green-500">
                                    <span class="text-sm font-medium text-green-600">＋ Tambah</span>
                                </label>
                                <label class="flex-1 flex items-center gap-2 rounded-lg border border-gray-200 dark:border-gray-700 p-3 cursor-pointer hover:bg-red-50 dark:hover:bg-red-500/5 transition">
                                    <input type="radio" name="tipe_koreksi" value="kurang" required class="text-red-500">
                                    <span class="text-sm font-medium text-red-600">－ Kurangi</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Jumlah (Rp)</label>
                            <input type="number" name="jumlah" min="1" required placeholder="Masukkan jumlah" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 transition"/>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Catatan / Alasan <span class="text-red-500">*</span></label>
                            <textarea name="catatan" rows="3" required placeholder="Tuliskan alasan koreksi saldo..." class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 transition" style="resize:none"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="flex shrink-0 items-center justify-end gap-3 border-t border-gray-200 dark:border-gray-800 px-5 py-4">
                <button type="button" onclick="closeModal('koreksiModal')"
                    class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Batal
                </button>
                <button type="button" onclick="if(confirm('Yakin ingin melakukan koreksi saldo ini?')) document.getElementById('koreksiForm').submit()"
                    class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-indigo-700 transition">
                    <svg style="width:16px;height:16px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Terapkan Koreksi
                </button>
            </div>
        </div>
    </div>

    <script>
        function openModal(id) {
            const el = document.getElementById(id);
            if (el) el.style.display = 'flex';
        }
        function closeModal(id) {
            const el = document.getElementById(id);
            if (el) el.style.display = 'none';
        }
        function toggleReject(id) {
            const el = document.getElementById(id);
            if (el) el.style.display = el.style.display === 'none' ? 'block' : 'none';
        }
        function openTopUpModal(id) { openModal('topUpModal_' + id); }
        function openPenarikanModal(id) { openModal('penarikanModal_' + id); }
    </script>
@endsection


@extends('admin.layouts.app')
@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Monitoring Pesanan</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pantau semua pesanan jemput sampah</p>
        </div>
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

    <!-- Filter Tabs -->
    @php $s = request('status'); @endphp
    <div class="flex flex-wrap gap-2 mb-6">
        <a href="{{ route('admin.pesanan') }}"
            class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium {{ !$s ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 hover:bg-gray-200' }}">Semua</a>
        <a href="{{ route('admin.pesanan', ['status' => 'menunggu']) }}"
            class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium {{ $s === 'menunggu' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 hover:bg-gray-200' }}">Menunggu</a>
        <a href="{{ route('admin.pesanan', ['status' => 'diklaim']) }}"
            class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium {{ $s === 'diklaim' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 hover:bg-gray-200' }}">Diklaim</a>
        <a href="{{ route('admin.pesanan', ['status' => 'dalam_perjalanan']) }}"
            class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium {{ $s === 'dalam_perjalanan' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 hover:bg-gray-200' }}">Dalam Perjalanan</a>
        <a href="{{ route('admin.pesanan', ['status' => 'selesai']) }}"
            class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium {{ $s === 'selesai' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 hover:bg-gray-200' }}">Selesai</a>
        <a href="{{ route('admin.pesanan', ['status' => 'dibatalkan']) }}"
            class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium {{ $s === 'dibatalkan' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 hover:bg-gray-200' }}">Dibatalkan</a>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="p-5 md:p-6 overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">No. Pesanan</th>
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pelanggan</th>
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Juru Angkut</th>
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tipe</th>
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Berat</th>
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jenis Sampah</th>
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Metode Bayar</th>
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Bayar</th>
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pendapatan</th>
                        <th class="pb-3 pr-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="pb-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($pesanan as $p)
                        @php
                            $jenisSampah = $p->detailPesanan->map(fn($d) => $d->kategoriSampah->nama ?? 'Lainnya')->unique()->implode(', ');
                            $totalBerat = $p->total_berat > 0 ? $p->total_berat : $p->detailPesanan->sum('berat');
                            $totalBayar = $p->biaya_jemput;
                            $pendapatan = $p->total_pendapatan;
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02] transition-colors">
                            <td class="py-3 pr-4 text-sm font-medium text-gray-700 dark:text-white/80">{{ $p->nomor_pesanan }}</td>
                            <td class="py-3 pr-4">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $p->pengguna->name ?? '-' }}</p>
                            </td>
                            <td class="py-3 pr-4 text-sm text-gray-600 dark:text-gray-400">{{ $p->pengangkut->name ?? '-' }}</td>
                            <td class="py-3 pr-4 text-sm text-gray-600 dark:text-gray-400">{{ optional($p->tanggal_jemput)->format('d M Y') ?? $p->created_at->format('d M Y') }}</td>
                            <td class="py-3 pr-4">
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $p->tipe_pesanan === 'langganan' ? 'bg-purple-50 text-purple-700 dark:bg-purple-500/10 dark:text-purple-400' : 'bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400' }}">{{ ucfirst($p->tipe_pesanan) }}</span>
                            </td>
                            <td class="py-3 pr-4 text-sm text-gray-600 dark:text-gray-400">{{ number_format($totalBerat, 1) }} kg</td>
                            <td class="py-3 pr-4 text-sm text-gray-600 dark:text-gray-400 max-w-[120px] truncate" title="{{ $jenisSampah ?: '-' }}">{{ $jenisSampah ?: '-' }}</td>
                            <td class="py-3 pr-4">
                                <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600 dark:bg-gray-700 dark:text-gray-300">{{ ucfirst($p->metode_pembayaran ?? '-') }}</span>
                            </td>
                            <td class="py-3 pr-4 text-sm font-semibold text-gray-700 dark:text-gray-300">Rp {{ number_format($totalBayar, 0, ',', '.') }}</td>
                            <td class="py-3 pr-4 text-sm font-semibold {{ $pendapatan > 0 ? 'text-green-600 dark:text-green-400' : 'text-gray-400' }}">
                                {{ $pendapatan > 0 ? 'Rp ' . number_format($pendapatan, 0, ',', '.') : '-' }}
                            </td>
                            <td class="py-3 pr-4">
                                @if($p->status === 'selesai')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-semibold text-green-700 dark:bg-green-500/10 dark:text-green-400">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> Selesai
                                    </span>
                                @elseif($p->status === 'dibatalkan')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-semibold text-red-700 dark:bg-red-500/10 dark:text-red-400">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg> Dibatalkan
                                    </span>
                                @elseif($p->status === 'menunggu')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Menunggu
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span> {{ ucfirst(str_replace('_', ' ', $p->status)) }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 text-center">
                                <button type="button" onclick="openModal('detailModal{{ $p->id }}')"
                                    class="inline-flex items-center gap-1 rounded-lg bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700 hover:bg-indigo-100 dark:bg-indigo-500/10 dark:text-indigo-400 dark:hover:bg-indigo-500/20 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="py-8 text-center text-sm text-gray-400">Data tidak tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ═══ DETAIL MODALS (Server-Rendered) ═══ --}}
    @foreach($pesanan as $p)
        @php
            $jenisSampahModal = $p->detailPesanan->map(fn($d) => $d->kategoriSampah->nama ?? 'Lainnya')->unique()->implode(', ');
            $totalBeratModal = $p->total_berat > 0 ? $p->total_berat : $p->detailPesanan->sum('berat');
        @endphp
        <div id="detailModal{{ $p->id }}" class="fixed inset-0 z-[999999] hidden items-center justify-center bg-black/50 backdrop-blur-sm" onclick="if(event.target===this)closeModal('detailModal{{ $p->id }}')">
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-lg mx-4 overflow-hidden" onclick="event.stopPropagation()">
                {{-- Header --}}
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-base">Detail Pesanan</h3>
                            <p class="text-white/70 text-xs">#{{ $p->nomor_pesanan }}</p>
                        </div>
                    </div>
                    <button onclick="closeModal('detailModal{{ $p->id }}')" class="w-8 h-8 bg-white/20 hover:bg-white/30 rounded-lg flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Body --}}
                <div class="px-6 py-5 max-h-[60vh] overflow-y-auto space-y-4">
                    {{-- Info Cards --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div class="rounded-xl bg-gray-50 dark:bg-gray-800 p-3">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Pelanggan</p>
                            <p class="text-sm font-semibold text-gray-800 dark:text-white">{{ $p->pengguna->name ?? '-' }}</p>
                            <p class="text-xs text-gray-400">{{ $p->pengguna->telepon ?? '-' }}</p>
                        </div>
                        <div class="rounded-xl bg-gray-50 dark:bg-gray-800 p-3">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Juru Angkut</p>
                            <p class="text-sm font-semibold text-gray-800 dark:text-white">{{ $p->pengangkut->name ?? '-' }}</p>
                            <p class="text-xs text-gray-400">{{ $p->pengangkut->telepon ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="rounded-xl bg-gray-50 dark:bg-gray-800 p-3">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Tanggal Jemput</p>
                            <p class="text-sm font-semibold text-gray-800 dark:text-white">{{ optional($p->tanggal_jemput)->format('d M Y') ?? '-' }}</p>
                            <p class="text-xs text-gray-400">{{ $p->jam_jemput ? date('H:i', strtotime($p->jam_jemput)) : '-' }}</p>
                        </div>
                        <div class="rounded-xl bg-gray-50 dark:bg-gray-800 p-3">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Tipe Pesanan</p>
                            <p class="text-sm font-semibold text-gray-800 dark:text-white">{{ ucfirst($p->tipe_pesanan) }}</p>
                        </div>
                    </div>

                    <div class="rounded-xl bg-gray-50 dark:bg-gray-800 p-3">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Alamat Jemput</p>
                        <p class="text-sm text-gray-800 dark:text-white">{{ $p->alamat_jemput }}</p>
                    </div>

                    {{-- Detail Sampah --}}
                    <div class="rounded-xl bg-gray-50 dark:bg-gray-800 p-3">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Detail Sampah</p>
                        @if($p->detailPesanan->count() > 0)
                            @foreach($p->detailPesanan as $d)
                                <div class="flex items-center justify-between py-1.5 {{ !$loop->last ? 'border-b border-gray-200 dark:border-gray-700' : '' }}">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm">{{ $d->kategoriSampah->ikon ?? '🗑️' }}</span>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $d->kategoriSampah->nama ?? 'Lainnya' }}</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-sm font-semibold text-gray-800 dark:text-white">{{ number_format($d->berat, 1) }} kg</span>
                                        @if($d->subtotal > 0)
                                            <span class="text-xs text-green-600 dark:text-green-400 ml-2">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-xs text-gray-400">Tidak ada detail</p>
                        @endif
                    </div>

                    {{-- Keuangan --}}
                    <div class="grid grid-cols-3 gap-3">
                        <div class="rounded-xl bg-indigo-50 dark:bg-indigo-500/10 p-3">
                            <p class="text-xs text-indigo-600 dark:text-indigo-400 mb-1">Jarak</p>
                            <p class="text-sm font-bold text-indigo-700 dark:text-indigo-300">{{ $p->jarak_km ? $p->jarak_km . ' KM' : '-' }}</p>
                        </div>
                        <div class="rounded-xl bg-blue-50 dark:bg-blue-500/10 p-3">
                            <p class="text-xs text-blue-600 dark:text-blue-400 mb-1">Ongkir JA</p>
                            <p class="text-sm font-bold text-blue-700 dark:text-blue-300">Rp {{ number_format($p->ongkir_juru_angkut, 0, ',', '.') }}</p>
                        </div>
                        <div class="rounded-xl bg-purple-50 dark:bg-purple-500/10 p-3">
                            <p class="text-xs text-purple-600 dark:text-purple-400 mb-1">Biaya Admin</p>
                            <p class="text-sm font-bold text-purple-700 dark:text-purple-300">Rp {{ number_format($p->biaya_admin, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="rounded-xl bg-green-50 dark:bg-green-500/10 p-3">
                            <p class="text-xs text-green-600 dark:text-green-400 mb-1">Total Bayar Pelanggan</p>
                            <p class="text-sm font-bold text-green-700 dark:text-green-300">Rp {{ number_format($p->biaya_jemput, 0, ',', '.') }}</p>
                        </div>
                        <div class="rounded-xl bg-green-50 dark:bg-green-500/10 p-3">
                            <p class="text-xs text-green-600 dark:text-green-400 mb-1">Pendapatan Sampah</p>
                            <p class="text-sm font-bold text-green-700 dark:text-green-300">Rp {{ number_format($p->total_pendapatan, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    @if($p->tipe_pesanan === 'langganan')
                        <div class="rounded-xl bg-amber-50 dark:bg-amber-500/10 p-3 border border-amber-200 dark:border-amber-800">
                            <p class="text-xs text-amber-600 dark:text-amber-400 mb-1 font-semibold">📢 Subsidi Ongkir</p>
                            <p class="text-sm text-amber-700 dark:text-amber-300">Ongkir JA Rp {{ number_format($p->ongkir_juru_angkut, 0, ',', '.') }} disubsidi dari dana langganan</p>
                        </div>
                    @endif

                    @if($p->metode_pembayaran_pelanggan)
                        <div class="rounded-xl bg-indigo-50 dark:bg-indigo-500/10 p-3">
                            <p class="text-xs text-indigo-600 dark:text-indigo-400 mb-1">Pembayaran ke Pelanggan</p>
                            <p class="text-sm font-semibold text-indigo-700 dark:text-indigo-300">{{ ucfirst($p->metode_pembayaran_pelanggan) }}</p>
                        </div>
                    @endif

                    @if($p->catatan)
                        <div class="rounded-xl bg-gray-50 dark:bg-gray-800 p-3">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Catatan</p>
                            <p class="text-sm text-gray-800 dark:text-white">{{ $p->catatan }}</p>
                        </div>
                    @endif

                    @if($p->status === 'dibatalkan' && $p->alasan_pembatalan)
                        <div class="rounded-xl bg-red-50 dark:bg-red-500/10 p-3 border border-red-200 dark:border-red-800">
                            <p class="text-xs text-red-600 dark:text-red-400 mb-1 font-semibold">Alasan Pembatalan</p>
                            <p class="text-sm text-red-700 dark:text-red-300">{{ $p->alasan_pembatalan }}</p>
                        </div>
                    @endif

                    {{-- Status --}}
                    <div class="rounded-xl p-3 {{ $p->status === 'selesai' ? 'bg-green-50 dark:bg-green-500/10' : ($p->status === 'dibatalkan' ? 'bg-red-50 dark:bg-red-500/10' : 'bg-amber-50 dark:bg-amber-500/10') }}">
                        <p class="text-xs {{ $p->status === 'selesai' ? 'text-green-600 dark:text-green-400' : ($p->status === 'dibatalkan' ? 'text-red-600 dark:text-red-400' : 'text-amber-600 dark:text-amber-400') }} mb-1">Status</p>
                        <p class="text-sm font-bold {{ $p->status === 'selesai' ? 'text-green-700 dark:text-green-300' : ($p->status === 'dibatalkan' ? 'text-red-700 dark:text-red-300' : 'text-amber-700 dark:text-amber-300') }}">{{ ucfirst(str_replace('_', ' ', $p->status)) }}</p>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between gap-3">
                    @if(!in_array($p->status, ['selesai', 'dibatalkan']))
                        <button type="button" onclick="toggleBatalForm('batalForm{{ $p->id }}')"
                            class="inline-flex items-center gap-1.5 rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            Batalkan Pesanan
                        </button>
                    @else
                        <div></div>
                    @endif
                    <button type="button" onclick="closeModal('detailModal{{ $p->id }}')"
                        class="inline-flex items-center gap-1.5 rounded-lg bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 transition-colors">
                        Tutup
                    </button>
                </div>

                {{-- Batal Form (hidden) --}}
                @if(!in_array($p->status, ['selesai', 'dibatalkan']))
                    <div id="batalForm{{ $p->id }}" class="hidden px-6 py-4 bg-red-50 dark:bg-red-500/10 border-t border-red-200 dark:border-red-800">
                        <form action="{{ route('admin.pesanan.batalkan', $p) }}" method="POST">
                            @csrf
                            <p class="text-sm font-semibold text-red-700 dark:text-red-400 mb-2">Alasan Pembatalan <span class="text-red-500">*</span></p>
                            <textarea name="alasan_pembatalan" rows="3" required placeholder="Tulis alasan pembatalan pesanan ini..."
                                class="w-full rounded-lg border border-red-300 dark:border-red-700 bg-white dark:bg-gray-900 text-sm text-gray-800 dark:text-white p-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 resize-none"></textarea>
                            <div class="flex items-center justify-end gap-2 mt-3">
                                <button type="button" onclick="toggleBatalForm('batalForm{{ $p->id }}')"
                                    class="px-3 py-1.5 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">Batal</button>
                                <button type="submit"
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    Konfirmasi Batalkan
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    @endforeach

    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }
        function closeModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }
        function toggleBatalForm(id) {
            const form = document.getElementById(id);
            if (form) form.classList.toggle('hidden');
        }
    </script>
@endsection

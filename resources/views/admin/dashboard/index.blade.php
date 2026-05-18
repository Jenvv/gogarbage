@extends('admin.layouts.app')
@section('content')
    <!-- Page Header -->
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Dashboard</h2>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4 md:gap-6">
        <!-- Total Pengguna -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
            <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-xl dark:bg-green-500/15">
                <svg class="fill-green-600 dark:fill-green-400" width="24" height="24" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M8.8 5.6C7.59 5.6 6.61 6.59 6.61 7.8c0 1.21.98 2.2 2.19 2.2 1.22 0 2.2-.99 2.2-2.2 0-1.21-.98-2.2-2.19-2.2zM5.11 7.8c0-2.04 1.66-3.7 3.69-3.7 2.04 0 3.7 1.66 3.7 3.7 0 2.04-1.66 3.7-3.7 3.7-2.03 0-3.69-1.66-3.69-3.7zM4.86 15.32c-.77.77-1.16 1.74-1.34 2.54-.03.14.01.26.09.35.1.1.26.19.47.19h9.35c.21 0 .37-.09.47-.19.09-.09.12-.21.09-.35-.19-.8-.57-1.77-1.35-2.54-.76-.75-1.95-1.37-3.89-1.37s-3.13.62-3.89 1.37z"
                        fill="" />
                </svg>
            </div>
            <div class="flex items-end justify-between mt-5">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Total Pengguna</span>
                    <h4 class="mt-2 font-bold text-gray-800 text-2xl dark:text-white/90">{{ number_format($totalPengguna) }}
                    </h4>
                </div>
                <span
                    class="flex items-center gap-1 rounded-full bg-green-50 py-0.5 pl-2 pr-2.5 text-sm font-medium text-green-600 dark:bg-green-500/15 dark:text-green-500">Pengguna</span>
            </div>
        </div>

        <!-- Juru Angkut Aktif -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
            <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-xl dark:bg-blue-500/15">
                <svg class="fill-blue-600 dark:fill-blue-400" width="24" height="24" viewBox="0 0 24 24">
                    <path
                        d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z"
                        fill="" />
                </svg>
            </div>
            <div class="flex items-end justify-between mt-5">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Juru Angkut Aktif</span>
                    <h4 class="mt-2 font-bold text-gray-800 text-2xl dark:text-white/90">
                        {{ number_format($juruAngkutAktif) }}</h4>
                </div>
                <span
                    class="flex items-center gap-1 rounded-full bg-blue-50 py-0.5 pl-2 pr-2.5 text-sm font-medium text-blue-600 dark:bg-blue-500/15 dark:text-blue-500">Aktif</span>
            </div>
        </div>

        <!-- Pengepul Terdaftar -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
            <div class="flex items-center justify-center w-12 h-12 bg-amber-100 rounded-xl dark:bg-amber-500/15">
                <svg class="fill-amber-600 dark:fill-amber-400" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M20 4H4v2h16V4zm1 10v-2l-1-5H4l-1 5v2h1v6h10v-6h4v6h2v-6h1zm-9 4H6v-4h6v4z" fill="" />
                </svg>
            </div>
            <div class="flex items-end justify-between mt-5">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Pengepul Terdaftar</span>
                    <h4 class="mt-2 font-bold text-gray-800 text-2xl dark:text-white/90">{{ number_format($totalPengepul) }}
                    </h4>
                </div>
                <span
                    class="flex items-center gap-1 rounded-full bg-amber-50 py-0.5 pl-2 pr-2.5 text-sm font-medium text-amber-600 dark:bg-amber-500/15 dark:text-amber-500">Pengepul</span>
            </div>
        </div>

        <!-- Total Sampah -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
            <div class="flex items-center justify-center w-12 h-12 bg-purple-100 rounded-xl dark:bg-purple-500/15">
                <svg class="fill-purple-600 dark:fill-purple-400" width="24" height="24" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M11.665 3.756a.75.75 0 01.671 0l6.445 3.222-6.445 3.223a.75.75 0 01-.671 0L5.22 6.978l6.445-3.222zM4.293 8.192v7.903c0 .284.16.543.415.67L11.25 20.037V11.651a1.868 1.868 0 01-.256-.109L4.293 8.192zM12.75 20.037l6.543-3.272a.75.75 0 00.415-.67V8.192l-6.7 3.35a1.868 1.868 0 01-.258.109v8.386z"
                        fill="" />
                </svg>
            </div>
            <div class="flex items-end justify-between mt-5">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Total Sampah (kg)</span>
                    <h4 class="mt-2 font-bold text-gray-800 text-2xl dark:text-white/90">
                        {{ number_format($totalSampah, 2) }}</h4>
                </div>
                <span
                    class="flex items-center gap-1 rounded-full bg-purple-50 py-0.5 pl-2 pr-2.5 text-sm font-medium text-purple-600 dark:bg-purple-500/15 dark:text-purple-500">Kg</span>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-12 gap-4 mt-6 md:gap-6">
        <div class="col-span-12 xl:col-span-7">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-1">Pertumbuhan Bulanan</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Data pengguna, pengepul, dan sampah per bulan</p>
                <div id="growthChart" class="h-[300px]"></div>
            </div>
        </div>
        <div class="col-span-12 xl:col-span-5">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-1">Distribusi Jenis Sampah</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Total sampah berdasarkan kategori</p>
                <div id="categoryChart" class="h-[300px]"></div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-12 gap-4 mt-6 md:gap-6">
        <div class="col-span-12">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 pt-5 md:px-6 md:pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Pesanan Terbaru</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Daftar pesanan masuk terbaru</p>
                </div>
                <div class="p-5 md:p-6 overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-800">
                                <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">No. Pesanan
                                </th>
                                <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Pelanggan
                                </th>
                                <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal</th>
                                <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Status</th>
                                <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPesanan as $p)
                                <tr>
                                    <td class="py-3 text-sm text-gray-700 dark:text-white/80">{{ $p->nomor_pesanan }}</td>
                                    <td class="py-3 text-sm text-gray-700 dark:text-white/80">
                                        {{ $p->pengguna->name ?? '-' }}</td>
                                    <td class="py-3 text-sm text-gray-700 dark:text-white/80">
                                        {{ optional($p->tanggal_jemput)->format('d M Y') ?? $p->created_at->format('d M Y') }}
                                    </td>
                                    <td class="py-3 text-sm text-gray-700 dark:text-white/80">
                                        {{ ucfirst(str_replace('_', ' ', $p->status)) }}</td>
                                    <td class="py-3 text-sm text-gray-700 dark:text-white/80">Rp
                                        {{ number_format($p->total_pendapatan ?? 0, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-sm text-gray-400">Tidak ada pesanan
                                        terbaru</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            const usersSeries = {!! json_encode($growthUsers ?? []) !!};
            const pengepulSeries = {!! json_encode($growthPengepul ?? []) !!};
            const sampahSeries = {!! json_encode($growthSampah ?? []) !!};

            // Growth area chart
            if (document.getElementById('growthChart') && typeof ApexCharts !== 'undefined') {
                const growthOptions = {
                    series: [{
                            name: 'Pengguna',
                            data: usersSeries
                        },
                        {
                            name: 'Pengepul',
                            data: pengepulSeries
                        },
                        {
                            name: 'Sampah (kg)',
                            data: sampahSeries
                        }
                    ],
                    chart: {
                        type: 'area',
                        height: 310,
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#465FFF', '#9CB9FF', '#A78BFA'],
                    xaxis: {
                        categories: months,
                        type: 'category'
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
                    fill: {
                        gradient: {
                            enabled: true,
                            opacityFrom: 0.55,
                            opacityTo: 0
                        }
                    },
                    markers: {
                        size: 0
                    },
                    dataLabels: {
                        enabled: false
                    },
                    tooltip: {
                        x: {
                            format: 'dd MMM yyyy'
                        }
                    },
                };
                new ApexCharts(document.querySelector('#growthChart'), growthOptions).render();
            }

            // Category donut chart
            const categoryLabels = {!! json_encode($categoryLabels ?? []) !!};
            const categorySeries = {!! json_encode($categorySeries ?? []) !!};
            if (document.getElementById('categoryChart') && typeof ApexCharts !== 'undefined') {
                const donutOptions = {
                    series: categorySeries,
                    chart: {
                        type: 'donut',
                        height: 300
                    },
                    labels: categoryLabels,
                    colors: ['#7c3aed', '#06b6d4', '#f59e0b', '#10b981', '#ef4444', '#6366f1', '#818cf8',
                        '#a78bfa'
                    ],
                    legend: {
                        position: 'bottom'
                    },
                };
                new ApexCharts(document.querySelector('#categoryChart'), donutOptions).render();
            }
        });
    </script>
@endpush

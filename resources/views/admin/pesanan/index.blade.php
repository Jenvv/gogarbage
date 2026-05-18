@extends('admin.layouts.app')
@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Monitoring Pesanan</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pantau semua pesanan jemput sampah</p>
        </div>
    </div>

    <!-- Filter Tabs -->
    @php $s = request('status'); @endphp
    <div class="flex flex-wrap gap-2 mb-6">
        <a href="{{ route('admin.pesanan') }}" data-status=""
            class="pesanan-filter-tab inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium {{ $s ? 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400' : 'bg-green-500 text-white' }}">Semua</a>
        <a href="{{ route('admin.pesanan', ['status' => 'menunggu']) }}" data-status="menunggu"
            class="pesanan-filter-tab inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium {{ $s === 'menunggu' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 cursor-pointer hover:bg-gray-200' }}">Menunggu</a>
        <a href="{{ route('admin.pesanan', ['status' => 'diklaim']) }}" data-status="diklaim"
            class="pesanan-filter-tab inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium {{ $s === 'diklaim' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 cursor-pointer hover:bg-gray-200' }}">Diklaim</a>
        <a href="{{ route('admin.pesanan', ['status' => 'dalam_perjalanan']) }}" data-status="dalam_perjalanan"
            class="pesanan-filter-tab inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium {{ $s === 'dalam_perjalanan' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 cursor-pointer hover:bg-gray-200' }}">Dalam
            Perjalanan</a>
        <a href="{{ route('admin.pesanan', ['status' => 'selesai']) }}" data-status="selesai"
            class="pesanan-filter-tab inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium {{ $s === 'selesai' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 cursor-pointer hover:bg-gray-200' }}">Selesai</a>
        <a href="{{ route('admin.pesanan', ['status' => 'dibatalkan']) }}" data-status="dibatalkan"
            class="pesanan-filter-tab inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium {{ $s === 'dibatalkan' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 cursor-pointer hover:bg-gray-200' }}">Dibatalkan</a>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="p-5 md:p-6 overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">No. Pesanan</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Pelanggan</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Juru Angkut</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Tipe</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Berat</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Status</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody id="pesananRows">
                    @forelse($pesanan as $p)
                        <tr>
                            <td class="py-3 text-sm text-gray-700 dark:text-white/80">{{ $p->nomor_pesanan }}</td>
                            <td class="py-3 text-sm text-gray-700 dark:text-white/80">{{ $p->pengguna->name ?? '-' }}</td>
                            <td class="py-3 text-sm text-gray-700 dark:text-white/80">{{ $p->pengangkut->name ?? '-' }}
                            </td>
                            <td class="py-3 text-sm text-gray-700 dark:text-white/80">
                                {{ optional($p->tanggal_jemput)->format('d M Y') ?? $p->created_at->format('d M Y') }}</td>
                            <td class="py-3 text-sm text-gray-700 dark:text-white/80">{{ ucfirst($p->tipe_pesanan) }}</td>
                            <td class="py-3 text-sm text-gray-700 dark:text-white/80">
                                {{ number_format($p->total_berat ?? ($p->detailPesanan->sum('berat') ?? 0), 2) }} kg</td>
                            <td class="py-3 text-sm text-gray-700 dark:text-white/80">
                                {{ ucfirst(str_replace('_', ' ', $p->status)) }}</td>
                            <td class="py-3 text-sm text-gray-700 dark:text-white/80">
                                <div class="flex items-center gap-2">
                                    <form action="{{ route('admin.pesanan.batalkan', $p) }}" method="post"
                                        onsubmit="return confirm('Batalkan pesanan {{ $p->nomor_pesanan }}?');">
                                        @csrf
                                        <button type="submit"
                                            class="text-xs text-white bg-red-600 hover:bg-red-700 px-2 py-1 rounded">Batalkan</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-sm text-gray-400">Data tidak tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.pesanan-filter-tab');
            const rowsContainer = document.getElementById('pesananRows');
            const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

            function renderRows(data) {
                if (!rowsContainer) return;
                if (!data || data.length === 0) {
                    rowsContainer.innerHTML =
                        '<tr><td colspan="8" class="py-8 text-center text-sm text-gray-400">Data tidak tersedia</td></tr>';
                    return;
                }

                const html = data.map(p => {
                    const batalkanForm = '<form action="' + p.batalkan_url +
                        '" method="post" onsubmit="return confirm(\'Batalkan pesanan ' + p.nomor_pesanan
                        .replace(/'/g, "\\'") + '?\');">' +
                        '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                        '<button type="submit" class="text-xs text-white bg-red-600 hover:bg-red-700 px-2 py-1 rounded">Batalkan</button>' +
                        '</form>';

                    return '<tr>' +
                        '<td class="py-3 text-sm text-gray-700 dark:text-white/80">' + p.nomor_pesanan +
                        '</td>' +
                        '<td class="py-3 text-sm text-gray-700 dark:text-white/80">' + p.pengguna +
                        '</td>' +
                        '<td class="py-3 text-sm text-gray-700 dark:text-white/80">' + p.pengangkut +
                        '</td>' +
                        '<td class="py-3 text-sm text-gray-700 dark:text-white/80">' + p.tanggal_jemput +
                        '</td>' +
                        '<td class="py-3 text-sm text-gray-700 dark:text-white/80">' + p.tipe_pesanan +
                        '</td>' +
                        '<td class="py-3 text-sm text-gray-700 dark:text-white/80">' + p.total_berat +
                        ' kg</td>' +
                        '<td class="py-3 text-sm text-gray-700 dark:text-white/80">' + p.status + '</td>' +
                        '<td class="py-3 text-sm text-gray-700 dark:text-white/80"><div class="flex items-center gap-2">' +
                        batalkanForm + '</div></td>' +
                        '</tr>';
                }).join('');

                rowsContainer.innerHTML = html;
            }

            async function loadForUrl(url) {
                try {
                    const res = await fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    if (!res.ok) throw new Error('Network response was not ok');
                    const json = await res.json();
                    if (json.data) renderRows(json.data);
                } catch (err) {
                    console.error('Failed to load pesanan:', err);
                }
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = this.getAttribute('href');

                    // Update active styles
                    tabs.forEach(t => {
                        t.classList.remove('bg-green-500');
                        t.classList.remove('text-white');
                        t.classList.remove('bg-gray-100');
                        t.classList.remove('text-gray-600');
                    });
                    this.classList.add('bg-green-500');
                    this.classList.add('text-white');

                    // fetch data and render
                    loadForUrl(url);

                    // update browser URL
                    const status = this.dataset.status || '';
                    const newUrl = status ? (window.location.pathname + '?status=' +
                        encodeURIComponent(status)) : window.location.pathname;
                    window.history.replaceState({}, '', newUrl);
                });
            });
        });
    </script>
@endpush

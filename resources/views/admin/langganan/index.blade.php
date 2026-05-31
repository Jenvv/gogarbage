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
            <h4 id="countMenunggu" class="mt-2 text-2xl font-bold text-amber-700 dark:text-amber-300">
                {{ $countMenunggu ?? 0 }}</h4>
        </div>
        <div class="rounded-2xl border border-green-200 bg-green-50 p-5 dark:border-green-800 dark:bg-green-500/10">
            <p class="text-sm text-green-600 dark:text-green-400 font-medium">Aktif</p>
            <h4 id="countAktif" class="mt-2 text-2xl font-bold text-green-700 dark:text-green-300">{{ $countAktif ?? 0 }}
            </h4>
        </div>
        <div class="rounded-2xl border border-red-200 bg-red-50 p-5 dark:border-red-800 dark:bg-red-500/10">
            <p class="text-sm text-red-600 dark:text-red-400 font-medium">Dibatalkan</p>
            <h4 id="countDibatalkan" class="mt-2 text-2xl font-bold text-red-700 dark:text-red-300">
                {{ $countDibatalkan ?? 0 }}</h4>
        </div>
    </div>

    <!-- Filter Tabs -->
    @php $s = request('status'); @endphp
    <div class="flex flex-wrap gap-2 mb-6">
        <a href="{{ route('admin.langganan') }}" data-status=""
            class="langganan-filter-tab inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium {{ $s ? 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400' : 'bg-green-500 text-white' }}">Semua</a>
        <a href="{{ route('admin.langganan', ['status' => 'menunggu']) }}" data-status="menunggu"
            class="langganan-filter-tab inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium {{ $s === 'menunggu' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 cursor-pointer hover:bg-gray-200' }}">Menunggu</a>
        <a href="{{ route('admin.langganan', ['status' => 'aktif']) }}" data-status="aktif"
            class="langganan-filter-tab inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium {{ $s === 'aktif' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 cursor-pointer hover:bg-gray-200' }}">Aktif</a>
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
                <tbody id="langgananRows">
                    @forelse($langganan as $l)
                        <tr>
                            <td class="py-3 text-sm text-gray-700 dark:text-white/80">{{ $l->pengguna->name ?? '-' }}</td>
                            <td class="py-3 text-sm text-gray-700 dark:text-white/80">{{ $l->paket->nama ?? '-' }}</td>
                            <td class="py-3 text-sm text-gray-700 dark:text-white/80">{{ ucfirst($l->metode_pembayaran) }}
                            </td>
                            <td class="py-3 text-sm text-gray-700 dark:text-white/80">Rp
                                {{ number_format($l->jumlah_bayar ?? 0, 0, ',', '.') }}</td>
                            <td class="py-3 text-sm text-gray-700 dark:text-white/80">
                                {{ ucfirst(str_replace('_', ' ', $l->status)) }}</td>
                            <td class="py-3 text-sm text-gray-700 dark:text-white/80">
                                @if ($l->bukti_pembayaran)
                                    <a href="{{ asset('storage/' . $l->bukti_pembayaran) }}" target="_blank"
                                        class="text-sm text-blue-600 dark:text-blue-400">Lihat</a>
                                @else
                                    <span class="text-sm text-gray-500 dark:text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="py-3 text-sm text-gray-700 dark:text-white/80">
                                <div class="flex items-center gap-2">
                                    @if (in_array($l->status, ['menunggu', 'menunggu_tunai']))
                                        <form action="{{ route('admin.langganan.setujui', $l) }}" method="post">
                                            @csrf
                                            <button type="submit"
                                                class="text-xs text-white bg-green-600 hover:bg-green-700 px-2 py-1 rounded">Setujui</button>
                                        </form>

                                        <form action="{{ route('admin.langganan.tolak', $l) }}" method="post">
                                            @csrf
                                            <input type="text" name="catatan" placeholder="Catatan"
                                                class="text-xs border rounded px-2 py-1" />
                                            <button type="submit"
                                                class="text-xs text-white bg-red-600 hover:bg-red-700 px-2 py-1 rounded">Tolak</button>
                                        </form>
                                    @else
                                        <span class="text-sm text-gray-500 dark:text-gray-400">-</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-sm text-gray-400">Data tidak tersedia</td>
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
            const tabs = document.querySelectorAll('.langganan-filter-tab');
            const rowsContainer = document.getElementById('langgananRows');
            const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

            function renderRows(data) {
                if (!rowsContainer) return;
                if (!data || data.length === 0) {
                    rowsContainer.innerHTML =
                        '<tr><td colspan="7" class="py-8 text-center text-sm text-gray-400">Data tidak tersedia</td></tr>';
                    return;
                }

                const html = data.map(l => {
                    const lihat = l.bukti_url ? ('<a href="' + l.bukti_url +
                            '" target="_blank" class="text-sm text-blue-600 dark:text-blue-400">Lihat</a>'
                            ) : '<span class="text-sm text-gray-500 dark:text-gray-400">-</span>';

                    const setujuiForm = '<form action="' + l.setujui_url + '" method="post">' +
                        '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                        '<button type="submit" class="text-xs text-white bg-green-600 hover:bg-green-700 px-2 py-1 rounded">Setujui</button>' +
                        '</form>';

                    const tolakForm = '<form action="' + l.tolak_url + '" method="post">' +
                        '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                        '<input type="text" name="catatan" placeholder="Catatan" class="text-xs border rounded px-2 py-1" />' +
                        '<button type="submit" class="text-xs text-white bg-red-600 hover:bg-red-700 px-2 py-1 rounded">Tolak</button>' +
                        '</form>';

                    const actions = (l.status === 'menunggu' || l.status === 'menunggu_tunai') ? (
                            '<div class="flex items-center gap-2">' + setujuiForm + tolakForm + '</div>') :
                        '<span class="text-sm text-gray-500 dark:text-gray-400">-</span>';

                    return '<tr>' +
                        '<td class="py-3 text-sm text-gray-700 dark:text-white/80">' + l.pelanggan +
                        '</td>' +
                        '<td class="py-3 text-sm text-gray-700 dark:text-white/80">' + l.paket + '</td>' +
                        '<td class="py-3 text-sm text-gray-700 dark:text-white/80">' + l.metode + '</td>' +
                        '<td class="py-3 text-sm text-gray-700 dark:text-white/80">Rp ' + l.jumlah +
                        '</td>' +
                        '<td class="py-3 text-sm text-gray-700 dark:text-white/80">' + l.status.replace(
                            /_/g, ' ') + '</td>' +
                        '<td class="py-3 text-sm text-gray-700 dark:text-white/80">' + lihat + '</td>' +
                        '<td class="py-3 text-sm text-gray-700 dark:text-white/80">' + actions + '</td>' +
                        '</tr>';
                }).join('');

                rowsContainer.innerHTML = html;
            }

            function updateCounts(counts) {
                if (!counts) return;
                const c1 = document.getElementById('countMenunggu');
                const c2 = document.getElementById('countAktif');
                const c3 = document.getElementById('countDibatalkan');
                if (c1) c1.textContent = counts.menunggu ?? c1.textContent;
                if (c2) c2.textContent = counts.aktif ?? c2.textContent;
                if (c3) c3.textContent = counts.dibatalkan ?? c3.textContent;
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
                    if (json.counts) updateCounts(json.counts);
                } catch (err) {
                    console.error('Failed to load langganan:', err);
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

                    loadForUrl(url);

                    const status = this.dataset.status || '';
                    const newUrl = status ? (window.location.pathname + '?status=' +
                        encodeURIComponent(status)) : window.location.pathname;
                    window.history.replaceState({}, '', newUrl);
                });
            });
        });
    </script>
@endpush

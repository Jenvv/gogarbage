@php
    $pendingPesananCount = \App\Models\Pesanan::where('status', 'menunggu')->count();
    $pendingLanggananCount = \App\Models\Langganan::whereIn('status', ['menunggu', 'menunggu_tunai'])->count();
@endphp
<aside id="sidebar"
    class="fixed flex flex-col mt-0 top-0 px-5 left-0 bg-white dark:bg-gray-900 dark:border-gray-800 text-gray-900 h-screen transition-all duration-300 ease-in-out z-99999 border-r border-gray-200"
    x-data="{
        openMenus: {},
        toggleMenu(id) {
            const isOpen = !this.openMenus[id];
            this.openMenus = {};
            this.openMenus[id] = isOpen;
        },
        isOpen(id) { return this.openMenus[id] || false; },
        isActive(path) { return window.location.pathname === path; }
    }"
    :class="{
        'w-[290px]': $store.sidebar.isExpanded || $store.sidebar.isMobileOpen || $store.sidebar.isHovered,
        'w-[90px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
        'translate-x-0': $store.sidebar.isMobileOpen,
        '-translate-x-full xl:translate-x-0': !$store.sidebar.isMobileOpen
    }"
    @mouseenter="if (!$store.sidebar.isExpanded) $store.sidebar.setHovered(true)"
    @mouseleave="$store.sidebar.setHovered(false)">

    {{-- Logo --}}
    <div class="pt-8 pb-7 flex"
        :class="(!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ? 'xl:justify-center' : 'justify-start'">
        <a href="/admin" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </div>
            <div x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white leading-tight">Go Garbage</h2>
                <p class="text-xs text-gray-400">Admin Dashboard</p>
            </div>
        </a>
    </div>

    {{-- Navigation --}}
    <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
        <nav class="mb-6">
            <div class="flex flex-col gap-4">

                {{-- ============ GRUP: Menu Utama ============ --}}
                <div>
                    <h2 class="mb-4 text-xs uppercase text-gray-400"
                        x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen">
                        Menu Utama
                    </h2>
                    <ul class="flex flex-col gap-1">

                        {{-- Dashboard --}}
                        <li>
                            <a href="/admin" class="menu-item group"
                                :class="isActive('/admin') ? 'menu-item-active' : 'menu-item-inactive'">
                                <span :class="isActive('/admin') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'">
                                    <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                                </span>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="menu-item-text">Dashboard</span>
                            </a>
                        </li>

                        {{-- Manajemen Pengguna (submenu) --}}
                        <li>
                            <button @click="toggleMenu('pengguna')" class="menu-item group w-full"
                                :class="isOpen('pengguna') ? 'menu-item-active' : 'menu-item-inactive'">
                                <span :class="isOpen('pengguna') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'">
                                    <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M8.8 5.6C7.59 5.6 6.61 6.59 6.61 7.8c0 1.21.98 2.2 2.19 2.2 1.22 0 2.2-.99 2.2-2.2 0-1.21-.98-2.2-2.19-2.2zM5.11 7.8c0-2.04 1.66-3.7 3.69-3.7 2.04 0 3.7 1.66 3.7 3.7 0 2.04-1.66 3.7-3.7 3.7-2.03 0-3.69-1.66-3.69-3.7zM4.86 15.32c-.77.77-1.16 1.74-1.34 2.54-.03.14.01.26.09.35.1.1.26.19.47.19h9.35c.21 0 .37-.09.47-.19.09-.09.12-.21.09-.35-.19-.8-.57-1.77-1.35-2.54-.76-.75-1.95-1.37-3.89-1.37s-3.13.62-3.89 1.37z"/></svg>
                                </span>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="menu-item-text">Manajemen Pengguna</span>
                                <svg x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                    class="ml-auto w-5 h-5 transition-transform duration-200"
                                    :class="{ 'rotate-180 text-brand-500': isOpen('pengguna') }"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="isOpen('pengguna') && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)">
                                <ul class="mt-2 space-y-1 ml-9">
                                    <li><a href="/admin/pengguna/pelanggan" class="menu-dropdown-item" :class="isActive('/admin/pengguna/pelanggan') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">Pelanggan</a></li>
                                    <li><a href="/admin/pengguna/juru-angkut" class="menu-dropdown-item" :class="isActive('/admin/pengguna/juru-angkut') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">Juru Angkut</a></li>
                                    <li><a href="/admin/pengguna/pengepul" class="menu-dropdown-item" :class="isActive('/admin/pengguna/pengepul') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">Pengepul</a></li>
                                </ul>
                            </div>
                        </li>

                        {{-- Pesanan --}}
                        <li>
                            <a href="/admin/pesanan" class="menu-item group relative"
                                :class="isActive('/admin/pesanan') ? 'menu-item-active' : 'menu-item-inactive'">
                                <span :class="isActive('/admin/pesanan') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'">
                                    <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.75 3A2.75 2.75 0 003 5.75v12.5A2.75 2.75 0 005.75 21h12.5A2.75 2.75 0 0021 18.25V5.75A2.75 2.75 0 0018.25 3H5.75zM4.5 5.75c0-.69.56-1.25 1.25-1.25h12.5c.69 0 1.25.56 1.25 1.25v12.5c0 .69-.56 1.25-1.25 1.25H5.75c-.69 0-1.25-.56-1.25-1.25V5.75zM8 8.25a.75.75 0 01.75-.75h6.5a.75.75 0 010 1.5h-6.5A.75.75 0 018 8.25zm0 3.75a.75.75 0 01.75-.75h6.5a.75.75 0 010 1.5h-6.5A.75.75 0 018 12zm0 3.75a.75.75 0 01.75-.75h4a.75.75 0 010 1.5h-4a.75.75 0 01-.75-.75z"/></svg>
                                </span>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="menu-item-text">Pesanan</span>
                                @if($pendingPesananCount > 0)
                                <span x-show="!isActive('/admin/pesanan') && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)" class="ml-auto inline-flex items-center justify-center w-5 h-5 text-[10px] font-bold text-white bg-red-500 rounded-full flex-shrink-0">{{ $pendingPesananCount }}</span>
                                <span x-show="!isActive('/admin/pesanan') && !($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)" class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full border border-white"></span>
                                @endif
                            </a>
                        </li>

                        {{-- Langganan --}}
                        <li>
                            <a href="/admin/langganan" class="menu-item group relative"
                                :class="isActive('/admin/langganan') ? 'menu-item-active' : 'menu-item-inactive'">
                                <span :class="isActive('/admin/langganan') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'">
                                    <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M4.5 3.75a.75.75 0 00-.75.75v15c0 .414.336.75.75.75h15a.75.75 0 00.75-.75v-15a.75.75 0 00-.75-.75h-15zm-2.25.75A2.25 2.25 0 014.5 2.25h15a2.25 2.25 0 012.25 2.25v15a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25v-15zm4.5 3a.75.75 0 01.75-.75h9a.75.75 0 010 1.5h-9a.75.75 0 01-.75-.75zm.75 3a.75.75 0 000 1.5h6a.75.75 0 000-1.5h-6zM16.28 9.22a.75.75 0 010 1.06l-3 3a.75.75 0 01-1.06 0l-1.5-1.5a.75.75 0 011.06-1.06l.97.97 2.47-2.47a.75.75 0 011.06 0z"/></svg>
                                </span>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="menu-item-text">Langganan</span>
                                @if($pendingLanggananCount > 0)
                                <span x-show="!isActive('/admin/langganan') && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)" class="ml-auto inline-flex items-center justify-center w-5 h-5 text-[10px] font-bold text-white bg-red-500 rounded-full flex-shrink-0">{{ $pendingLanggananCount }}</span>
                                <span x-show="!isActive('/admin/langganan') && !($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)" class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full border border-white"></span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- ============ GRUP: Gudang & Pengepul ============ --}}
                <div>
                    <h2 class="mb-4 text-xs uppercase text-gray-400"
                        x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen">
                        Gudang & Pengepul
                    </h2>
                    <ul class="flex flex-col gap-1">

                        {{-- Stok Sampah --}}
                        <li>
                            <a href="/admin/stok" class="menu-item group"
                                :class="isActive('/admin/stok') ? 'menu-item-active' : 'menu-item-inactive'">
                                <span :class="isActive('/admin/stok') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'">
                                    <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.665 3.756a.75.75 0 01.671 0l6.445 3.222-6.445 3.223a.75.75 0 01-.671 0L5.22 6.978l6.445-3.222zM4.293 8.192v7.903c0 .284.16.543.415.67L11.25 20.037V11.651a1.868 1.868 0 01-.256-.109L4.293 8.192zM12.75 20.037l6.543-3.272a.75.75 0 00.415-.67V8.192l-6.7 3.35a1.868 1.868 0 01-.258.109v8.386z"/></svg>
                                </span>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="menu-item-text">Stok Sampah</span>
                            </a>
                        </li>

                        {{-- Transaksi Pengepul --}}
                        <li>
                            <a href="/admin/transaksi-pengepul" class="menu-item group"
                                :class="isActive('/admin/transaksi-pengepul') ? 'menu-item-active' : 'menu-item-inactive'">
                                <span :class="isActive('/admin/transaksi-pengepul') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'">
                                    <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M6 2.25A2.75 2.75 0 003.25 5v14A2.75 2.75 0 006 21.75h12A2.75 2.75 0 0020.75 19V5A2.75 2.75 0 0018 2.25H6zM4.75 5c0-.69.56-1.25 1.25-1.25h12c.69 0 1.25.56 1.25 1.25v14c0 .69-.56 1.25-1.25 1.25H6c-.69 0-1.25-.56-1.25-1.25V5zM7.25 8A.75.75 0 018 7.25h3a.75.75 0 010 1.5H8A.75.75 0 017.25 8zm0 4a.75.75 0 01.75-.75h8a.75.75 0 010 1.5H8a.75.75 0 01-.75-.75zm0 4a.75.75 0 01.75-.75h8a.75.75 0 010 1.5H8a.75.75 0 01-.75-.75z"/></svg>
                                </span>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="menu-item-text">Transaksi Pengepul</span>
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- ============ GRUP: Keuangan & Lainnya ============ --}}
                <div>
                    <h2 class="mb-4 text-xs uppercase text-gray-400"
                        x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen">
                        Keuangan & Lainnya
                    </h2>
                    <ul class="flex flex-col gap-1">

                        {{-- Keuangan --}}
                        <li>
                            <a href="/admin/keuangan" class="menu-item group"
                                :class="isActive('/admin/keuangan') ? 'menu-item-active' : 'menu-item-inactive'">
                                <span :class="isActive('/admin/keuangan') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'">
                                    <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.317c-1.63.292-3 1.517-3 3.183 0 1.907 1.693 3.25 3.75 3.25 1.3 0 2.25.766 2.25 1.75s-.95 1.75-2.25 1.75c-.77 0-1.42-.33-1.8-.81a.75.75 0 00-1.2.9c.598.796 1.55 1.303 2.5 1.475V18a.75.75 0 001.5 0v-.317c1.63-.292 3-1.517 3-3.183 0-1.907-1.693-3.25-3.75-3.25-1.3 0-2.25-.766-2.25-1.75s.95-1.75 2.25-1.75c.77 0 1.42.33 1.8.81a.75.75 0 001.2-.9c-.598-.796-1.55-1.303-2.5-1.475V6z"/></svg>
                                </span>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="menu-item-text">Keuangan</span>
                            </a>
                        </li>

                        {{-- Hadiah & Poin --}}
                        <li>
                            <a href="/admin/hadiah" class="menu-item group"
                                :class="isActive('/admin/hadiah') ? 'menu-item-active' : 'menu-item-inactive'">
                                <span :class="isActive('/admin/hadiah') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'">
                                    <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.25 6.375a3.375 3.375 0 016.068-2.034A3.375 3.375 0 0118.75 6.375V7.5H20.25A.75.75 0 0121 8.25v3a.75.75 0 01-.75.75H3.75A.75.75 0 013 11.25v-3A.75.75 0 013.75 7.5h1.5V6.375zM8.625 7.5h2.625V6.375a1.875 1.875 0 10-2.625 1.125zm5.25 0h2.625V6.375a1.875 1.875 0 00-2.625 1.125V7.5zM4.5 13.5v5.25A2.25 2.25 0 006.75 21h10.5a2.25 2.25 0 002.25-2.25V13.5h-15z"/></svg>
                                </span>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="menu-item-text">Hadiah & Poin</span>
                            </a>
                        </li>

                        {{-- Master Data (submenu) --}}
                        <li>
                            <button @click="toggleMenu('master')" class="menu-item group w-full"
                                :class="isOpen('master') ? 'menu-item-active' : 'menu-item-inactive'">
                                <span :class="isOpen('master') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'">
                                    <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.562 7.562 0 00-.631.327c-.173.106-.344.1-.464.05l-1.088-.435c-.84-.336-1.8.015-2.26.83l-.921 1.63c-.458.815-.276 1.84.432 2.42l.896.727c.095.077.168.21.154.404a7.646 7.646 0 000 .658c.014.194-.059.327-.154.404l-.896.727c-.708.58-.89 1.605-.432 2.42l.921 1.63c.46.815 1.42 1.166 2.26.83l1.088-.435c.12-.048.29-.054.464.05.204.126.415.24.631.327.182.088.278.229.297.349l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.115-.26.297-.348.216-.088.427-.2.631-.327.173-.106.344-.099.464-.05l1.088.435c.84.336 1.8-.015 2.26-.83l.921-1.63c.458-.815.276-1.84-.432-2.42l-.896-.727c-.095-.077-.168-.21-.154-.404a7.561 7.561 0 000-.658c-.014-.194.059-.327.154-.404l.896-.727c.708-.58.89-1.605.432-2.42l-.92-1.63c-.46-.815-1.42-1.166-2.26-.83l-1.089.435c-.12.048-.29.054-.464-.05a7.574 7.574 0 00-.63-.327c-.183-.088-.279-.229-.298-.349l-.178-1.071A1.875 1.875 0 0012.922 2.25h-1.844zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z"/></svg>
                                </span>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="menu-item-text">Master Data</span>
                                <svg x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                    class="ml-auto w-5 h-5 transition-transform duration-200"
                                    :class="{ 'rotate-180 text-brand-500': isOpen('master') }"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="isOpen('master') && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)">
                                <ul class="mt-2 space-y-1 ml-9">
                                    <li><a href="/admin/master-data/kategori-sampah" class="menu-dropdown-item" :class="isActive('/admin/master-data/kategori-sampah') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">Kategori Sampah</a></li>
                                    <li><a href="/admin/master-data/paket" class="menu-dropdown-item" :class="isActive('/admin/master-data/paket') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">Paket Langganan</a></li>
                                </ul>
                            </div>
                        </li>

                        {{-- Pengaturan --}}
                        <li>
                            <a href="/admin/konfigurasi" class="menu-item group"
                                :class="isActive('/admin/konfigurasi') ? 'menu-item-active' : 'menu-item-inactive'">
                                <span :class="isActive('/admin/konfigurasi') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'">
                                    <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.562 7.562 0 00-.631.327c-.173.106-.344.1-.464.05l-1.088-.435c-.84-.336-1.8.015-2.26.83l-.921 1.63c-.458.815-.276 1.84.432 2.42l.896.727c.095.077.168.21.154.404a7.646 7.646 0 000 .658c.014.194-.059.327-.154.404l-.896.727c-.708.58-.89 1.605-.432 2.42l.921 1.63c.46.815 1.42 1.166 2.26.83l1.088-.435c.12-.048.29-.054.464.05.204.126.415.24.631.327.182.088.278.229.297.349l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.115-.26.297-.348.216-.088.427-.2.631-.327.173-.106.344-.099.464-.05l1.088.435c.84.336 1.8-.015 2.26-.83l.921-1.63c.458-.815.276-1.84-.432-2.42l-.896-.727c-.095-.077-.168-.21-.154-.404a7.561 7.561 0 000-.658c-.014-.194.059-.327.154-.404l.896-.727c.708-.58.89-1.605.432-2.42l-.92-1.63c-.46-.815-1.42-1.166-2.26-.83l-1.089.435c-.12.048-.29.054-.464-.05a7.574 7.574 0 00-.63-.327c-.183-.088-.279-.229-.298-.349l-.178-1.071A1.875 1.875 0 0012.922 2.25h-1.844zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z"/></svg>
                                </span>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="menu-item-text">Pengaturan</span>
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </nav>
    </div>
</aside>

{{-- Mobile Overlay --}}
<div x-show="$store.sidebar.isMobileOpen" @click="$store.sidebar.setMobileOpen(false)"
    class="fixed z-50 h-screen w-full bg-gray-900/50"></div>

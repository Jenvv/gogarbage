@php
    $currentRoute = Route::currentRouteName();
    $isHome = $currentRoute === 'pengepul.index';
    $isStok = $currentRoute === 'pengepul.stok';
    $isRequest = $currentRoute === 'pengepul.request';
    $isRiwayat = str_starts_with($currentRoute, 'pengepul.riwayat');
@endphp
<div class="nav-bottom">
    <a href="{{ route('pengepul.index') }}" class="nav-btn">
        <svg width="22" height="22" fill="{{ $isHome ? '#16a34a' : 'none' }}" stroke="{{ $isHome ? '#16a34a' : '#9ca3af' }}" stroke-width="2" viewBox="0 0 24 24">
            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
        </svg>
        <span style="font-size:10px;font-weight:{{ $isHome ? '700' : '500' }};color:{{ $isHome ? '#16a34a' : '#9ca3af' }};">Home</span>
    </a>
    <a href="{{ route('pengepul.stok') }}" class="nav-btn">
        <svg width="22" height="22" fill="none" stroke="{{ $isStok ? '#16a34a' : '#9ca3af' }}" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
        </svg>
        <span style="font-size:10px;font-weight:{{ $isStok ? '700' : '500' }};color:{{ $isStok ? '#16a34a' : '#9ca3af' }};">Stok</span>
    </a>
    <a href="{{ route('pengepul.request') }}" class="nav-btn">
        <svg width="22" height="22" fill="none" stroke="{{ $isRequest ? '#16a34a' : '#9ca3af' }}" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
        <span style="font-size:10px;font-weight:{{ $isRequest ? '700' : '500' }};color:{{ $isRequest ? '#16a34a' : '#9ca3af' }};">Request</span>
    </a>
    <a href="{{ route('pengepul.riwayat') }}" class="nav-btn">
        <svg width="22" height="22" fill="none" stroke="{{ $isRiwayat ? '#16a34a' : '#9ca3af' }}" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span style="font-size:10px;font-weight:{{ $isRiwayat ? '700' : '500' }};color:{{ $isRiwayat ? '#16a34a' : '#9ca3af' }};">Riwayat</span>
    </a>
</div>

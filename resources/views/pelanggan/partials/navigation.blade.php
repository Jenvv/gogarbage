  <div class="nav-bottom">
      <!-- Home -->
      <a href="{{ route('pelanggan.index') }}" class="nav-btn" style="text-decoration:none;">
          @if (request()->routeIs('pelanggan.index'))
              <svg width="22" height="22" fill="#16a34a" viewBox="0 0 24 24">
                  <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
              </svg>
              <span style="font-size:10px;font-weight:700;color:#16a34a;">Home</span>
          @else
              <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                  <polyline stroke-linecap="round" stroke-linejoin="round" points="9 22 9 12 15 12 15 22" />
              </svg>
              <span style="font-size:10px;font-weight:500;color:#9ca3af;">Home</span>
          @endif
      </a>

      <!-- Order -->
      <a href="{{ route('pelanggan.jemput-sampah') }}" class="nav-btn" style="text-decoration:none;">
          <svg width="22" height="22" fill="none" stroke="{{ request()->routeIs('pelanggan.jemput-sampah*') ? '#16a34a' : '#9ca3af' }}" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
          </svg>
          <span style="font-size:10px;font-weight:{{ request()->routeIs('pelanggan.jemput-sampah*') ? '700' : '500' }};color:{{ request()->routeIs('pelanggan.jemput-sampah*') ? '#16a34a' : '#9ca3af' }};">Order</span>
      </a>

      <!-- History -->
      <a href="{{ route('pelanggan.riwayat') }}" class="nav-btn" style="text-decoration:none;">
          <svg width="22" height="22" fill="none" stroke="{{ request()->routeIs('pelanggan.riwayat') ? '#16a34a' : '#9ca3af' }}" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span style="font-size:10px;font-weight:{{ request()->routeIs('pelanggan.riwayat') ? '700' : '500' }};color:{{ request()->routeIs('pelanggan.riwayat') ? '#16a34a' : '#9ca3af' }};">History</span>
      </a>

      <!-- Wallet -->
      <a href="{{ route('pelanggan.dompet') }}" class="nav-btn" style="text-decoration:none;">
          <svg width="22" height="22" fill="none" stroke="{{ request()->routeIs('pelanggan.dompet*') || request()->routeIs('pelanggan.langganan*') ? '#16a34a' : '#9ca3af' }}" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
          </svg>
          <span style="font-size:10px;font-weight:{{ request()->routeIs('pelanggan.dompet*') || request()->routeIs('pelanggan.langganan*') ? '700' : '500' }};color:{{ request()->routeIs('pelanggan.dompet*') || request()->routeIs('pelanggan.langganan*') ? '#16a34a' : '#9ca3af' }};">Wallet</span>
      </a>

      <!-- Profile -->
      <a href="{{ route('pelanggan.profil') }}" class="nav-btn" style="text-decoration:none;">
          <svg width="22" height="22" fill="{{ request()->routeIs('pelanggan.profil') ? '#16a34a' : 'none' }}" stroke="{{ request()->routeIs('pelanggan.profil') ? '#16a34a' : '#9ca3af' }}" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round"
                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
          </svg>
          <span style="font-size:10px;font-weight:{{ request()->routeIs('pelanggan.profil') ? '700' : '500' }};color:{{ request()->routeIs('pelanggan.profil') ? '#16a34a' : '#9ca3af' }};">Profile</span>
      </a>
  </div>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Go Garbage – Profil Juru Angkut</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <style>
        * {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: #e8e8e8;
            display: flex;
            justify-content: center;
            min-height: 100vh;
        }

        .phone-wrapper {
            width: 390px;
            height: 100vh;
            background: #f2f3f7;
            position: relative;
            overflow: hidden;
            box-shadow: 0 0 48px rgba(0, 0, 0, 0.18);
            display: flex;
            flex-direction: column;
        }

        @media (max-width: 390px) {
            body {
                background: #f2f3f7;
            }

            .phone-wrapper {
                width: 100%;
                box-shadow: none;
            }
        }

        /* Scroll */
        .scroll-area {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }

        .scroll-area::-webkit-scrollbar {
            display: none;
        }

        /* Green header */
        .header-green {
            background: linear-gradient(150deg, #2ecc71 0%, #1aab57 55%, #168a45 100%);
            padding: 22px 20px 72px;
        }

        /* Avatar */
        .avatar-circle {
            width: 88px;
            height: 88px;
            background: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
            overflow: hidden;
        }

        .avatar-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Floating info card */
        .info-card {
            background: #fff;
            border-radius: 22px;
            margin: -48px 16px 0;
            box-shadow: 0 6px 28px rgba(0, 0, 0, 0.09);
            position: relative;
            z-index: 10;
            overflow: hidden;
        }

        /* Info row */
        .info-row {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 16px 20px;
        }

        .info-row+.info-row {
            border-top: 1px solid #f3f4f6;
        }

        .info-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 2px;
        }

        /* Form mode */
        .form-wrap {
            padding: 20px 20px 6px;
            display: none;
        }

        .form-group {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 18px;
        }

        .form-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 28px;
        }

        .form-field {
            flex: 1;
        }

        .form-label {
            font-size: 11.5px;
            color: #9ca3af;
            font-weight: 500;
            margin-bottom: 6px;
            display: block;
        }

        .form-input {
            width: 100%;
            background: #f9fafb;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: #111827;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-input:focus {
            border-color: #22c55e;
            background: #fff;
        }

        textarea.form-input {
            resize: vertical;
            min-height: 80px;
            line-height: 1.5;
        }

        .form-error {
            font-size: 11px;
            color: #ef4444;
            margin-top: 4px;
        }

        /* Stat card */
        .stat-card {
            flex: 1;
            border-radius: 16px;
            padding: 14px 16px;
        }

        /* Keluar */
        .keluar-btn {
            width: 100%;
            background: #fff;
            border: 2px solid #ef4444;
            color: #ef4444;
            font-size: 15px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            border-radius: 16px;
            padding: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.18s, transform 0.15s;
        }

        .keluar-btn:hover {
            background: #fef2f2;
        }

        .keluar-btn:active {
            transform: scale(0.98);
        }

        /* Simpan */
        .simpan-btn {
            width: 100%;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            border: none;
            border-radius: 16px;
            padding: 17px;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s;
            margin-bottom: 6px;
        }

        .simpan-btn:active {
            transform: scale(0.98);
            opacity: 0.9;
        }

        /* Bottom nav */
        .nav-bottom {
            height: 64px;
            background: #fff;
            border-top: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-around;
            flex-shrink: 0;
        }

        .nav-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            padding-top: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        .fade-in {
            animation: fadeIn 0.22s ease forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Toast notification */
        .toast {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #16a34a;
            color: #fff;
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            z-index: 999;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            animation: toastIn 0.3s ease, toastOut 0.3s ease 2.5s forwards;
        }

        .toast.error {
            background: #ef4444;
        }

        @keyframes toastIn {
            from { opacity: 0; transform: translateX(-50%) translateY(-10px); }
            to { opacity: 1; transform: translateX(-50%) translateY(0); }
        }

        @keyframes toastOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    </style>
</head>

<body>
    {{-- Toast Notifications --}}
    @if(session('success'))
        <div class="toast">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="toast error">{{ $errors->first() }}</div>
    @endif

    <div class="phone-wrapper">

        <div class="scroll-area">
            <div style="padding-bottom: 32px;">

                <!-- ── HEADER ── -->
                <div class="header-green">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
                        <div style="display:flex;align-items:center;gap:14px;">
                            <a href="{{ route('juru-angkut.index') }}"
                                style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2.5"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                            </a>
                            <h1 style="font-size:20px;font-weight:800;color:#fff;">Profil Saya</h1>
                        </div>
                        <button id="editToggleBtn" onclick="toggleEdit()"
                            style="width:38px;height:38px;background:rgba(255,255,255,0.2);border-radius:50%;border:none;display:flex;align-items:center;justify-content:center;cursor:pointer;">
                            <svg id="iconEdit" width="18" height="18" fill="none" stroke="#fff"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <svg id="iconClose" width="18" height="18" fill="none" stroke="#fff"
                                stroke-width="2.5" viewBox="0 0 24 24" style="display:none;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div style="text-align:center;">
                        <div class="avatar-circle">
                            @if($user->foto)
                                <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil" />
                            @else
                                <svg width="42" height="42" fill="none" stroke="#22c55e" stroke-width="1.8"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            @endif
                        </div>
                        <p style="font-size:20px;font-weight:800;color:#fff;">{{ $user->name }}</p>
                        <p style="font-size:13px;color:rgba(255,255,255,0.82);margin-top:5px;">Juru Angkut</p>
                    </div>
                </div>

                <!-- ── INFO CARD ── -->
                <div class="info-card">

                    <!-- VIEW MODE -->
                    <div id="viewMode">
                        <!-- Nama -->
                        <div class="info-row">
                            <div class="info-icon" style="background:#e8faf0;">
                                <svg width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <p style="font-size:11.5px;color:#9ca3af;font-weight:500;margin-bottom:3px;">Nama
                                    Lengkap</p>
                                <p style="font-size:14px;font-weight:700;color:#111827;">{{ $user->name }}</p>
                            </div>
                        </div>
                        <!-- HP -->
                        <div class="info-row">
                            <div class="info-icon" style="background:#eff6ff;">
                                <svg width="18" height="18" fill="none" stroke="#3b82f6" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <p style="font-size:11.5px;color:#9ca3af;font-weight:500;margin-bottom:3px;">Nomor HP
                                </p>
                                <p style="font-size:14px;font-weight:700;color:#111827;">{{ $user->telepon ?? '-' }}</p>
                            </div>
                        </div>
                        <!-- Alamat -->
                        <div class="info-row">
                            <div class="info-icon" style="background:#fff1f2;">
                                <svg width="18" height="18" fill="none" stroke="#f43f5e" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <p style="font-size:11.5px;color:#9ca3af;font-weight:500;margin-bottom:3px;">Alamat</p>
                                <p style="font-size:14px;font-weight:700;color:#111827;line-height:1.5;">{{ $user->alamat ?? '-' }}</p>
                            </div>
                        </div>
                        <!-- Email -->
                        <div class="info-row">
                            <div class="info-icon" style="background:#fef9c3;">
                                <svg width="18" height="18" fill="none" stroke="#ca8a04" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p style="font-size:11.5px;color:#9ca3af;font-weight:500;margin-bottom:3px;">Email
                                </p>
                                <p style="font-size:14px;font-weight:700;color:#111827;">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- EDIT MODE -->
                    <div id="editMode" class="form-wrap">
                        <form action="{{ route('juru-angkut.profil.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Foto -->
                            <div class="form-group">
                                <div class="form-icon" style="background:#e8faf0;">
                                    <svg width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Foto Profil</label>
                                    <input type="file" name="foto" accept="image/*" class="form-input" style="padding:10px 14px;font-weight:500;" />
                                    @error('foto')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Nama -->
                            <div class="form-group">
                                <div class="form-icon" style="background:#e8faf0;">
                                    <svg width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" />
                                    @error('name')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <!-- HP -->
                            <div class="form-group">
                                <div class="form-icon" style="background:#eff6ff;">
                                    <svg width="18" height="18" fill="none" stroke="#3b82f6" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Nomor HP</label>
                                    <input type="tel" name="telepon" class="form-input" value="{{ old('telepon', $user->telepon) }}" />
                                    @error('telepon')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <!-- Alamat -->
                            <div class="form-group">
                                <div class="form-icon" style="background:#fff1f2;">
                                    <svg width="18" height="18" fill="none" stroke="#f43f5e" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="alamat" class="form-input">{{ old('alamat', $user->alamat) }}</textarea>
                                    @error('alamat')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="simpan-btn">Simpan Perubahan</button>
                        </form>
                    </div>

                </div>
                <!-- END INFO CARD -->

                <!-- ── STATISTIK + KELUAR (tampil di view mode) ── -->
                <div id="menuSection">

                    <!-- Statistik -->
                    <div style="margin: 18px 16px 0;">
                        <p style="font-size:16px;font-weight:800;color:#111827;margin-bottom:12px;">Statistik</p>
                        <div style="display:flex;gap:12px;">
                            <div class="stat-card" style="background:#dcfce7;">
                                <p style="font-size:12px;color:#16a34a;font-weight:600;margin-bottom:6px;">Total Order
                                </p>
                                <p style="font-size:28px;font-weight:800;color:#16a34a;line-height:1.1;">{{ $totalOrder }}</p>
                            </div>
                            <div class="stat-card" style="background:#fef9c3;">
                                <p style="font-size:12px;color:#ca8a04;font-weight:600;margin-bottom:6px;">Total Komisi</p>
                                <div style="display:flex;align-items:center;gap:4px;">
                                    <p style="font-size:16px;font-weight:800;color:#ca8a04;line-height:1.1;">Rp {{ number_format($totalKomisi, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Keluar -->
                    <div style="padding: 14px 16px 0;">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="keluar-btn">
                                <svg width="18" height="18" fill="none" stroke="#ef4444" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>

                    <p style="text-align:center;font-size:11.5px;color:#d1d5db;font-weight:500;margin-top:18px;">Go
                        Garbage v1.0.0</p>
                </div>

            </div>
        </div><!-- end scroll-area -->

        <!-- ── BOTTOM NAV ── -->
        <div class="nav-bottom">
            <a href="{{ route('juru-angkut.index') }}" class="nav-btn">
                <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    <polyline stroke-linecap="round" stroke-linejoin="round" points="9 22 9 12 15 12 15 22" />
                </svg>
                <span style="font-size:10px;font-weight:500;color:#9ca3af;">Home</span>
            </a>
            <a href="{{ route('juru-angkut.order.index') }}" class="nav-btn">
                <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 11H4L5 9z" />
                </svg>
                <span style="font-size:10px;font-weight:500;color:#9ca3af;">Order</span>
            </a>
            <a href="{{ route('juru-angkut.riwayat') }}" class="nav-btn">
                <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span style="font-size:10px;font-weight:500;color:#9ca3af;">History</span>
            </a>
            <a href="{{ route('juru-angkut.profil') }}" class="nav-btn">
                <svg width="22" height="22" fill="#16a34a" viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                </svg>
                <span style="font-size:10px;font-weight:700;color:#16a34a;">Profile</span>
            </a>
        </div>

    </div>

    <script>
        let isEditMode = false;

        function toggleEdit() {
            isEditMode = !isEditMode;
            const viewMode = document.getElementById('viewMode');
            const editMode = document.getElementById('editMode');
            const menuSection = document.getElementById('menuSection');
            const iconEdit = document.getElementById('iconEdit');
            const iconClose = document.getElementById('iconClose');

            if (isEditMode) {
                viewMode.style.display = 'none';
                editMode.style.display = 'block';
                editMode.classList.add('fade-in');
                menuSection.style.display = 'none';
                iconEdit.style.display = 'none';
                iconClose.style.display = 'block';
            } else {
                viewMode.style.display = 'block';
                viewMode.classList.add('fade-in');
                editMode.style.display = 'none';
                menuSection.style.display = 'block';
                iconEdit.style.display = 'block';
                iconClose.style.display = 'none';
            }
        }

        // Auto-open edit mode if there are validation errors
        @if($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                toggleEdit();
            });
        @endif
    </script>
</body>

</html>

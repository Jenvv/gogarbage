@extends('admin.layouts.app')

@push('styles')
    <style>
        .dark #modalJuruAngkutPanel {
            background-color: #1a2231;
            border-color: #1d2939;
        }

        .dark #ja-header {
            border-bottom-color: #1d2939;
        }

        .dark #ja-icon-wrap {
            background-color: rgba(34, 197, 94, .10);
        }

        .dark #ja-icon-wrap svg {
            stroke: #4ade80;
        }

        .dark #modalJuruAngkutTitle {
            color: rgba(255, 255, 255, .90);
        }

        .dark #ja-header-sub {
            color: #98a2b3;
        }

        .dark #ja-close-btn:hover {
            background-color: rgba(255, 255, 255, .05);
            color: #d0d5dd;
        }

        .dark .ja-label {
            color: #d0d5dd;
        }

        .dark .ja-label-opt {
            color: #667085;
        }

        .dark .ja-hint {
            color: #667085;
        }

        .dark .ja-input {
            background-color: rgba(255, 255, 255, .05);
            border-color: #344054;
            color: rgba(255, 255, 255, .90);
        }

        .dark .ja-input::placeholder {
            color: rgba(255, 255, 255, .30);
        }

        .dark .ja-input:focus {
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, .15);
        }

        .dark .ja-section-label {
            color: #667085;
            background-color: #1a2231;
        }

        .dark .ja-section-line {
            border-color: #1d2939;
        }

        .dark .ja-dropzone {
            border-color: #344054;
            background-color: rgba(255, 255, 255, .02);
        }

        .dark .ja-dropzone:hover {
            border-color: #22c55e;
            background-color: rgba(34, 197, 94, .05);
        }

        .dark .ja-dropzone-icon {
            background-color: rgba(255, 255, 255, .05);
            color: #98a2b3;
        }

        .dark .ja-dropzone:hover .ja-dropzone-icon {
            background-color: rgba(34, 197, 94, .10);
            color: #4ade80;
        }

        .dark .ja-dropzone-cta {
            color: #4ade80;
        }

        .dark .ja-dropzone-or {
            color: #98a2b3;
        }

        .dark .ja-dropzone-hint {
            color: #667085;
        }

        .dark #jaFotoPreviewImg {
            box-shadow: 0 0 0 2px #344054;
        }

        .dark #jaFotoPreviewName {
            color: #d0d5dd;
        }

        .dark .ja-reset-btn {
            color: #f87171;
        }

        .dark .ja-reset-btn:hover {
            color: #fca5a5;
        }

        /* Password strength bar */
        .dark .ja-strength-track {
            background-color: rgba(255, 255, 255, .08);
        }

        .dark #ja-footer {
            border-top-color: #1d2939;
        }

        .dark .ja-btn-cancel {
            border-color: #344054;
            background-color: rgba(255, 255, 255, .05);
            color: #d0d5dd;
        }

        .dark .ja-btn-cancel:hover {
            background-color: rgba(255, 255, 255, .10);
        }
    </style>
@endpush


@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Data Juru Angkut</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola dan daftarkan akun juru angkut</p>
        </div>
        <button onclick="modalJuruAngkut.open()"
            class="inline-flex items-center gap-2 rounded-lg bg-green-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-green-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Juru Angkut
        </button>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-700 dark:bg-green-500/10 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-700 dark:bg-red-500/10 dark:text-red-400">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="p-5 md:p-6 overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Nama</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Email</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Telepon</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Saldo</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Total Order</th>
                        <th class="pb-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($juruAngkut as $ja)
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <td class="py-3 text-sm text-gray-700 dark:text-gray-300">{{ $ja->name }}</td>
                            <td class="py-3 text-sm text-gray-700 dark:text-gray-300">{{ $ja->email }}</td>
                            <td class="py-3 text-sm text-gray-700 dark:text-gray-300">{{ $ja->telepon ?? '-' }}</td>
                            <td class="py-3 text-sm font-semibold text-gray-700 dark:text-gray-300">Rp {{ number_format($ja->saldo, 0, ',', '.') }}</td>
                            <td class="py-3 text-sm text-gray-700 dark:text-gray-300">{{ $ja->total_order ?? 0 }}</td>
                            <td class="py-3 text-sm">
                                <div class="flex items-center gap-2">
                                    <button type="button" onclick='modalJuruAngkut.edit(@json($ja))'
                                        class="text-blue-500 hover:text-blue-700 text-xs font-medium transition">Edit</button>
                                    <form method="POST" action="{{ route('admin.pengguna.juru-angkut.destroy', $ja) }}" onsubmit="return confirm('Yakin ingin menghapus juru angkut ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium transition">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-sm text-gray-400">
                                Belum ada data juru angkut
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    {{-- ══════════════════════════════════════════
         MODAL TAMBAH JURU ANGKUT
    ══════════════════════════════════════════ --}}
    <div id="modalJuruAngkutWrap" aria-modal="true" role="dialog" aria-labelledby="modalJuruAngkutTitle"
        style="display:none; position:fixed; inset:0; z-index:999999;
               align-items:center; justify-content:center; padding:1rem;">

        <div id="modalJuruAngkutBackdrop" onclick="modalJuruAngkut.close()"
            style="position:absolute; inset:0;
                   background:rgba(16,24,40,0.55);
                   backdrop-filter:blur(3px); -webkit-backdrop-filter:blur(3px);
                   opacity:0; transition:opacity 250ms ease;">
        </div>

        <div id="modalJuruAngkutPanel" class="relative flex w-full flex-col rounded-2xl border border-gray-200 bg-white"
            style="z-index:1; max-width:760px; max-height:92vh;
                   box-shadow:0 20px 24px -4px rgba(16,24,40,.10),0 8px 8px -4px rgba(16,24,40,.04);
                   transform:scale(0.94); opacity:0;
                   transition:transform 280ms cubic-bezier(0.34,1.36,0.64,1), opacity 250ms ease;">

            {{-- Header --}}
            <div id="ja-header" class="flex shrink-0 items-center justify-between border-b border-gray-200 px-5 py-4">
                <div class="flex items-center gap-3">
                    <span id="ja-icon-wrap" class="flex items-center justify-center rounded-xl bg-green-50"
                        style="width:36px;height:36px">
                        <svg style="width:20px;height:20px" class="text-green-600" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </span>
                    <div>
                        <h3 id="modalJuruAngkutTitle" class="text-base font-semibold text-gray-800">
                            Tambah Juru Angkut
                        </h3>
                        <p id="ja-header-sub" class="text-xs text-gray-500">
                            Akun baru akan mendapat role <code class="font-mono">juru_angkut</code>
                        </p>
                    </div>
                </div>
                <button id="ja-close-btn" type="button" onclick="modalJuruAngkut.close()"
                    class="flex items-center justify-center rounded-lg text-gray-400
                           transition hover:bg-gray-100 hover:text-gray-600"
                    style="width:32px;height:32px" aria-label="Tutup modal">
                    <svg style="width:20px;height:20px" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="flex-1 overflow-y-auto px-5 py-5" style="scrollbar-width:thin">
                {{--
                    Controller: Admin\JuruAngkutController@store
                    Validasi server: name, email unique:users, password min:8 confirmed,
                    telepon nullable max:20, alamat nullable, foto nullable image max:2048
                    role di-set hardcode di controller, BUKAN dari form.
                --}}
                <form id="formJuruAngkut" action="{{ route('admin.pengguna.juru-angkut.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    <input type="hidden" name="_method" id="ja_method" value="POST">
                    <input type="hidden" name="role" value="juru_angkut">

                    <div style="display:flex;flex-direction:column;gap:1.25rem;">

                        {{-- ════ DATA AKUN ════ --}}
                        <div class="relative flex items-center gap-3" style="margin-top:4px">
                            <span class="ja-section-label shrink-0 text-xs font-medium text-gray-400 bg-white pr-2">
                                Data Akun
                            </span>
                            <div class="ja-section-line flex-1 border-t border-gray-200"></div>
                        </div>

                        {{-- Nama lengkap --}}
                        <div>
                            <label for="ja_name" class="ja-label block text-sm font-medium text-gray-700"
                                style="margin-bottom:6px">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="ja_name" name="name" maxlength="255" required autocomplete="name"
                                placeholder="Contoh: Budi Santoso"
                                class="ja-input w-full rounded-lg border border-gray-300 bg-white
                                       text-gray-800 placeholder-gray-400 text-sm px-4
                                       focus:outline-none focus:ring-2 focus:ring-green-500/20
                                       focus:border-green-400 transition"
                                style="height:44px">
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="ja_email" class="ja-label block text-sm font-medium text-gray-700"
                                style="margin-bottom:6px">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="ja_email" name="email" maxlength="255" required
                                autocomplete="email" placeholder="contoh@email.com"
                                class="ja-input w-full rounded-lg border border-gray-300 bg-white
                                       text-gray-800 placeholder-gray-400 text-sm px-4
                                       focus:outline-none focus:ring-2 focus:ring-green-500/20
                                       focus:border-green-400 transition"
                                style="height:44px">
                            <p class="ja-hint text-xs text-gray-400" style="margin-top:6px">
                                Digunakan untuk login — harus unik.
                            </p>
                        </div>

                 {{-- Password + Konfirmasi (2 kolom) --}}
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;align-items:start;">

                            <div>
                                <label for="ja_password" class="ja-label block text-sm font-medium text-gray-700"
                                    style="margin-bottom:6px">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                {{-- Gunakan inline style untuk bypass konflik class CSS --}}
                                <div style="position: relative; width: 100%;">
                                    <input type="password" id="ja_password" name="password" minlength="8" required
                                        autocomplete="new-password" placeholder="Min. 8 karakter"
                                        oninput="jaCheckStrength(this.value)"
                                        class="ja-input h-11 w-full rounded-lg border border-gray-300 bg-white
                                               text-gray-800 placeholder-gray-400 text-sm px-4
                                               focus:outline-none focus:ring-2 focus:ring-green-500/20
                                               focus:border-green-400 transition"
                                        style="padding-right: 2.5rem; box-sizing: border-box;">
                                    
                                    <button type="button" onclick="jaTogglePass('ja_password', this)"
                                        style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); z-index: 30; background: transparent; border: none; padding: 0;"
                                        class="text-gray-400 hover:text-gray-600 focus:outline-none transition"
                                        tabindex="-1" aria-label="Tampilkan password">
                                        <svg id="ja_password_eye" style="width:18px;height:18px" fill="none"
                                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639
                                                 C3.423 7.51 7.36 4.5 12 4.5c4.638 0
                                                 8.573 3.007 9.963 7.178.07.207.07.431
                                                 0 .639C20.577 16.49 16.64 19.5 12 19.5
                                                 c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </button>
                                </div>
                                
                                <div class="rounded-full mt-2 overflow-hidden bg-transparent" style="height:4px">
                                    <div id="jaStrengthBar" class="rounded-full transition-all duration-300"
                                        style="height:100%;width:0%;background:transparent;">
                                    </div>
                                </div>
                                <p id="jaStrengthLabel" class="ja-hint text-xs text-gray-400" style="margin-top:4px; min-height:16px;">
                                    &nbsp;
                                </p>
                            </div>

                            <div>
                                <label for="ja_password_confirmation"
                                    class="ja-label block text-sm font-medium text-gray-700" style="margin-bottom:6px">
                                    Konfirmasi Password <span class="text-red-500">*</span>
                                </label>
                                {{-- Gunakan inline style untuk bypass konflik class CSS --}}
                                <div style="position: relative; width: 100%;">
                                    <input type="password" id="ja_password_confirmation" name="password_confirmation"
                                        minlength="8" required autocomplete="new-password" placeholder="Ulangi password"
                                        oninput="jaCheckConfirm()"
                                        class="ja-input h-11 w-full rounded-lg border border-gray-300 bg-white
                                               text-gray-800 placeholder-gray-400 text-sm px-4
                                               focus:outline-none focus:ring-2 focus:ring-green-500/20
                                               focus:border-green-400 transition"
                                        style="padding-right: 2.5rem; box-sizing: border-box;">
                                    
                                    <button type="button" onclick="jaTogglePass('ja_password_confirmation', this)"
                                        style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); z-index: 30; background: transparent; border: none; padding: 0;"
                                        class="text-gray-400 hover:text-gray-600 focus:outline-none transition"
                                        tabindex="-1" aria-label="Tampilkan password">
                                        <svg id="ja_password_confirmation_eye" style="width:18px;height:18px"
                                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639
                                                 C3.423 7.51 7.36 4.5 12 4.5c4.638 0
                                                 8.573 3.007 9.963 7.178.07.207.07.431
                                                 0 .639C20.577 16.49 16.64 19.5 12 19.5
                                                 c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </button>
                                </div>
                                <div style="margin-top:8px">
                                    <p id="jaConfirmLabel" class="ja-hint text-xs text-gray-400" style="margin-top:4px; min-height:16px;">
                                        &nbsp;
                                    </p>
                                </div>
                            </div>

                        </div>

                        {{-- ════ DATA PRIBADI ════ --}}
                        <div class="relative flex items-center gap-3" style="margin-top:4px">
                            <span class="ja-section-label shrink-0 text-xs font-medium text-gray-400 bg-white pr-2">
                                Data Pribadi
                            </span>
                            <div class="ja-section-line flex-1 border-t border-gray-200"></div>
                        </div>

                        {{-- Telepon --}}
                        <div>
                            <label for="ja_telepon" class="ja-label block text-sm font-medium text-gray-700"
                                style="margin-bottom:6px">
                                No. Telepon
                                <span class="ja-label-opt text-xs font-normal text-gray-400">(opsional)</span>
                            </label>
                            <input type="text" id="ja_telepon" name="telepon" maxlength="20" autocomplete="tel"
                                placeholder="Contoh: 08123456789"
                                class="ja-input w-full rounded-lg border border-gray-300 bg-white
                                       text-gray-800 placeholder-gray-400 text-sm px-4
                                       focus:outline-none focus:ring-2 focus:ring-green-500/20
                                       focus:border-green-400 transition"
                                style="height:44px">
                            <p class="ja-hint text-xs text-gray-400" style="margin-top:6px">
                                Maksimal 20 karakter.
                            </p>
                        </div>

                        {{-- Alamat --}}
                        <div>
                            <label for="ja_alamat" class="ja-label block text-sm font-medium text-gray-700"
                                style="margin-bottom:6px">
                                Alamat
                                <span class="ja-label-opt text-xs font-normal text-gray-400">(opsional)</span>
                            </label>
                            <textarea id="ja_alamat" name="alamat" rows="3" placeholder="Alamat lengkap juru angkut..."
                                class="ja-input w-full rounded-lg border border-gray-300 bg-white
                                       text-sm text-gray-800 placeholder-gray-400 px-4 py-2.5
                                       focus:outline-none focus:ring-2 focus:ring-green-500/20
                                       focus:border-green-400 transition"
                                style="resize:none"></textarea>
                        </div>

                        {{-- ════ FOTO PROFIL ════ --}}
                        <div class="relative flex items-center gap-3" style="margin-top:4px">
                            <span class="ja-section-label shrink-0 text-xs font-medium text-gray-400 bg-white pr-2">
                                Foto Profil
                            </span>
                            <div class="ja-section-line flex-1 border-t border-gray-200"></div>
                        </div>

                        <div>
                            <label class="ja-label block text-sm font-medium text-gray-700" style="margin-bottom:6px">
                                Foto
                                <span class="ja-label-opt text-xs font-normal text-gray-400">(opsional)</span>
                            </label>
                            <label for="ja_foto"
                                class="ja-dropzone group flex cursor-pointer flex-col items-center
                                       justify-center rounded-xl border-2 border-dashed
                                       border-gray-200 bg-gray-50 p-6 transition
                                       hover:border-green-400 hover:bg-green-50">

                                <div id="jaFotoPlaceholder" class="flex flex-col items-center gap-2 text-center">
                                    <span
                                        class="ja-dropzone-icon flex items-center justify-center
                                                 rounded-xl bg-gray-100 text-gray-400
                                                 group-hover:bg-green-100 group-hover:text-green-500
                                                 transition"
                                        style="width:40px;height:40px">
                                        <svg style="width:20px;height:20px" fill="none" stroke="currentColor"
                                            stroke-width="1.75" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 16.5V19a1.5 1.5 0 001.5 1.5h15A1.5 1.5 0 0021 19v-2.5M16 8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-sm">
                                            <span class="ja-dropzone-cta font-medium text-green-500">Klik untuk
                                                unggah</span>
                                            <span class="ja-dropzone-or text-gray-500"> atau seret ke sini</span>
                                        </p>
                                        <p class="ja-dropzone-hint text-xs text-gray-400 mt-0.5">PNG, JPG, WebP · Maks. 2
                                            MB</p>
                                    </div>
                                </div>

                                <div id="jaFotoPreviewBox"
                                    style="display:none;flex-direction:column;align-items:center;gap:10px;text-align:center;">
                                    <img id="jaFotoPreviewImg" src="#" alt="Preview"
                                        class="rounded-xl object-cover ring-2 ring-gray-200"
                                        style="width:72px;height:72px">
                                    <div>
                                        <p id="jaFotoPreviewName" class="text-sm font-medium text-gray-700"></p>
                                        <button type="button" onclick="jaFotoReset(event)"
                                            class="ja-reset-btn text-xs text-red-500 hover:text-red-600 mt-0.5">
                                            Hapus &amp; ganti
                                        </button>
                                    </div>
                                </div>

                                <input type="file" id="ja_foto" name="foto" accept="image/*" class="hidden"
                                    onchange="jaFotoPreview(event)">
                            </label>
                        </div>

                    </div>{{-- /fields --}}
                </form>
            </div>{{-- /body --}}

            {{-- Footer --}}
            <div id="ja-footer"
                class="flex shrink-0 items-center justify-end gap-3
                       border-t border-gray-200 px-5 py-4">
                <button type="button" onclick="modalJuruAngkut.close()"
                    class="ja-btn-cancel rounded-lg border border-gray-300 bg-white
                           px-4 py-2.5 text-sm font-medium text-gray-700
                           hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="button" onclick="jaSubmit()"
                    class="inline-flex items-center gap-2 rounded-lg bg-green-500
                           px-5 py-2.5 text-sm font-medium text-white
                           hover:bg-green-600 active:scale-95 transition">
                    <svg style="width:16px;height:16px" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <span id="ja-submit-label">Simpan Juru Angkut</span>
                </button>
            </div>

        </div>{{-- /panel --}}
    </div>{{-- /wrap --}}
@endsection


@push('scripts')
    <script>
        (function() {
            'use strict';

            const wrap = document.getElementById('modalJuruAngkutWrap');
            const backdrop = document.getElementById('modalJuruAngkutBackdrop');
            const panel = document.getElementById('modalJuruAngkutPanel');

            /* ── Open / Close / Edit ── */
            window.modalJuruAngkut = {
                open() {
                    document.getElementById('modalJuruAngkutTitle').textContent = 'Tambah Juru Angkut';
                    document.getElementById('ja-header-sub').innerHTML = 'Akun baru akan mendapat role <code class="font-mono">juru_angkut</code>';
                    document.getElementById('ja-submit-label').textContent = 'Simpan Juru Angkut';
                    document.getElementById('ja_method').value = 'POST';
                    document.getElementById('formJuruAngkut').action = '{{ route("admin.pengguna.juru-angkut.store") }}';
                    document.getElementById('formJuruAngkut').reset();
                    document.getElementById('ja_password').required = true;
                    document.getElementById('ja_password_confirmation').required = true;
                    // Reset foto
                    document.getElementById('jaFotoPlaceholder').style.display = '';
                    document.getElementById('jaFotoPreviewBox').style.display = 'none';

                    wrap.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                    void wrap.offsetWidth;
                    backdrop.style.opacity = '1';
                    panel.style.transform = 'scale(1)';
                    panel.style.opacity = '1';
                },
                edit(data) {
                    document.getElementById('modalJuruAngkutTitle').textContent = 'Edit Juru Angkut';
                    document.getElementById('ja-header-sub').textContent = 'Ubah data: ' + data.name;
                    document.getElementById('ja-submit-label').textContent = 'Update Juru Angkut';
                    document.getElementById('ja_method').value = 'PUT';
                    document.getElementById('formJuruAngkut').action = '/admin/pengguna/juru-angkut/' + data.id;
                    document.getElementById('formJuruAngkut').reset();

                    // Fill fields
                    document.getElementById('ja_name').value = data.name || '';
                    document.getElementById('ja_email').value = data.email || '';
                    document.getElementById('ja_telepon').value = data.telepon || '';
                    document.getElementById('ja_alamat').value = data.alamat || '';
                    // Password optional for edit
                    document.getElementById('ja_password').required = false;
                    document.getElementById('ja_password_confirmation').required = false;
                    document.getElementById('ja_password').placeholder = 'Kosongkan jika tidak diubah';
                    document.getElementById('ja_password_confirmation').placeholder = 'Kosongkan jika tidak diubah';

                    wrap.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                    void wrap.offsetWidth;
                    backdrop.style.opacity = '1';
                    panel.style.transform = 'scale(1)';
                    panel.style.opacity = '1';
                },
                close() {
                    backdrop.style.opacity = '0';
                    panel.style.transform = 'scale(0.94)';
                    panel.style.opacity = '0';
                    setTimeout(function() {
                        wrap.style.display = 'none';
                        document.body.style.overflow = '';
                    }, 280);
                }
            };

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && wrap.style.display === 'flex') {
                    window.modalJuruAngkut.close();
                }
            });


            /* ── Toggle tampilkan/sembunyikan password ── */
            window.jaTogglePass = function(inputId, btn) {
                var inp = document.getElementById(inputId);
                var eye = document.getElementById(inputId + '_eye');
                var show = inp.type === 'password';

                inp.type = show ? 'text' : 'password';

                /* Ganti ikon: open-eye ↔ eye-slash */
                eye.innerHTML = show ?
                    '<path stroke-linecap="round" stroke-linejoin="round"' +
                    ' d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338' +
                    ' 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228' +
                    ' 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065' +
                    ' 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228' +
                    ' 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0' +
                    ' 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>' :
                    '<path stroke-linecap="round" stroke-linejoin="round"' +
                    ' d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5' +
                    ' 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639' +
                    'C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>' +
                    '<path stroke-linecap="round" stroke-linejoin="round"' +
                    ' d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>';
            };


            /* ── Password strength indicator ── */
            window.jaCheckStrength = function(val) {
                var bar = document.getElementById('jaStrengthBar');
                var label = document.getElementById('jaStrengthLabel');
                var score = 0;

                if (val.length >= 8) score++;
                if (/[A-Z]/.test(val)) score++;
                if (/[0-9]/.test(val)) score++;
                if (/[^A-Za-z0-9]/.test(val)) score++;

                var map = [{
                        w: '0%',
                        color: '#e5e7eb',
                        text: ''
                    },
                    {
                        w: '30%',
                        color: '#ef4444',
                        text: 'Lemah'
                    },
                    {
                        w: '55%',
                        color: '#f59e0b',
                        text: 'Sedang'
                    },
                    {
                        w: '80%',
                        color: '#3b82f6',
                        text: 'Kuat'
                    },
                    {
                        w: '100%',
                        color: '#22c55e',
                        text: 'Sangat kuat'
                    },
                ];

                var m = map[val.length === 0 ? 0 : score] || map[0];
                bar.style.width = m.w;
                bar.style.background = m.color;
                label.textContent = m.text;
                label.style.color = val.length === 0 ? '' : m.color;

                jaCheckConfirm();
            };

            /* ── Cek kecocokan konfirmasi password ── */
            window.jaCheckConfirm = function() {
                var pw = document.getElementById('ja_password').value;
                var conf = document.getElementById('ja_password_confirmation').value;
                var lbl = document.getElementById('jaConfirmLabel');

                if (!conf) {
                    lbl.textContent = '\u00a0';
                    lbl.style.color = '';
                    return;
                }

                if (pw === conf) {
                    lbl.textContent = '✓ Password cocok';
                    lbl.style.color = '#22c55e';
                } else {
                    lbl.textContent = '✗ Password tidak cocok';
                    lbl.style.color = '#ef4444';
                }
            };


            /* ── Foto preview & reset ── */
            window.jaFotoPreview = function(e) {
                var file = e.target.files[0];
                if (!file) return;
                if (file.size > 2 * 1024 * 1024) {
                    alert('File melebihi 2 MB. Pilih file yang lebih kecil.');
                    e.target.value = '';
                    return;
                }
                var reader = new FileReader();
                reader.onload = function(ev) {
                    document.getElementById('jaFotoPreviewImg').src = ev.target.result;
                    document.getElementById('jaFotoPreviewName').textContent = file.name;
                    document.getElementById('jaFotoPlaceholder').style.display = 'none';
                    document.getElementById('jaFotoPreviewBox').style.display = 'flex';
                };
                reader.readAsDataURL(file);
            };

            window.jaFotoReset = function(e) {
                e.preventDefault();
                e.stopPropagation();
                document.getElementById('ja_foto').value = '';
                document.getElementById('jaFotoPreviewBox').style.display = 'none';
                document.getElementById('jaFotoPlaceholder').style.display = '';
            };


            /* ── Submit + validasi client-side ── */
            window.jaSubmit = function() {
                var form = document.getElementById('formJuruAngkut');

                /* Validasi password confirmation secara manual */
                var pw = document.getElementById('ja_password').value;
                var conf = document.getElementById('ja_password_confirmation').value;

                if (pw !== conf) {
                    document.getElementById('ja_password_confirmation')
                        .setCustomValidity('Password dan konfirmasi tidak cocok.');
                } else {
                    document.getElementById('ja_password_confirmation').setCustomValidity('');
                }

                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                form.submit();
            };

        })();
    </script>
@endpush

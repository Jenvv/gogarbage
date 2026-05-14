import sys
import re

file_path = 'd:/Makul/JOKI/gogarbage/resources/views/jasa_angkut/order/proses_jemput.blade.php'
with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

# 1. CSRF Token
content = content.replace(
    '<meta name="viewport" content="width=device-width, initial-scale=1.0" />',
    '<meta name="viewport" content="width=device-width, initial-scale=1.0" />\n    <meta name="csrf-token" content="{{ csrf_token() }}">'
)

# 2. Customer Card
content = re.sub(
    r'<p style="font-size:17px;font-weight:800;color:#111827;margin-bottom:8px;">Budi Santoso</p>.*?Navigasi ke Lokasi\s*</button>',
    '''<p style="font-size:17px;font-weight:800;color:#111827;margin-bottom:8px;">{{ $pesanan->pengguna->name ?? 'Pelanggan' }}</p>
                    <div style="display:flex;align-items:flex-start;gap:6px;">
                        <svg width="15" height="15" fill="none" stroke="#ef4444" stroke-width="2" viewBox="0 0 24 24"
                            style="flex-shrink:0;margin-top:3px;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <p style="font-size:13px;color:#6b7280;line-height:1.65;">{{ $pesanan->alamat_jemput }}</p>
                    </div>
                    <a href="https://maps.google.com/?q={{ urlencode($pesanan->alamat_jemput) }}" target="_blank" class="btn-navigasi" style="text-decoration:none;">
                        <svg width="17" height="17" fill="none" stroke="#fff" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Navigasi ke Lokasi
                    </a>''',
    content, flags=re.DOTALL
)

# 3. Form Input & Kalkulasi
kalk_replacement = '''<!-- ── KALKULASI CARD (hidden initially) ── -->
                <div id="kalkulasiArea" style="display:none;">
                    <form id="selesaikanForm" action="{{ route('jasa-angkut.order.selesaikan', $pesanan->id) }}" method="POST">
                        @csrf
                        <div class="kalkulasi-card">

                            <!-- Card Header -->
                            <div class="kalk-header">
                                <div
                                    style="width:30px;height:30px;background:#16a34a;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                    <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2.2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 7H6a2 2 0 00-2 2v9a2 2 0 002 2h9a2 2 0 002-2v-3M16 3h5m0 0v5m0-5l-7 7" />
                                    </svg>
                                </div>
                                <div>
                                    <p style="font-size:13px;font-weight:700;color:#166534;">Ringkasan Sampah</p>
                                    <p style="font-size:11px;color:#16a34a;font-weight:500;">{{ count($pesanan->detailPesanan) }} item ditambahkan</p>
                                </div>
                            </div>

                            <div class="kalk-body">

                                <!-- Weight rows -->
                                <div id="weightRows">
                                    @php $hasAnorganik = false; @endphp
                                    @foreach($pesanan->detailPesanan as $detail)
                                    @php 
                                        $nama = $detail->kategoriSampah->nama ?? '-';
                                        if (strcasecmp($nama, 'Anorganik') === 0) {
                                            $hasAnorganik = true;
                                        }
                                        $icon = strcasecmp($nama, 'Organik') === 0 ? '🌿' : '♻️';
                                        $bgColor = strcasecmp($nama, 'Organik') === 0 ? '#f0fdf4' : '#eff6ff';
                                        $iconBg = strcasecmp($nama, 'Organik') === 0 ? '#d1fae5' : '#dbeafe';
                                    @endphp
                                    <div class="weight-row" style="background:{{ $bgColor }};margin-bottom:8px;">
                                        <div class="weight-badge">
                                            <div class="weight-icon" style="background:{{ $iconBg }};">{{ $icon }}</div>
                                            <div>
                                                <p style="font-size:12px;color:#6b7280;font-weight:500;">{{ $nama }}</p>
                                            </div>
                                        </div>
                                        <div style="display:flex;align-items:center;gap:6px;width:100px;">
                                            <input type="number" name="berat[{{ $detail->id }}]" class="form-input" placeholder="0.0" min="0" step="0.1" style="width:100%;text-align:right;font-size:16px;padding:8px;height:40px;" required>
                                            <p style="font-size:11px;color:#9ca3af;font-weight:500;">kg</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <!-- ── DIVIDER + Harga Anorganik ── -->
                                @if($hasAnorganik)
                                <div id="anorganikPriceSection">
                                    <div class="kalk-divider"></div>

                                    <!-- Section label -->
                                    <div style="display:flex;align-items:center;gap:6px;margin-bottom:10px;">
                                        <svg width="14" height="14" fill="none" stroke="#6b7280" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <line x1="12" y1="1" x2="12" y2="23" />
                                            <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" />
                                        </svg>
                                        <p
                                            style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:0.4px;">
                                            Harga Pembelian Anorganik
                                        </p>
                                    </div>

                                    <!-- Manual Rp input -->
                                    <div class="price-input-wrap" id="priceInputWrap">
                                        <div class="price-input-label-row">
                                            <span style="font-size:13px;font-weight:700;color:#9ca3af;">Rp</span>
                                            <span
                                                style="font-size:11px;color:#9ca3af;font-weight:500;margin-left:auto;">Masukkan
                                                harga manual</span>
                                        </div>
                                        <input type="number" name="harga_manual" id="inputHargaAnorganik" class="price-input-field"
                                            placeholder="0" min="0" oninput="renderTotal()" />
                                    </div>

                                    <!-- helper text -->
                                    <p style="font-size:11px;color:#9ca3af;margin-top:7px;padding-left:2px;">
                                        💡 Sesuaikan dengan harga yang disepakati bersama pelanggan
                                    </p>
                                </div>

                                <!-- ── TOTAL ── -->
                                <div id="totalSection">
                                    <div class="kalk-divider"></div>
                                    <div class="total-row">
                                        <div>
                                            <p style="font-size:11.5px;color:#16a34a;font-weight:600;margin-bottom:2px;">
                                                Total Pembayaran</p>
                                            <p style="font-size:11px;color:#6b7280;">ke pelanggan</p>
                                        </div>
                                        <p id="totalHarga" style="font-size:20px;font-weight:800;color:#16a34a;">Rp 0</p>
                                    </div>
                                </div>
                                @endif

                            </div>
                        </div>
                    </form>
                </div>
                <!-- ── END KALKULASI ── -->'''

content = re.sub(
    r'<!-- Tambah Sampah button \(hidden initially\) -->.*?<!-- ── END KALKULASI ── -->',
    kalk_replacement,
    content, flags=re.DOTALL
)

# 4. Modal Removal
content = re.sub(
    r'<!-- ── MODAL ── -->.*?</div>\s*</div>\s*</div>',
    '</div>\n    </div>',
    content, flags=re.DOTALL
)

# 5. Script Replacement
script_replacement = '''<script>
        const statusOrder = '{{ $pesanan->status }}';
        let state = 0;   // 0=menuju, 1=sampai, 2=mengambil, 3=done
        
        if (statusOrder === 'dalam_perjalanan') {
            state = 1;
        } else if (statusOrder === 'tiba' || statusOrder === 'penimbangan') {
            state = 2;
        } else if (statusOrder === 'selesai') {
            state = 3;
        }

        const mainBtn = document.getElementById('mainBtn');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const updateUrl = '{{ route("jasa-angkut.order.update-status", $pesanan->id) }}';

        // Init UI based on state
        window.onload = () => {
            if (state >= 1) {
                document.getElementById('sub1').style.display = 'none';
                markDone('circle1', 'line1');
                markActive('circle2', 'label2', 'sub2');
                mainBtn.textContent = 'Saya Sudah Sampai';
            }
            if (state >= 2) {
                document.getElementById('sub2').style.display = 'none';
                markDone('circle2', 'line2');
                markActive('circle3', 'label3', 'sub3');
                document.getElementById('kalkulasiArea').style.display = 'block';
                mainBtn.textContent = 'Selesaikan Order';
            }
            if (state >= 3) {
                document.getElementById('sub3').style.display = 'none';
                markDone('circle3', 'line3');
                markDone('circle4', null);
                document.getElementById('label4').style.color = '#111827';
                document.getElementById('label4').style.fontWeight = '700';
                document.getElementById('kalkulasiArea').style.display = 'none';
                mainBtn.style.background = 'linear-gradient(135deg,#d1fae5,#bbf7d0)';
                mainBtn.style.color = '#16a34a';
                mainBtn.style.cursor = 'default';
                mainBtn.textContent = '✓ Order Selesai';
                mainBtn.onclick = null;
            }
        };

        /* ── State machine ── */
        function handleMainBtn() {
            if (state === 0) goToSampaiLokasi();
            else if (state === 1) goToMengambilSampah();
            else if (state === 2) selesaikanOrder();
        }

        function markDone(circleId, lineId) {
            const c = document.getElementById(circleId);
            c.className = 'step-circle-done';
            c.innerHTML = `<svg width="16" height="16" fill="none" stroke="#fff" stroke-width="3" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>`;
            if (lineId) document.getElementById(lineId).className = 'step-line-done';
        }

        function markActive(circleId, labelId, subId) {
            const c = document.getElementById(circleId);
            c.className = 'step-circle-active';
            c.innerHTML = '';
            document.getElementById(labelId).style.color = '#111827';
            document.getElementById(subId).style.display = 'block';
        }

        async function updateStatus(newStatus) {
            try {
                const res = await fetch(updateUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ status: newStatus })
                });
                return res.ok;
            } catch (err) {
                console.error(err);
                return false;
            }
        }

        async function goToSampaiLokasi() {
            mainBtn.disabled = true;
            mainBtn.textContent = 'Memproses...';
            const success = await updateStatus('dalam_perjalanan');
            if (success) {
                state = 1;
                document.getElementById('sub1').style.display = 'none';
                markDone('circle1', 'line1');
                markActive('circle2', 'label2', 'sub2');
                mainBtn.textContent = 'Saya Sudah Sampai';
                mainBtn.disabled = false;
                scrollBottom();
            } else {
                mainBtn.disabled = false;
                mainBtn.textContent = 'Mulai Perjalanan';
                showToast('Gagal update status!');
            }
        }

        async function goToMengambilSampah() {
            mainBtn.disabled = true;
            mainBtn.textContent = 'Memproses...';
            const success = await updateStatus('tiba');
            if (success) {
                state = 2;
                document.getElementById('sub2').style.display = 'none';
                markDone('circle2', 'line2');
                markActive('circle3', 'label3', 'sub3');
                document.getElementById('kalkulasiArea').style.display = 'block';
                mainBtn.textContent = 'Selesaikan Order';
                mainBtn.disabled = false;
                scrollBottom();
            } else {
                mainBtn.disabled = false;
                mainBtn.textContent = 'Saya Sudah Sampai';
                showToast('Gagal update status!');
            }
        }

        function selesaikanOrder() {
            // Check form validity
            const form = document.getElementById('selesaikanForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            
            // Submit the form
            mainBtn.textContent = 'Menyimpan...';
            mainBtn.disabled = true;
            form.submit();
        }

        function renderTotal() {
            const raw = document.getElementById('inputHargaAnorganik').value;
            const val = parseInt(raw) || 0;
            document.getElementById('totalHarga').textContent = formatRp(val);
        }

        function formatRp(val) {
            return 'Rp ' + val.toLocaleString('id-ID');
        }

        function scrollBottom() {
            setTimeout(() => {
                const s = document.getElementById('scrollArea');
                s.scrollTo({ top: s.scrollHeight, behavior: 'smooth' });
            }, 120);
        }

        /* ── Toast ── */
        function showToast(msg) {
            const old = document.getElementById('_toast');
            if (old) old.remove();
            const t = document.createElement('div');
            t.id = '_toast';
            t.style.cssText = `
      position:absolute; bottom:86px; left:50%; transform:translateX(-50%);
      background:rgba(17,24,39,0.90); color:#fff; padding:10px 20px;
      border-radius:50px; font-size:12.5px; font-weight:600; z-index:300;
      white-space:nowrap; box-shadow:0 4px 20px rgba(0,0,0,0.22);
      animation: fadeInUp 0.28s ease;
    `;
            t.textContent = msg;
            document.getElementById('app').appendChild(t);
            setTimeout(() => t.remove(), 2800);
        }
    </script>'''

content = re.sub(
    r'<script>.*?</script>',
    script_replacement,
    content, flags=re.DOTALL
)

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(content)

print("Replacement done!")

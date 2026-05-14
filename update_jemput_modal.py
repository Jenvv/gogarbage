import re

file_path = 'd:/Makul/JOKI/gogarbage/resources/views/jasa_angkut/order/proses_jemput.blade.php'
with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

# 1. Hapus KALKULASI CARD saat ini (dari div id="kalkulasiArea" sampai div class="tips-banner")
# Kemudian masukkan Tambah Sampah Button, Kalkulasi Card versi dinamis (js), dan Tips Banner.
html_replacement = '''<!-- Tambah Sampah button (hidden initially) -->
                <div id="tambahArea" style="display:none;margin:0 16px 14px;">
                    <button class="btn-tambah" onclick="openModal()">
                        <svg width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Sampah
                    </button>
                </div>

                <!-- ── KALKULASI CARD (hidden initially) ── -->
                <div id="kalkulasiArea" style="display:none;">
                    <form id="selesaikanForm" action="{{ route('jasa-angkut.order.selesaikan', $pesanan->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="trash_items" id="trashItemsInput">
                        
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
                                    <p style="font-size:11px;color:#16a34a;font-weight:500;" id="itemCount">0 item
                                        ditambahkan</p>
                                </div>
                            </div>

                            <div class="kalk-body">

                                <!-- Weight rows -->
                                <div id="weightRows"></div>

                                <!-- ── DIVIDER + Harga Anorganik ── -->
                                <div id="anorganikPriceSection" style="display:none;">
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
                                <div id="totalSection" style="display:none;">
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

                            </div>
                        </div>
                    </form>
                </div>
                <!-- ── END KALKULASI ── -->

                <!-- Tips Banner -->
                <div class="tips-banner">
                    <p style="font-size:13px;color:#374151;line-height:1.65;">
                        <span style="font-weight:700;color:#b45309;">Tips:</span>
                        Pastikan mengambil semua sampah dan mengkonfirmasi dengan pelanggan sebelum menyelesaikan order.
                    </p>
                </div>'''

content = re.sub(
    r'<!-- ── KALKULASI CARD \(hidden initially\) ── -->.*?<!-- Tips Banner -->',
    html_replacement + '\n\n                <!-- Tips Banner (replaced) -->',
    content, flags=re.DOTALL
)
# Fix double tips banner if we over-replaced or didn't replace exactly
content = re.sub(r'<!-- Tips Banner \(replaced\) -->.*?</div>', '', content, flags=re.DOTALL)


# 2. Add Modal HTML above <script>
modal_html = '''        <!-- ── MODAL ── -->
        <div class="modal-overlay" id="modalOverlay" onclick="closeModalOutside(event)">
            <div class="modal-sheet">
                <div class="modal-handle"></div>

                <!-- Modal Header -->
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                    <div>
                        <p style="font-size:16px;font-weight:800;color:#111827;">Tambah Data Sampah</p>
                        <p style="font-size:12px;color:#9ca3af;margin-top:2px;">Isi jumlah dan jenis sampah</p>
                    </div>
                    <button type="button" onclick="closeModal()"
                        style="width:32px;height:32px;border-radius:50%;background:#f3f4f6;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                        <svg width="14" height="14" fill="none" stroke="#6b7280" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Two-col inputs -->
                @php
                    $kategoris = \App\Models\KategoriSampah::where('aktif', true)->get();
                @endphp
                <div style="display:flex;gap:12px;">
                    <div class="form-group">
                        <label class="form-label">Jumlah</label>
                        <div style="position:relative;">
                            <input type="number" id="inputKg" class="form-input" placeholder="0.0" min="0" step="0.1"
                                style="padding-right:42px;" />
                            <span
                                style="position:absolute;right:14px;top:50%;transform:translateY(-50%);font-size:13px;font-weight:700;color:#9ca3af;">kg</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jenis Sampah</label>
                        <select id="inputJenis" class="form-input">
                            <option value="" disabled selected>Pilih</option>
                            @foreach($kategoris as $k)
                                <option value="{{ $k->nama }}">{{ $k->ikon }} {{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="button" class="btn-simpan" onclick="simpanSampah()">
                    <span style="display:flex;align-items:center;justify-content:center;gap:8px;">
                        <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan
                    </span>
                </button>
            </div>
        </div>

    </div>

    <script>'''

content = content.replace('    </div>\n\n    <script>', modal_html)


# 3. Replace the entire <script> content
script_content = '''        const statusOrder = '{{ $pesanan->status }}';
        let state = 0;   // 0=menuju, 1=sampai, 2=mengambil, 3=done
        let trashItems = [];   // { kg, jenis }

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
                document.getElementById('tambahArea').style.display = 'block';
                mainBtn.textContent = 'Selesaikan Order';
            }
            if (state >= 3) {
                document.getElementById('sub3').style.display = 'none';
                markDone('circle3', 'line3');
                markDone('circle4', null);
                document.getElementById('label4').style.color = '#111827';
                document.getElementById('label4').style.fontWeight = '700';
                document.getElementById('tambahArea').style.display = 'none';
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
                document.getElementById('tambahArea').style.display = 'block';
                mainBtn.textContent = 'Selesaikan Order';
                mainBtn.disabled = false;
                scrollBottom();
            } else {
                mainBtn.disabled = false;
                mainBtn.textContent = 'Saya Sudah Sampai';
                showToast('Gagal update status!');
            }
        }

        /* ── Modal ── */
        function openModal() {
            document.getElementById('modalOverlay').classList.add('active');
            document.getElementById('inputKg').value = '';
            document.getElementById('inputJenis').value = '';
        }

        function closeModal() {
            document.getElementById('modalOverlay').classList.remove('active');
        }

        function closeModalOutside(e) {
            if (e.target === document.getElementById('modalOverlay')) closeModal();
        }

        function simpanSampah() {
            const kg = parseFloat(document.getElementById('inputKg').value);
            const jenis = document.getElementById('inputJenis').value;
            if (!kg || kg <= 0) { showToast('⚠️ Masukkan jumlah kg yang valid!'); return; }
            if (!jenis) { showToast('⚠️ Pilih jenis sampah terlebih dahulu!'); return; }

            trashItems.push({ kg, jenis });
            renderKalkulasi();
            closeModal();
            showToast(`✅ ${jenis} ${kg} kg berhasil ditambahkan`);
        }

        /* ── Kalkulasi rendering ── */
        function renderKalkulasi() {
            document.getElementById('kalkulasiArea').style.display = 'block';

            // Aggregate by type
            let organikKg = 0;
            let anorganikKg = 0;
            let campuranKg = 0;
            trashItems.forEach(i => {
                if (i.jenis.toLowerCase() === 'organik') organikKg += i.kg;
                else if (i.jenis.toLowerCase() === 'anorganik') anorganikKg += i.kg;
                else campuranKg += i.kg;
            });

            let rowsHTML = '';

            if (organikKg > 0) {
                rowsHTML += `
        <div class="weight-row" style="background:#f0fdf4;margin-bottom:8px;">
          <div class="weight-badge">
            <div class="weight-icon" style="background:#d1fae5;">🌿</div>
            <div>
              <p style="font-size:12px;color:#6b7280;font-weight:500;">Organik</p>
            </div>
          </div>
          <div style="text-align:right;">
            <p style="font-size:18px;font-weight:800;color:#111827;line-height:1;">${formatKg(organikKg)}</p>
            <p style="font-size:11px;color:#9ca3af;font-weight:500;">kg</p>
          </div>
        </div>`;
            }

            if (anorganikKg > 0) {
                rowsHTML += `
        <div class="weight-row" style="background:#eff6ff;margin-bottom:8px;">
          <div class="weight-badge">
            <div class="weight-icon" style="background:#dbeafe;">♻️</div>
            <div>
              <p style="font-size:12px;color:#6b7280;font-weight:500;">Anorganik</p>
            </div>
          </div>
          <div style="text-align:right;">
            <p style="font-size:18px;font-weight:800;color:#111827;line-height:1;">${formatKg(anorganikKg)}</p>
            <p style="font-size:11px;color:#9ca3af;font-weight:500;">kg</p>
          </div>
        </div>`;
            }

            if (campuranKg > 0) {
                rowsHTML += `
        <div class="weight-row" style="background:#f3f4f6;margin-bottom:8px;">
          <div class="weight-badge">
            <div class="weight-icon" style="background:#e5e7eb;">🗑️</div>
            <div>
              <p style="font-size:12px;color:#6b7280;font-weight:500;">Campuran</p>
            </div>
          </div>
          <div style="text-align:right;">
            <p style="font-size:18px;font-weight:800;color:#111827;line-height:1;">${formatKg(campuranKg)}</p>
            <p style="font-size:11px;color:#9ca3af;font-weight:500;">kg</p>
          </div>
        </div>`;
            }

            document.getElementById('weightRows').innerHTML = rowsHTML;
            document.getElementById('itemCount').textContent = trashItems.length + ' item ditambahkan';

            const showAnorganik = anorganikKg > 0;
            document.getElementById('anorganikPriceSection').style.display = showAnorganik ? 'block' : 'none';
            document.getElementById('totalSection').style.display = showAnorganik ? 'block' : 'none';

            renderTotal();
            scrollBottom();
        }

        function renderTotal() {
            const raw = document.getElementById('inputHargaAnorganik').value;
            const val = parseInt(raw) || 0;
            document.getElementById('totalHarga').textContent = formatRp(val);
        }

        function formatKg(val) {
            return parseFloat(val.toFixed(1)).toString();
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

        function selesaikanOrder() {
            if (trashItems.length === 0) {
                showToast('⚠️ Tambahkan minimal 1 data sampah dulu!');
                return;
            }
            
            // Set the hidden input value
            document.getElementById('trashItemsInput').value = JSON.stringify(trashItems);

            const form = document.getElementById('selesaikanForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            
            mainBtn.textContent = 'Menyimpan...';
            mainBtn.disabled = true;
            form.submit();
        }

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
        }'''

content = re.sub(
    r'        const statusOrder = .*?showToast\(msg\) \{.*?\}',
    script_content,
    content, flags=re.DOTALL
)

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(content)

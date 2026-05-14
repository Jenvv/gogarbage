import re

file_path = 'd:/Makul/JOKI/gogarbage/resources/views/jasa_angkut/order/proses_jemput.blade.php'
with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

# 1. Tambahkan fungsi hapusSampah sebelum renderKalkulasi
hapus_function = '''
        function hapusSampah(index) {
            const removed = trashItems.splice(index, 1)[0];
            renderKalkulasi();
            showToast(`🗑️ ${removed.jenis} ${removed.kg} kg dihapus`);
            
            if (trashItems.length === 0) {
                document.getElementById('weightRows').innerHTML = '<p style="font-size:12px;color:#9ca3af;text-align:center;padding:10px 0;">Belum ada sampah yang dicatat</p>';
                document.getElementById('itemCount').textContent = `0 item ditambahkan`;
                document.getElementById('anorganikPriceSection').style.display = 'none';
                document.getElementById('totalSection').style.display = 'none';
                document.getElementById('inputHargaAnorganik').value = '';
            }
        }

        /* ── Kalkulasi rendering ── */
'''
content = content.replace('/* ── Kalkulasi rendering ── */', hapus_function)

# 2. Replace fungsi renderKalkulasi untuk merender per-item
# Kita regex isi fungsi mulai dari document.getElementById('kalkulasiArea').style.display = 'block';
# sampai baris sebelum document.getElementById('itemCount').textContent = ...
new_render_logic = '''        function renderKalkulasi() {
            document.getElementById('kalkulasiArea').style.display = 'block';

            let rowsHTML = '';
            let hasAnorganik = false;

            trashItems.forEach((i, index) => {
                if (i.jenis.toLowerCase() === 'anorganik') hasAnorganik = true;

                let bgRow = '#f9fafb';
                let bgIcon = '#f3f4f6';
                let iconChar = '🗑️';

                if (i.jenis.toLowerCase() === 'organik') { bgRow = '#f0fdf4'; bgIcon = '#d1fae5'; iconChar = '🌿'; }
                else if (i.jenis.toLowerCase() === 'anorganik') { bgRow = '#eff6ff'; bgIcon = '#dbeafe'; iconChar = '♻️'; }
                else { bgRow = '#f3f4f6'; bgIcon = '#e5e7eb'; iconChar = '🗑️'; }

                rowsHTML += `
                <div class="weight-row" style="background:${bgRow};margin-bottom:8px;">
                  <div class="weight-badge">
                    <div class="weight-icon" style="background:${bgIcon};">${iconChar}</div>
                    <div>
                      <p style="font-size:12px;color:#6b7280;font-weight:500;">${i.jenis}</p>
                    </div>
                  </div>
                  <div style="display:flex;align-items:center;gap:14px;">
                    <div style="text-align:right;">
                      <p style="font-size:18px;font-weight:800;color:#111827;line-height:1;">${formatKg(i.kg)}</p>
                      <p style="font-size:11px;color:#9ca3af;font-weight:500;">kg</p>
                    </div>
                    <button type="button" onclick="hapusSampah(${index})" style="background:none;border:none;cursor:pointer;padding:4px;display:flex;align-items:center;justify-content:center;border-radius:6px;transition:background 0.2s;" onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='none'">
                        <svg width="18" height="18" fill="none" stroke="#ef4444" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                  </div>
                </div>`;
            });

            document.getElementById('weightRows').innerHTML = rowsHTML;'''

# Kita akan lakukan substring replace dari "function renderKalkulasi() {" 
# sampai "document.getElementById('weightRows').innerHTML = rowsHTML;"
import re

content = re.sub(
    r'function renderKalkulasi\(\) \{.*?document\.getElementById\(\'weightRows\'\)\.innerHTML = rowsHTML;',
    new_render_logic,
    content,
    flags=re.DOTALL
)

# 3. Kita perlu pastikan anorganikKg yang digunakan di bagian if (hasAnorganik) bisa dikalkulasi ulang
# Karena anorganikKg sebelumnya dihitung di dalam renderKalkulasi, kita ganti logic anorganik section 
# dengan mencari hasAnorganik yang sudah kita declare di loop.
# Di bawah innerHTML = rowsHTML ada:
#             /* ── Show/hide anorganik price section ── */
#             if (anorganikKg > 0) {
# Ganti dengan if (hasAnorganik)
content = content.replace('if (anorganikKg > 0) {', 'if (hasAnorganik) {')

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(content)

import re

file_path = 'd:/Makul/JOKI/gogarbage/resources/views/jasa_angkut/order/proses_jemput.blade.php'
with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

# 1. Update fungsi hapusSampah untuk menghapus berdasarkan "jenis" kategori agregasi, bukan per-index
hapus_function_baru = '''
        function hapusSampah(jenis) {
            // Filter out items of this type
            const oldLength = trashItems.length;
            trashItems = trashItems.filter(item => item.jenis.toLowerCase() !== jenis.toLowerCase());
            
            if (oldLength !== trashItems.length) {
                renderKalkulasi();
                showToast(`🗑️ Sampah ${jenis} dihapus`);
            }
            
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
content = re.sub(r'function hapusSampah\(index\) \{.*?\/\* ── Kalkulasi rendering ── \*\/', hapus_function_baru, content, flags=re.DOTALL)

# 2. Kembalikan renderKalkulasi agar melakukan agregasi seperti simulasi awal (seperti awal semula)
# dan tambahkan tombol hapus di sebelah kg
new_render_logic = '''        function renderKalkulasi() {
            document.getElementById('kalkulasiArea').style.display = 'block';

            // Aggregate by type
            let organikKg = 0;
            let anorganikKg = 0;
            let campuranKg = 0;
            trashItems.forEach(i => {
                if (i.jenis.toLowerCase() === 'organik') organikKg += parseFloat(i.kg);
                else if (i.jenis.toLowerCase() === 'anorganik') anorganikKg += parseFloat(i.kg);
                else campuranKg += parseFloat(i.kg);
            });

            let rowsHTML = '';

            const makeRow = (jenisStr, kgVal, bgRow, bgIcon, iconChar, isLast) => {
                const margin = isLast ? '0' : '8px';
                return `
                <div class="weight-row" style="background:${bgRow};margin-bottom:${margin};">
                  <div class="weight-badge">
                    <div class="weight-icon" style="background:${bgIcon}; font-size:14px;">${iconChar}</div>
                    <div>
                      <p style="font-size:12px;color:#6b7280;font-weight:500;">${jenisStr}</p>
                    </div>
                  </div>
                  <div style="display:flex;align-items:center;gap:12px;">
                    <div style="text-align:right;">
                      <p style="font-size:18px;font-weight:800;color:#111827;line-height:1;">${kgVal.toFixed(1)}</p>
                      <p style="font-size:11px;color:#9ca3af;font-weight:500;">kg</p>
                    </div>
                    <button type="button" onclick="hapusSampah('${jenisStr}')" style="background:none;border:none;cursor:pointer;padding:4px;display:flex;align-items:center;justify-content:center;border-radius:6px;transition:background 0.2s;" onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='none'">
                        <svg width="18" height="18" fill="none" stroke="#ef4444" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                  </div>
                </div>`;
            };

            const itemsArr = [];
            if (organikKg > 0) itemsArr.push({ jenis: 'Organik', kg: organikKg, bgRow: '#f0fdf4', bgIcon: '#d1fae5', icon: '🌿' });
            if (anorganikKg > 0) itemsArr.push({ jenis: 'Anorganik', kg: anorganikKg, bgRow: '#eff6ff', bgIcon: '#dbeafe', icon: '♻️' });
            if (campuranKg > 0) itemsArr.push({ jenis: 'Campuran', kg: campuranKg, bgRow: '#f3f4f6', bgIcon: '#e5e7eb', icon: '🗑️' });

            itemsArr.forEach((item, index) => {
                rowsHTML += makeRow(item.jenis, item.kg, item.bgRow, item.bgIcon, item.icon, index === itemsArr.length - 1);
            });

            document.getElementById('weightRows').innerHTML = rowsHTML;'''

content = re.sub(
    r'function renderKalkulasi\(\) \{.*?document\.getElementById\(\'weightRows\'\)\.innerHTML = rowsHTML;',
    new_render_logic,
    content,
    flags=re.DOTALL
)

# 3. Pastikan pengkondisian harga anorganik menggunakan anorganikKg > 0
content = content.replace('if (hasAnorganik) {', 'if (anorganikKg > 0) {')
# tapi di fungsi baru, anorganikKg ada di local scope. Tunggu, kita harus letakkan hasAnorganik = anorganikKg > 0 
# di dalam renderKalkulasi! Kita harus ubah itu. 
# Lebih mudah biarkan anorganikKg > 0 jika di function aslinya, atau definisikan ulang:
content = content.replace('if (anorganikKg > 0) {', 'const hasAnorganikVal = trashItems.some(i => i.jenis.toLowerCase() === "anorganik");\n            if (hasAnorganikVal) {')

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(content)

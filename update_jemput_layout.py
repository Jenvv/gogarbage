import re

file_path = 'd:/Makul/JOKI/gogarbage/resources/views/jasa_angkut/order/proses_jemput.blade.php'
with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

# 1. Hapus form dari kalkulasiArea
content = content.replace('''<div id="kalkulasiArea" style="display:none;">
                    <form id="selesaikanForm" action="{{ route('jasa-angkut.order.selesaikan', $pesanan->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="trash_items" id="trashItemsInput">
                        
                        <div class="kalkulasi-card">''', '''<div id="kalkulasiArea" style="display:none;">
                    <div class="kalkulasi-card">''')

content = content.replace('''                        </div>
                    </form>
                </div>''', '''                        </div>
                    </div>
                </div>''')

# 2. Tambahkan invisible form di akhir file
form_html = '''    <form id="selesaikanForm" action="{{ route('jasa-angkut.order.selesaikan', $pesanan->id) }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="trash_items" id="trashItemsInput">
        <input type="hidden" name="harga_manual" id="hargaManualInput">
    </form>
</body>'''
content = content.replace('</body>', form_html)

# 3. Hapus name attr dari input visible
content = content.replace('<input type="number" name="harga_manual" id="inputHargaAnorganik"', '<input type="number" id="inputHargaAnorganik"')

# 4. Update selesaikanOrder function di js
js_replace = '''document.getElementById('trashItemsInput').value = JSON.stringify(trashItems);
            
            const rawHarga = document.getElementById('inputHargaAnorganik') ? document.getElementById('inputHargaAnorganik').value : '';
            document.getElementById('hargaManualInput').value = rawHarga;

            const form = document.getElementById('selesaikanForm');'''

content = content.replace('''document.getElementById('trashItemsInput').value = JSON.stringify(trashItems);

            const form = document.getElementById('selesaikanForm');''', js_replace)

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(content)

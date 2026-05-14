import re

file_path = 'd:/Makul/JOKI/gogarbage/resources/views/pelanggan/jemput_sampah/tracking_pesanan.blade.php'
with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

# Driver info update
content = content.replace('Budi Santoso', '{{ $pesanan->jasaAngkut->name ?? \'Menunggu Juru Angkut\' }}')

# Add IDs to Step 1
content = content.replace(
    '''<!-- Step 1: Pesanan Dikonfirmasi (done) -->
                    <div class="timeline-item" style="position:relative;">
                        <div style="position:relative;flex-shrink:0;">
                            <div class="timeline-dot done">''',
    '''<!-- Step 1: Pesanan Dikonfirmasi -->
                    <div class="timeline-item" style="position:relative;" id="step1">
                        <div style="position:relative;flex-shrink:0;">
                            <div class="timeline-dot pending" id="dot1">'''
)
content = content.replace(
    '''<div class="timeline-line done"></div>''',
    '''<div class="timeline-line pending" id="line1"></div>'''
)

# Replace the ACTION BUTTONS and SCRIPT
script_replacement = '''<!-- ── ACTION BUTTONS ── -->
                <div style="padding: 14px 16px 0;">
                    <button class="btn-home" onclick="window.location.href='{{ route('pelanggan.dashboard') }}'">Kembali ke Beranda</button>
                </div>

            </div>
        </div><!-- end scroll-area -->

        <!-- ── BOTTOM NAV ── -->
        <div class="nav-bottom">
            <div class="nav-btn" onclick="window.location.href='{{ route('pelanggan.dashboard') }}'">
                <svg width="22" height="22" fill="#9ca3af" viewBox="0 0 24 24">
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                </svg>
                <span style="font-size:10px;font-weight:500;color:#9ca3af;">Home</span>
            </div>
            <div class="nav-btn" onclick="window.location.href='{{ route('pelanggan.jemput.riwayat') }}'">
                <svg width="22" height="22" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span style="font-size:10px;font-weight:700;color:#16a34a;">Order</span>
            </div>
            <div class="nav-btn">
                <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span style="font-size:10px;font-weight:500;color:#9ca3af;">History</span>
            </div>
            <div class="nav-btn">
                <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                <span style="font-size:10px;font-weight:500;color:#9ca3af;">Wallet</span>
            </div>
            <div class="nav-btn">
                <svg width="22" height="22" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span style="font-size:10px;font-weight:500;color:#9ca3af;">Profile</span>
            </div>
        </div>

    </div>

    <script>
        const statusOrder = '{{ $pesanan->status }}';

        function checkIcon() {
            return `<svg width="16" height="16" fill="none" stroke="#fff" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>`;
        }

        function setDot(id, state) {
            const el = document.getElementById(id);
            if (!el) return;
            el.className = 'timeline-dot ' + state;
            el.innerHTML = state === 'done' ? checkIcon() : '';
        }
        function setLine(id, state) {
            const el = document.getElementById(id);
            if (!el) return;
            el.className = 'timeline-line ' + state;
        }

        function initUI() {
            // Reset all
            ['dot1','dot2','dot3','dot4'].forEach(id => setDot(id, 'pending'));
            ['line1','line2','line3'].forEach(id => setLine(id, 'pending'));

            if (statusOrder === 'menunggu') {
                setDot('dot1', 'active');
                document.getElementById('label2').style.color = '#9ca3af';
                document.getElementById('desc2').style.color = '#9ca3af';
                document.getElementById('live2').style.display = 'none';
                document.getElementById('time2').style.display = 'none';
            }
            else if (statusOrder === 'diklaim') {
                setDot('dot1', 'done'); setLine('line1', 'done');
                document.getElementById('label2').style.color = '#9ca3af';
                document.getElementById('desc2').style.color = '#9ca3af';
                document.getElementById('live2').style.display = 'none';
                document.getElementById('time2').style.display = 'none';
            } 
            else if (statusOrder === 'dalam_perjalanan') {
                setDot('dot1', 'done'); setLine('line1', 'done');
                setDot('dot2', 'active');
                document.getElementById('label2').style.color = '#111827';
                document.getElementById('desc2').style.color = '#6b7280';
                document.getElementById('live2').style.display = 'block';
                document.getElementById('time2').style.display = 'none';
            }
            else if (statusOrder === 'tiba' || statusOrder === 'penimbangan') {
                setDot('dot1', 'done'); setLine('line1', 'done');
                setDot('dot2', 'done'); setLine('line2', 'done');
                setDot('dot3', 'active');
                
                document.getElementById('label2').style.color = '#111827';
                document.getElementById('desc2').style.color = '#6b7280';
                document.getElementById('live2').style.display = 'none';
                document.getElementById('time2').style.display = 'block';

                document.getElementById('label3').style.color = '#111827';
                document.getElementById('desc3').style.color = '#6b7280';
                document.getElementById('live3').style.display = 'block';
            }
            else if (statusOrder === 'selesai') {
                setDot('dot1', 'done'); setLine('line1', 'done');
                setDot('dot2', 'done'); setLine('line2', 'done');
                setDot('dot3', 'done'); setLine('line3', 'done');
                setDot('dot4', 'done');

                document.getElementById('label2').style.color = '#111827';
                document.getElementById('desc2').style.color = '#6b7280';
                document.getElementById('live2').style.display = 'none';
                document.getElementById('time2').style.display = 'block';

                document.getElementById('label3').style.color = '#111827';
                document.getElementById('desc3').style.color = '#6b7280';
                document.getElementById('live3').style.display = 'none';

                document.getElementById('label4').style.color = '#111827';
                document.getElementById('desc4').style.color = '#6b7280';
            }
        }

        initUI();

        // Optional: Auto-refresh data status
        setInterval(() => {
            window.location.reload();
        }, 10000);
    </script>
</body>
</html>'''

content = re.sub(
    r'<!-- ── ACTION BUTTONS ── -->.*?</html>',
    script_replacement,
    content, flags=re.DOTALL
)

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(content)

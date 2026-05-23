<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\KategoriSampah;
use App\Models\Pesanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Konfigurasi;

class JemputSampahController extends Controller
{
    public function index()
    {
        $kategoriSampah = KategoriSampah::aktif()->get();

        // Cek apakah user punya langganan aktif
        $user = Auth::user();
        $langgananAktif = $user ? $user->langgananAktif() : null;
        $isBerlangganan = $langgananAktif !== null;

        // Biaya jemput dari konfigurasi, gratis jika berlangganan
        $biayaJemput = $isBerlangganan ? 0 : (int) Konfigurasi::getValue('biaya_jemput', 5000);

        return view('pelanggan.jemput_sampah.index', compact(
            'kategoriSampah',
            'isBerlangganan',
            'langgananAktif',
            'biayaJemput'
        ));
    }


    // * Step 1: Validasi form → simpan di SESSION (belum masuk database). 
    // * Data baru masuk DB saat user klik "Pesan Sekarang" di halaman konfirmasi.

    public function store(Request $request)
    {
        $user = Auth::user();

        // Validasi: 1 user hanya bisa punya 1 pesanan aktif
        $pesananAktif = Pesanan::where('user_id', $user->id)
            ->whereNotIn('status', ['selesai', 'dibatalkan'])
            ->first();

        if ($pesananAktif) {
            return back()->withErrors([
                'pesanan' => 'Kamu masih memiliki pesanan aktif (#' . $pesananAktif->nomor_pesanan . '). Selesaikan atau batalkan terlebih dahulu.'
            ])->withInput();
        }

        $request->validate([
            'kategori_sampah'   => 'required|array|min:1',
            'kategori_sampah.*' => 'exists:kategori_sampah,id',
            'alamat_jemput'     => 'required|string|max:500',
            'latitude'          => 'nullable|numeric',
            'longitude'         => 'nullable|numeric',
            'tanggal_jemput'    => 'required|date|after_or_equal:today',
            'jam_jemput'        => 'required|string',
            'catatan'           => 'nullable|string|max:500',
        ], [
            'kategori_sampah.required'      => 'Pilih minimal 1 jenis sampah.',
            'kategori_sampah.min'           => 'Pilih minimal 1 jenis sampah.',
            'alamat_jemput.required'        => 'Alamat penjemputan wajib diisi.',
            'tanggal_jemput.required'       => 'Tanggal penjemputan wajib diisi.',
            'tanggal_jemput.after_or_equal' => 'Tanggal tidak boleh di masa lalu.',
            'jam_jemput.required'           => 'Jam penjemputan wajib diisi.',
        ]);

        // Simpan data form ke SESSION (belum masuk database)
        $langgananAktif = $user->langgananAktif();
        $isBerlangganan = $langgananAktif !== null;

        session()->put('pesanan_draft', [
            'kategori_sampah' => $request->kategori_sampah,
            'alamat_jemput'   => $request->alamat_jemput,
            'latitude'        => $request->latitude,
            'longitude'       => $request->longitude,
            'tanggal_jemput'  => $request->tanggal_jemput,
            'jam_jemput'      => $request->jam_jemput,
            'catatan'         => $request->catatan,
            'biaya_jemput'    => $isBerlangganan ? 0 : (int) Konfigurasi::getValue('biaya_jemput', 5000),
            'tipe_pesanan'    => $isBerlangganan ? 'langganan' : 'reguler',
            'langganan_id'    => $isBerlangganan ? $langgananAktif->id : null,
        ]);

        return redirect()->route('pelanggan.konfirmasi-pesanan');
    }


    //  * Step 2: Tampilkan halaman konfirmasi dari data SESSION.
    //  * Data belum masuk database — user masih bisa batal.

    public function konfirmasi_pesanan()
    {
        $draft = session('pesanan_draft');

        if (!$draft) {
            return redirect()->route('pelanggan.jemput-sampah')
                ->withErrors(['pesanan' => 'Silakan isi form jemput sampah terlebih dahulu.']);
        }

        // Ambil data kategori sampah untuk ditampilkan
        $kategoriList = KategoriSampah::whereIn('id', $draft['kategori_sampah'])->get();
        $isBerlangganan = $draft['tipe_pesanan'] === 'langganan';

        return view('pelanggan.jemput_sampah.konfirmasi_pesanan', compact(
            'draft',
            'kategoriList',
            'isBerlangganan'
        ));
    }


    //  * Step 3: User klik "Pesan Sekarang" → INSERT ke database.
    //  * Data masuk ke 3 tabel: pesanan, detail_pesanan, transaksi.
    //  * Dibungkus DB::transaction agar atomik.

    public function confirm_pesanan(Request $request)
    {
        $draft = session('pesanan_draft');

        if (!$draft) {
            return redirect()->route('pelanggan.jemput-sampah')
                ->withErrors(['pesanan' => 'Data pesanan tidak ditemukan. Silakan ulangi.']);
        }

        $user = Auth::user();
        $metode = $request->input('metode_pembayaran', 'tunai');
        $totalBiaya = $draft['biaya_jemput'] + 1000;

        // Validasi ulang: 1 user = 1 pesanan aktif
        $pesananAktif = Pesanan::where('user_id', $user->id)
            ->whereNotIn('status', ['selesai', 'dibatalkan'])
            ->first();

        if ($pesananAktif) {
            session()->forget('pesanan_draft');
            return redirect()->route('pelanggan.jemput-sampah')->withErrors([
                'pesanan' => 'Kamu masih memiliki pesanan aktif (#' . $pesananAktif->nomor_pesanan . ').'
            ]);
        }

        // Validasi saldo
        if ($metode === 'saldo' && $user->saldo < $totalBiaya) {
            return redirect()->route('pelanggan.konfirmasi-pesanan')->withErrors([
                'saldo' => 'Saldo kamu tidak mencukupi.'
            ]);
        }

        // Handle bukti pembayaran upload
        $buktiPath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        $pesanan = DB::transaction(function () use ($draft, $user, $metode, $totalBiaya, $buktiPath) {

            $saldoSebelum = $user->saldo;

            // Potong saldo jika bayar via saldo
            if ($metode === 'saldo') {
                $user->update(['saldo' => $user->saldo - $totalBiaya]);
            }

            $saldoSesudah = $user->saldo;

            // 1. Insert ke tabel pesanan
            $pesanan = Pesanan::create([
                'nomor_pesanan' => Pesanan::generateNomor(),
                'user_id'       => $user->id,
                'langganan_id'  => $draft['langganan_id'],
                'alamat_jemput'  => $draft['alamat_jemput'],
                'latitude'       => $draft['latitude'],
                'longitude'      => $draft['longitude'],
                'tanggal_jemput'  => $draft['tanggal_jemput'],
                'jam_jemput'      => $draft['jam_jemput'],
                'status'          => 'menunggu',
                'tipe_pesanan'    => $draft['tipe_pesanan'],
                'biaya_jemput'    => $draft['biaya_jemput'],
                'metode_pembayaran' => $metode,
                'bukti_pembayaran'  => $buktiPath,
                'catatan'         => $draft['catatan'],
            ]);

            // 2. Insert ke tabel detail_pesanan (per kategori sampah)
            $kategoriList = KategoriSampah::whereIn('id', $draft['kategori_sampah'])->get();

            foreach ($kategoriList as $kategori) {
                DetailPesanan::create([
                    'pesanan_id'        => $pesanan->id,
                    'kategori_sampah_id' => $kategori->id,
                    'berat'              => 0,
                    'harga_per_kg'       => $kategori->harga_per_kg,
                    'subtotal'           => 0,
                ]);
            }

            // 3. Insert ke tabel transaksi (record pembayaran biaya jemput)
            Transaksi::create([
                'nomor_transaksi' => 'TRX-' . now()->format('Ymd') . '-' . str_pad(
                    Transaksi::whereDate('created_at', today())->count() + 1,
                    4,
                    '0',
                    STR_PAD_LEFT
                ),
                'user_id'        => $user->id,
                'tipe'           => 'keluar',
                'jumlah'         => $draft['biaya_jemput'],
                'saldo_sebelum'  => $saldoSebelum,
                'saldo_sesudah'  => $saldoSesudah,
                'status'         => 'selesai',
                'referensi_type' => Pesanan::class,
                'referensi_id'   => $pesanan->id,
                'deskripsi'      => 'Biaya jemput pesanan ' . $pesanan->nomor_pesanan . ' via ' . ucfirst($metode),
            ]);

            return $pesanan;
        });

        // Hapus draft dari session setelah berhasil
        session()->forget('pesanan_draft');

        return redirect()
            ->route('pelanggan.order-sukses', $pesanan->id)
            ->with('success', 'Pesanan berhasil dikonfirmasi!');
    }

    public function order_sukses($id)
    {
        $pesanan = Pesanan::with('detailPesanan.kategoriSampah')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('pelanggan.jemput_sampah.order_sukses', compact('pesanan'));
    }

    public function tracking_pesanan($id)
    {
        $pesanan = Pesanan::with('detailPesanan.kategoriSampah', 'pengangkut')
            ->where('user_id', Auth::id())
            ->findOrFail($id);
        return view('pelanggan.jemput_sampah.tracking_pesanan', compact('pesanan'));
    }

    public function order_selesai($id)
    {
        $pesanan = Pesanan::with('detailPesanan.kategoriSampah', 'pengangkut')
            ->where('user_id', Auth::id())
            ->findOrFail($id);
        return view('pelanggan.jemput_sampah.order_selesai', compact('pesanan'));
    }
}

<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\KategoriSampah;
use App\Models\Langganan;
use App\Models\Pesanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Konfigurasi;
use Carbon\CarbonImmutable;

class JemputSampahController extends Controller
{
    /**
     * Hitung jarak (KM) dari Bank Sampah ke lokasi pelanggan via OSRM.
     */
    private function hitungJarakOSRM(float $latUser, float $lonUser): ?float
    {
        $latBase = (float) Konfigurasi::getValue('lat_bank_sampah', -0.026330);
        $lonBase = (float) Konfigurasi::getValue('lon_bank_sampah', 109.342504);

        try {
            $response = Http::timeout(10)->get(
                "http://router.project-osrm.org/route/v1/driving/{$lonBase},{$latBase};{$lonUser},{$latUser}",
                ['overview' => 'false']
            );

            if ($response->ok()) {
                $data = $response->json();
                if (isset($data['routes'][0]['distance'])) {
                    return round($data['routes'][0]['distance'] / 1000, 2); // meter → KM
                }
            }
        } catch (\Exception $e) {
            // Fallback: hitung jarak langsung (Haversine) jika OSRM gagal
            return $this->hitungJarakHaversine($latBase, $lonBase, $latUser, $lonUser);
        }

        // Fallback jika response tidak valid
        return $this->hitungJarakHaversine($latBase, $lonBase, $latUser, $lonUser);
    }

    /**
     * Fallback: Haversine formula untuk hitung jarak lurus.
     */
    private function hitungJarakHaversine(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371; // KM
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return round($earthRadius * $c, 2);
    }

    /**
     * Kalkulasi ongkir berdasarkan jarak.
     * - Base fee meng-cover 1 KM pertama
     * - Setiap KM tambahan (dibulatkan ke atas) × tarif per KM
     */
    private function hitungOngkir(float $jarakKm): int
    {
        $baseFee = (int) Konfigurasi::getValue('ongkir_base_fee', 10000);
        $perKm   = (int) Konfigurasi::getValue('ongkir_per_km', 2500);

        if ($jarakKm <= 1) {
            return $baseFee;
        }

        $sisaKm = ceil($jarakKm - 1);
        return $baseFee + ($sisaKm * $perKm);
    }

    public function index()
    {
        $kategoriSampah = KategoriSampah::aktif()->get();

        // Cek apakah user punya langganan aktif
        $user = Auth::user();
        $langgananAktif = $user ? $user->langgananAktif() : null;
        $isBerlangganan = $langgananAktif !== null;

        // Ambil konfigurasi untuk kalkulasi di frontend
        $latBase = (float) Konfigurasi::getValue('lat_bank_sampah', -0.026330);
        $lonBase = (float) Konfigurasi::getValue('lon_bank_sampah', 109.342504);
        $baseFee = (int) Konfigurasi::getValue('ongkir_base_fee', 10000);
        $perKm   = (int) Konfigurasi::getValue('ongkir_per_km', 2500);

        return view('pelanggan.jemput_sampah.index', compact(
            'kategoriSampah',
            'isBerlangganan',
            'langgananAktif',
            'latBase',
            'lonBase',
            'baseFee',
            'perKm'
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
            'alamat_jemput'     => 'required|string|max:500',
            'latitude'          => 'required|numeric',
            'longitude'         => 'required|numeric',
            'tanggal_jemput'    => 'required|date|after_or_equal:today',
            'jam_jemput'        => 'required|string',
            'catatan'           => 'nullable|string|max:500',
        ], [
            'alamat_jemput.required'        => 'Alamat penjemputan wajib diisi.',
            'latitude.required'             => 'Lokasi GPS wajib dipilih dari peta.',
            'longitude.required'            => 'Lokasi GPS wajib dipilih dari peta.',
            'tanggal_jemput.required'       => 'Tanggal penjemputan wajib diisi.',
            'tanggal_jemput.after_or_equal' => 'Tanggal tidak boleh di masa lalu.',
            'jam_jemput.required'           => 'Jam penjemputan wajib diisi.',
        ]);

        // Simpan data form ke SESSION (belum masuk database)
        $langgananAktif = $user->langgananAktif();
        $isBerlangganan = $langgananAktif !== null;

        // Hitung jarak via OSRM
        $jarakKm = $this->hitungJarakOSRM((float) $request->latitude, (float) $request->longitude);
        if ($jarakKm === null) {
            $jarakKm = 1.0; // Default fallback jika semua gagal
        }

        // Hitung ongkir (hak juru angkut)
        $ongkirJuruAngkut = $this->hitungOngkir($jarakKm);

        // Hitung biaya admin & total
        $biayaAdmin = (int) Konfigurasi::getValue('biaya_admin_reguler', 2000);

        if ($isBerlangganan) {
            // Validasi kuota langganan
            $sisaKuota = $langgananAktif->sisaKuota();
            if ($sisaKuota <= 0) {
                return back()->withErrors([
                    'pesanan' => 'Kuota penjemputan langganan sudah habis. Silakan perpanjang paket.'
                ])->withInput();
            }

            $biayaAdmin = 0;
            $totalBayar = 0; // Pelanggan tidak bayar apa-apa
        } else {
            $totalBayar = $ongkirJuruAngkut + $biayaAdmin;
        }

        session()->put('pesanan_draft', [
            'alamat_jemput'       => $request->alamat_jemput,
            'latitude'            => $request->latitude,
            'longitude'           => $request->longitude,
            'tanggal_jemput'      => $request->tanggal_jemput,
            'jam_jemput'          => $request->jam_jemput,
            'catatan'             => $request->catatan,
            'jarak_km'            => $jarakKm,
            'ongkir_juru_angkut'  => $ongkirJuruAngkut,
            'biaya_admin'         => $biayaAdmin,
            'biaya_jemput'        => $totalBayar, // total tagihan pelanggan
            'tipe_pesanan'        => $isBerlangganan ? 'langganan' : 'reguler',
            'langganan_id'        => $isBerlangganan ? $langgananAktif->id : null,
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

        $isBerlangganan = $draft['tipe_pesanan'] === 'langganan';

        return view('pelanggan.jemput_sampah.konfirmasi_pesanan', compact(
            'draft',
            'isBerlangganan'
        ));
    }


    //  * Step 3: User klik "Pesan Sekarang" → INSERT ke database.
    //  * Data masuk ke tabel: pesanan, transaksi.
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

        $isBerlangganan = $draft['tipe_pesanan'] === 'langganan';
        $totalBiaya = $draft['biaya_jemput']; // sudah dihitung di store()

        // Jika berlangganan, override metode ke 'saldo'
        if ($isBerlangganan) {
            $metode = 'saldo';
        }

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
        if ($metode === 'saldo' && !$isBerlangganan && $user->saldo < $totalBiaya) {
            return redirect()->route('pelanggan.konfirmasi-pesanan')->withErrors([
                'saldo' => 'Saldo kamu tidak mencukupi.'
            ]);
        }

        // Handle bukti pembayaran upload
        $buktiPath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        $pesanan = DB::transaction(function () use ($draft, $user, $metode, $totalBiaya, $buktiPath, $isBerlangganan) {

            $saldoSebelum = $user->saldo;

            // Potong saldo jika bayar via saldo (dan bukan langganan gratis)
            if ($metode === 'saldo' && !$isBerlangganan && $totalBiaya > 0) {
                $user->update(['saldo' => $user->saldo - $totalBiaya]);
            }

            $saldoSesudah = $user->saldo;

            // 1. Insert ke tabel pesanan
            $pesanan = Pesanan::create([
                'nomor_pesanan'       => Pesanan::generateNomor(),
                'user_id'             => $user->id,
                'langganan_id'        => $draft['langganan_id'],
                'alamat_jemput'       => $draft['alamat_jemput'],
                'latitude'            => $draft['latitude'],
                'longitude'           => $draft['longitude'],
                'jarak_km'            => $draft['jarak_km'],
                'tanggal_jemput'      => $draft['tanggal_jemput'],
                'jam_jemput'          => $draft['jam_jemput'],
                'status'              => 'menunggu',
                'tipe_pesanan'        => $draft['tipe_pesanan'],
                'biaya_jemput'        => $draft['biaya_jemput'],
                'ongkir_juru_angkut'  => $draft['ongkir_juru_angkut'],
                'biaya_admin'         => $draft['biaya_admin'],
                'metode_pembayaran'   => $metode,
                'bukti_pembayaran'    => $buktiPath,
                'catatan'             => $draft['catatan'],
            ]);

            // 2. Insert ke tabel transaksi (record pembayaran jika tidak berlangganan dan ada biaya)
            if (!$isBerlangganan && $totalBiaya > 0) {
                Transaksi::create([
                    'nomor_transaksi' => 'TRX-' . now()->format('Ymd') . '-' . str_pad(
                        Transaksi::whereDate('created_at', today())->count() + 1,
                        4,
                        '0',
                        STR_PAD_LEFT
                    ),
                    'user_id'        => $user->id,
                    'tipe'           => 'keluar',
                    'jumlah'         => $totalBiaya,
                    'saldo_sebelum'  => $saldoSebelum,
                    'saldo_sesudah'  => $saldoSesudah,
                    'status'         => 'selesai',
                    'referensi_type' => Pesanan::class,
                    'referensi_id'   => $pesanan->id,
                    'deskripsi'      => 'Biaya jemput pesanan ' . $pesanan->nomor_pesanan . ' (Ongkir: Rp ' . number_format($draft['ongkir_juru_angkut'], 0, ',', '.') . ' + Admin: Rp ' . number_format($draft['biaya_admin'], 0, ',', '.') . ') via ' . ucfirst($metode),
                ]);
            }

            return $pesanan;
        });

        // Jika berlangganan → trigger reschedule jadwal
        if ($isBerlangganan && !empty($draft['langganan_id'])) {
            $langganan = Langganan::find($draft['langganan_id']);
            if ($langganan) {
                $titikOrder = CarbonImmutable::parse($draft['tanggal_jemput']);
                $langganan->rescheduleAfterManualOrder($titikOrder);
            }
        }

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

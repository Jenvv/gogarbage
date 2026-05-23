<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penarikan;
use App\Models\Pesanan;
use App\Models\PenjualanPengepul;
use App\Models\Transaksi;
use App\Models\TopUp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeuanganController extends Controller
{
    public function index()
    {
        // ── Summary Cards ──
        $totalPendapatanPesanan = Pesanan::where('status', 'selesai')->sum('total_pendapatan');
        $totalPendapatanPengepul = PenjualanPengepul::where('status_pembayaran', 'lunas')->sum('total_harga');
        $totalPendapatan = $totalPendapatanPesanan + $totalPendapatanPengepul;

        $totalKomisiJA = Pesanan::where('status', 'selesai')->sum('komisi_pengangkut');

        $totalPenarikanMenunggu = Penarikan::where('status', 'menunggu')->sum('jumlah');
        $jumlahPenarikanMenunggu = Penarikan::where('status', 'menunggu')->count();

        $totalTopUpMenunggu = TopUp::where('status', 'menunggu')->sum('jumlah');
        $jumlahTopUpMenunggu = TopUp::where('status', 'menunggu')->count();

        $totalBagianPerusahaan = Pesanan::where('status', 'selesai')->sum('bagian_perusahaan');

        // ── Tabel Data ──
        $penarikan = Penarikan::with('pengguna', 'penyetuju')
            ->latest()
            ->get();

        $topUps = TopUp::with('pengguna', 'penyetuju')
            ->latest()
            ->get();

        $transaksi = Transaksi::with('pengguna')
            ->latest()
            ->get();

        // Users list untuk koreksi saldo
        $users = User::whereIn('role', ['pengguna', 'juru_angkut'])
            ->orderBy('name')
            ->get();

        return view('admin.keuangan.index', compact(
            'totalPendapatan',
            'totalKomisiJA',
            'totalPenarikanMenunggu',
            'jumlahPenarikanMenunggu',
            'totalTopUpMenunggu',
            'jumlahTopUpMenunggu',
            'totalBagianPerusahaan',
            'penarikan',
            'topUps',
            'transaksi',
            'users',
        ));
    }

    /**
     * Approve penarikan saldo
     */
    public function approve(Request $request, Penarikan $penarikan)
    {
        if ($penarikan->status !== 'menunggu') {
            return redirect()->route('admin.keuangan')
                ->with('error', 'Penarikan ini sudah diproses sebelumnya.');
        }

        $user = $penarikan->pengguna;

        // Validasi kecukupan saldo (Double-Spend Protection)
        if ($user->saldo < $penarikan->jumlah) {
            return redirect()->route('admin.keuangan')
                ->with('error', 'Persetujuan gagal! Saldo ' . $user->name . ' saat ini tidak mencukupi (Saldo: Rp ' . number_format($user->saldo, 0, ',', '.') . ').');
        }

        DB::transaction(function () use ($penarikan, $request, $user) {
            $saldoSebelum = $user->saldo;

            $user->saldo -= $penarikan->jumlah;
            $user->save();

            $penarikan->status = 'disetujui';
            $penarikan->disetujui_oleh = $request->user()->id;
            $penarikan->disetujui_pada = now();
            $penarikan->save();

            Transaksi::create([
                'nomor_transaksi' => 'TRX-' . now()->format('Ymd') . '-' . str_pad((string) (Transaksi::count() + 1), 4, '0', STR_PAD_LEFT),
                'user_id' => $penarikan->user_id,
                'tipe' => 'keluar',
                'jumlah' => $penarikan->jumlah,
                'saldo_sebelum' => $saldoSebelum,
                'saldo_sesudah' => $user->saldo,
                'status' => 'selesai',
                'referensi_type' => Penarikan::class,
                'referensi_id' => $penarikan->id,
                'deskripsi' => 'Penarikan saldo via ' . $penarikan->metode . ' ke ' . $penarikan->nama_bank . ' ' . $penarikan->nomor_rekening,
            ]);
        });

        return redirect()->route('admin.keuangan')
            ->with('success', 'Penarikan berhasil disetujui dan saldo telah dikurangi.');
    }

    /**
     * Reject penarikan saldo
     */
    public function reject(Request $request, Penarikan $penarikan)
    {
        if ($penarikan->status !== 'menunggu') {
            return redirect()->route('admin.keuangan')
                ->with('error', 'Penarikan ini sudah diproses sebelumnya.');
        }

        $request->validate([
            'alasan_penolakan' => 'required|string|max:1000',
        ]);

        $penarikan->status = 'ditolak';
        $penarikan->alasan_penolakan = $request->alasan_penolakan;
        $penarikan->disetujui_oleh = $request->user()->id;
        $penarikan->disetujui_pada = now();
        $penarikan->save();

        return redirect()->route('admin.keuangan')
            ->with('success', 'Penarikan telah ditolak.');
    }

    /**
     * Approve top up — saldo user bertambah
     */
    public function approveTopUp(Request $request, TopUp $topUp)
    {
        if ($topUp->status !== 'menunggu') {
            return redirect()->route('admin.keuangan')
                ->with('error', 'Top Up ini sudah diproses sebelumnya.');
        }

        DB::transaction(function () use ($topUp, $request) {
            $user = $topUp->pengguna;
            $saldoSebelum = $user->saldo;

            // Tambah saldo user
            $user->saldo += $topUp->jumlah;
            $user->save();

            // Update status
            $topUp->status = 'disetujui';
            $topUp->disetujui_oleh = $request->user()->id;
            $topUp->disetujui_pada = now();
            $topUp->save();

            // Buat record transaksi
            Transaksi::create([
                'nomor_transaksi' => 'TRX-' . now()->format('Ymd') . '-' . str_pad((string) (Transaksi::count() + 1), 4, '0', STR_PAD_LEFT),
                'user_id' => $topUp->user_id,
                'tipe' => 'topup',
                'jumlah' => $topUp->jumlah,
                'saldo_sebelum' => $saldoSebelum,
                'saldo_sesudah' => $user->saldo,
                'status' => 'selesai',
                'referensi_type' => TopUp::class,
                'referensi_id' => $topUp->id,
                'deskripsi' => 'Top up saldo via ' . $topUp->metode_pembayaran,
            ]);
        });

        return redirect()->route('admin.keuangan')
            ->with('success', 'Top Up berhasil disetujui. Saldo user telah ditambahkan.');
    }

    /**
     * Reject top up
     */
    public function rejectTopUp(Request $request, TopUp $topUp)
    {
        if ($topUp->status !== 'menunggu') {
            return redirect()->route('admin.keuangan')
                ->with('error', 'Top Up ini sudah diproses sebelumnya.');
        }

        $request->validate([
            'alasan_penolakan' => 'required|string|max:1000',
        ]);

        $topUp->status = 'ditolak';
        $topUp->alasan_penolakan = $request->alasan_penolakan;
        $topUp->disetujui_oleh = $request->user()->id;
        $topUp->disetujui_pada = now();
        $topUp->save();

        return redirect()->route('admin.keuangan')
            ->with('success', 'Top Up telah ditolak.');
    }

    /**
     * Koreksi saldo user secara manual oleh admin
     */
    public function koreksiSaldo(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tipe_koreksi' => 'required|in:tambah,kurang',
            'jumlah' => 'required|numeric|min:1',
            'catatan' => 'required|string|max:1000',
        ]);

        $user = User::findOrFail($request->user_id);

        DB::transaction(function () use ($user, $request) {
            $saldoSebelum = $user->saldo;

            if ($request->tipe_koreksi === 'tambah') {
                $user->saldo += $request->jumlah;
            } else {
                $user->saldo -= $request->jumlah;
                if ($user->saldo < 0) $user->saldo = 0;
            }
            $user->save();

            Transaksi::create([
                'nomor_transaksi' => 'KOR-' . now()->format('Ymd') . '-' . str_pad((string) (Transaksi::count() + 1), 4, '0', STR_PAD_LEFT),
                'user_id' => $user->id,
                'tipe' => 'koreksi',
                'jumlah' => $request->jumlah,
                'saldo_sebelum' => $saldoSebelum,
                'saldo_sesudah' => $user->saldo,
                'status' => 'selesai',
                'deskripsi' => 'Koreksi saldo (' . $request->tipe_koreksi . '): ' . $request->catatan,
            ]);
        });

        return redirect()->route('admin.keuangan')
            ->with('success', 'Koreksi saldo berhasil. Saldo ' . $user->name . ' telah diperbarui.');
    }
}

<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::with(['pengangkut', 'detailPesanan.kategoriSampah'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $riwayat_data = [];
        foreach($pesanans as $p) {
            $jenis_sampah_arr = [];
            foreach($p->detailPesanan as $d) {
                $jenis_sampah_arr[] = $d->kategoriSampah ? $d->kategoriSampah->nama : 'Lainnya';
            }
            // filter unique
            $jenis_sampah_arr = array_unique($jenis_sampah_arr);
            $jenis_sampah_str = count($jenis_sampah_arr) > 0 ? implode(', ', $jenis_sampah_arr) : 'Campuran';
            
            $filter = $p->tipe_pesanan == 'langganan' ? 'paket' : 'jemput';
            if($p->total_pendapatan > 0) {
                $filter = 'jual'; 
            }
            
            $nominal = $p->total_pendapatan > 0 ? '+Rp ' . number_format($p->total_pendapatan, 0, ',', '.') : 'Rp ' . number_format($p->biaya_jemput, 0, ',', '.');
            $nominalSign = $p->total_pendapatan > 0 ? 'plus' : 'neutral';
            
            $iconType = 'trash';
            $iconBg = '#dcfce7';
            $iconColor = '#16a34a';
            
            if($filter == 'jual') {
                $iconType = 'cart';
                $iconBg = '#ede9fe';
                $iconColor = '#7c3aed';
            } else if($filter == 'paket') {
                $iconType = 'box';
                $iconBg = '#ede9fe';
                $iconColor = '#7c3aed';
            }

            $detail = [
                'Nomor Pesanan' => $p->nomor_pesanan,
                'Jenis Sampah' => $jenis_sampah_str,
                'Alamat' => $p->alamat_jemput,
                'Tanggal' => date('d M Y', strtotime($p->tanggal_jemput)),
                'Waktu' => $p->jam_jemput ? date('H:i', strtotime($p->jam_jemput)) : '-',
                'Total Berat' => $p->total_berat . ' Kg',
                'Biaya Jemput' => 'Rp ' . number_format($p->biaya_jemput, 0, ',', '.'),
            ];
            
            if($p->total_pendapatan > 0) {
                $detail['Pendapatan'] = '+Rp ' . number_format($p->total_pendapatan, 0, ',', '.');
            }
            if($p->poin_didapat > 0) {
                $detail['Poin Didapat'] = '+ ' . $p->poin_didapat . ' Poin';
            }
            if($p->pengangkut) {
                $detail['Juru Angkut'] = $p->pengangkut->name;
                $telepon = $p->pengangkut->telepon ?? '-';
                if($telepon !== '-') {
                    $detail['No. Telp Juru Angkut'] = $telepon;
                }
            }
            $detail['Status'] = ucfirst($p->status);

            if($p->status === 'dibatalkan' && $p->alasan_pembatalan) {
                $detail['Alasan Pembatalan'] = $p->alasan_pembatalan;
            }
            if($p->metode_pembayaran_pelanggan) {
                $detail['Pembayaran ke Pelanggan'] = ucfirst($p->metode_pembayaran_pelanggan);
            }

            $riwayat_data[] = [
                'id' => $p->id,
                'filter' => $filter,
                'title' => ($filter == 'jual' ? 'Jual Sampah ' : 'Jemput Sampah ') . $jenis_sampah_str,
                'tanggal' => date('d M Y', strtotime($p->tanggal_jemput)),
                'waktu' => $p->jam_jemput ? date('H:i', strtotime($p->jam_jemput)) : '',
                'nominal' => $nominal,
                'nominalSign' => $nominalSign,
                'status' => $p->status == 'dibatalkan' ? 'batal' : ($p->status == 'selesai' ? 'selesai' : 'proses'),
                'status_asli' => $p->status,
                'iconBg' => $iconBg,
                'iconColor' => $iconColor,
                'iconType' => $iconType,
                'detail' => $detail,
                'telepon_juru_angkut' => $p->pengangkut ? ($p->pengangkut->telepon ?? '') : '',
                'alasan_pembatalan' => $p->alasan_pembatalan,
            ];
        }

        return view('pelanggan.riwayat.index', compact('riwayat_data'));
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Paket;

class PaketDanLanggananSeeder extends Seeder
{
    public function run(): void
    {
        $paketData = [
            [
                'nama'                  => 'Paket Hemat',
                'deskripsi'             => 'Cocok untuk rumah tangga kecil. Jemput sampah 2x seminggu.',
                'harga'                 => 49000,
                'durasi_hari'           => 30,
                'frekuensi_jemput'      => 2,
                'satuan_frekuensi'      => 'minggu',
                'info_tong'             => 'Tong 40L (1 buah)',
                'biaya_jemput'          => 0,
                'persentase_bagi_hasil' => 100,
                'aktif'                 => true,
            ],
            [
                'nama'                  => 'Paket Reguler',
                'deskripsi'             => 'Ideal untuk keluarga. Jemput sampah 3x seminggu dengan tong lebih besar.',
                'harga'                 => 79000,
                'durasi_hari'           => 30,
                'frekuensi_jemput'      => 3,
                'satuan_frekuensi'      => 'minggu',
                'info_tong'             => 'Tong 60L (1 buah)',
                'biaya_jemput'          => 0,
                'persentase_bagi_hasil' => 100,
                'aktif'                 => true,
            ],
            [
                'nama'                  => 'Paket Premium',
                'deskripsi'             => 'Untuk keluarga besar atau usaha kecil. Jemput setiap hari!',
                'harga'                 => 149000,
                'durasi_hari'           => 30,
                'frekuensi_jemput'      => 7,
                'satuan_frekuensi'      => 'minggu',
                'info_tong'             => 'Tong 120L (2 buah)',
                'biaya_jemput'          => 0,
                'persentase_bagi_hasil' => 100,
                'aktif'                 => true,
            ],
            [
                'nama'                  => 'Paket Tahunan',
                'deskripsi'             => 'Berlangganan setahun penuh dengan harga lebih hemat. Jemput 3x seminggu.',
                'harga'                 => 799000,
                'durasi_hari'           => 365,
                'frekuensi_jemput'      => 3,
                'satuan_frekuensi'      => 'minggu',
                'info_tong'             => 'Tong 60L (2 buah)',
                'biaya_jemput'          => 0,
                'persentase_bagi_hasil' => 100,
                'aktif'                 => true,
            ],
        ];

        foreach ($paketData as $item) {
            Paket::updateOrCreate(
                ['nama' => $item['nama']],
                $item
            );
        }
    }
}

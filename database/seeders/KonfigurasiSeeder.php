<?php

namespace Database\Seeders;

use App\Models\Konfigurasi;
use Illuminate\Database\Seeder;

class KonfigurasiSeeder extends Seeder
{
    public function run(): void
    {
        $configs = [
            [
                'kunci'     => 'poin_per_kg',
                'nilai'     => '10',
                'deskripsi' => 'Jumlah poin yang didapat pelanggan per 1 kg sampah.',
            ],
            [
                'kunci'     => 'poin_per_order',
                'nilai'     => '5',
                'deskripsi' => 'Bonus poin yang didapat pelanggan per 1 kali order.',
            ],
            [
                'kunci'     => 'lat_bank_sampah',
                'nilai'     => '-0.026330',
                'deskripsi' => 'Latitude lokasi Bank Sampah (titik awal perhitungan jarak).',
            ],
            [
                'kunci'     => 'lon_bank_sampah',
                'nilai'     => '109.342504',
                'deskripsi' => 'Longitude lokasi Bank Sampah (titik awal perhitungan jarak).',
            ],
            [
                'kunci'     => 'ongkir_base_fee',
                'nilai'     => '10000',
                'deskripsi' => 'Base ongkir juru angkut jika jarak ≤ 1 KM (Rp). Ini adalah tarif dasar ongkir.',
            ],
            [
                'kunci'     => 'ongkir_per_km',
                'nilai'     => '2500',
                'deskripsi' => 'Tarif tambahan ongkir per KM setelah 1 KM pertama (Rp).',
            ],
            [
                'kunci'     => 'biaya_admin_reguler',
                'nilai'     => '2000',
                'deskripsi' => 'Biaya admin/platform fee untuk pelanggan reguler (Rp). Gratis untuk pelanggan berlangganan.',
            ],
        ];

        foreach ($configs as $config) {
            Konfigurasi::updateOrCreate(
                ['kunci' => $config['kunci']],
                $config
            );
        }

        // Hapus konfigurasi lama yang tidak dipakai lagi
        Konfigurasi::where('kunci', 'biaya_jemput')->delete();
        Konfigurasi::where('kunci', 'komisi_pengangkut_persen')->delete();
    }
}

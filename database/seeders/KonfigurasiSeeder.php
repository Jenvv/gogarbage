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
                'kunci'     => 'biaya_jemput',
                'nilai'     => '5000',
                'deskripsi' => 'Biaya jemput sampah reguler (Rp). Gratis jika pelanggan berlangganan.',
            ],
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
                'kunci'     => 'komisi_pengangkut_persen',
                'nilai'     => '70',
                'deskripsi' => 'Persentase komisi juru angkut dari biaya jemput (%).',
            ],
        ];

        foreach ($configs as $config) {
            Konfigurasi::updateOrCreate(
                ['kunci' => $config['kunci']],
                $config
            );
        }
    }
}

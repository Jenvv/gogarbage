<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriSampah;

class KategoriSampahSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama'         => 'Plastik',
                'slug'         => 'plastik',
                'deskripsi'    => 'Botol plastik, kantong kresek, kemasan plastik, dll.',
                'harga_per_kg' => 2500,
                'satuan'       => 'kg',
                'ikon'         => '♻️',
                'aktif'        => true,
            ],
            [
                'nama'         => 'Kertas',
                'slug'         => 'kertas',
                'deskripsi'    => 'Koran, majalah, kardus, kertas HVS, dll.',
                'harga_per_kg' => 1500,
                'satuan'       => 'kg',
                'ikon'         => '📄',
                'aktif'        => true,
            ],
            [
                'nama'         => 'Logam',
                'slug'         => 'logam',
                'deskripsi'    => 'Kaleng aluminium, besi tua, tembaga, dll.',
                'harga_per_kg' => 5000,
                'satuan'       => 'kg',
                'ikon'         => '🔩',
                'aktif'        => true,
            ],
            [
                'nama'         => 'Kaca',
                'slug'         => 'kaca',
                'deskripsi'    => 'Botol kaca, pecahan kaca, gelas kaca, dll.',
                'harga_per_kg' => 1000,
                'satuan'       => 'kg',
                'ikon'         => '🪟',
                'aktif'        => true,
            ],
            [
                'nama'         => 'Organik',
                'slug'         => 'organik',
                'deskripsi'    => 'Sisa makanan, daun kering, sayuran busuk, dll.',
                'harga_per_kg' => 500,
                'satuan'       => 'kg',
                'ikon'         => '🍂',
                'aktif'        => true,
            ],
            [
                'nama'         => 'Elektronik',
                'slug'         => 'elektronik',
                'deskripsi'    => 'HP rusak, charger, kabel, komponen elektronik, dll.',
                'harga_per_kg' => 8000,
                'satuan'       => 'kg',
                'ikon'         => '📱',
                'aktif'        => true,
            ],
            [
                'nama'         => 'Tekstil',
                'slug'         => 'tekstil',
                'deskripsi'    => 'Pakaian bekas, kain perca, sepatu, dll.',
                'harga_per_kg' => 1200,
                'satuan'       => 'kg',
                'ikon'         => '👕',
                'aktif'        => true,
            ],
        ];

        foreach ($data as $item) {
            KategoriSampah::updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }
    }
}

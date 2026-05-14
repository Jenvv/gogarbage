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
                'nama'         => 'Organik',
                'slug'         => 'organik',
                'deskripsi'    => 'Sisa makanan, daun kering, sayuran busuk, dll.',
                'harga_per_kg' => 0,
                'satuan'       => 'kg',
                'ikon'         => '🌿',
                'aktif'        => true,
            ],
            [
                'nama'         => 'Anorganik',
                'slug'         => 'anorganik',
                'deskripsi'    => 'Plastik, kertas, botol kaca, logam, dll yang dapat dijual kembali.',
                'harga_per_kg' => 2000,
                'satuan'       => 'kg',
                'ikon'         => '♻️',
                'aktif'        => true,
            ],
            [
                'nama'         => 'Campuran',
                'slug'         => 'campuran',
                'deskripsi'    => 'Sampah campuran yang tidak dipilah.',
                'harga_per_kg' => 0,
                'satuan'       => 'kg',
                'ikon'         => '🗑️',
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

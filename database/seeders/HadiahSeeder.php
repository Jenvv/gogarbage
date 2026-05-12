<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HadiahSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama'        => 'Voucher Grab Rp 10.000',
                'deskripsi'   => 'Voucher Grab senilai Rp 10.000 untuk transportasi atau makanan.',
                'biaya_poin'  => 100,
                'stok'        => 50,
                'gambar'      => null,
                'tipe'        => 'voucher',
                'aktif'       => true,
            ],
            [
                'nama'        => 'Voucher Shopee Rp 15.000',
                'deskripsi'   => 'Voucher belanja Shopee senilai Rp 15.000.',
                'biaya_poin'  => 150,
                'stok'        => 30,
                'gambar'      => null,
                'tipe'        => 'voucher',
                'aktif'       => true,
            ],
            [
                'nama'        => 'Voucher GoFood Rp 20.000',
                'deskripsi'   => 'Voucher GoFood senilai Rp 20.000 untuk pesan makanan.',
                'biaya_poin'  => 200,
                'stok'        => 25,
                'gambar'      => null,
                'tipe'        => 'voucher',
                'aktif'       => true,
            ],
            [
                'nama'        => 'Tumbler Ramah Lingkungan',
                'deskripsi'   => 'Tumbler stainless steel 500ml dengan logo GoGarbage.',
                'biaya_poin'  => 500,
                'stok'        => 15,
                'gambar'      => null,
                'tipe'        => 'fisik',
                'aktif'       => true,
            ],
            [
                'nama'        => 'Tas Belanja Eco-Friendly',
                'deskripsi'   => 'Tas belanja lipat berbahan kanvas, bisa dicuci ulang.',
                'biaya_poin'  => 300,
                'stok'        => 40,
                'gambar'      => null,
                'tipe'        => 'fisik',
                'aktif'       => true,
            ],
            [
                'nama'        => 'Bibit Tanaman',
                'deskripsi'   => 'Paket bibit tanaman hias untuk mempercantik rumahmu.',
                'biaya_poin'  => 250,
                'stok'        => 20,
                'gambar'      => null,
                'tipe'        => 'fisik',
                'aktif'       => true,
            ],
            [
                'nama'        => 'Pulsa Rp 25.000',
                'deskripsi'   => 'Pulsa All Operator senilai Rp 25.000.',
                'biaya_poin'  => 250,
                'stok'        => 100,
                'gambar'      => null,
                'tipe'        => 'lainnya',
                'aktif'       => true,
            ],
            [
                'nama'        => 'Donasi ke Yayasan Lingkungan',
                'deskripsi'   => 'Poinmu akan dikonversi menjadi donasi untuk pelestarian lingkungan.',
                'biaya_poin'  => 50,
                'stok'        => 9999,
                'gambar'      => null,
                'tipe'        => 'lainnya',
                'aktif'       => true,
            ],
        ];

        foreach ($data as $item) {
            DB::table('hadiah')->updateOrInsert(
                ['nama' => $item['nama']],
                array_merge($item, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}

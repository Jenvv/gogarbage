<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'     => 'Pengguna',
                'email'    => 'pengguna@gmail.com',
                'password' => '123123123',
                'role'     => 'pengguna',
                'telepon'  => '081200000001',
                'alamat'   => 'Jl. Contoh No. 1',
                'saldo'    => 0,
                'poin'     => 0,
            ],
            [
                'name'     => 'Juru Angkut',
                'email'    => 'angkut@gmail.com',
                'password' => '123123123',
                'role'     => 'juru_angkut',
                'telepon'  => '081200000002',
                'alamat'   => 'Jl. Contoh No. 2',
                'saldo'    => 0,
                'poin'     => 0,
            ],
            [
                'name'     => 'Pengepul',
                'email'    => 'ngepul@gmail.com',
                'password' => '123123123',
                'role'     => 'pengepul',
                'telepon'  => '081200000003',
                'alamat'   => 'Jl. Contoh No. 3',
                'saldo'    => 0,
                'poin'     => 0,
            ],
            [
                'name'     => 'Admin Gudang',
                'email'    => 'admin@admin.com',
                'password' => '123123123',
                'role'     => 'admin_gudang',
                'telepon'  => '081200000004',
                'alamat'   => 'Gudang Utama',
                'saldo'    => 0,
                'poin'     => 0,
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}

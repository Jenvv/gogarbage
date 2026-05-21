<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tambahkan 'topup' dan 'koreksi' ke enum tipe di tabel transaksi
        DB::statement("ALTER TABLE transaksi MODIFY COLUMN tipe ENUM('masuk','keluar','komisi','topup','koreksi') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE transaksi MODIFY COLUMN tipe ENUM('masuk','keluar','komisi') NOT NULL");
    }
};

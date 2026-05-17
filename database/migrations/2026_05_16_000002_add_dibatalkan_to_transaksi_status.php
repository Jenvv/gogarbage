<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE transaksi MODIFY status ENUM('menunggu', 'disetujui', 'ditolak', 'selesai', 'dibatalkan') DEFAULT 'menunggu'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE transaksi MODIFY status ENUM('menunggu', 'disetujui', 'ditolak', 'selesai') DEFAULT 'menunggu'");
    }
};

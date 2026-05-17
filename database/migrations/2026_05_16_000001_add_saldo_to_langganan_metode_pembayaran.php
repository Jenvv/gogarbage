<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE langganan MODIFY metode_pembayaran ENUM('transfer', 'payment_gateway', 'tunai', 'saldo') DEFAULT 'transfer'");
        DB::statement("ALTER TABLE langganan MODIFY status ENUM('menunggu', 'menunggu_tunai', 'aktif', 'kadaluarsa', 'dibatalkan') DEFAULT 'menunggu'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE langganan MODIFY metode_pembayaran ENUM('transfer', 'payment_gateway', 'tunai') DEFAULT 'transfer'");
        DB::statement("ALTER TABLE langganan MODIFY status ENUM('menunggu', 'aktif', 'kadaluarsa', 'dibatalkan') DEFAULT 'menunggu'");
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->decimal('jarak_km', 8, 2)->nullable()->after('longitude');
            $table->decimal('ongkir_juru_angkut', 15, 2)->default(0)->after('biaya_jemput');
            $table->decimal('biaya_admin', 15, 2)->default(0)->after('ongkir_juru_angkut');
        });
    }

    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn(['jarak_km', 'ongkir_juru_angkut', 'biaya_admin']);
        });
    }
};

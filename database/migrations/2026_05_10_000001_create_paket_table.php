<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paket', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 15, 2);
            $table->unsignedInteger('durasi_hari');
            $table->unsignedSmallInteger('frekuensi_jemput');
            $table->enum('satuan_frekuensi', ['minggu', 'bulan']);
            $table->string('info_tong')->nullable();
            $table->decimal('biaya_jemput', 15, 2)->default(0);
            $table->decimal('persentase_bagi_hasil', 5, 2)->default(100);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket');
    }
};

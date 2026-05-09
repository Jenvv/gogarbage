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
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade');
            $table->foreignId('kategori_sampah_id')->constrained('kategori_sampah')->onDelete('restrict');
            $table->decimal('berat', 10, 2);
            $table->decimal('harga_per_kg', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();

            $table->index('pesanan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanan');
    }
};

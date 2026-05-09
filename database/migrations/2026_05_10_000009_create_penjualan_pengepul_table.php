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
        Schema::create('penjualan_pengepul', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_invoice')->unique();
            $table->foreignId('pembeli_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('admin_id')->constrained('users')->onDelete('restrict');
            $table->decimal('total_berat', 15, 2)->default(0);
            $table->decimal('total_harga', 15, 2)->default(0);
            $table->enum('status_pembayaran', ['belum_bayar', 'lunas'])->default('belum_bayar');
            $table->enum('metode_pembayaran', ['tunai', 'transfer'])->default('tunai');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index('pembeli_id');
        });

        Schema::create('detail_penjualan_pengepul', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penjualan_pengepul_id')->constrained('penjualan_pengepul')->onDelete('cascade');
            $table->foreignId('kategori_sampah_id')->constrained('kategori_sampah')->onDelete('restrict');
            $table->decimal('berat', 15, 2);
            $table->decimal('harga_per_kg', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();

            $table->index('penjualan_pengepul_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penjualan_pengepul');
        Schema::dropIfExists('penjualan_pengepul');
    }
};

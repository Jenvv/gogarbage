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
        Schema::create('stok_gudang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_sampah_id')->unique()->constrained('kategori_sampah')->onDelete('restrict');
            $table->decimal('stok_kg', 15, 2)->default(0);
            $table->decimal('total_masuk', 15, 2)->default(0);
            $table->decimal('total_keluar', 15, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('log_stok_gudang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stok_gudang_id')->constrained('stok_gudang')->onDelete('cascade');
            $table->foreignId('kategori_sampah_id')->constrained('kategori_sampah')->onDelete('restrict');
            $table->enum('tipe', ['masuk', 'keluar']);
            $table->decimal('jumlah_kg', 15, 2);
            $table->decimal('stok_sebelum', 15, 2)->default(0);
            $table->decimal('stok_sesudah', 15, 2)->default(0);

            // Polymorphic reference ke sumber (Pesanan atau Penjualan Pengepul)
            $table->nullableMorphs('sumber');

            $table->text('deskripsi')->nullable();
            $table->foreignId('dibuat_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index(['stok_gudang_id', 'tipe']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_stok_gudang');
        Schema::dropIfExists('stok_gudang');
    }
};

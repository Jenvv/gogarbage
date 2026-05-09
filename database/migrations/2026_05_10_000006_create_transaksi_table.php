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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_transaksi')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->enum('tipe', [
                'masuk',          // Saldo masuk (dari pesanan selesai)
                'keluar',         // Saldo keluar (penarikan)
                'komisi',         // Komisi juru angkut
            ]);

            $table->decimal('jumlah', 15, 2);
            $table->decimal('saldo_sebelum', 15, 2)->default(0);
            $table->decimal('saldo_sesudah', 15, 2)->default(0);

            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'selesai'])->default('menunggu');

            // Polymorphic reference ke sumber transaksi
            $table->nullableMorphs('referensi');

            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'tipe']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};

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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pesanan')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pengangkut_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('langganan_id')->nullable()->constrained('langganan')->onDelete('set null');

            // Lokasi & Jadwal
            $table->text('alamat_jemput');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->date('tanggal_jemput');
            $table->time('jam_jemput')->nullable();

            // Status & Tracking
            $table->enum('status', [
                'menunggu',       // Menunggu diklaim juru angkut
                'diklaim',        // Sudah diklaim, belum berangkat
                'dalam_perjalanan', // Di jalan
                'tiba',           // Sudah sampai lokasi
                'penimbangan',    // Sedang timbang
                'selesai',        // Selesai
                'dibatalkan',     // Dibatalkan
            ])->default('menunggu');
            $table->enum('tipe_pesanan', ['reguler', 'langganan'])->default('reguler');

            // Keuangan
            $table->decimal('biaya_jemput', 15, 2)->default(0);
            $table->decimal('total_berat', 10, 2)->default(0);
            $table->decimal('total_pendapatan', 15, 2)->default(0);
            $table->unsignedInteger('poin_didapat')->default(0);

            // Bagi hasil juru angkut
            $table->decimal('komisi_pengangkut', 15, 2)->default(0);
            $table->decimal('bagian_perusahaan', 15, 2)->default(0);

            $table->text('catatan')->nullable();
            $table->timestamp('diklaim_pada')->nullable();
            $table->timestamp('diselesaikan_pada')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['pengangkut_id', 'status']);
            $table->index('tanggal_jemput');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};

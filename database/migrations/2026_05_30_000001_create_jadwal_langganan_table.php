<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_langganan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('langganan_id')->constrained('langganan')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');           // pelanggan
            $table->foreignId('pengangkut_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('pesanan_id')->nullable()->constrained('pesanan')->onDelete('set null');
            $table->date('tanggal_jemput');
            $table->time('jam_jemput')->default('08:00');
            $table->enum('status', ['terjadwal', 'selesai', 'dilewati'])->default('terjadwal');
            $table->text('catatan_skip')->nullable();
            $table->timestamp('dilewati_pada')->nullable();
            $table->timestamp('diselesaikan_pada')->nullable();
            $table->timestamps();

            $table->index(['tanggal_jemput', 'status']);
            $table->index(['pengangkut_id', 'tanggal_jemput']);
            $table->index(['user_id', 'tanggal_jemput']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_langganan');
    }
};

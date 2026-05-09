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
        Schema::create('hadiah', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->unsignedInteger('biaya_poin');
            $table->unsignedInteger('stok')->default(0);
            $table->string('gambar')->nullable();
            $table->enum('tipe', ['voucher', 'fisik', 'lainnya'])->default('voucher');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('klaim_hadiah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('hadiah_id')->constrained('hadiah')->onDelete('restrict');
            $table->unsignedInteger('poin_digunakan');
            $table->enum('status', ['menunggu', 'disetujui', 'dikirim', 'ditolak'])->default('menunggu');
            $table->foreignId('diproses_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('diproses_pada')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klaim_hadiah');
        Schema::dropIfExists('hadiah');
    }
};

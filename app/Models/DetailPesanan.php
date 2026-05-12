<?php

namespace App\Models;

use App\Models\KategoriSampah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPesanan extends Model
{
    protected $table = 'detail_pesanan';

    protected $fillable = [
        'pesanan_id',
        'kategori_sampah_id',
        'berat',
        'harga_per_kg',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'berat'       => 'decimal:2',
            'harga_per_kg' => 'decimal:2',
            'subtotal'    => 'decimal:2',
        ];
    }

    // ── Relationships ──

    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }

    public function kategoriSampah(): BelongsTo
    {
        return $this->belongsTo(KategoriSampah::class, 'kategori_sampah_id');
    }
}

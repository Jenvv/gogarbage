<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPenjualanPengepul extends Model
{
    protected $table = 'detail_penjualan_pengepul';

    protected $fillable = [
        'penjualan_pengepul_id',
        'kategori_sampah_id',
        'berat',
        'harga_per_kg',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'berat' => 'decimal:2',
            'harga_per_kg' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    public function penjualan(): BelongsTo
    {
        return $this->belongsTo(PenjualanPengepul::class, 'penjualan_pengepul_id');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriSampah::class, 'kategori_sampah_id');
    }
}

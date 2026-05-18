<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StokGudang extends Model
{
    protected $table = 'stok_gudang';

    protected $fillable = [
        'kategori_sampah_id',
        'stok_kg',
        'total_masuk',
        'total_keluar',
    ];

    protected function casts(): array
    {
        return [
            'stok_kg' => 'decimal:2',
            'total_masuk' => 'decimal:2',
            'total_keluar' => 'decimal:2',
        ];
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriSampah::class, 'kategori_sampah_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(LogStokGudang::class, 'stok_gudang_id');
    }
}

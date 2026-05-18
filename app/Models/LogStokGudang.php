<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogStokGudang extends Model
{
    protected $table = 'log_stok_gudang';

    protected $fillable = [
        'stok_gudang_id',
        'kategori_sampah_id',
        'tipe',
        'jumlah_kg',
        'stok_sebelum',
        'stok_sesudah',
        'sumber_type',
        'sumber_id',
        'deskripsi',
        'dibuat_oleh',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_kg' => 'decimal:2',
            'stok_sebelum' => 'decimal:2',
            'stok_sesudah' => 'decimal:2',
        ];
    }

    public function stokGudang(): BelongsTo
    {
        return $this->belongsTo(StokGudang::class, 'stok_gudang_id');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriSampah::class, 'kategori_sampah_id');
    }

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}

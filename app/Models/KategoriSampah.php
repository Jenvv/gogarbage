<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriSampah extends Model
{
    protected $table = 'kategori_sampah';

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
        'harga_per_kg',
        'satuan',
        'ikon',
        'aktif',
    ];

    protected function casts(): array
    {
        return [
            'harga_per_kg' => 'decimal:2',
            'aktif'        => 'boolean',
        ];
    }

    /**
     * Scope: hanya kategori yang aktif.
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    // ── Relationships ──

    public function detailPesanan(): HasMany
    {
        return $this->hasMany(DetailPesanan::class, 'kategori_sampah_id');
    }
}

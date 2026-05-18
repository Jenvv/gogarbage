<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hadiah extends Model
{
    protected $table = 'hadiah';

    protected $fillable = [
        'nama',
        'deskripsi',
        'biaya_poin',
        'stok',
        'gambar',
        'tipe',
        'aktif',
    ];

    protected function casts(): array
    {
        return [
            'biaya_poin' => 'integer',
            'stok' => 'integer',
            'aktif' => 'boolean',
        ];
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    public function klaim(): HasMany
    {
        return $this->hasMany(KlaimHadiah::class, 'hadiah_id');
    }
}

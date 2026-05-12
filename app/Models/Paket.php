<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paket extends Model
{
    protected $table = 'paket';

    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'durasi_hari',
        'frekuensi_jemput',
        'satuan_frekuensi',
        'info_tong',
        'biaya_jemput',
        'persentase_bagi_hasil',
        'aktif',
    ];

    protected function casts(): array
    {
        return [
            'harga'                 => 'decimal:2',
            'durasi_hari'           => 'integer',
            'frekuensi_jemput'      => 'integer',
            'biaya_jemput'          => 'decimal:2',
            'persentase_bagi_hasil' => 'decimal:2',
            'aktif'                 => 'boolean',
        ];
    }

    // ── Relationships ──

    public function langganan(): HasMany
    {
        return $this->hasMany(Langganan::class, 'paket_id');
    }
}

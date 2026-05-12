<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'nomor_transaksi',
        'user_id',
        'tipe',
        'jumlah',
        'saldo_sebelum',
        'saldo_sesudah',
        'status',
        'referensi_type',
        'referensi_id',
        'deskripsi',
    ];

    protected function casts(): array
    {
        return [
            'jumlah'        => 'decimal:2',
            'saldo_sebelum' => 'decimal:2',
            'saldo_sesudah' => 'decimal:2',
        ];
    }

    // ── Relationships ──

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function referensi(): MorphTo
    {
        return $this->morphTo('referensi');
    }
}

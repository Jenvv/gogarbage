<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalLangganan extends Model
{
    protected $table = 'jadwal_langganan';

    protected $fillable = [
        'langganan_id',
        'user_id',
        'pengangkut_id',
        'pesanan_id',
        'tanggal_jemput',
        'jam_jemput',
        'status',
        'catatan_skip',
        'dilewati_pada',
        'diselesaikan_pada',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_jemput'    => 'date',
            'dilewati_pada'     => 'datetime',
            'diselesaikan_pada' => 'datetime',
        ];
    }

    // ── Scopes ──

    public function scopeHariIni($query)
    {
        return $query->whereDate('tanggal_jemput', today());
    }

    public function scopeMendatang($query)
    {
        return $query->whereDate('tanggal_jemput', '>=', today());
    }

    public function scopeTerjadwal($query)
    {
        return $query->where('status', 'terjadwal');
    }

    // ── Relationships ──

    public function langganan(): BelongsTo
    {
        return $this->belongsTo(Langganan::class, 'langganan_id');
    }

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pengangkut(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengangkut_id');
    }

    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }
}

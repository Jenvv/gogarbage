<?php

namespace App\Models;

use App\Models\Paket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Langganan extends Model
{
    protected $table = 'langganan';

    protected $fillable = [
        'user_id',
        'paket_id',
        'status',
        'metode_pembayaran',
        'bukti_pembayaran',
        'jumlah_bayar',
        'tanggal_mulai',
        'tanggal_selesai',
        'disetujui_pada',
        'disetujui_oleh',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_bayar'   => 'decimal:2',
            'tanggal_mulai'  => 'date',
            'tanggal_selesai' => 'date',
            'disetujui_pada' => 'datetime',
        ];
    }

    /**
     * Scope: langganan yang sedang aktif.
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif')
            ->where('tanggal_selesai', '>=', now()->toDateString());
    }

    // ── Relationships ──

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function paket(): BelongsTo
    {
        return $this->belongsTo(Paket::class, 'paket_id');
    }
}

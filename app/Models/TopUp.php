<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class TopUp extends Model
{
    protected $table = 'top_up';

    protected $fillable = [
        'user_id',
        'jumlah',
        'metode_pembayaran',
        'bukti_pembayaran',
        'status',
        'disetujui_oleh',
        'disetujui_pada',
        'alasan_penolakan',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'jumlah' => 'decimal:2',
            'disetujui_pada' => 'datetime',
        ];
    }

    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function penyetuju(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }

    public function transaksi(): MorphMany
    {
        return $this->morphMany(Transaksi::class, 'referensi');
    }
}

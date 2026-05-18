<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KlaimHadiah extends Model
{
    protected $table = 'klaim_hadiah';

    protected $fillable = [
        'user_id',
        'hadiah_id',
        'poin_digunakan',
        'status',
        'diproses_oleh',
        'diproses_pada',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'poin_digunakan' => 'integer',
            'diproses_pada' => 'datetime',
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

    public function hadiah(): BelongsTo
    {
        return $this->belongsTo(Hadiah::class, 'hadiah_id');
    }

    public function pemroses(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }
}

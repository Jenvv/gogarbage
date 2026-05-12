<?php

namespace App\Models;

use App\Models\DetailPesanan;
use App\Models\Langganan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pesanan extends Model
{
    protected $table = 'pesanan';

    protected $fillable = [
        'nomor_pesanan',
        'user_id',
        'pengangkut_id',
        'langganan_id',
        'alamat_jemput',
        'latitude',
        'longitude',
        'tanggal_jemput',
        'jam_jemput',
        'status',
        'tipe_pesanan',
        'biaya_jemput',
        'total_berat',
        'total_pendapatan',
        'poin_didapat',
        'komisi_pengangkut',
        'bagian_perusahaan',
        'catatan',
        'diklaim_pada',
        'diselesaikan_pada',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_jemput'    => 'date',
            'jam_jemput'        => 'datetime',
            'biaya_jemput'      => 'decimal:2',
            'total_berat'       => 'decimal:2',
            'total_pendapatan'  => 'decimal:2',
            'komisi_pengangkut' => 'decimal:2',
            'bagian_perusahaan' => 'decimal:2',
            'poin_didapat'      => 'integer',
            'diklaim_pada'      => 'datetime',
            'diselesaikan_pada' => 'datetime',
        ];
    }

    /**
     * Generate nomor pesanan unik.
     */
    public static function generateNomor(): string
    {
        $tanggal = now()->format('Ymd');
        $terakhir = static::where('nomor_pesanan', 'like', "GG-{$tanggal}-%")
            ->orderByDesc('nomor_pesanan')
            ->first();

        if ($terakhir) {
            $urutan = (int) substr($terakhir->nomor_pesanan, -4) + 1;
        } else {
            $urutan = 1;
        }

        return "GG-{$tanggal}-" . str_pad($urutan, 4, '0', STR_PAD_LEFT);
    }

    // ── Relationships ──

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pengangkut(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengangkut_id');
    }

    public function langganan(): BelongsTo
    {
        return $this->belongsTo(Langganan::class, 'langganan_id');
    }

    public function detailPesanan(): HasMany
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PenjualanPengepul extends Model
{
    protected $table = 'penjualan_pengepul';

    protected $fillable = [
        'nomor_invoice',
        'pembeli_id',
        'admin_id',
        'total_berat',
        'total_harga',
        'status_pembayaran',
        'metode_pembayaran',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'total_berat' => 'decimal:2',
            'total_harga' => 'decimal:2',
        ];
    }

    public static function generateNomorInvoice(): string
    {
        $tanggal = now()->format('Ymd');
        $terakhir = static::where('nomor_invoice', 'like', "INV-{$tanggal}-%")
            ->orderByDesc('nomor_invoice')
            ->first();

        $urutan = $terakhir ? (int) substr($terakhir->nomor_invoice, -4) + 1 : 1;

        return 'INV-'.$tanggal.'-'.str_pad((string) $urutan, 4, '0', STR_PAD_LEFT);
    }

    public function pembeli(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pembeli_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function detail(): HasMany
    {
        return $this->hasMany(DetailPenjualanPengepul::class, 'penjualan_pengepul_id');
    }
}

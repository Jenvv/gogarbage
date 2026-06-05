<?php

namespace App\Models;

use App\Models\Paket;
use App\Models\JadwalLangganan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

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

    public function scopeMenungguVerifikasi($query)
    {
        return $query->whereIn('status', ['menunggu', 'menunggu_tunai']);
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

    public function disetujuiOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }

    public function jadwalLangganan(): HasMany
    {
        return $this->hasMany(JadwalLangganan::class, 'langganan_id');
    }

    /**
     * Generate jadwal penjemputan dengan Dynamic Spacing.
     * Dipanggil saat langganan disetujui admin.
     */
    public function generateJadwal(): void
    {
        app(\App\Actions\ReschedulePickupAction::class)->generateInitial($this);
    }

    /**
     * Reschedule jadwal setelah order manual mengonsumsi kuota.
     */
    public function rescheduleAfterManualOrder(\Carbon\CarbonImmutable $titikOrder): void
    {
        app(\App\Actions\ReschedulePickupAction::class)->rescheduleAfterManualOrder($this, $titikOrder);
    }

    /**
     * Cek sisa kuota penjemputan.
     */
    public function sisaKuota(): int
    {
        return app(\App\Actions\ReschedulePickupAction::class)->sisaKuota($this);
    }
}

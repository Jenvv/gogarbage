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
     * Generate jadwal penjemputan berdasarkan frekuensi paket.
     * Dipanggil saat langganan disetujui admin.
     */
    public function generateJadwal(): void
    {
        $paket = $this->paket;
        if (!$paket || !$this->tanggal_mulai || !$this->tanggal_selesai) {
            return;
        }

        $frekuensi = $paket->frekuensi_jemput;      // misal 2
        $satuan    = $paket->satuan_frekuensi;       // 'minggu' atau 'bulan'

        // Map frekuensi per minggu ke hari-hari (0=Minggu, 1=Senin, ..., 6=Sabtu)
        $hariJemput = $this->getHariJemput($frekuensi, $satuan);

        $mulai   = Carbon::parse($this->tanggal_mulai);
        $selesai = Carbon::parse($this->tanggal_selesai);

        $jadwalData = [];
        $current = $mulai->copy();

        while ($current->lte($selesai)) {
            if (in_array($current->dayOfWeek, $hariJemput)) {
                $jadwalData[] = [
                    'langganan_id'  => $this->id,
                    'user_id'       => $this->user_id,
                    'tanggal_jemput' => $current->toDateString(),
                    'jam_jemput'    => '08:00',
                    'status'        => 'terjadwal',
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
            }
            $current->addDay();
        }

        // Bulk insert
        if (!empty($jadwalData)) {
            // Hapus jadwal lama jika ada (re-generate)
            $this->jadwalLangganan()->delete();
            JadwalLangganan::insert($jadwalData);
        }
    }

    /**
     * Tentukan hari-hari jemput berdasarkan frekuensi per minggu.
     * Returns array of dayOfWeek (0=Minggu, 1=Senin, ..., 6=Sabtu)
     */
    private function getHariJemput(int $frekuensi, string $satuan): array
    {
        if ($satuan === 'bulan') {
            // Untuk bulanan, jemput tiap X kali per bulan → distribusikan merata
            // Simplified: 1x/bulan = tanggal 1 & 15 setiap bulan → pakai weekly mapping
            $frekuensi = max(1, intval($frekuensi / 4));
        }

        return match ($frekuensi) {
            1 => [1],                          // Senin
            2 => [1, 4],                       // Senin, Kamis
            3 => [1, 3, 5],                    // Senin, Rabu, Jumat
            4 => [1, 2, 4, 5],                 // Senin, Selasa, Kamis, Jumat
            5 => [1, 2, 3, 4, 5],              // Senin-Jumat
            6 => [1, 2, 3, 4, 5, 6],           // Senin-Sabtu
            default => [0, 1, 2, 3, 4, 5, 6],  // Setiap hari (7x)
        };
    }
}

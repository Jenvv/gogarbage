<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\JadwalLangganan;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'telepon',
        'alamat',
        'latitude',
        'longitude',
        'saldo',
        'poin',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'saldo' => 'decimal:2',
            'poin' => 'integer',
        ];
    }

    // ── Relationships ──

    public function pesanan(): HasMany
    {
        return $this->hasMany(Pesanan::class, 'user_id');
    }

    public function langganan(): HasMany
    {
        return $this->hasMany(Langganan::class, 'user_id');
    }

    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'user_id');
    }

    public function pesananSebagaiPengangkut(): HasMany
    {
        return $this->hasMany(Pesanan::class, 'pengangkut_id');
    }

    public function penjualanSebagaiPembeli(): HasMany
    {
        return $this->hasMany(PenjualanPengepul::class, 'pembeli_id');
    }

    public function penjualanSebagaiAdmin(): HasMany
    {
        return $this->hasMany(PenjualanPengepul::class, 'admin_id');
    }

    public function penarikan(): HasMany
    {
        return $this->hasMany(Penarikan::class, 'user_id');
    }

    public function klaimHadiah(): HasMany
    {
        return $this->hasMany(KlaimHadiah::class, 'user_id');
    }

    public function langgananDisetujui(): HasMany
    {
        return $this->hasMany(Langganan::class, 'disetujui_oleh');
    }

    public function jadwalLangganan(): HasMany
    {
        return $this->hasMany(JadwalLangganan::class, 'user_id');
    }

    public function jadwalSebagaiPengangkut(): HasMany
    {
        return $this->hasMany(JadwalLangganan::class, 'pengangkut_id');
    }

    /**
     * Cek apakah user punya langganan aktif.
     */
    public function langgananAktif(): ?Langganan
    {
        return $this->langganan()
            ->where('status', 'aktif')
            ->where('tanggal_selesai', '>=', now()->toDateString())
            ->first();
    }

    /**
     * Apakah user sedang berlangganan?
     */
    public function isBerlangganan(): bool
    {
        return $this->langgananAktif() !== null;
    }

    /**
     * Get the dashboard route name based on user's role.
     */
    public function getDashboardRoute(): string
    {
        switch ($this->role) {
            case 'pengguna':
                return 'pelanggan.index';
            case 'juru_angkut':
                return 'juru-angkut.index';
            case 'pengepul':
                return 'pengepul.index';
            case 'admin_gudang':
                return 'admin.dashboard';
            default:
                return 'login';
        }
    }
}

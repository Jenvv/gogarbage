<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konfigurasi extends Model
{
    protected $table = 'konfigurasi';

    protected $fillable = [
        'kunci',
        'nilai',
        'deskripsi',
    ];

    /**
     * Get configuration value by key, with optional default.
     */
    public static function getValue(string $kunci, mixed $default = null): mixed
    {
        $config = static::where('kunci', $kunci)->first();
        return $config ? $config->nilai : $default;
    }

    /**
     * Set configuration value by key.
     */
    public static function setValue(string $kunci, string $nilai): void
    {
        static::updateOrCreate(
            ['kunci' => $kunci],
            ['nilai' => $nilai]
        );
    }
}

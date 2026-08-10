<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenueSetting extends Model
{
    protected $fillable = [
        'nama_venue',
        'jenis_lapangan',
        'lokasi',
        'fasilitas',
        'link_maps',
        'foto',
    ];

    public static function singleton(): self
    {
        return static::query()->firstOrCreate([], []);
    }
}

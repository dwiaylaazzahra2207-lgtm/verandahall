<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gedung extends Model
{
    protected $fillable = [
        'nama',
        'kapasitas',
        'harga',
        'foto',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'kapasitas' => 'integer',
            'harga' => 'decimal:2',
        ];
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public static function statusLabel(string $status): string
    {
        return match ($status) {
            'pending' => 'Pending',
            'tersedia' => 'Tersedia',
            'habis' => 'Habis',
            default => ucfirst($status),
        };
    }
}

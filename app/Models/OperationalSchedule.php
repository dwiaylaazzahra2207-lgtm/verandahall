<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationalSchedule extends Model
{
    protected $fillable = [
        'hari',
        'jam_buka',
        'jam_tutup',
        'slot_menit',
    ];

    protected function casts(): array
    {
        return [
            'slot_menit' => 'integer',
        ];
    }

    public static function hariChoices(): array
    {
        return [
            'senin' => 'Senin',
            'selasa' => 'Selasa',
            'rabu' => 'Rabu',
            'kamis' => 'Kamis',
            'jumat' => 'Jumat',
            'sabtu' => 'Sabtu',
            'minggu' => 'Minggu',
        ];
    }
}

<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Booking extends Model
{
    public const STATUS_MENUNGGU = 'menunggu';

    public const STATUS_DISETUJUI = 'disetujui';

    public const STATUS_DITOLAK = 'ditolak';

    public const STATUS_SELESAI = 'selesai';

    public const STATUS_DIBATALKAN = 'dibatalkan';

    protected $fillable = [
        'user_id',
        'gedung_id',
        'tanggal_booking',
        'jam_mulai',
        'jam_selesai',
        'nama_acara',
        'jumlah_orang',
        'catatan',
        'status',
        'alasan_penolakan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_booking' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function gedung(): BelongsTo
    {
        return $this->belongsTo(Gedung::class);
    }

    public static function statusLabel(string $status): string
    {
        return match ($status) {
            self::STATUS_MENUNGGU => 'Menunggu',
            self::STATUS_DISETUJUI => 'Disetujui',
            self::STATUS_DITOLAK => 'Ditolak',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_DIBATALKAN => 'Dibatalkan',
            default => $status,
        };
    }

    /** Kategori tampilan kolom status di Riwayat pemesanan (mock UI). */
    public function riwayatKategori(): string
    {
        return match ($this->status) {
            self::STATUS_SELESAI => 'selesai',
            self::STATUS_DIBATALKAN, self::STATUS_DITOLAK => 'dibatalkan',
            default => 'pending',
        };
    }

    public function riwayatStatusLabel(): string
    {
        return match ($this->riwayatKategori()) {
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
            default => 'Pending',
        };
    }

    /**
     * Sudah ada booking lain yang disetujui untuk gedung & tanggal yang sama.
     */
    public function hasApprovedConflictExcludingSelf(): bool
    {
        $date = $this->tanggal_booking instanceof CarbonInterface
            ? $this->tanggal_booking->format('Y-m-d')
            : Carbon::parse($this->tanggal_booking)->format('Y-m-d');

        return static::query()
            ->where('gedung_id', $this->gedung_id)
            ->whereDate('tanggal_booking', $date)
            ->where('status', self::STATUS_DISETUJUI)
            ->whereKeyNot($this->getKey())
            ->exists();
    }
}

<?php

namespace App\Exports;

use App\Models\Booking;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanExport implements FromCollection, WithHeadings
{
    protected $bookings;

    public function __construct($bookings)
    {
        $this->bookings = $bookings;
    }

    public function collection()
    {
        return $this->bookings->map(function ($booking) {
            $harga = $booking->gedung?->harga ?? 0;

            if ($booking->jam_mulai && $booking->jam_selesai) {
                $mulai = Carbon::parse($booking->jam_mulai);
                $selesai = Carbon::parse($booking->jam_selesai);
                $durasi = max(1, $mulai->diffInHours($selesai));
                $harga = $harga * $durasi;
            }

            return [
                $booking->tanggal_booking,
                $booking->user?->name ?? '-',
                $booking->gedung?->nama ?? '-',
                $booking->jam_mulai ?? '-',
                $booking->jam_selesai ?? '-',
                $booking->status,
                $harga,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Pengguna',
            'Gedung',
            'Jam Mulai',
            'Jam Selesai',
            'Status',
            'Total Harga',
        ];
    }
}
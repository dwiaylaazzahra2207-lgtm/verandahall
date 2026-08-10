<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Gedung;
use App\Models\User;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        // Gedung tersedia untuk ditampilkan di landing page (maks 6)
        $gedungs = Gedung::query()
            ->where('status', 'tersedia')
            ->latest()
            ->limit(6)
            ->get();

        // Statistik real dari database
        $totalPengguna   = User::query()->where('role', 'user')->count();
        $totalGedung     = Gedung::query()->count();
        $totalBooking    = Booking::query()->where('status', Booking::STATUS_SELESAI)->count();

        // Booking aktif hari ini (disetujui) untuk hero visual
        $bookingHariIni = Booking::query()
            ->with('gedung')
            ->whereDate('tanggal_booking', today())
            ->whereIn('status', [Booking::STATUS_DISETUJUI, Booking::STATUS_MENUNGGU])
            ->latest()
            ->limit(3)
            ->get();

        return view('welcome', compact(
            'gedungs',
            'totalPengguna',
            'totalGedung',
            'totalBooking',
            'bookingHariIni'
        ));
    }
}

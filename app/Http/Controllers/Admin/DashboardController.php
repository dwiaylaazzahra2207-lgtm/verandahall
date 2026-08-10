<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Gedung;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalPengguna = User::query()->count();
        $totalGedung = Gedung::query()->count();
        $totalPemesanan = Booking::query()->count();

        $monthStart = now()->copy()->startOfMonth()->toDateString();
        $monthEnd = now()->copy()->endOfMonth()->toDateString();

        $filledSlots = Booking::query()
            ->where('status', Booking::STATUS_DISETUJUI)
            ->whereBetween('tanggal_booking', [$monthStart, $monthEnd])
            ->select('gedung_id', DB::raw('DATE(tanggal_booking) as booking_date'))
            ->groupBy('gedung_id', DB::raw('DATE(tanggal_booking)'))
            ->get()
            ->count();

        $gedungAktif = Gedung::query()->where('status', 'tersedia')->count();
        $daysInMonth = (int) now()->format('t');
        $kapasitasSlot = max($gedungAktif * $daysInMonth, 1);
        $tingkatOkupansi = min(100, (int) round(($filledSlots / $kapasitasSlot) * 100));

        $bookingTerbaru = Booking::query()
            ->with(['user', 'gedung'])
            ->latest()
            ->limit(10)
            ->get();

        $notifikasiTerbaru = Notifikasi::query()
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboardadmin', compact(
            'totalPengguna',
            'totalGedung',
            'totalPemesanan',
            'tingkatOkupansi',
            'bookingTerbaru',
            'notifikasiTerbaru'
        ));
    }
}

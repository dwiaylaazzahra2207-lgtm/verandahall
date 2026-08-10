<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserRiwayatController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', 'semua');

        $query = Booking::query()
            ->with('gedung')
            ->where('user_id', Auth::id())
            ->latest();

        if ($status !== 'semua') {
            $query->where('status', $status);
        }

        $bookings = $query->paginate(10)->withQueryString();

        $counts = [
            'semua'    => Booking::query()->where('user_id', Auth::id())->count(),
            'menunggu' => Booking::query()->where('user_id', Auth::id())->where('status', Booking::STATUS_MENUNGGU)->count(),
            'disetujui'=> Booking::query()->where('user_id', Auth::id())->where('status', Booking::STATUS_DISETUJUI)->count(),
            'ditolak'  => Booking::query()->where('user_id', Auth::id())->where('status', Booking::STATUS_DITOLAK)->count(),
            'selesai'  => Booking::query()->where('user_id', Auth::id())->where('status', Booking::STATUS_SELESAI)->count(),
        ];

        return view('user.riwayat.index', compact('bookings', 'status', 'counts'));
    }

    public function show(Booking $booking): View
    {
        // Pastikan user hanya bisa lihat booking miliknya
        abort_if($booking->user_id !== Auth::id(), 403);

        $booking->load('gedung');

        return view('user.riwayat.show', compact('booking'));
    }
}

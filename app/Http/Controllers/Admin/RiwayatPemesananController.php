<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RiwayatPemesananController extends Controller
{
    public function index(Request $request): View
    {
        $query = Booking::query()->with(['user', 'gedung'])->latest();

        if ($request->filled('q')) {
            $term = $request->input('q');
            $query->where(function ($q) use ($term) {
                $q->whereHas('user', fn ($u) => $u->where('name', 'like', '%'.$term.'%'))
                    ->orWhereHas('gedung', fn ($g) => $g->where('nama', 'like', '%'.$term.'%'));
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_booking', $request->input('tanggal'));
        }

        $statusFilter = $request->input('status');
        if ($statusFilter && $statusFilter !== 'semua') {
            match ($statusFilter) {
                'pending' => $query->whereIn('status', [Booking::STATUS_MENUNGGU, Booking::STATUS_DISETUJUI]),
                'selesai' => $query->where('status', Booking::STATUS_SELESAI),
                'dibatalkan' => $query->whereIn('status', [Booking::STATUS_DIBATALKAN, Booking::STATUS_DITOLAK]),
                default => null,
            };
        }

        $bookings = $query->paginate(12)->withQueryString();

        return view('admin.riwayat.index', compact('bookings'));
    }
}

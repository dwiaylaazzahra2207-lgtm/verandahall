<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Gedung;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserBerandaController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $gedungs = Gedung::query()
            ->where('status', 'tersedia')
            ->latest()
            ->get();

        $totalPesanan   = Booking::query()->where('user_id', $user->id)->count();
        $pesananAktif   = Booking::query()->where('user_id', $user->id)
                            ->whereIn('status', [Booking::STATUS_MENUNGGU, Booking::STATUS_DISETUJUI])
                            ->count();
        $pesananSelesai = Booking::query()->where('user_id', $user->id)
                            ->where('status', Booking::STATUS_SELESAI)
                            ->count();

        $riwayatTerbaru = Booking::query()
            ->with('gedung')
            ->where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        return view('user.beranda', compact(
            'gedungs',
            'totalPesanan',
            'pesananAktif',
            'pesananSelesai',
            'riwayatTerbaru'
        ));
    }

    public function show(Gedung $gedung): View
    {
        return view('user.gedung-detail', compact('gedung'));
    }
}

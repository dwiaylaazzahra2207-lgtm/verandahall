<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Gedung;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserPemesananController extends Controller
{
    public function index(): View
    {
        $gedungs = Gedung::query()->where('status', 'tersedia')->get();

        return view('user.pemesanan.index', compact('gedungs'));
    }

    public function create(Request $request): View
    {
        $gedung = null;

        if ($request->filled('gedung_id')) {
            $gedung = Gedung::query()->findOrFail($request->gedung_id);
        }

        $gedungs = Gedung::query()->where('status', 'tersedia')->get();

        return view('user.pemesanan.create', compact('gedungs', 'gedung'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'gedung_id'      => ['required', 'exists:gedungs,id'],
            'tanggal_booking'=> ['required', 'date', 'after_or_equal:today'],
            'jam_mulai'      => ['required', 'date_format:H:i'],
            'jam_selesai'    => ['nullable', 'date_format:H:i', 'after:jam_mulai'],
            'nama_acara'     => ['required', 'string', 'max:255'],
            'jumlah_orang'   => ['required', 'integer', 'min:1'],
            'catatan'        => ['nullable', 'string', 'max:1000'],
        ]);

        // Cek ketersediaan: apakah sudah ada booking disetujui di gedung & tanggal yang sama
        $conflict = Booking::query()
            ->where('gedung_id', $validated['gedung_id'])
            ->whereDate('tanggal_booking', $validated['tanggal_booking'])
            ->where('status', Booking::STATUS_DISETUJUI)
            ->exists();

        if ($conflict) {
            return back()
                ->withInput()
                ->with('error', 'Tanggal tidak tersedia. Gedung sudah dipesan pada tanggal tersebut.');
        }

        Booking::query()->create([
            'user_id'         => Auth::id(),
            'gedung_id'       => $validated['gedung_id'],
            'tanggal_booking' => $validated['tanggal_booking'],
            'jam_mulai'       => $validated['jam_mulai'],
            'jam_selesai'     => $validated['jam_selesai'] ?? null,
            'nama_acara'      => $validated['nama_acara'],
            'jumlah_orang'    => $validated['jumlah_orang'],
            'catatan'         => $validated['catatan'] ?? null,
            'status'          => Booking::STATUS_MENUNGGU,
        ]);

        return redirect()->route('user.riwayat.index')
            ->with('success', 'Pemesanan berhasil dikirim! Status: Menunggu Persetujuan Admin.');
    }

    public function checkAvailability(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'gedung_id'       => ['required', 'exists:gedungs,id'],
            'tanggal_booking' => ['required', 'date'],
        ]);

        $conflict = Booking::query()
            ->where('gedung_id', $request->gedung_id)
            ->whereDate('tanggal_booking', $request->tanggal_booking)
            ->where('status', Booking::STATUS_DISETUJUI)
            ->exists();

        return response()->json([
            'available' => ! $conflict,
            'message'   => $conflict
                ? 'Tanggal tidak tersedia. Gedung sudah dipesan pada tanggal tersebut.'
                : 'Tanggal tersedia.',
        ]);
    }
}

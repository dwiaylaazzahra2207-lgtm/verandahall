<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Gedung;
use App\Models\Notifikasi;
use App\Models\User;
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

        // Cek bentrok gedung, tanggal, dan jam dengan booking yang sudah disetujui
        $cekBooking = new Booking([
            'gedung_id'       => $validated['gedung_id'],
            'tanggal_booking' => $validated['tanggal_booking'],
            'jam_mulai'       => $validated['jam_mulai'],
            'jam_selesai'     => $validated['jam_selesai'] ?? null,
        ]);

        $conflict = $cekBooking->hasApprovedConflictExcludingSelf();

        if ($conflict) {
            return back()
                ->withInput()
                ->with('error', 'Jadwal tidak tersedia. Gedung sudah memiliki booking yang disetujui pada waktu tersebut.');
        }

        $booking = Booking::query()->create([
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

        $gedung = Gedung::query()->find($validated['gedung_id']);
        $namaGedung = $gedung ? $gedung->nama : 'Gedung';

        // Notifikasi untuk pengguna yang memesan
        Notifikasi::create([
            'user_id' => Auth::id(),
            'title'   => 'Pemesanan Berhasil Dikirim',
            'message' => "Pemesanan untuk {$namaGedung} pada tanggal {$validated['tanggal_booking']} berhasil dikirim dan menunggu persetujuan admin.",
            'type'    => 'info',
            'is_read' => false,
        ]);

        // Notifikasi untuk admin
        $admins = User::query()->where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notifikasi::create([
                'user_id' => $admin->id,
                'title'   => 'Pemesanan Baru Masuk',
                'message' => Auth::user()->name . " telah mengajukan pemesanan baru untuk {$namaGedung} pada tanggal {$validated['tanggal_booking']}.",
                'type'    => 'info',
                'is_read' => false,
            ]);
        }

        return redirect()->route('user.riwayat.index')
            ->with('success', 'Pemesanan berhasil dikirim! Status: Menunggu Persetujuan Admin.');
    }

    public function checkAvailability(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'gedung_id'       => ['required', 'exists:gedungs,id'],
            'tanggal_booking' => ['required', 'date'],
            'jam_mulai'       => ['required', 'date_format:H:i'],
            'jam_selesai'     => ['nullable', 'date_format:H:i', 'after:jam_mulai'],
        ]);

        $cekBooking = new Booking([
            'gedung_id'       => $validated['gedung_id'],
            'tanggal_booking' => $validated['tanggal_booking'],
            'jam_mulai'       => $validated['jam_mulai'],
            'jam_selesai'     => $validated['jam_selesai'] ?? null,
        ]);

        $conflict = $cekBooking->hasApprovedConflictExcludingSelf();

        return response()->json([
            'available' => ! $conflict,
            'message'   => $conflict
                ? 'Jadwal tidak tersedia. Gedung sudah memiliki booking yang disetujui pada waktu tersebut.'
                : 'Jadwal tersedia.',
        ]);
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ApproveBookingRequest;
use App\Http\Requests\Admin\RejectBookingRequest;
use App\Models\Booking;
use App\Models\Notifikasi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        $bookings = Booking::query()
            ->with(['user', 'gedung'])
            ->latest()
            ->paginate(15);

        return view('admin.pemesanan.index', compact('bookings'));
    }

    public function show(Booking $booking): View
    {
        $booking->load(['user', 'gedung']);

        return view('admin.pemesanan.show', compact('booking'));
    }

    public function approve(ApproveBookingRequest $request, Booking $booking): JsonResponse|RedirectResponse
    {
        if ($booking->status !== Booking::STATUS_MENUNGGU) {
            return $this->bookingActionResponse(false, 'Hanya booking berstatus menunggu yang dapat disetujui.', 422);
        }

        if ($booking->hasApprovedConflictExcludingSelf()) {
            return $this->bookingActionResponse(
                false,
                'Sudah ada booking dengan status disetujui untuk gedung dan tanggal yang sama.',
                422
            );
        }

        $booking->update([
            'status' => Booking::STATUS_DISETUJUI,
            'alasan_penolakan' => null,
        ]);

        $namaGedung = $booking->gedung ? $booking->gedung->nama : 'Gedung';
        Notifikasi::create([
            'user_id' => $booking->user_id,
            'title'   => 'Pemesanan Disetujui',
            'message' => "Selamat! Pemesanan Anda untuk {$namaGedung} pada tanggal {$booking->tanggal_booking} telah disetujui oleh admin.",
            'type'    => 'success',
            'is_read' => false,
        ]);

        return $this->bookingActionResponse(true, 'Booking berhasil disetujui.');
    }

    public function reject(RejectBookingRequest $request, Booking $booking): JsonResponse|RedirectResponse
    {
        if ($booking->status !== Booking::STATUS_MENUNGGU) {
            return $this->bookingActionResponse(false, 'Hanya booking berstatus menunggu yang dapat ditolak.', 422);
        }

        $alasan = $request->validated('alasan_penolakan') ?? '-';
        $booking->update([
            'status' => Booking::STATUS_DITOLAK,
            'alasan_penolakan' => $alasan,
        ]);

        $namaGedung = $booking->gedung ? $booking->gedung->nama : 'Gedung';
        Notifikasi::create([
            'user_id' => $booking->user_id,
            'title'   => 'Pemesanan Ditolak',
            'message' => "Mohon maaf, pemesanan Anda untuk {$namaGedung} ditolak oleh admin. Alasan: {$alasan}",
            'type'    => 'danger',
            'is_read' => false,
        ]);

        return $this->bookingActionResponse(true, 'Booking telah ditolak.');
    }

    private function bookingActionResponse(bool $success, string $message, int $errorStatus = 400): JsonResponse|RedirectResponse
    {
        if (request()->expectsJson()) {
            return response()->json([
                'success' => $success,
                'message' => $message,
            ], $success ? 200 : $errorStatus);
        }

        return $success
            ? redirect()->back()->with('success', $message)
            : redirect()->back()->with('error', $message);
    }
}

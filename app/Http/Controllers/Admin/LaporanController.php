<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Gedung;
use App\Models\User;
use App\Exports\LaporanExport;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // ── 1. Resolusi rentang tanggal ──────────────────────────────────────
        $periode  = $request->input('periode', 'bulan_ini');
        $dariRaw  = $request->input('dari_tanggal');
        $sampaiRaw = $request->input('sampai_tanggal');

        [$dari, $sampai] = $this->resolveRange($periode, $dariRaw, $sampaiRaw);

        // ── 2. Query dasar bookings dalam rentang ────────────────────────────
        $baseQuery = Booking::with(['user', 'gedung'])
            ->whereBetween('tanggal_booking', [$dari->toDateString(), $sampai->toDateString()]);

        // Filter jenis laporan (opsional)
        $jenisLaporan = $request->input('jenis_laporan', 'semua');
        if ($jenisLaporan !== 'semua') {
            $baseQuery->where('status', $jenisLaporan);
        }

        // ── 3. Kartu statistik ───────────────────────────────────────────────
        $allBookings = (clone $baseQuery)->get();

        $totalPemesanan   = $allBookings->count();
        $totalPengguna    = User::where('role', 'user')->count();
        $totalGedung      = Gedung::where('status', 'aktif')->count();

        // Hitung pendapatan: harga gedung × durasi jam, hanya booking selesai/disetujui
        $totalPendapatan = $allBookings
            ->whereIn('status', [Booking::STATUS_SELESAI, Booking::STATUS_DISETUJUI])
            ->sum(fn ($b) => $this->hitungHarga($b));

        // Tingkat okupansi: (booking disetujui+selesai) / total × 100
        $tingkatOkupansi = $totalPemesanan > 0
            ? round(
                $allBookings->whereIn('status', [Booking::STATUS_SELESAI, Booking::STATUS_DISETUJUI])->count()
                / $totalPemesanan * 100
            )
            : 0;

        // ── 4. Data grafik pendapatan per bulan (12 bulan terakhir) ──────────
        $chartBulan = [];
        for ($i = 11; $i >= 0; $i--) {
            $bln = Carbon::now()->subMonths($i);
            $label = $bln->translatedFormat('M');

            $pendapatanBulan = Booking::with('gedung')
                ->whereYear('tanggal_booking', $bln->year)
                ->whereMonth('tanggal_booking', $bln->month)
                ->whereIn('status', [Booking::STATUS_SELESAI, Booking::STATUS_DISETUJUI])
                ->get()
                ->sum(fn ($b) => $this->hitungHarga($b));

            $chartBulan[] = [
                'label'      => $label,
                'pendapatan' => round($pendapatanBulan / 1_000_000, 2), // dalam juta Rp
            ];
        }

        // ── 5. Distribusi booking per gedung (dalam rentang) ─────────────────
        $distribusiGedung = (clone $baseQuery)
            ->get()
            ->groupBy('gedung_id')
            ->map(fn ($items) => [
                'nama'  => $items->first()->gedung?->nama ?? 'Unknown',
                'total' => $items->count(),
            ])
            ->values();

        // ── 6. Tabel detail (paginated) ───────────────────────────────────────
        $detailBookings = (clone $baseQuery)
            ->latest('tanggal_booking')
            ->paginate(10)
            ->withQueryString();

        // Export CSV
        if ($request->input('export') === 'csv') {
            $bookings = (clone $baseQuery)
                ->latest('tanggal_booking')
                ->get();

            $filename = 'laporan-booking-' . now()->format('Y-m-d') . '.csv';

            return response()->streamDownload(function () use ($bookings) {
                $handle = fopen('php://output', 'w');

                fputcsv($handle, [
                    'Tanggal',
                    'Nama Pengguna',
                    'Gedung',
                    'Jam Mulai',
                    'Jam Selesai',
                    'Status',
                    'Total Harga',
                ]);

                foreach ($bookings as $booking) {
                    fputcsv($handle, [
                        $booking->tanggal_booking,
                        $booking->user?->name ?? '-',
                        $booking->gedung?->nama ?? '-',
                        $booking->jam_mulai ?? '-',
                        $booking->jam_selesai ?? '-',
                        $booking->status,
                        $this->hitungHarga($booking),
                    ]);
                }

                fclose($handle);
            }, $filename, [
                'Content-Type' => 'text/csv; charset=UTF-8',
            ]);
        }

            // Export Excel
        if ($request->input('export') === 'excel') {
            $bookings = (clone $baseQuery)
                ->latest('tanggal_booking')
                ->get();

            return Excel::download(
                new LaporanExport($bookings),
                'laporan-booking-' . now()->format('Y-m-d') . '.xlsx'
            );
        }

                // Export PDF
        if ($request->input('export') === 'pdf') {
            $bookings = (clone $baseQuery)
                ->latest('tanggal_booking')
                ->get();

            foreach ($bookings as $booking) {
                $booking->laporan_total_harga = $this->hitungHarga($booking);
            }

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan-pdf', [
                'bookings' => $bookings,
                'dari' => $dari,
                'sampai' => $sampai,
            ]);

            return $pdf->download(
                'laporan-booking-' . now()->format('Y-m-d') . '.pdf'
            );
        }

        // ── 7. Kirim ke view ─────────────────────────────────────────────────
        return view('admin.laporan', compact(
            'periode', 'dari', 'sampai', 'jenisLaporan',
            'totalPemesanan', 'totalPengguna', 'totalGedung',
            'totalPendapatan', 'tingkatOkupansi',
            'chartBulan', 'distribusiGedung',
            'detailBookings'
        ));
    }

    // ── Helper: resolusi rentang tanggal ─────────────────────────────────────
    private function resolveRange(string $periode, ?string $dari, ?string $sampai): array
    {
        return match ($periode) {
            'hari_ini'    => [Carbon::today(),        Carbon::today()],
            'minggu_ini'  => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
            'bulan_lalu'  => [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()],
            'tahun_ini'   => [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()],
            'kustom'      => [
                Carbon::parse($dari  ?? now()->startOfMonth()),
                Carbon::parse($sampai ?? now()),
            ],
            default /* bulan_ini */ => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
        };
    }

    // ── Helper: hitung harga booking (harga gedung × durasi jam) ────────────
    private function hitungHarga(Booking $booking): float
    {
        $harga = $booking->gedung?->harga ?? 0;
        if (!$booking->jam_mulai || !$booking->jam_selesai) {
            return (float) $harga; // anggap 1 jam jika jam_selesai null
        }
        $mulai   = Carbon::parse($booking->jam_mulai);
        $selesai = Carbon::parse($booking->jam_selesai);
        $durasi  = max(1, $mulai->diffInHours($selesai));
        return (float) $harga * $durasi;
    }
}
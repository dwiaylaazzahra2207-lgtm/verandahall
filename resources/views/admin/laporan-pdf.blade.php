<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Booking</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .periode {
            text-align: center;
            margin-bottom: 20px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #eeeeee;
        }

        .right {
            text-align: right;
        }
    </style>
</head>

<body>

    <h2>LAPORAN PEMESANAN GEDUNG</h2>

    <div class="periode">
        Periode:
        {{ $dari->format('d/m/Y') }}
        -
        {{ $sampai->format('d/m/Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Pengguna</th>
                <th>Gedung</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Status</th>
                <th>Total Harga</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($bookings as $booking)
                <tr>
                    <td>{{ $booking->tanggal_booking }}</td>

                    <td>
                        {{ $booking->user?->name ?? '-' }}
                    </td>

                    <td>
                        {{ $booking->gedung?->nama ?? '-' }}
                    </td>

                    <td>
                        {{ $booking->jam_mulai ?? '-' }}
                    </td>

                    <td>
                        {{ $booking->jam_selesai ?? '-' }}
                    </td>

                    <td>
                        {{ $booking->status }}
                    </td>

                    <td class="right">
                        Rp {{ number_format($booking->laporan_total_harga ?? 0, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">
                        Tidak ada data booking.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
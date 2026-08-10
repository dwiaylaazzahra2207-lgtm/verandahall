@extends('layouts.user')

@section('title', 'Riwayat Pemesanan')
@section('page-title', 'Riwayat Pemesanan')

@push('styles')
<style>
    .filter-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: .4rem;
        margin-bottom: 1.25rem;
    }
    .filter-tab {
        padding: .35rem 1rem;
        border-radius: 20px;
        font-size: .8rem;
        font-weight: 600;
        text-decoration: none;
        border: 1.5px solid #e2e8f0;
        color: #64748b;
        background: #fff;
        transition: all .15s;
    }
    .filter-tab:hover { border-color: #1e6fba; color: #1e6fba; }
    .filter-tab.active { background: #0f2235; color: #fff; border-color: #0f2235; }

    .status-badge {
        display: inline-block;
        padding: 3px 12px;
        border-radius: 20px;
        font-size: .72rem;
        font-weight: 600;
    }
    .status-menunggu  { background: #fef9c3; color: #a16207; }
    .status-disetujui { background: #dcfce7; color: #16a34a; }
    .status-ditolak   { background: #fee2e2; color: #dc2626; }
    .status-selesai   { background: #e0f2fe; color: #0369a1; }
    .status-dibatalkan{ background: #f1f5f9; color: #64748b; }

    .riwayat-table th { font-size: .75rem; color: #7a93ad; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; }
    .riwayat-table td { font-size: .85rem; vertical-align: middle; }
</style>
@endpush

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Riwayat Pemesanan</h5>
        <p class="text-muted small mb-0">Semua riwayat pemesanan gedung Anda</p>
    </div>
    <a href="{{ route('user.pemesanan.create') }}" class="btn btn-sm rounded-pill fw-semibold text-white px-4"
       style="background:#0f2235;">
        <i class="bi bi-plus-lg me-1"></i> Pesan Baru
    </a>
</div>

{{-- Filter Tabs --}}
<div class="filter-tabs">
    <a href="{{ route('user.riwayat.index', ['status' => 'semua']) }}"
       class="filter-tab {{ $status === 'semua' ? 'active' : '' }}">
        Semua <span class="ms-1">({{ $counts['semua'] }})</span>
    </a>
    <a href="{{ route('user.riwayat.index', ['status' => 'menunggu']) }}"
       class="filter-tab {{ $status === 'menunggu' ? 'active' : '' }}">
        Menunggu <span class="ms-1">({{ $counts['menunggu'] }})</span>
    </a>
    <a href="{{ route('user.riwayat.index', ['status' => 'disetujui']) }}"
       class="filter-tab {{ $status === 'disetujui' ? 'active' : '' }}">
        Disetujui <span class="ms-1">({{ $counts['disetujui'] }})</span>
    </a>
    <a href="{{ route('user.riwayat.index', ['status' => 'ditolak']) }}"
       class="filter-tab {{ $status === 'ditolak' ? 'active' : '' }}">
        Ditolak <span class="ms-1">({{ $counts['ditolak'] }})</span>
    </a>
    <a href="{{ route('user.riwayat.index', ['status' => 'selesai']) }}"
       class="filter-tab {{ $status === 'selesai' ? 'active' : '' }}">
        Selesai <span class="ms-1">({{ $counts['selesai'] }})</span>
    </a>
</div>

<div class="bg-white rounded-4 shadow-sm overflow-hidden">
    @if($bookings->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="bi bi-inbox" style="font-size:2.5rem;"></i>
            <p class="mt-3">Belum ada pemesanan
                @if($status !== 'semua') dengan status "{{ \App\Models\Booking::statusLabel($status) }}" @endif.
            </p>
            <a href="{{ route('user.pemesanan.create') }}" class="btn btn-sm rounded-pill px-4 fw-semibold text-white"
               style="background:#0f2235;">
                Buat Pemesanan
            </a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table riwayat-table mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="py-3">Gedung</th>
                        <th class="py-3">Nama Acara</th>
                        <th class="py-3">Tanggal</th>
                        <th class="py-3">Jam</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                    <tr>
                        <td class="px-4 py-3 fw-semibold">#{{ $booking->id }}</td>
                        <td class="py-3">{{ $booking->gedung?->nama ?? '-' }}</td>
                        <td class="py-3">{{ $booking->nama_acara ?? '-' }}</td>
                        <td class="py-3">{{ optional($booking->tanggal_booking)->format('d/m/Y') }}</td>
                        <td class="py-3">
                            {{ substr((string) $booking->jam_mulai, 0, 5) }}
                            @if($booking->jam_selesai)
                                – {{ substr((string) $booking->jam_selesai, 0, 5) }}
                            @endif
                        </td>
                        <td class="py-3">
                            <span class="status-badge status-{{ $booking->status }}">
                                {{ \App\Models\Booking::statusLabel($booking->status) }}
                            </span>
                        </td>
                        <td class="py-3">
                            <a href="{{ route('user.riwayat.show', $booking) }}"
                               class="btn btn-sm btn-outline-secondary rounded-pill px-3" style="font-size:.75rem;">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($bookings->hasPages())
            <div class="px-4 py-3 border-top">
                {{ $bookings->links() }}
            </div>
        @endif
    @endif
</div>

@endsection

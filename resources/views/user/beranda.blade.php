@extends('layouts.user')

@section('title', 'Beranda')
@section('page-title', 'Beranda')

@push('styles')
<style>
    .stat-card {
        background: #fff;
        border-radius: 1rem;
        padding: 1.25rem 1.5rem;
        box-shadow: 0 2px 12px rgba(15,34,53,.06);
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .stat-icon {
        width: 52px; height: 52px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }
    .stat-label { font-size: .78rem; color: #7a93ad; font-weight: 500; }
    .stat-value { font-size: 1.6rem; font-weight: 800; color: #1a2b3c; line-height: 1.1; }

    .gedung-card {
        background: #fff;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(15,34,53,.06);
        transition: transform .2s, box-shadow .2s;
    }
    .gedung-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(15,34,53,.12);
    }
    .gedung-card img {
        width: 100%; height: 180px;
        object-fit: cover;
    }
    .gedung-card-body { padding: 1.1rem 1.25rem 1.25rem; }
    .gedung-name { font-weight: 700; font-size: .95rem; color: #1a2b3c; margin-bottom: .25rem; }
    .gedung-meta { font-size: .8rem; color: #7a93ad; margin-bottom: .75rem; }
    .gedung-price { font-weight: 800; color: #1e6fba; font-size: 1rem; }
    .gedung-price span { font-size: .75rem; font-weight: 400; color: #7a93ad; }

    .badge-tersedia { background: #dcfce7; color: #16a34a; font-size: .7rem; padding: 3px 10px; border-radius: 20px; font-weight: 600; }
    .badge-habis    { background: #fee2e2; color: #dc2626; font-size: .7rem; padding: 3px 10px; border-radius: 20px; font-weight: 600; }

    .section-title { font-weight: 700; font-size: 1rem; color: #1a2b3c; margin-bottom: 1rem; }

    .riwayat-table th { font-size: .75rem; color: #7a93ad; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; }
    .riwayat-table td { font-size: .85rem; vertical-align: middle; }

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

    .welcome-banner {
        background: linear-gradient(135deg, #0f2235 0%, #1e6fba 100%);
        border-radius: 1.25rem;
        padding: 1.75rem 2rem;
        color: #fff;
        margin-bottom: 1.5rem;
    }
    .welcome-banner h4 { font-family: 'Playfair Display', serif; font-size: 1.4rem; margin-bottom: .25rem; }
    .welcome-banner p  { opacity: .8; font-size: .9rem; margin: 0; }
</style>
@endpush

@section('content')

{{-- Welcome Banner --}}
<div class="welcome-banner d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h4>Selamat datang, {{ Auth::user()->name }}!</h4>
        <p>Temukan dan pesan gedung impian Anda di VerandaHall.</p>
    </div>
    <div class="text-end">
        <div style="opacity:.7; font-size:.8rem;">{{ now()->isoFormat('dddd, D MMMM Y') }}</div>
        <a href="{{ route('user.pemesanan.create') }}" class="btn btn-light btn-sm mt-2 fw-semibold rounded-pill px-4">
            <i class="bi bi-calendar-plus me-1"></i> Pesan Sekarang
        </a>
    </div>
</div>

{{-- Statistik --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#dbeafe;">
                <i class="bi bi-journal-text" style="color:#1e6fba;"></i>
            </div>
            <div>
                <div class="stat-label">Total Pesanan</div>
                <div class="stat-value">{{ $totalPesanan }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#dcfce7;">
                <i class="bi bi-hourglass-split" style="color:#16a34a;"></i>
            </div>
            <div>
                <div class="stat-label">Pesanan Aktif</div>
                <div class="stat-value">{{ $pesananAktif }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e0f2fe;">
                <i class="bi bi-check2-circle" style="color:#0369a1;"></i>
            </div>
            <div>
                <div class="stat-label">Selesai</div>
                <div class="stat-value">{{ $pesananSelesai }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Daftar Gedung --}}
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="section-title mb-0">Gedung Tersedia</h6>
        <a href="{{ route('user.pemesanan.index') }}" class="text-decoration-none" style="font-size:.82rem; color:#1e6fba;">
            Lihat Semua <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    @if($gedungs->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="bi bi-building-x" style="font-size:2.5rem;"></i>
            <p class="mt-2">Belum ada gedung tersedia saat ini.</p>
        </div>
    @else
        <div class="row g-3">
            @foreach($gedungs->take(6) as $gedung)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="gedung-card">
                    @if($gedung->foto)
                        <img src="{{ asset('storage/' . $gedung->foto) }}" alt="{{ $gedung->nama }}">
                    @else
                        <div style="width:100%;height:180px;background:linear-gradient(135deg,#0f2235,#1e6fba);display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-buildings" style="font-size:3rem;color:rgba(255,255,255,.4);"></i>
                        </div>
                    @endif
                    <div class="gedung-card-body">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <div class="gedung-name">{{ $gedung->nama }}</div>
                            <span class="badge-tersedia">Tersedia</span>
                        </div>
                        <div class="gedung-meta">
                            <i class="bi bi-people-fill me-1"></i>Kapasitas {{ number_format($gedung->kapasitas) }} orang
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <div class="gedung-price">
                                Rp {{ number_format($gedung->harga, 0, ',', '.') }}
                                <span>/hari</span>
                            </div>
                            <a href="{{ route('user.pemesanan.create', ['gedung_id' => $gedung->id]) }}"
                               class="btn btn-sm rounded-pill px-3 fw-semibold"
                               style="background:#0f2235;color:#fff;font-size:.78rem;">
                                Pesan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

{{-- Riwayat Terbaru --}}
<div class="bg-white rounded-4 shadow-sm overflow-hidden">
    <div class="d-flex justify-content-between align-items-center px-4 py-3 border-bottom">
        <h6 class="section-title mb-0">Riwayat Pemesanan Terbaru</h6>
        <a href="{{ route('user.riwayat.index') }}" class="text-decoration-none" style="font-size:.82rem; color:#1e6fba;">
            Lihat Semua <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    @if($riwayatTerbaru->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="bi bi-inbox" style="font-size:2rem;"></i>
            <p class="mt-2 small">Belum ada riwayat pemesanan.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table riwayat-table mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="py-3">Gedung</th>
                        <th class="py-3">Tanggal</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayatTerbaru as $booking)
                    <tr>
                        <td class="px-4 py-3 fw-semibold">#{{ $booking->id }}</td>
                        <td class="py-3">{{ $booking->gedung?->nama ?? '-' }}</td>
                        <td class="py-3">{{ optional($booking->tanggal_booking)->format('d/m/Y') }}</td>
                        <td class="py-3">
                            <span class="status-badge status-{{ $booking->status }}">
                                {{ \App\Models\Booking::statusLabel($booking->status) }}
                            </span>
                        </td>
                        <td class="py-3">
                            <a href="{{ route('user.riwayat.show', $booking) }}"
                               class="text-decoration-none" style="color:#1e6fba; font-size:.82rem;">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection

@extends('layouts.user')

@section('title', 'Detail Pemesanan #' . $booking->id)
@section('page-title', 'Detail Pemesanan')

@push('styles')
<style>
    .detail-card {
        background: #fff;
        border-radius: 1.25rem;
        box-shadow: 0 4px 24px rgba(15,34,53,.07);
        padding: 1.75rem;
    }
    .detail-label { font-size: .78rem; color: #7a93ad; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; }
    .detail-value { font-size: .92rem; color: #1a2b3c; font-weight: 500; margin-top: .15rem; }
    .status-badge {
        display: inline-block;
        padding: 5px 16px;
        border-radius: 20px;
        font-size: .82rem;
        font-weight: 700;
    }
    .status-menunggu  { background: #fef9c3; color: #a16207; }
    .status-disetujui { background: #dcfce7; color: #16a34a; }
    .status-ditolak   { background: #fee2e2; color: #dc2626; }
    .status-selesai   { background: #e0f2fe; color: #0369a1; }
    .status-dibatalkan{ background: #f1f5f9; color: #64748b; }

    .timeline-item {
        display: flex;
        gap: 1rem;
        padding-bottom: 1.25rem;
        position: relative;
    }
    .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 32px;
        bottom: 0;
        width: 2px;
        background: #e2e8f0;
    }
    .timeline-dot {
        width: 32px; height: 32px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        font-size: .85rem;
    }
    .timeline-dot.done { background: #dcfce7; color: #16a34a; }
    .timeline-dot.active { background: #dbeafe; color: #1e6fba; }
    .timeline-dot.pending { background: #f1f5f9; color: #94a3b8; }
    .timeline-dot.rejected { background: #fee2e2; color: #dc2626; }
</style>
@endpush

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('user.riwayat.index') }}" class="btn btn-light rounded-pill btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
    <div>
        <h5 class="fw-bold mb-0">Pemesanan #{{ $booking->id }}</h5>
        <p class="text-muted small mb-0">
            Dibuat {{ $booking->created_at->diffForHumans() }}
        </p>
    </div>
</div>

<div class="row g-4">
    {{-- Detail Utama --}}
    <div class="col-lg-8">
        <div class="detail-card mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold mb-0">Informasi Pemesanan</h6>
                <span class="status-badge status-{{ $booking->status }}">
                    {{ \App\Models\Booking::statusLabel($booking->status) }}
                </span>
            </div>

            <div class="row g-3">
                <div class="col-sm-6">
                    <div class="detail-label">Gedung</div>
                    <div class="detail-value">{{ $booking->gedung?->nama ?? '-' }}</div>
                </div>
                <div class="col-sm-6">
                    <div class="detail-label">Nama Acara</div>
                    <div class="detail-value">{{ $booking->nama_acara ?? '-' }}</div>
                </div>
                <div class="col-sm-6">
                    <div class="detail-label">Tanggal</div>
                    <div class="detail-value">{{ optional($booking->tanggal_booking)->isoFormat('dddd, D MMMM Y') }}</div>
                </div>
                <div class="col-sm-6">
                    <div class="detail-label">Waktu</div>
                    <div class="detail-value">
                        {{ substr((string) $booking->jam_mulai, 0, 5) }}
                        @if($booking->jam_selesai)
                            – {{ substr((string) $booking->jam_selesai, 0, 5) }}
                        @endif
                        WIB
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="detail-label">Jumlah Orang</div>
                    <div class="detail-value">{{ $booking->jumlah_orang ? number_format($booking->jumlah_orang) . ' orang' : '-' }}</div>
                </div>
                <div class="col-sm-6">
                    <div class="detail-label">Harga Gedung</div>
                    <div class="detail-value fw-bold" style="color:#1e6fba;">
                        Rp {{ number_format($booking->gedung?->harga ?? 0, 0, ',', '.') }} / hari
                    </div>
                </div>
                @if($booking->catatan)
                <div class="col-12">
                    <div class="detail-label">Catatan</div>
                    <div class="detail-value">{{ $booking->catatan }}</div>
                </div>
                @endif
                @if($booking->status === \App\Models\Booking::STATUS_DITOLAK && $booking->alasan_penolakan)
                <div class="col-12">
                    <div class="detail-label text-danger">Alasan Penolakan</div>
                    <div class="detail-value">
                        <div class="alert alert-danger rounded-3 small mb-0 py-2">
                            <i class="bi bi-x-circle me-1"></i>{{ $booking->alasan_penolakan }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Timeline Status --}}
        <div class="detail-card">
            <h6 class="fw-bold mb-4">Riwayat Status</h6>
            @php
                $isDitolak = $booking->status === \App\Models\Booking::STATUS_DITOLAK;
                $isDibatalkan = $booking->status === \App\Models\Booking::STATUS_DIBATALKAN;
            @endphp

            <div class="timeline-item">
                <div class="timeline-dot done"><i class="bi bi-check2"></i></div>
                <div>
                    <div class="fw-semibold" style="font-size:.88rem;">Pemesanan Dibuat</div>
                    <div class="text-muted" style="font-size:.78rem;">{{ $booking->created_at->format('d M Y, H:i') }}</div>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-dot {{ in_array($booking->status, ['disetujui','ditolak','selesai','dibatalkan']) ? ($isDitolak || $isDibatalkan ? 'rejected' : 'done') : 'active' }}">
                    @if($isDitolak || $isDibatalkan)
                        <i class="bi bi-x"></i>
                    @elseif(in_array($booking->status, ['disetujui','selesai']))
                        <i class="bi bi-check2"></i>
                    @else
                        <i class="bi bi-hourglass-split"></i>
                    @endif
                </div>
                <div>
                    <div class="fw-semibold" style="font-size:.88rem;">
                        @if($isDitolak) Ditolak Admin
                        @elseif($isDibatalkan) Dibatalkan
                        @elseif(in_array($booking->status, ['disetujui','selesai'])) Disetujui Admin
                        @else Menunggu Persetujuan Admin
                        @endif
                    </div>
                    <div class="text-muted" style="font-size:.78rem;">
                        @if($booking->status === \App\Models\Booking::STATUS_MENUNGGU)
                            Sedang diproses
                        @else
                            {{ $booking->updated_at->format('d M Y, H:i') }}
                        @endif
                    </div>
                </div>
            </div>

            @if(!$isDitolak && !$isDibatalkan)
            <div class="timeline-item">
                <div class="timeline-dot {{ $booking->status === \App\Models\Booking::STATUS_SELESAI ? 'done' : 'pending' }}">
                    @if($booking->status === \App\Models\Booking::STATUS_SELESAI)
                        <i class="bi bi-check2-all"></i>
                    @else
                        <i class="bi bi-flag"></i>
                    @endif
                </div>
                <div>
                    <div class="fw-semibold" style="font-size:.88rem;">Selesai</div>
                    <div class="text-muted" style="font-size:.78rem;">
                        @if($booking->status === \App\Models\Booking::STATUS_SELESAI)
                            {{ $booking->updated_at->format('d M Y, H:i') }}
                        @else
                            Menunggu pelaksanaan acara
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Sidebar Gedung --}}
    <div class="col-lg-4">
        <div class="detail-card">
            <h6 class="fw-bold mb-3">Gedung Dipesan</h6>
            @if($booking->gedung?->foto)
                <img src="{{ asset('storage/' . $booking->gedung->foto) }}"
                     alt="{{ $booking->gedung->nama }}"
                     class="rounded-3 w-100 mb-3" style="height:160px;object-fit:cover;">
            @else
                <div class="rounded-3 mb-3 d-flex align-items-center justify-content-center"
                     style="height:160px;background:linear-gradient(135deg,#0f2235,#1e6fba);">
                    <i class="bi bi-buildings" style="font-size:3rem;color:rgba(255,255,255,.3);"></i>
                </div>
            @endif
            <div class="fw-bold mb-1">{{ $booking->gedung?->nama }}</div>
            <div class="text-muted small">
                <i class="bi bi-people-fill me-1"></i>Kapasitas {{ number_format($booking->gedung?->kapasitas ?? 0) }} orang
            </div>
            <div class="fw-bold mt-2" style="color:#1e6fba;">
                Rp {{ number_format($booking->gedung?->harga ?? 0, 0, ',', '.') }} / hari
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('user.pemesanan.create', ['gedung_id' => $booking->gedung_id]) }}"
               class="btn w-100 rounded-pill fw-semibold text-white py-2"
               style="background:#0f2235;">
                <i class="bi bi-calendar-plus me-1"></i> Pesan Lagi
            </a>
        </div>
    </div>
</div>

@endsection

@extends('layouts.admin')

@section('title', 'Booking #'.$booking->id)

@php use App\Models\Booking; @endphp

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap');

    .bk-wrap { font-family:'Sora',sans-serif; }

    /* Header */
    .bk-header {
        background:linear-gradient(135deg,#0f172a 0%,#1e293b 60%,#0f2a4a 100%);
        border-radius:20px;
        padding:26px 30px;
        margin-bottom:24px;
        position:relative; overflow:hidden;
        display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:12px;
    }
    .bk-header::before {
        content:''; position:absolute; top:-50px; right:-50px;
        width:200px; height:200px;
        background:radial-gradient(circle,rgba(99,179,237,.15) 0%,transparent 70%);
    }
    .bk-header-left h1 { color:#f1f5f9; font-size:1.25rem; font-weight:700; margin:0 0 6px; }
    .bk-back-btn {
        display:inline-flex; align-items:center; gap:6px;
        padding:8px 18px;
        background:rgba(255,255,255,.1);
        border:1px solid rgba(255,255,255,.15);
        color:#e2e8f0 !important;
        border-radius:50px;
        font-size:.78rem; font-weight:600;
        text-decoration:none;
        transition:background .15s;
        backdrop-filter:blur(4px);
        position:relative; z-index:1;
    }
    .bk-back-btn:hover { background:rgba(255,255,255,.18); }

    /* Status badge in header */
    .bk-status-badge {
        display:inline-flex; align-items:center; gap:6px;
        padding:5px 14px; border-radius:50px;
        font-size:.72rem; font-weight:600;
    }
    .bk-status-badge::before { content:''; width:7px; height:7px; border-radius:50%; }
    .bs-waiting   { background:rgba(234,179,8,.15);  color:#fde047; } .bs-waiting::before   { background:#fde047; }
    .bs-approved  { background:rgba(34,197,94,.15);  color:#4ade80; } .bs-approved::before  { background:#4ade80; }
    .bs-rejected  { background:rgba(244,63,94,.15);  color:#fb7185; } .bs-rejected::before  { background:#fb7185; }
    .bs-done      { background:rgba(59,130,246,.15); color:#93c5fd; } .bs-done::before      { background:#93c5fd; }
    .bs-cancelled { background:rgba(148,163,184,.15);color:#cbd5e1; } .bs-cancelled::before { background:#cbd5e1; }

    @php
        $bsClass = match($booking->status){
            Booking::STATUS_MENUNGGU   => 'bs-waiting',
            Booking::STATUS_DISETUJUI  => 'bs-approved',
            Booking::STATUS_DITOLAK    => 'bs-rejected',
            Booking::STATUS_SELESAI    => 'bs-done',
            Booking::STATUS_DIBATALKAN => 'bs-cancelled',
            default => ''
        };
    @endphp

    /* Cards */
    .bk-card {
        background:#fff;
        border-radius:20px;
        border:1.5px solid #f1f5f9;
        box-shadow:0 2px 24px rgba(15,23,42,.06);
        overflow:hidden;
    }
    .bk-card-header {
        padding:18px 24px 14px;
        border-bottom:1.5px solid #f1f5f9;
        display:flex; align-items:center; gap:10px;
    }
    .bk-card-icon {
        width:32px; height:32px;
        background:#f0f9ff;
        border-radius:9px;
        display:flex; align-items:center; justify-content:center;
        font-size:.9rem;
    }
    .bk-card-title { font-size:.85rem; font-weight:700; color:#0f172a; margin:0; }
    .bk-card-body  { padding:20px 24px; }

    /* Info rows */
    .bk-dl { display:grid; grid-template-columns:auto 1fr; gap:10px 16px; font-size:.82rem; }
    .bk-dt { color:#94a3b8; font-weight:600; font-size:.75rem; text-transform:uppercase; letter-spacing:.4px; white-space:nowrap; align-self:center; }
    .bk-dd { color:#334155; font-weight:500; margin:0; }
    .bk-dd .mono { font-family:'DM Mono',monospace; font-size:.8rem; }
    .bk-dd .email { color:#64748b; font-size:.78rem; }
    .bk-dd .gedung-pill {
        background:#f0f9ff; color:#0369a1;
        padding:2px 10px; border-radius:6px;
        font-size:.78rem; font-weight:600; display:inline-block;
    }
    .bk-alasan {
        background:#fff1f2; color:#9f1239;
        border-left:3px solid #f43f5e;
        padding:10px 14px; border-radius:0 8px 8px 0;
        font-size:.8rem; line-height:1.5;
    }

    /* Divider */
    .bk-divider { height:1px; background:#f1f5f9; margin:20px 0; }

    /* Action buttons */
    .bk-actions { display:flex; gap:10px; flex-wrap:wrap; }
    .bk-btn-approve {
        flex:1; min-width:140px;
        background:linear-gradient(135deg,#16a34a,#15803d);
        color:#fff; border:none; border-radius:50px;
        padding:10px 20px; font-size:.82rem; font-weight:600;
        cursor:pointer; font-family:'Sora',sans-serif;
        transition:opacity .15s, transform .1s;
    }
    .bk-btn-approve:hover { opacity:.9; transform:translateY(-1px); }

    .bk-btn-reject-toggle {
        flex:1; min-width:140px;
        background:#fff; color:#be123c;
        border:1.5px solid #fda4af; border-radius:50px;
        padding:10px 20px; font-size:.82rem; font-weight:600;
        cursor:pointer; font-family:'Sora',sans-serif;
        transition:background .15s, transform .1s;
    }
    .bk-btn-reject-toggle:hover { background:#fff1f2; transform:translateY(-1px); }

    /* Reject form */
    .bk-reject-panel {
        background:#fff8f8;
        border:1.5px solid #fda4af;
        border-radius:14px;
        padding:18px 20px;
        margin-top:14px;
    }
    .bk-reject-panel label { font-size:.75rem; font-weight:700; color:#be123c; text-transform:uppercase; letter-spacing:.4px; display:block; margin-bottom:8px; }
    .bk-reject-panel textarea {
        width:100%; border:1.5px solid #fda4af; border-radius:10px;
        padding:10px 14px; font-size:.82rem; font-family:'Sora',sans-serif;
        color:#334155; resize:vertical; outline:none;
        transition:border-color .15s;
        box-sizing:border-box;
    }
    .bk-reject-panel textarea:focus { border-color:#f43f5e; }
    .bk-btn-reject-submit {
        background:linear-gradient(135deg,#f43f5e,#be123c);
        color:#fff; border:none; border-radius:50px;
        padding:9px 22px; font-size:.8rem; font-weight:600;
        margin-top:12px; cursor:pointer; font-family:'Sora',sans-serif;
        transition:opacity .15s, transform .1s;
    }
    .bk-btn-reject-submit:hover { opacity:.9; transform:translateY(-1px); }
    .invalid-feedback { font-size:.75rem; color:#f43f5e; margin-top:4px; }

    /* Gedung image card */
    .bk-img { width:100%; border-radius:12px; object-fit:cover; max-height:190px; display:block; margin-bottom:14px; }
    .bk-meta { display:flex; flex-direction:column; gap:8px; }
    .bk-meta-row {
        display:flex; align-items:center; justify-content:space-between;
        font-size:.8rem;
    }
    .bk-meta-label { color:#94a3b8; font-weight:500; }
    .bk-meta-value { color:#0f172a; font-weight:700; }
    .bk-meta-value.price { color:#0369a1; }
    .bk-meta-divider { height:1px; background:#f1f5f9; }
</style>
@endpush

@section('content')

@php
    $bsClass = match($booking->status){
        Booking::STATUS_MENUNGGU   => 'bs-waiting',
        Booking::STATUS_DISETUJUI  => 'bs-approved',
        Booking::STATUS_DITOLAK    => 'bs-rejected',
        Booking::STATUS_SELESAI    => 'bs-done',
        Booking::STATUS_DIBATALKAN => 'bs-cancelled',
        default => ''
    };
@endphp

<div class="bk-wrap">

    {{-- Header --}}
    <div class="bk-header">
        <div class="bk-header-left" style="position:relative;z-index:1;">
            <h1>Booking <span style="font-family:'DM Mono',monospace;font-size:1rem;opacity:.7">#{{ $booking->id }}</span></h1>
            <span class="bk-status-badge {{ $bsClass }}">{{ Booking::statusLabel($booking->status) }}</span>
        </div>
        <a href="{{ route('admin.pemesanan.index') }}" class="bk-back-btn">← Kembali</a>
    </div>

    <div class="row g-3">

        {{-- Info + Actions --}}
        <div class="col-lg-7">
            <div class="bk-card">
                <div class="bk-card-header">
                    <div class="bk-card-icon">📋</div>
                    <p class="bk-card-title">Informasi Booking</p>
                </div>
                <div class="bk-card-body">
                    <div class="bk-dl">
                        <span class="bk-dt">Pengguna</span>
                        <span class="bk-dd">
                            {{ $booking->user?->name }}
                            <span class="email">&nbsp;{{ $booking->user?->email }}</span>
                        </span>

                        <span class="bk-dt">Gedung</span>
                        <span class="bk-dd"><span class="gedung-pill">{{ $booking->gedung?->nama }}</span></span>

                        <span class="bk-dt">Tanggal</span>
                        <span class="bk-dd">{{ optional($booking->tanggal_booking)->format('d F Y') }}</span>

                        <span class="bk-dt">Jam</span>
                        <span class="bk-dd mono">
                            {{ substr((string) $booking->jam_mulai, 0, 5) }}
                            @if($booking->jam_selesai) – {{ substr((string) $booking->jam_selesai, 0, 5) }} @endif
                        </span>

                        @if($booking->status === Booking::STATUS_DITOLAK && $booking->alasan_penolakan)
                            <span class="bk-dt">Penolakan</span>
                            <span class="bk-dd">
                                <div class="bk-alasan">{{ $booking->alasan_penolakan }}</div>
                            </span>
                        @endif
                    </div>

                    @if($booking->status === Booking::STATUS_MENUNGGU)
                        <div class="bk-divider"></div>

                        <div class="bk-actions">
                            <form action="{{ route('admin.pemesanan.approve', $booking) }}" method="POST" style="flex:1;min-width:140px;">
                                @csrf
                                <button type="submit" class="bk-btn-approve w-100">✓ Setujui Booking</button>
                            </form>
                            <button type="button" class="bk-btn-reject-toggle"
                                data-bs-toggle="collapse" data-bs-target="#rejectPanel">
                                ✕ Tolak Booking
                            </button>
                        </div>

                        <div class="collapse" id="rejectPanel">
                            <div class="bk-reject-panel">
                                <form action="{{ route('admin.pemesanan.reject', $booking) }}" method="POST">
                                    @csrf
                                    <label>Alasan Penolakan</label>
                                    <textarea name="alasan_penolakan" rows="3"
                                        class="@error('alasan_penolakan') is-invalid @enderror"
                                        required placeholder="Jelaskan alasan penolakan...">{{ old('alasan_penolakan') }}</textarea>
                                    @error('alasan_penolakan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <button type="submit" class="bk-btn-reject-submit">Kirim Penolakan</button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Gedung info --}}
        <div class="col-lg-5">
            <div class="bk-card">
                <div class="bk-card-header">
                    <div class="bk-card-icon">🏛️</div>
                    <p class="bk-card-title">Informasi Gedung</p>
                </div>
                <div class="bk-card-body">
                    @if($booking->gedung?->foto)
                        <img src="{{ asset('storage/'.$booking->gedung->foto) }}" class="bk-img" alt="{{ $booking->gedung->nama }}">
                    @endif
                    <div class="bk-meta">
                        <div class="bk-meta-row">
                            <span class="bk-meta-label">Kapasitas</span>
                            <span class="bk-meta-value">{{ number_format($booking->gedung?->kapasitas ?? 0) }} orang</span>
                        </div>
                        <div class="bk-meta-divider"></div>
                        <div class="bk-meta-row">
                            <span class="bk-meta-label">Harga Sewa</span>
                            <span class="bk-meta-value price">Rp {{ number_format($booking->gedung?->harga ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
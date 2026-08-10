@extends('layouts.admin')

@section('title', 'Manajemen Pemesanan')

@php
    use App\Models\Booking;
    $bookingStatusClass = fn ($status) => match ($status) {
        Booking::STATUS_MENUNGGU  => 'badge-waiting',
        Booking::STATUS_DISETUJUI => 'badge-approved',
        Booking::STATUS_DITOLAK   => 'badge-rejected',
        Booking::STATUS_SELESAI   => 'badge-done',
        Booking::STATUS_DIBATALKAN => 'badge-cancelled',
        default => 'badge-muted',
    };
    $formatJam = fn ($time) => $time ? (strlen((string) $time) >= 5 ? substr((string) $time, 0, 5) : $time) : '-';
@endphp

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap');

    .pm-wrap { font-family: 'Sora', sans-serif; }

    /* Header */
    .pm-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #0f2a4a 100%);
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }
    .pm-header::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 200px; height: 200px;
        background: radial-gradient(circle, rgba(99,179,237,.18) 0%, transparent 70%);
    }
    .pm-header::after {
        content: '';
        position: absolute;
        bottom: -30px; left: 60px;
        width: 140px; height: 140px;
        background: radial-gradient(circle, rgba(56,189,248,.12) 0%, transparent 70%);
    }
    .pm-header h1 { color:#f1f5f9; font-size:1.35rem; font-weight:700; margin:0 0 4px; letter-spacing:-.3px; }
    .pm-header p  { color:#94a3b8; font-size:.82rem; margin:0; }

    /* Stats chips */
    .pm-stats { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:24px; }
    .pm-stat-chip {
        background:#fff;
        border:1.5px solid #e2e8f0;
        border-radius:50px;
        padding:6px 16px;
        font-size:.78rem;
        font-weight:600;
        color:#475569;
        display:flex; align-items:center; gap:6px;
    }
    .pm-stat-chip span { font-size:.7rem; font-weight:500; }

    /* Card */
    .pm-card {
        background:#fff;
        border-radius:20px;
        border:1.5px solid #f1f5f9;
        box-shadow: 0 2px 24px rgba(15,23,42,.06);
        overflow:hidden;
    }

    /* Table */
    .pm-table { width:100%; border-collapse:collapse; font-size:.825rem; }
    .pm-table thead tr { background:#f8fafc; border-bottom:1.5px solid #e2e8f0; }
    .pm-table thead th {
        padding:13px 16px;
        font-size:.72rem;
        font-weight:600;
        color:#94a3b8;
        text-transform:uppercase;
        letter-spacing:.6px;
        white-space:nowrap;
    }
    .pm-table thead th:first-child { padding-left:28px; }
    .pm-table thead th:last-child  { padding-right:28px; text-align:right; }

    .pm-table tbody tr {
        border-bottom:1px solid #f1f5f9;
        transition:background .15s;
    }
    .pm-table tbody tr:last-child { border-bottom:none; }
    .pm-table tbody tr:hover { background:#f8faff; }

    .pm-table td { padding:14px 16px; color:#334155; vertical-align:middle; }
    .pm-table td:first-child { padding-left:28px; }
    .pm-table td:last-child  { padding-right:28px; text-align:right; }

    /* ID cell */
    .pm-id {
        font-family:'DM Mono', monospace;
        font-size:.75rem;
        font-weight:500;
        background:#f1f5f9;
        color:#475569;
        padding:3px 9px;
        border-radius:6px;
        display:inline-block;
    }

    /* Avatar-like user cell */
    .pm-user { display:flex; align-items:center; gap:10px; }
    .pm-avatar {
        width:30px; height:30px;
        background:linear-gradient(135deg,#38bdf8,#6366f1);
        border-radius:50%;
        display:flex; align-items:center; justify-content:center;
        font-size:.7rem; font-weight:700; color:#fff; flex-shrink:0;
    }

    /* Gedung pill */
    .pm-gedung {
        background:#f0f9ff;
        color:#0369a1;
        padding:3px 10px;
        border-radius:6px;
        font-size:.78rem;
        font-weight:500;
        display:inline-block;
    }

    /* Jam */
    .pm-jam { font-family:'DM Mono',monospace; font-size:.78rem; color:#64748b; }

    /* Status badges */
    .pm-badge {
        display:inline-flex; align-items:center; gap:5px;
        padding:4px 11px; border-radius:50px;
        font-size:.7rem; font-weight:600; letter-spacing:.2px;
    }
    .pm-badge::before { content:''; width:6px; height:6px; border-radius:50%; flex-shrink:0; }
    .badge-waiting   { background:#fefce8; color:#a16207; } .badge-waiting::before   { background:#eab308; }
    .badge-approved  { background:#f0fdf4; color:#15803d; } .badge-approved::before  { background:#22c55e; }
    .badge-rejected  { background:#fff1f2; color:#be123c; } .badge-rejected::before  { background:#f43f5e; }
    .badge-done      { background:#eff6ff; color:#1d4ed8; } .badge-done::before      { background:#3b82f6; }
    .badge-cancelled { background:#f8fafc; color:#64748b; } .badge-cancelled::before { background:#94a3b8; }
    .badge-muted     { background:#f8fafc; color:#94a3b8; }

    /* Action button */
    .pm-btn-detail {
        display:inline-flex; align-items:center; gap:5px;
        padding:6px 14px;
        background:#0f172a;
        color:#f8fafc !important;
        border-radius:50px;
        font-size:.75rem;
        font-weight:600;
        text-decoration:none;
        transition:background .15s, transform .1s;
        white-space:nowrap;
    }
    .pm-btn-detail:hover { background:#1e293b; transform:translateY(-1px); }

    /* Empty state */
    .pm-empty { text-align:center; padding:64px 20px; color:#94a3b8; }
    .pm-empty-icon { font-size:2.5rem; margin-bottom:12px; opacity:.4; }
    .pm-empty p { font-size:.85rem; }

    /* Pagination wrapper */
    .pm-pagination { padding:16px 28px; border-top:1.5px solid #f1f5f9; }
</style>
@endpush

@section('content')
<div class="pm-wrap">

    {{-- Header --}}
    <div class="pm-header">
        <h1>Manajemen Pemesanan</h1>
        <p>Kelola seluruh booking — tinjau detail, setujui, atau tolak dari halaman detail.</p>
    </div>

    {{-- Table card --}}
    <div class="pm-card">
        <div class="table-responsive">
            <table class="pm-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pengguna</th>
                        <th>Gedung</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $b)
                        <tr>
                            <td><span class="pm-id">#{{ $b->id }}</span></td>
                            <td>
                                <div class="pm-user">
                                    <div class="pm-avatar">{{ strtoupper(substr($b->user?->name ?? '?', 0, 1)) }}</div>
                                    <span>{{ $b->user?->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td><span class="pm-gedung">{{ $b->gedung?->nama ?? '-' }}</span></td>
                            <td>{{ optional($b->tanggal_booking)->format('d/m/Y') }}</td>
                            <td class="pm-jam">
                                {{ $formatJam($b->jam_mulai) }}
                                @if($b->jam_selesai) – {{ $formatJam($b->jam_selesai) }} @endif
                            </td>
                            <td>
                                <span class="pm-badge {{ $bookingStatusClass($b->status) }}">
                                    {{ Booking::statusLabel($b->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.pemesanan.show', $b) }}" class="pm-btn-detail">
                                    <i class="bi bi-eye-fill"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="pm-empty">
                                    <div class="pm-empty-icon">📋</div>
                                    <p>Belum ada pemesanan yang masuk.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($bookings->hasPages())
            <div class="pm-pagination">{{ $bookings->links() }}</div>
        @endif
    </div>

</div>
@endsection
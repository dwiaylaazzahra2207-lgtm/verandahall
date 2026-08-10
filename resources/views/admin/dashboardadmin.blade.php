@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@push('styles')
<style>
    /* ── STAT CARDS ──────────────────────────────────────────────────── */
    .stat-card {
        background: #ffffff;
        border-radius: 1rem;
        padding: 20px 22px;
        border: 2px solid transparent;
        box-shadow: 0 3px 10px rgba(13, 29, 46, 0.06);
        transition: transform .2s, box-shadow .2s;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(15,34,53,.10);
    }

    .stat-card .stat-label {
        font-size: .78rem;
        font-weight: 500;
        color: #7a93ad;
        margin-bottom: 6px;
    }

    .stat-card .stat-val {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 2rem;
        line-height: 1;
        margin-bottom: 4px;
    }

    .stat-card .stat-sub {
        font-size: .72rem;
        color: #7a93ad;
    }

    .stat-card .stat-icon {
        position: absolute;
        top: 18px; right: 20px;
        font-size: 1.6rem;
        opacity: .85;
    }

    .stat-card .stat-change {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        font-size: .72rem;
        font-weight: 600;
        padding: 2px 7px;
        border-radius: 20px;
    }

    /* Warna per card */
    .stat-card-blue   { border-color: #dbeafe; }
    .stat-card-blue   .stat-val  { color: #1e6fba; }
    .stat-card-blue   .stat-icon { color: #1e6fba; }

    .stat-card-green  { border-color: #dcfce7; }
    .stat-card-green  .stat-val  { color: #15803d; }
    .stat-card-green  .stat-icon { color: #22c55e; }

    .stat-card-orange { border-color: #ffedd5; }
    .stat-card-orange .stat-val  { color: #c2410c; }
    .stat-card-orange .stat-icon { color: #f97316; }

    .stat-card-purple { border-color: #f3e8ff; }
    .stat-card-purple .stat-val  { color: #7e22ce; }
    .stat-card-purple .stat-icon { color: #a855f7; }

    /* SECTION CARDS */
    .vh-card {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 2px 12px rgba(15,34,53,.06);
        overflow: hidden;
    }

    .vh-card-header {
        padding: 18px 22px 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .vh-card-title {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: 1rem;
        color: #1a2b3c;
        margin: 0;
    }

    .vh-card-link {
        font-size: .78rem;
        color: #1e6fba;
        text-decoration: none;
        font-weight: 600;
    }

    .vh-card-link:hover { text-decoration: underline; }

    /* ── TABLE ───────────────────────────────────────────────────────── */
    .vh-table {
        width: 100%;
        border-collapse: collapse;
        font-size: .82rem;
    }

    .vh-table thead th {
        background: #f0f7ff;
        color: #1a2b3c;
        font-weight: 600;
        font-size: .72rem;
        text-transform: uppercase;
        letter-spacing: .04em;
        padding: 11px 14px;
        border: none;
        white-space: nowrap;
    }

    .vh-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background .15s;
    }

    .vh-table tbody tr:last-child { border-bottom: none; }
    .vh-table tbody tr:hover { background: #f8fbff; }

    .vh-table tbody td {
        padding: 12px 14px;
        color: #1a2b3c;
        vertical-align: middle;
    }

    /* ── STATUS BADGES ───────────────────────────────────────────────── */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: .72rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-badge::before {
        content: '';
        width: 6px; height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-menunggu  { background: #fff3e8; color: #c2500a; }
    .status-disetujui { background: #e8f8ef; color: #15803d; }
    .status-ditolak   { background: #fde8e8; color: #b91c1c; }
    .status-selesai   { background: #e8f0fc; color: #1e6fba; }
    .status-dibatalkan{ background: #f1f5f9; color: #475569; }

    /* ── ACTION BTN ──────────────────────────────────────────────────── */
    .action-btn {
        width: 30px; height: 30px;
        border-radius: 8px;
        border: none;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: .8rem;
        cursor: pointer;
        transition: all .15s;
        text-decoration: none;
    }

    .action-btn-view   { background: #e8f0fc; color: #1e6fba; }
    .action-btn-ok     { background: #e8f8ef; color: #15803d; }
    .action-btn-reject { background: #fde8e8; color: #b91c1c; }

    .action-btn:hover { filter: brightness(.9); transform: scale(1.08); }

    /* ── NOTIF ITEMS ─────────────────────────────────────────────────── */
    .notif-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px 22px;
        border-bottom: 1px solid #f1f5f9;
        transition: background .15s;
    }

    .notif-item:last-child { border-bottom: none; }
    .notif-item:hover { background: #f8fbff; }

    .notif-icon-wrap {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: .95rem;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .notif-title {
        font-weight: 700;
        font-size: .82rem;
        color: #1a2b3c;
        line-height: 1.3;
    }

    .notif-body {
        font-size: .75rem;
        color: #7a93ad;
        margin-top: 2px;
        line-height: 1.4;
    }

    .notif-time {
        font-size: .68rem;
        color: #a0b3c4;
        margin-top: 4px;
    }

    .notif-dot-new {
        width: 8px; height: 8px;
        background: #1e6fba;
        border-radius: 50%;
        flex-shrink: 0;
        margin-top: 5px;
    }
</style>
@endpush

@php
    use App\Models\Booking;
    use Illuminate\Support\Str;

    $bookingStatusClass = fn ($status) => match ($status) {
        Booking::STATUS_MENUNGGU   => 'status-menunggu',
        Booking::STATUS_DISETUJUI  => 'status-disetujui',
        Booking::STATUS_DITOLAK    => 'status-ditolak',
        Booking::STATUS_SELESAI    => 'status-selesai',
        Booking::STATUS_DIBATALKAN => 'status-dibatalkan',
        default => '',
    };

    $formatJam = function ($time) {
        if (!$time) return '-';
        return strlen((string) $time) >= 5 ? substr((string) $time, 0, 5) : $time;
    };
@endphp

@section('content')

{{-- ── GREETING ─────────────────────────────────────────────────────────── --}}
<div class="mb-4">
    <h1 class="fw-bold mb-1" style="font-family:'Playfair Display',serif; font-size:1.5rem; color:#1a2b3c;">
        Halo, {{ Auth::user()->name }} 👋
    </h1>
    <p class="mb-0" style="font-size:.85rem; color:#7a93ad;">
        Selamat datang di dashboard VerandaHall — pantau gedung dan pemesanan dalam satu layar.
    </p>
</div>

{{-- ── STAT CARDS ───────────────────────────────────────────────────────── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card stat-card-blue h-100">
            <div class="stat-label">Total Pengguna</div>
            <div class="stat-val">{{ number_format($totalPengguna ?? 0, 0, ',', '.') }}</div>
            <div class="stat-sub">Pengguna terdaftar</div>
            <i class="bi bi-person-fill stat-icon"></i>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card stat-card-green h-100">
            <div class="stat-label">Total Gedung</div>
            <div class="stat-val">{{ number_format($totalGedung ?? 0, 0, ',', '.') }}</div>
            <div class="stat-sub">Lapangan tersedia</div>
            <i class="bi bi-buildings-fill stat-icon"></i>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card stat-card-orange h-100">
            <div class="stat-label">Total Pemesanan</div>
            <div class="stat-val">{{ number_format($totalPemesanan ?? 0, 0, ',', '.') }}</div>
            <div class="stat-sub">Semua status booking</div>
            <i class="bi bi-clipboard-check-fill stat-icon"></i>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card stat-card-purple h-100">
            <div class="stat-label">Tingkat Okupansi</div>
            <div class="stat-val">{{ $tingkatOkupansi ?? 0 }}%</div>
            <div class="stat-sub">+5% bulan ini</div>
            <i class="bi bi-graph-up-arrow stat-icon"></i>
        </div>
    </div>
</div>

{{-- ── TABEL BOOKING + NOTIFIKASI ────────────────────────────────────────── --}}
<div class="row g-3">

    {{-- Booking Terbaru --}}
    <div class="col-lg-8">
        <div class="vh-card h-100">
            <div class="vh-card-header mb-3">
                <h2 class="vh-card-title">Booking Terbaru</h2>
                <a href="{{ route('admin.pemesanan.index') }}" class="vh-card-link">Lihat semua</a>
            </div>
            <div class="table-responsive">
                <table class="vh-table">
                    <thead>
                        <tr>
                            <th style="padding-left:22px;">Id</th>
                            <th>Nama Pengguna</th>
                            <th>Gedung</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Status</th>
                            <th style="text-align:right; padding-right:22px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookingTerbaru ?? [] as $b)
                            <tr>
                                <td style="padding-left:22px; font-weight:700; color:#1e6fba;">
                                    {{ str_pad($b->id, 3, '0', STR_PAD_LEFT) }}
                                </td>
                                <td>{{ $b->user?->name ?? '-' }}</td>
                                <td style="color:#7a93ad; font-size:.78rem;">
                                    {{ \Illuminate\Support\Str::limit($b->gedung?->nama ?? '-', 14) }}
                                </td>
                                <td>{{ optional($b->tanggal_booking)->format('d/m/Y') }}</td>
                                <td>
                                    {{ $formatJam($b->jam_mulai) }}
                                    @if($b->jam_selesai)–{{ $formatJam($b->jam_selesai) }}@endif
                                </td>
                                <td>
                                    <span class="status-badge {{ $bookingStatusClass($b->status) }}">
                                        {{ Booking::statusLabel($b->status) }}
                                    </span>
                                </td>
                                <td style="text-align:right; padding-right:22px;">
                                    <div class="d-flex gap-1 justify-content-end">
                                        <a href="{{ route('admin.pemesanan.show', $b) }}"
                                           class="action-btn action-btn-view" title="Lihat">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        @if($b->status === Booking::STATUS_MENUNGGU)
                                            <button type="button" class="action-btn action-btn-ok"
                                                    onclick="vhBookingModal({{ $b->id }}, 'approve')"
                                                    title="Setujui">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                            <button type="button" class="action-btn action-btn-reject"
                                                    onclick="vhBookingModal({{ $b->id }}, 'reject')"
                                                    title="Tolak">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        @else
                                            <button class="action-btn" style="background:#f1f5f9; color:#cbd5e1;" disabled>
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                            <button class="action-btn" style="background:#f1f5f9; color:#cbd5e1;" disabled>
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align:center; padding:48px; color:#7a93ad;">
                                    <i class="bi bi-inbox" style="font-size:2rem; display:block; margin-bottom:8px; opacity:.3;"></i>
                                    Belum ada data booking.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Notifikasi --}}
    <div class="col-lg-4">
        <div class="vh-card h-100">
            <div class="vh-card-header mb-1">
                <h2 class="vh-card-title">Notifikasi</h2>
                <a href="{{ route('admin.notifikasi.index') }}" class="vh-card-link">Lihat semua</a>
            </div>

            @forelse($notifikasiTerbaru ?? [] as $n)
                <div class="notif-item">
                    {{-- Icon warna berdasarkan judul --}}
                    @php
                        $ic = 'bi-bell-fill';
                        $bg = '#e8f0fc'; $fc = '#1e6fba';
                        $title = strtolower($n->title ?? '');
                        if (str_contains($title, 'bayar') || str_contains($title, 'pembayaran')) {
                            $ic = 'bi-cash-coin'; $bg = '#e8f8ef'; $fc = '#15803d';
                        } elseif (str_contains($title, 'review') || str_contains($title, 'rating')) {
                            $ic = 'bi-star-fill'; $bg = '#fff8e0'; $fc = '#ca8a04';
                        } elseif (str_contains($title, 'booking') || str_contains($title, 'pesan')) {
                            $ic = 'bi-journal-check'; $bg = '#f3e8ff'; $fc = '#a855f7';
                        }
                    @endphp
                    <div class="notif-icon-wrap" style="background:{{ $bg }}; color:{{ $fc }};">
                        <i class="bi {{ $ic }}"></i>
                    </div>
                    <div style="flex:1; min-width:0;">
                        <div class="notif-title">{{ $n->title }}</div>
                        <div class="notif-body">{{ \Illuminate\Support\Str::limit($n->message, 80) }}</div>
                        <div class="notif-time">{{ $n->created_at->diffForHumans() }}</div>
                    </div>
                    @if(!$n->is_read)
                        <div class="notif-dot-new"></div>
                    @endif
                </div>
            @empty
                <div style="text-align:center; padding:48px; color:#7a93ad; font-size:.82rem;">
                    <i class="bi bi-bell-slash" style="font-size:2rem; display:block; margin-bottom:8px; opacity:.3;"></i>
                    Tidak ada notifikasi.
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- ── MODAL APPROVE / REJECT ────────────────────────────────────────────── --}}
<div class="modal fade" id="vhBookingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="vhBookingModalTitle">Konfirmasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-2">
                <p class="mb-3" id="vhBookingModalBody" style="font-size:.85rem; color:#7a93ad;"></p>
                <div id="vhRejectWrap" class="d-none">
                    <label class="form-label fw-semibold" style="font-size:.82rem;">Alasan penolakan</label>
                    <textarea id="vhRejectReason" class="form-control rounded-3" rows="3"
                              placeholder="Jelaskan alasan penolakan..."></textarea>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn rounded-pill px-4 text-white" id="vhBookingConfirmBtn">Konfirmasi</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
(() => {
    const csrf       = document.querySelector('meta[name="csrf-token"]')?.content;
    const approveUrl = id => `{{ url('/admin/pemesanan') }}/${id}/approve`;
    const rejectUrl  = id => `{{ url('/admin/pemesanan') }}/${id}/reject`;

    let currentId = null, currentAction = null;
    const modalEl = document.getElementById('vhBookingModal');
    const modal   = modalEl ? new bootstrap.Modal(modalEl) : null;

    window.vhBookingModal = function(id, action) {
        currentId = id; currentAction = action;
        const title      = document.getElementById('vhBookingModalTitle');
        const body       = document.getElementById('vhBookingModalBody');
        const rejectWrap = document.getElementById('vhRejectWrap');
        const btn        = document.getElementById('vhBookingConfirmBtn');
        document.getElementById('vhRejectReason').value = '';

        if (action === 'approve') {
            title.textContent = 'Setujui booking';
            body.textContent  = 'Booking akan ditandai disetujui. Pastikan tidak bentrok dengan jadwal lain.';
            rejectWrap.classList.add('d-none');
            btn.className = 'btn rounded-pill px-4 text-white';
            btn.style.background = '#22c55e';
            btn.textContent = 'Ya, setujui';
        } else {
            title.textContent = 'Tolak booking';
            body.textContent  = 'User akan menerima informasi bahwa booking ditolak.';
            rejectWrap.classList.remove('d-none');
            btn.className = 'btn rounded-pill px-4 text-white';
            btn.style.background = '#ef4444';
            btn.textContent = 'Ya, tolak';
        }
        modal?.show();
    };

    document.getElementById('vhBookingConfirmBtn')?.addEventListener('click', async () => {
        if (!currentId || !csrf) return;
        if (currentAction === 'reject') {
            const reason = document.getElementById('vhRejectReason').value.trim();
            if (!reason) { alert('Harap isi alasan penolakan.'); return; }
        }

        const url     = currentAction === 'approve' ? approveUrl(currentId) : rejectUrl(currentId);
        const payload = currentAction === 'reject'
            ? JSON.stringify({ alasan_penolakan: document.getElementById('vhRejectReason').value.trim() })
            : '{}';

        try {
            const res  = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: payload,
            });
            const data = await res.json().catch(() => ({}));
            if (!res.ok) { alert(data.message || 'Terjadi kesalahan.'); return; }
            if (data.success) { modal?.hide(); location.reload(); }
            else { alert(data.message || 'Permintaan gagal.'); }
        } catch { alert('Koneksi gagal. Coba lagi.'); }
    });
})();
</script>
@endpush
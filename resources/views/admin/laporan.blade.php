@extends('layouts.admin')

@section('title', 'Laporan')

@push('styles')
<style>
    .vh-stat-card {
        border-radius: 1rem;
        border: none;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(15, 34, 53, 0.08);
    }
    .vh-stat-card .icon-wrap {
        width: 48px; height: 48px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.35rem;
        color: #fff;
    }
    .vh-stat-card .stat-val {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 1.75rem;
        color: var(--text-dark, #1a2b3c);
    }
    .vh-table thead th {
        background: #e8f4fc !important;
        color: #1a2b3c !important;
        font-weight: 600;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: .03em;
    }
    .vh-filter-card {
        border-radius: 1rem;
        border: 1px solid #e2eaf3;
        background: #fff;
        box-shadow: 0 2px 12px rgba(15,34,53,.05);
    }
    .badge-menunggu  { background: #fff3e8; color: #c2500a; }
    .badge-disetujui { background: #e8f8ef; color: #15803d; }
    .badge-ditolak   { background: #fde8e8; color: #b91c1c; }
    .badge-selesai   { background: #e8f0fc; color: #1e6fba; }
    .badge-dibatalkan{ background: #f1f5f9; color: #475569; }
    .export-btn {
        font-size: .78rem;
        font-weight: 600;
        letter-spacing: .02em;
        border-radius: .5rem;
        padding: .3rem .85rem;
    }
    #periodeKustom { display: none; }
</style>
@endpush

@section('content')

{{-- Header --}}
<div class="mb-4">
    <h1 class="h3 fw-bold mb-1" style="font-family:'Playfair Display',sans;">Laporan</h1>
    <p class="text-muted small mb-0" style="font-family:'Poppins',sans;">
        Ringkasan data pemesanan, pendapatan, dan operasional VerandaHall.
    </p>
</div>

{{-- ── FILTER ──────────────────────────────────────────────────────────── --}}
<div class="vh-filter-card p-4 mb-4">
    <form method="GET" action="{{ route('admin.laporan.index') }}" id="filterForm">
        <div class="row g-3 align-items-end">
            <div class="col-12 col-sm-6 col-lg-3">
                <label class="form-label small fw-semibold mb-1">Periode</label>
                <select name="periode" id="periodeSelect" class="form-select form-select-sm rounded-3"
                        onchange="toggleKustom(this.value)">
                    @foreach([
                        'bulan_ini'   => 'Bulan ini',
                        'hari_ini'    => 'Hari ini',
                        'minggu_ini'  => 'Minggu ini',
                        'bulan_lalu'  => 'Bulan lalu',
                        'tahun_ini'   => 'Tahun ini',
                        'kustom'      => 'Kustom',
                    ] as $val => $label)
                        <option value="{{ $val }}" {{ $periode === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div id="periodeKustom" class="col-12 col-sm-6 col-lg-2">
                <label class="form-label small fw-semibold mb-1">Dari Tanggal</label>
                <input type="date" name="dari_tanggal" class="form-control form-control-sm rounded-3"
                       value="{{ $dari->toDateString() }}">
            </div>
            <div id="periodeKustom2" class="col-12 col-sm-6 col-lg-2" style="display:none">
                <label class="form-label small fw-semibold mb-1">Sampai Tanggal</label>
                <input type="date" name="sampai_tanggal" class="form-control form-control-sm rounded-3"
                       value="{{ $sampai->toDateString() }}">
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <label class="form-label small fw-semibold mb-1">Status</label>
                <select name="jenis_laporan" class="form-select form-select-sm rounded-3">
                    @foreach([
                        'semua'       => 'Semua Status',
                        'menunggu'    => 'Menunggu',
                        'disetujui'   => 'Disetujui',
                        'selesai'     => 'Selesai',
                        'ditolak'     => 'Ditolak',
                        'dibatalkan'  => 'Dibatalkan',
                    ] as $val => $label)
                        <option value="{{ $val }}" {{ $jenisLaporan === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-lg-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm rounded-3 flex-fill">
                    <i class="bi bi-search me-1"></i> Filter
                </button>
                <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline-secondary btn-sm rounded-3" title="Reset">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </div>

        {{-- Rentang aktif --}}
        <div class="mt-2 text-muted" style="font-size:.78rem;">
            <i class="bi bi-calendar-range me-1"></i>
            Menampilkan data:
            <strong>{{ $dari->translatedFormat('d F Y') }}</strong>
            –
            <strong>{{ $sampai->translatedFormat('d F Y') }}</strong>
        </div>
    </form>
</div>

{{-- ── KARTU STATISTIK ─────────────────────────────────────────────────── --}}
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card vh-stat-card h-100">
            <div class="card-body d-flex align-items-start gap-3">
                <div class="icon-wrap" style="background: linear-gradient(135deg,#475569,#64748b);">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Pengguna</div>
                    <div class="stat-val">{{ number_format($totalPengguna, 0, ',', '.') }}</div>
                    <div class="text-muted mt-1" style="font-size:.72rem;">Pengguna terdaftar</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card vh-stat-card h-100">
            <div class="card-body d-flex align-items-start gap-3">
                <div class="icon-wrap" style="background: linear-gradient(135deg,#fb923c,#ea580c);">
                    <i class="bi bi-clipboard-check-fill"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Pemesanan</div>
                    <div class="stat-val">{{ number_format($totalPemesanan, 0, ',', '.') }}</div>
                    <div class="text-muted mt-1" style="font-size:.72rem;">Dalam periode ini</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card vh-stat-card h-100">
            <div class="card-body d-flex align-items-start gap-3">
                <div class="icon-wrap" style="background: linear-gradient(135deg,#22c55e,#15803d);">
                    <i class="bi bi-cash-coin"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Pendapatan</div>
                    <div class="stat-val" style="font-size:1.35rem;">
                        Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                    </div>
                    <div class="text-muted mt-1" style="font-size:.72rem;">Booking selesai & disetujui</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card vh-stat-card h-100">
            <div class="card-body d-flex align-items-start gap-3">
                <div class="icon-wrap" style="background: linear-gradient(135deg,#a855f7,#7e22ce);">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <div>
                    <div class="text-muted small">Tingkat Okupansi</div>
                    <div class="stat-val">{{ $tingkatOkupansi }}%</div>
                    <div class="text-muted mt-1" style="font-size:.72rem;">Dari total booking</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── GRAFIK ───────────────────────────────────────────────────────────── --}}
<div class="row g-3 mb-4">
    {{-- Grafik Pendapatan Bulanan --}}
    <div class="col-lg-8">
        <div class="card vh-stat-card h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h2 class="h5 fw-bold mb-0" style="font-family:'Playfair Display',sans;">Pendapatan Bulanan</h2>
                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill" style="font-size:.72rem;">
                    12 bulan terakhir
                </span>
            </div>
            <div class="card-body pt-2">
                <canvas id="chartPendapatan" height="110"></canvas>
            </div>
        </div>
    </div>

    {{-- Distribusi Booking per Gedung --}}
    <div class="col-lg-4">
        <div class="card vh-stat-card h-100">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h2 class="h5 fw-bold mb-0" style="font-family:'Playfair Display',sans;">Distribusi per Gedung</h2>
            </div>
            <div class="card-body pt-2 d-flex flex-column align-items-center justify-content-center">
                @if($distribusiGedung->isEmpty())
                    <p class="text-muted small text-center py-4">Belum ada data booking pada periode ini.</p>
                @else
                    <canvas id="chartDistribusi" height="220"></canvas>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ── TABEL DETAIL BOOKING ─────────────────────────────────────────────── --}}
<div class="card vh-stat-card mb-4">
    <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h2 class="h5 fw-bold mb-0" style="font-family:'Playfair Display',sans;">Detail Laporan Booking</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.laporan.index', array_merge(request()->query(), ['export' => 'csv'])) }}"
               class="btn btn-outline-secondary export-btn">
                <i class="bi bi-filetype-csv me-1"></i> CSV
            </a>
            <a href="{{ route('admin.laporan.index', array_merge(request()->query(), ['export' => 'excel'])) }}"
               class="btn btn-outline-success export-btn">
                <i class="bi bi-file-earmark-excel me-1"></i> Excel
            </a>
            <a href="{{ route('admin.laporan.index', array_merge(request()->query(), ['export' => 'pdf'])) }}"
               class="btn btn-outline-danger export-btn">
                <i class="bi bi-file-earmark-pdf me-1"></i> PDF
            </a>
        </div>
    </div>
    <div class="card-body px-0 pt-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 vh-table align-middle">
                <thead>
                    <tr>
                        <th class="px-4">ID Booking</th>
                        <th>Gedung</th>
                        <th>Customer</th>
                        <th>Tanggal</th>
                        <th>Durasi</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody class="small">
                    @forelse($detailBookings as $b)
                        @php
                            $durasi = '-';
                            $total  = 0;
                            if ($b->jam_mulai && $b->jam_selesai) {
                                $jam    = \Carbon\Carbon::parse($b->jam_mulai)->diffInHours(\Carbon\Carbon::parse($b->jam_selesai));
                                $durasi = $jam . ' jam';
                                $total  = ($b->gedung?->harga ?? 0) * max(1, $jam);
                            }
                        @endphp
                        <tr>
                            <td class="px-4 fw-semibold">#{{ str_pad($b->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $b->gedung?->nama ?? '-' }}</td>
                            <td>{{ $b->user?->name ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($b->tanggal_booking)->format('d M Y') }}</td>
                            <td>{{ $durasi }}</td>
                            <td>Rp {{ $total > 0 ? number_format($total, 0, ',', '.') : '-' }}</td>
                            <td>
                                <span class="badge rounded-pill badge-{{ $b->status }} px-3 py-1" style="font-size:.72rem;">
                                    {{ \App\Models\Booking::statusLabel($b->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-2 d-block mb-2 opacity-25"></i>
                                Tidak ada data booking pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($detailBookings->hasPages())
            <div class="d-flex justify-content-center py-3">
                {{ $detailBookings->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(() => {
    // ── Data dari controller ──────────────────────────────────────────────
    const chartBulan = @json($chartBulan);
    const distribusi = @json($distribusiGedung);

    // ── Warna palette ─────────────────────────────────────────────────────
    const TEAL     = '#1D9E75';
    const TEAL_BG  = 'rgba(29,158,117,.15)';
    const COLORS   = ['#1D9E75','#3B8BD4','#EF9F27','#A855F7','#EF4444','#64748B','#F97316','#22C55E'];

    // ── Grafik Pendapatan Bulanan (Bar) ───────────────────────────────────
    const ctxBar = document.getElementById('chartPendapatan');
    if (ctxBar) {
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: chartBulan.map(d => d.label),
                datasets: [{
                    label: 'Pendapatan (Juta Rp)',
                    data: chartBulan.map(d => d.pendapatan),
                    backgroundColor: TEAL_BG,
                    borderColor: TEAL,
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => ` Rp ${(ctx.raw * 1_000_000).toLocaleString('id-ID')}`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,.05)' },
                        ticks: { callback: v => `${v}jt`, font: { size: 11 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11 } }
                    }
                }
            }
        });
    }

    // ── Grafik Distribusi per Gedung (Donut) ──────────────────────────────
    const ctxDnt = document.getElementById('chartDistribusi');
    if (ctxDnt && distribusi.length) {
        new Chart(ctxDnt, {
            type: 'doughnut',
            data: {
                labels: distribusi.map(d => d.nama),
                datasets: [{
                    data: distribusi.map(d => d.total),
                    backgroundColor: COLORS.slice(0, distribusi.length),
                    borderWidth: 2,
                    hoverOffset: 8,
                }]
            },
            options: {
                responsive: true,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 12, padding: 14, font: { size: 11 } }
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => ` ${ctx.label}: ${ctx.raw} booking`
                        }
                    }
                }
            }
        });
    }

    // ── Toggle rentang kustom ─────────────────────────────────────────────
    window.toggleKustom = function(val) {
        const show = val === 'kustom';
        document.getElementById('periodeKustom').style.display  = show ? '' : 'none';
        document.getElementById('periodeKustom2').style.display = show ? '' : 'none';
    };

    // Inisialisasi saat load
    toggleKustom(document.getElementById('periodeSelect')?.value ?? 'bulan_ini');
})();
</script>
@endpush
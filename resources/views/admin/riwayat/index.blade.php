@extends('layouts.admin')

@section('title', 'Riwayat Pemesanan')

@push('styles')
@include('partials.admin-crud-styles')
@endpush

@section('content')
<div class="vh-toolbar-card mb-3">
    <form method="get" action="{{ route('admin.riwayat.index') }}" class="vh-toolbar-inner">
        <div class="vh-search-wrap flex-grow-1" style="max-width: none;">
            <i class="bi bi-search"></i>
            <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm"
                   placeholder="Cari nama, gedung, tanggal..." autocomplete="off">
        </div>
        <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control form-control-sm vh-filter-select"
               style="max-width: 168px;" title="Filter tanggal">
        <select name="status" class="form-select form-select-sm vh-filter-select" onchange="this.form.submit()">
            <option value="semua" @selected(request('status','semua')==='semua')>Status</option>
            <option value="pending" @selected(request('status')==='pending')>Pending</option>
            <option value="selesai" @selected(request('status')==='selesai')>Selesai</option>
            <option value="dibatalkan" @selected(request('status')==='dibatalkan')>Dibatalkan</option>
        </select>
        <button type="submit" class="btn btn-sm btn-outline-secondary rounded-pill">Terapkan</button>
        @if(request()->hasAny(['q','tanggal','status']))
            <a href="{{ route('admin.riwayat.index') }}" class="btn btn-sm btn-link text-secondary">Reset</a>
        @endif
    </form>
</div>

<div class="vh-table-shell">
    <div class="vh-inner-title">Riwayat User</div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th class="ps-4">Id</th>
                    <th>Nama Pengguna</th>
                    <th>Gedung</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th class="pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="small">
                @php
                    $jamDot = fn ($t) => $t ? str_replace(':', '.', substr((string) $t, 0, 5)) : '';
                @endphp
                @forelse($bookings as $b)
                    @php $kat = $b->riwayatKategori(); @endphp
                    <tr>
                        <td class="ps-4 fw-semibold text-muted">{{ str_pad((string) $b->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td class="fw-semibold">{{ $b->user?->name ?? '-' }}</td>
                        <td>{{ $b->gedung?->nama ?? '-' }}</td>
                        <td>{{ optional($b->tanggal_booking)->format('j/n/Y') }}</td>
                        <td>
                            {{ $jamDot($b->jam_mulai) }}
                            @if($b->jam_selesai)
                                -{{ $jamDot($b->jam_selesai) }}
                            @endif
                        </td>
                        <td class="pe-4">
                            @if($kat === 'selesai')
                                <span class="badge-vh-riw-selesai">{{ $b->riwayatStatusLabel() }}</span>
                            @elseif($kat === 'dibatalkan')
                                <span class="badge-vh-riw-batal">{{ $b->riwayatStatusLabel() }}</span>
                            @else
                                <span class="badge-vh-riw-pending">{{ $b->riwayatStatusLabel() }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-5">Belum ada riwayat pemesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="vh-pagination-wrap">{{ $bookings->links() }}</div>
@endsection

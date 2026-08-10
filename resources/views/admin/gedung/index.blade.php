@extends('layouts.admin')

@section('title', 'Pengelolaan Gedung')

@push('styles')
@include('partials.admin-crud-styles')
@endpush

@section('content')
@php
    use App\Models\Gedung;
@endphp

<div class="vh-toolbar-card mb-3">
    <form method="get" action="{{ route('admin.gedung.index') }}" class="vh-toolbar-inner">
        <div class="vh-search-wrap"> 
            <i class="bi bi-search"></i>
            <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm"
                   placeholder="Cari nama gedung" autocomplete="off">
        </div>
        <select name="status" class="form-select form-select-sm vh-filter-select " onchange="this.form.submit()">
            <option value="semua" @selected(request('status','semua')==='semua')>Status</option>
            <option value="pending" @selected(request('status')==='pending')>Pending</option>
            <option value="tersedia" @selected(request('status')==='tersedia')>Tersedia</option>
            <option value="habis" @selected(request('status')==='habis')>Habis</option>
        </select>
        <button type="submit" class="btn btn-sm btn-outline-secondary rounded-pill d-none d-md-inline-block">Terapkan</button>
        <a href="{{ route('admin.gedung.create') }}" class="btn btn-sm btn-success btn-vh-add ms-md-auto">
            <i class="bi bi-plus-lg me-1"></i> Tambah Gedung
        </a>
    </form>
</div>

<div class="vh-table-shell">
    <div class="vh-inner-title">Data Gedung</div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th class="ps-4">Id</th>
                    <th>Nama Gedung</th>
                    <th>Kapasitas</th>
                    <th>Harga/Jam</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="small">
                @forelse($gedungs as $g)
                    <tr>
                        <td class="ps-4 fw-semibold text-muted">{{ str_pad((string) $g->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td class="fw-semibold">{{ $g->nama }}</td>
                        <td>{{ number_format($g->kapasitas) }} orang</td>
                        <td>{{ number_format((float) $g->harga, 0, ',', '.') }}/jam</td>
                        <td>
                            @if($g->status === 'pending')
                                <span class="badge-vh-pending">{{ Gedung::statusLabel($g->status) }}</span>
                            @elseif($g->status === 'tersedia')
                                <span class="badge-vh-tersedia">{{ Gedung::statusLabel($g->status) }}</span>
                            @else
                                <span class="badge-vh-habis">{{ Gedung::statusLabel($g->status) }}</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-inline-flex gap-1 justify-content-end">
                                <a href="{{ route('admin.gedung.edit', $g) }}" class="btn btn-vh-edit" title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <form action="{{ route('admin.gedung.destroy', $g) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus gedung ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-vh-del" title="Hapus"><i class="bi bi-trash-fill"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-5">Belum ada gedung.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="vh-pagination-wrap">{{ $gedungs->links() }}</div>
@endsection

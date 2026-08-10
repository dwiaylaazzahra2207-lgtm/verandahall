@extends('layouts.admin')

@section('title', 'Manajemen User')

@push('styles')
@include('partials.admin-crud-styles')
@endpush

@section('content')
<div class="vh-toolbar-card mb-3">
    <form method="get" action="{{ route('admin.users.index') }}" class="vh-toolbar-inner">
        <div class="vh-search-wrap">
            <i class="bi bi-search"></i>
            <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm"
                   placeholder="Cari nama atau email..." autocomplete="off">
        </div>
        <select name="status" class="form-select form-select-sm vh-filter-select" onchange="this.form.submit()">
            <option value="" @selected(request('status','')==='')>Status</option>
            <option value="aktif" @selected(request('status')==='aktif')>Aktif</option>
            <option value="nonaktif" @selected(request('status')==='nonaktif')>Non Aktif</option>
        </select>
        <select name="role" class="form-select form-select-sm vh-filter-select" onchange="this.form.submit()">
            <option value="semua" @selected(request('role','semua')==='semua')>Role</option>
            <option value="user" @selected(request('role')==='user')>User</option>
            <option value="admin" @selected(request('role')==='admin')>Admin</option>
        </select>
        <button type="submit" class="btn btn-sm btn-outline-secondary rounded-pill d-none d-md-inline-block">Terapkan</button>
        <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-success btn-vh-add ms-md-auto">
            <i class="bi bi-plus-lg me-1"></i> Tambah User
        </a>
    </form>
</div>

<div class="vh-table-shell">
    <div class="vh-inner-title">Manajemen User</div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th class="ps-4">Id</th>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="small">
                @forelse($users as $u)
                    <tr>
                        <td class="ps-4 fw-semibold text-muted">{{ str_pad((string) $u->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td class="fw-semibold">{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>
                            @if($u->role === 'admin')
                                <span class="badge bg-primary rounded-pill">Admin</span>
                            @else
                                <span class="badge bg-secondary rounded-pill">User</span>
                            @endif
                        </td>
                        <td>
                            @if($u->is_active)
                                <span class="badge-vh-user-active">Aktif</span>
                            @else
                                <span class="badge-vh-user-inactive">Non Aktif</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-inline-flex gap-1 justify-content-end">
                                <a href="{{ route('admin.users.edit', $u) }}" class="btn btn-vh-edit" title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                @if($u->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Hapus pengguna ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-vh-del" title="Hapus"><i class="bi bi-trash-fill"></i></button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-5">Tidak ada pengguna.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="vh-pagination-wrap">{{ $users->links() }}</div>
@endsection

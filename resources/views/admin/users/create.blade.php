@extends('layouts.admin')

@section('title', 'Tambah User')

@section('content')
<h1 class="h5 fw-bold mb-3" style="font-family:'Plus Jakarta Sans',sans-serif;">Tambah User</h1>

<div class="card rounded-4 border-0 shadow-sm p-4">
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control rounded-3 @error('name') is-invalid @enderror" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control rounded-3 @error('email') is-invalid @enderror" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Password</label>
                <input type="password" name="password" class="form-control rounded-3 @error('password') is-invalid @enderror" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Konfirmasi password</label>
                <input type="password" name="password_confirmation" class="form-control rounded-3" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Role</label>
                <select name="role" class="form-select rounded-3 @error('role') is-invalid @enderror">
                    @php $r = old('role', 'user'); @endphp
                    <option value="user" @selected($r === 'user')>User</option>
                    <option value="admin" @selected($r === 'admin')>Admin</option>
                </select>
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <input type="hidden" name="is_active" value="0">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                           @checked(old('is_active', true))>
                    <label class="form-check-label small" for="is_active">Akun aktif</label>
                </div>
            </div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-light rounded-pill px-4">Batal</a>
        </div>
    </form>
</div>
@endsection

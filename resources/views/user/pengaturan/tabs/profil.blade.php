@php $user = auth()->user(); @endphp

<div class="vh-set-card">
    <h2><i class="bi bi-person-circle text-primary"></i> Profil Akun</h2>

    <form action="{{ route('user.pengaturan.update-profil') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Foto Profil --}}
        <div class="row g-4 mb-4">
            <div class="col-auto">
                @if($user->foto)
                    <img src="{{ asset('storage/'.$user->foto) }}" alt=""
                         class="rounded-circle border" style="width:88px;height:88px;object-fit:cover;">
                @else
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                         style="width:88px;height:88px;background:linear-gradient(135deg,#0f2235,#1e6fba);font-size:1.5rem;">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                @endif
            </div>
            <div class="col d-flex align-items-center">
                <div>
                    <label class="btn btn-outline-secondary rounded-pill btn-sm mb-0">
                        <i class="bi bi-upload me-1"></i> Ubah Foto
                        <input type="file" name="foto" accept="image/*" class="d-none">
                    </label>
                    <div class="small text-muted mt-1">PNG, JPG maks. 4MB</div>
                    @error('foto')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6 vh-set-input">
                <label class="vh-set-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $user->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 vh-set-input">
                <label class="vh-set-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 vh-set-input">
                <label class="vh-set-label">Nomor Telepon</label>
                <input type="text" name="phone"
                       class="form-control @error('phone') is-invalid @enderror"
                       value="{{ old('phone', $user->phone) }}"
                       placeholder="Contoh: 08123456789">
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('user.beranda') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
            <button type="submit" class="btn vh-btn-primary px-4">
                <i class="bi bi-floppy2 me-1"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>

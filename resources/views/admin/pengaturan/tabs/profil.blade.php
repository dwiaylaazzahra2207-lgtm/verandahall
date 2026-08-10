@php $user = auth()->user(); @endphp

<div class="vh-set-card">
    <h2><i class="bi bi-person-circle text-primary"></i> Profil Akun</h2>

    {{-- Tampilkan semua error validasi di atas form --}}
    @if($errors->any())
        <div class="alert alert-danger rounded-3 mb-4">
            <div class="fw-semibold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Terdapat kesalahan:</div>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.pengaturan.update-profil') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Foto profil --}}
        <div class="row g-3 mb-4">
            <div class="col-auto">
                @if($user->foto)
                    <img src="{{ asset('storage/'.$user->foto) }}" alt=""
                         class="rounded-circle border" style="width:80px;height:80px;object-fit:cover;">
                @else
                    <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center text-muted"
                         style="width:80px;height:80px;">
                        <i class="bi bi-person fs-2"></i>
                    </div>
                @endif
            </div>
            <div class="col d-flex align-items-center">
                <div>
                    <label class="btn btn-outline-secondary rounded-pill btn-sm mb-1">
                        <i class="bi bi-upload me-1"></i> Ubah Foto
                        <input type="file" name="foto" accept="image/*" class="d-none">
                    </label>
                    <div class="small text-muted">PNG, JPG maks. 4 MB</div>
                    @error('foto')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row g-3">
            {{-- Nama --}}
            <div class="col-md-6 vh-set-input">
                <label class="vh-set-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $user->name) }}"
                       placeholder="Masukkan nama lengkap" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Email --}}
            <div class="col-md-6 vh-set-input">
                <label class="vh-set-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $user->email) }}"
                       placeholder="Masukkan email" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Telepon --}}
            <div class="col-md-6 vh-set-input">
                <label class="vh-set-label">Nomor Telepon</label>
                <input type="text" name="phone"
                       class="form-control @error('phone') is-invalid @enderror"
                       value="{{ old('phone', $user->phone) }}"
                       placeholder="Contoh: 08123456789">
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Nama Venue --}}
            <div class="col-md-6 vh-set-input">
                <label class="vh-set-label">Nama Venue</label>
                <input type="text" name="profile_venue_name"
                       class="form-control @error('profile_venue_name') is-invalid @enderror"
                       value="{{ old('profile_venue_name', $user->profile_venue_name) }}"
                       placeholder="Masukkan nama venue">
                @error('profile_venue_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Deskripsi --}}
            <div class="col-12 vh-set-input">
                <label class="vh-set-label">Deskripsi Singkat</label>
                <textarea name="short_description" rows="3"
                          class="form-control @error('short_description') is-invalid @enderror"
                          placeholder="Masukkan deskripsi singkat">{{ old('short_description', $user->short_description) }}</textarea>
                @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Sosial --}}
            <div class="col-md-6 vh-set-input">
                <label class="vh-set-label">Instagram / WhatsApp</label>
                <input type="text" name="social_contact"
                       class="form-control @error('social_contact') is-invalid @enderror"
                       value="{{ old('social_contact', $user->social_contact) }}"
                       placeholder="Contoh: @verandahall">
                @error('social_contact')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Ganti Password --}}
            <div class="col-12 mt-2">
                <hr class="my-1">
                <p class="small text-muted mb-3 mt-2">
                    <i class="bi bi-info-circle me-1"></i>
                    Kosongkan kolom password jika tidak ingin menggantinya.
                </p>
            </div>
            <div class="col-md-6 vh-set-input">
                <label class="vh-set-label">Password Baru <span class="text-muted fw-normal">(opsional)</span></label>
                <input type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Minimal 8 karakter"
                       autocomplete="new-password">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 vh-set-input">
                <label class="vh-set-label">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation"
                       class="form-control"
                       placeholder="Ulangi password baru"
                       autocomplete="new-password">
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('admin.dashboard') }}"
               class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
            <button type="submit"
                    class="btn btn-primary vh-btn-teal text-white px-4">
                <i class="bi bi-floppy2 me-1"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>

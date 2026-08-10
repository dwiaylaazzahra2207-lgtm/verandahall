<div class="vh-set-card">
    <h2><i class="bi bi-shield-lock text-primary"></i> Keamanan</h2>
    <p class="text-muted small mb-4">
        Ubah password akun admin. Gunakan password minimal 8 karakter.
    </p>

    {{-- Error validation --}}
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

    <form action="{{ route('admin.pengaturan.update-keamanan') }}" method="POST" style="max-width:440px;">
        @csrf

        <div class="vh-set-input mb-3">
            <label class="vh-set-label">Password Saat Ini <span class="text-danger">*</span></label>
            <input type="password" name="current_password"
                   class="form-control @error('current_password') is-invalid @enderror"
                   placeholder="Masukkan password saat ini"
                   required autocomplete="current-password">
            @error('current_password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="vh-set-input mb-3">
            <label class="vh-set-label">Password Baru <span class="text-danger">*</span></label>
            <input type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Minimal 8 karakter"
                   required autocomplete="new-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Minimal 8 karakter.</div>
        </div>

        <div class="vh-set-input mb-4">
            <label class="vh-set-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
            <input type="password" name="password_confirmation"
                   class="form-control"
                   placeholder="Ulangi password baru"
                   required autocomplete="new-password">
        </div>

        <button type="submit" class="btn vh-btn-teal text-white px-4">
            <i class="bi bi-key me-1"></i> Perbarui Password
        </button>
    </form>
</div>

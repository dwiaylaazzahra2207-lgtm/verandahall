<div class="vh-set-card">
    <h2><i class="bi bi-shield-lock text-primary"></i> Keamanan</h2>
    <p class="text-muted small mb-4">Ubah password akun Anda. Gunakan password yang kuat dan belum dipakai di tempat lain.</p>

    <form action="{{ route('user.pengaturan.update-keamanan') }}" method="POST" style="max-width:420px;">
        @csrf
        <div class="vh-set-input mb-3">
            <label class="vh-set-label">Password Saat Ini <span class="text-danger">*</span></label>
            <input type="password" name="current_password"
                   class="form-control @error('current_password') is-invalid @enderror"
                   required autocomplete="current-password">
            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="vh-set-input mb-3">
            <label class="vh-set-label">Password Baru <span class="text-danger">*</span></label>
            <input type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   required autocomplete="new-password">
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="vh-set-input mb-4">
            <label class="vh-set-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
            <input type="password" name="password_confirmation"
                   class="form-control" required autocomplete="new-password">
        </div>
        <button type="submit" class="btn vh-btn-primary px-4">
            <i class="bi bi-key me-1"></i> Perbarui Password
        </button>
    </form>
</div>

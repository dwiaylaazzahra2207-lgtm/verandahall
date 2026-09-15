@csrf
@if($mode === 'edit')
    @method('PUT')
@endif

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Nama gedung</label>
        <input type="text" name="nama" value="{{ old('nama', $gedung->nama ?? '') }}" class="form-control rounded-3 @error('nama') is-invalid @enderror" required>
        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
        <label class="form-label small fw-semibold">Kapasitas (orang)</label>
        <input type="number" name="kapasitas" min="1" value="{{ old('kapasitas', $gedung->kapasitas ?? 1) }}" class="form-control rounded-3 @error('kapasitas') is-invalid @enderror" required>
        @error('kapasitas')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
        <label class="form-label small fw-semibold">Harga per jam (Rp)</label>
        <input type="number" name="harga" min="0" step="0.01" value="{{ old('harga', $gedung->harga ?? 0) }}" class="form-control rounded-3 @error('harga') is-invalid @enderror" required>
        @error('harga')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Status</label>
        <select name="status" class="form-select rounded-3 @error('status') is-invalid @enderror">
            @php $st = old('status', $gedung->status ?? 'tersedia'); @endphp
            <option value="pending" @selected($st === 'pending')>Pending</option>
            <option value="tersedia" @selected($st === 'tersedia')>Tersedia</option>
            <option value="habis" @selected($st === 'habis')>Habis</option>
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Foto</label>
        <input type="file" name="foto" accept="image/*" class="form-control rounded-3 @error('foto') is-invalid @enderror">
        @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
        @if(!empty($gedung->foto ?? null))
            <div class="small text-muted mt-1">Foto saat ini:</div>
            <img src="{{ asset('storage/'.$gedung->foto) }}" alt="" class="rounded-3 mt-1" style="max-height:120px;">
        @endif
    </div>
    <div class="col-12 mt-1">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="sync_venue" id="sync_venue" value="1" {{ $mode === 'create' ? 'checked' : '' }}>
            <label class="form-check-label small text-muted" for="sync_venue">
                <i class="bi bi-arrow-repeat me-1 text-primary"></i> Hubungkan & perbarui foto/nama ke <strong>Manajemen Venue (Pengaturan)</strong>
            </label>
        </div>
    </div>
</div>

<div class="mt-4 d-flex gap-2">
    <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan</button>
    <a href="{{ route('admin.gedung.index') }}" class="btn btn-light rounded-pill px-4">Batal</a>
</div>

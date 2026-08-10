@php
    $jamVal = fn ($t) => $t ? substr((string) $t, 0, 5) : '';
@endphp

<div class="vh-set-card">
    <h2><i class="bi bi-clock-history text-primary"></i> Jadwal & Slot Waktu</h2>
    <p class="text-muted small mb-4">Atur jam operasional dan durasi slot waktu per hari.</p>

    {{-- Pilih hari --}}
    <div class="mb-4 vh-set-input" style="max-width:260px;">
        <label class="vh-set-label">Pilih Hari</label>
        <select class="form-select"
                onchange="window.location.href='{{ route('admin.pengaturan.index', ['tab'=>'jadwal']) }}&hari='+this.value">
            @foreach($hariChoices as $key => $label)
                <option value="{{ $key }}" @selected($selectedHari === $key)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

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

    <form action="{{ route('admin.pengaturan.update-jadwal') }}" method="POST">
        @csrf
        <input type="hidden" name="hari" value="{{ $selectedHari }}">

        <div class="row g-3" style="max-width:640px;">
            <div class="col-md-4 vh-set-input">
                <label class="vh-set-label">Jam Buka</label>
                <input type="time" name="jam_buka"
                       class="form-control @error('jam_buka') is-invalid @enderror"
                       value="{{ old('jam_buka', $jamVal($schedule->jam_buka ?? null)) }}">
                @error('jam_buka')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4 vh-set-input">
                <label class="vh-set-label">Jam Tutup</label>
                <input type="time" name="jam_tutup"
                       class="form-control @error('jam_tutup') is-invalid @enderror"
                       value="{{ old('jam_tutup', $jamVal($schedule->jam_tutup ?? null)) }}">
                @error('jam_tutup')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4 vh-set-input">
                <label class="vh-set-label">Slot Waktu (menit)</label>
                <input type="number" name="slot_menit" min="5" max="720"
                       class="form-control @error('slot_menit') is-invalid @enderror"
                       value="{{ old('slot_menit', $schedule->slot_menit) }}"
                       placeholder="60">
                <div class="form-text">Durasi per slot (5–720 menit).</div>
                @error('slot_menit')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('admin.pengaturan.index', ['tab' => 'jadwal', 'hari' => $selectedHari]) }}"
               class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
            <button type="submit" class="btn vh-btn-teal text-white px-4">
                <i class="bi bi-floppy2 me-1"></i> Simpan Jadwal
            </button>
        </div>
    </form>
</div>

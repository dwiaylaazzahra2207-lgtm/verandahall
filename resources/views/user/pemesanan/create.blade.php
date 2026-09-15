@extends('layouts.user')

@section('title', 'Form Pemesanan')
@section('page-title', 'Pesan Gedung')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap');

    .fb-wrap { font-family:'Sora',sans-serif; }

    /* ── Header ── */
    .fb-header {
        background:linear-gradient(135deg,#0f172a 0%,#1e293b 60%,#0f2a4a 100%);
        border-radius:20px;
        padding:26px 30px;
        margin-bottom:28px;
        position:relative; overflow:hidden;
        display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:12px;
    }
    .fb-header::before {
        content:''; position:absolute; top:-50px; right:-50px;
        width:220px; height:220px;
        background:radial-gradient(circle,rgba(99,179,237,.15) 0%,transparent 70%);
        pointer-events:none;
    }
    .fb-header::after {
        content:''; position:absolute; bottom:-40px; left:80px;
        width:150px; height:150px;
        background:radial-gradient(circle,rgba(56,189,248,.1) 0%,transparent 70%);
        pointer-events:none;
    }
    .fb-header-left { position:relative; z-index:1; }
    .fb-header-left h1 { color:#f1f5f9; font-size:1.25rem; font-weight:700; margin:0 0 4px; letter-spacing:-.3px; }
    .fb-header-left p  { color:#94a3b8; font-size:.8rem; margin:0; }
    .fb-back-btn {
        display:inline-flex; align-items:center; gap:6px;
        padding:8px 18px;
        background:rgba(255,255,255,.1);
        border:1px solid rgba(255,255,255,.15);
        color:#e2e8f0 !important;
        border-radius:50px;
        font-size:.78rem; font-weight:600;
        text-decoration:none;
        transition:background .15s;
        backdrop-filter:blur(4px);
        position:relative; z-index:1;
        white-space:nowrap;
    }
    .fb-back-btn:hover { background:rgba(255,255,255,.2); }

    /* ── Form Card ── */
    .fb-card {
        background:#fff;
        border-radius:20px;
        border:1.5px solid #f1f5f9;
        box-shadow:0 2px 24px rgba(15,23,42,.06);
        overflow:hidden;
    }
    .fb-card-body { padding:28px 28px; }

    /* ── Section title ── */
    .fb-section {
        display:flex; align-items:center; gap:10px;
        margin:0 0 18px;
    }
    .fb-section-icon {
        width:32px; height:32px;
        background:linear-gradient(135deg,#0f172a,#1e293b);
        border-radius:9px;
        display:flex; align-items:center; justify-content:center;
        font-size:.85rem; flex-shrink:0;
        color:#fff;
    }
    .fb-section h6 { font-size:.82rem; font-weight:700; color:#0f172a; margin:0; text-transform:uppercase; letter-spacing:.5px; }
    .fb-section-line { flex:1; height:1px; background:#f1f5f9; }

    .fb-spacer { height:1px; background:#f1f5f9; margin:24px 0; }

    /* ── Labels & Inputs ── */
    .fb-label {
        font-size:.72rem; font-weight:700;
        color:#64748b; text-transform:uppercase; letter-spacing:.5px;
        display:block; margin-bottom:7px;
    }
    .fb-label .req { color:#f43f5e; margin-left:2px; }
    .fb-label .opt { color:#94a3b8; font-weight:400; text-transform:none; letter-spacing:0; font-size:.72rem; }

    .fb-control {
        width:100%;
        border:1.5px solid #e2e8f0;
        border-radius:12px;
        padding:10px 14px;
        font-size:.85rem;
        font-family:'Sora',sans-serif;
        color:#334155;
        background:#fff;
        outline:none;
        transition:border-color .15s, box-shadow .15s;
        box-sizing:border-box;
        appearance:none;
    }
    .fb-control:focus {
        border-color:#0f172a;
        box-shadow:0 0 0 3px rgba(15,23,42,.08);
    }
    .fb-control.is-invalid { border-color:#f43f5e; }
    .fb-control.is-invalid:focus { box-shadow:0 0 0 3px rgba(244,63,94,.1); }
    .invalid-feedback { font-size:.73rem; color:#f43f5e; margin-top:5px; display:block; }

    select.fb-control { background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 14px center; padding-right:36px; }

    textarea.fb-control { resize:vertical; min-height:90px; }

    /* ── Availability badge ── */
    #availabilityStatus { display:none; margin-top:8px; }
    .av-badge {
        display:inline-flex; align-items:center; gap:6px;
        padding:5px 14px; border-radius:50px;
        font-size:.75rem; font-weight:600;
    }
    .av-badge::before { content:''; width:6px; height:6px; border-radius:50%; }
    .av-available   { background:#f0fdf4; color:#15803d; } .av-available::before   { background:#22c55e; }
    .av-unavailable { background:#fff1f2; color:#be123c; } .av-unavailable::before { background:#f43f5e; }
    .av-checking    { background:#fefce8; color:#a16207; } .av-checking::before    { background:#eab308; animation:pulse 1s infinite; }
    @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }

    /* ── Submit bar ── */
    .fb-submit-bar {
        display:flex; gap:10px; flex-wrap:wrap;
        padding:20px 28px;
        background:#f8fafc;
        border-top:1.5px solid #f1f5f9;
    }
    .fb-btn-cancel {
        padding:10px 24px; border-radius:50px;
        background:#fff; border:1.5px solid #e2e8f0;
        color:#64748b; font-size:.82rem; font-weight:600;
        font-family:'Sora',sans-serif;
        cursor:pointer; text-decoration:none;
        display:inline-flex; align-items:center;
        transition:background .15s;
    }
    .fb-btn-cancel:hover { background:#f1f5f9; color:#334155; }
    .fb-btn-submit {
        flex:1; min-width:180px;
        padding:10px 28px; border-radius:50px;
        background:linear-gradient(135deg,#0f172a,#1e3a5f);
        border:none; color:#f8fafc;
        font-size:.85rem; font-weight:700;
        font-family:'Sora',sans-serif;
        cursor:pointer;
        display:inline-flex; align-items:center; justify-content:center; gap:7px;
        transition:opacity .15s, transform .1s;
    }
    .fb-btn-submit:hover:not(:disabled) { opacity:.9; transform:translateY(-1px); }
    .fb-btn-submit:disabled { opacity:.45; cursor:not-allowed; transform:none; }

    /* ── Sidebar ── */

    /* Gedung preview */
    .fb-preview {
        background:#fff;
        border-radius:20px;
        border:1.5px solid #f1f5f9;
        box-shadow:0 2px 20px rgba(15,23,42,.06);
        overflow:hidden;
        display:none;
        margin-bottom:16px;
    }
    .fb-preview.show { display:block; }
    .fb-preview-img {
        width:100%; height:170px;
        object-fit:cover; display:block;
    }
    .fb-preview-placeholder {
        width:100%; height:170px;
        background:linear-gradient(135deg,#0f172a,#1e3a5f);
        display:flex; align-items:center; justify-content:center;
        font-size:2.5rem; opacity:.35;
    }
    .fb-preview-body { padding:16px 18px; }
    .fb-preview-name { font-size:.95rem; font-weight:700; color:#0f172a; margin-bottom:12px; }
    .fb-preview-meta { display:flex; flex-direction:column; gap:7px; }
    .fb-preview-row {
        display:flex; justify-content:space-between; align-items:center;
        font-size:.78rem;
    }
    .fb-preview-row-label { color:#94a3b8; font-weight:500; }
    .fb-preview-row-val   { color:#0f172a; font-weight:700; }
    .fb-preview-row-val.price { color:#0369a1; }
    .fb-preview-divider { height:1px; background:#f1f5f9; }

    /* Info box */
    .fb-info {
        background:#fff;
        border-radius:20px;
        border:1.5px solid #f1f5f9;
        box-shadow:0 2px 20px rgba(15,23,42,.06);
        padding:20px 20px;
    }
    .fb-info-title { font-size:.78rem; font-weight:700; color:#0f172a; text-transform:uppercase; letter-spacing:.5px; margin-bottom:14px; display:flex; align-items:center; gap:7px; }
    .fb-info-title-dot { width:8px; height:8px; border-radius:50%; background:linear-gradient(135deg,#38bdf8,#6366f1); flex-shrink:0; }
    .fb-info-item {
        display:flex; align-items:flex-start; gap:9px;
        font-size:.78rem; color:#64748b; line-height:1.5;
        padding:7px 0;
        border-bottom:1px solid #f8fafc;
    }
    .fb-info-item:last-child { border-bottom:none; }
    .fb-info-dot { width:18px; height:18px; background:#f0fdf4; border-radius:5px; display:flex; align-items:center; justify-content:center; font-size:.6rem; flex-shrink:0; margin-top:1px; }
</style>
@endpush

@section('content')
<div class="fb-wrap">

    {{-- Header --}}
    <div class="fb-header">
        <div class="fb-header-left">
            <h1>Form Pemesanan</h1>
            <p>Lengkapi informasi di bawah untuk memesan gedung</p>
        </div>
        <a href="{{ route('user.pemesanan.index') }}" class="fb-back-btn">← Kembali</a>
    </div>

    <div class="row g-4">

        {{-- ── Kolom Form ── --}}
        <div class="col-lg-8">
            <div class="fb-card">
                <form action="{{ route('user.pemesanan.store') }}" method="POST" id="bookingForm">
                    @csrf
                    <div class="fb-card-body">

                        {{-- Pilih Gedung --}}
                        <div class="fb-section">
                            <div class="fb-section-icon">🏛️</div>
                            <h6>Pilih Gedung</h6>
                            <div class="fb-section-line"></div>
                        </div>
                        <div class="mb-4">
                            <label class="fb-label">Gedung <span class="req">*</span></label>
                            <select name="gedung_id" id="gedungSelect"
                                    class="fb-control @error('gedung_id') is-invalid @enderror" required>
                                <option value="">— Pilih gedung yang tersedia —</option>
                                @foreach($gedungs as $g)
                                    <option value="{{ $g->id }}"
                                            data-nama="{{ $g->nama }}"
                                            data-kapasitas="{{ $g->kapasitas }}"
                                            data-harga="{{ $g->harga }}"
                                            data-foto="{{ $g->foto ? asset('storage/'.$g->foto) : '' }}"
                                            {{ (old('gedung_id', $gedung?->id) == $g->id) ? 'selected' : '' }}>
                                        {{ $g->nama }} — Rp {{ number_format($g->harga, 0, ',', '.') }}/hari
                                    </option>
                                @endforeach
                            </select>
                            @error('gedung_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="fb-spacer"></div>

                        {{-- Tanggal & Waktu --}}
                        <div class="fb-section">
                            <div class="fb-section-icon">📅</div>
                            <h6>Tanggal & Waktu</h6>
                            <div class="fb-section-line"></div>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <label class="fb-label">Tanggal Acara <span class="req">*</span></label>
                                <input type="date" name="tanggal_booking" id="tanggalInput"
                                       class="fb-control @error('tanggal_booking') is-invalid @enderror"
                                       value="{{ old('tanggal_booking') }}"
                                       min="{{ date('Y-m-d') }}" required>
                                @error('tanggal_booking')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div id="availabilityStatus"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="fb-label">Jam Mulai <span class="req">*</span></label>
                                <input type="time" name="jam_mulai"
                                       class="fb-control @error('jam_mulai') is-invalid @enderror"
                                       value="{{ old('jam_mulai', '08:00') }}" required>
                                @error('jam_mulai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="fb-label">Jam Selesai <span class="opt">(opsional)</span></label>
                                <input type="time" name="jam_selesai"
                                       class="fb-control @error('jam_selesai') is-invalid @enderror"
                                       value="{{ old('jam_selesai', '17:00') }}">
                                @error('jam_selesai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="fb-spacer"></div>

                        {{-- Detail Acara --}}
                        <div class="fb-section">
                            <div class="fb-section-icon">📝</div>
                            <h6>Detail Acara</h6>
                            <div class="fb-section-line"></div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="fb-label">Nama Acara <span class="req">*</span></label>
                                <input type="text" name="nama_acara"
                                       class="fb-control @error('nama_acara') is-invalid @enderror"
                                       value="{{ old('nama_acara') }}"
                                       placeholder="Pernikahan, Seminar, Ulang Tahun…" required>
                                @error('nama_acara')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="fb-label">Jumlah Orang <span class="req">*</span></label>
                                <input type="number" name="jumlah_orang"
                                       class="fb-control @error('jumlah_orang') is-invalid @enderror"
                                       value="{{ old('jumlah_orang') }}"
                                       placeholder="100" min="1" required>
                                @error('jumlah_orang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="fb-label">Catatan Tambahan <span class="opt">(opsional)</span></label>
                                <textarea name="catatan"
                                          class="fb-control @error('catatan') is-invalid @enderror"
                                          placeholder="Kebutuhan khusus, dekorasi, permintaan lainnya…">{{ old('catatan') }}</textarea>
                                @error('catatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                    </div>{{-- /card-body --}}

                    {{-- Submit bar --}}
                    <div class="fb-submit-bar">
                        <a href="{{ route('user.pemesanan.index') }}" class="fb-btn-cancel">Batal</a>
                        <button type="submit" class="fb-btn-submit" id="submitBtn">
                            <i class="bi bi-send-fill"></i> Kirim Pemesanan
                        </button>
                    </div>

                </form>
            </div>
        </div>

        {{-- ── Sidebar ── --}}
        <div class="col-lg-4">

            {{-- Preview gedung --}}
            <div class="fb-preview" id="gedungPreview">
                <div id="previewFotoWrap"></div>
                <div class="fb-preview-body">
                    <div class="fb-preview-name" id="previewNama"></div>
                    <div class="fb-preview-meta">
                        <div class="fb-preview-row">
                            <span class="fb-preview-row-label">Kapasitas</span>
                            <span class="fb-preview-row-val" id="previewKapasitas"></span>
                        </div>
                        <div class="fb-preview-divider"></div>
                        <div class="fb-preview-row">
                            <span class="fb-preview-row-label">Harga Sewa</span>
                            <span class="fb-preview-row-val price" id="previewHarga"></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Info box --}}
            <div class="fb-info">
                <div class="fb-info-title"><span class="fb-info-title-dot"></span> Informasi Pemesanan</div>
                <div class="fb-info-item">
                    <div class="fb-info-dot">✓</div>
                    Pemesanan akan diverifikasi oleh admin sebelum dikonfirmasi
                </div>
                <div class="fb-info-item">
                    <div class="fb-info-dot">⏳</div>
                    Status awal booking adalah <strong>Menunggu Persetujuan</strong>
                </div>
                <div class="fb-info-item">
                    <div class="fb-info-dot">🔔</div>
                    Notifikasi akan dikirim setelah booking diproses
                </div>
                <div class="fb-info-item">
                    <div class="fb-info-dot">📋</div>
                    Pantau status di halaman riwayat pemesanan
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const gedungSelect  = document.getElementById('gedungSelect');
const tanggalInput  = document.getElementById('tanggalInput');
const gedungPreview = document.getElementById('gedungPreview');
const availStatus   = document.getElementById('availabilityStatus');
const submitBtn     = document.getElementById('submitBtn');

let checkTimeout = null;

gedungSelect.addEventListener('change', function () {
    const opt = this.options[this.selectedIndex];
    if (!opt.value) { gedungPreview.classList.remove('show'); return; }

    const foto = opt.dataset.foto;
    document.getElementById('previewFotoWrap').innerHTML = foto
        ? `<img src="${foto}" class="fb-preview-img" alt="">`
        : `<div class="fb-preview-placeholder">🏛️</div>`;
    document.getElementById('previewNama').textContent = opt.dataset.nama;
    document.getElementById('previewKapasitas').textContent = parseInt(opt.dataset.kapasitas).toLocaleString('id') + ' orang';
    document.getElementById('previewHarga').textContent = 'Rp ' + parseFloat(opt.dataset.harga).toLocaleString('id', {minimumFractionDigits:0}) + ' / hari';
    gedungPreview.classList.add('show');
    checkAvailability();
});

tanggalInput.addEventListener('change', function () {
    clearTimeout(checkTimeout);
    checkTimeout = setTimeout(checkAvailability, 400);
});

document.querySelector('[name="jam_mulai"]').addEventListener('change', checkAvailability);

document.querySelector('[name="jam_selesai"]').addEventListener('change', checkAvailability);

function checkAvailability() {
    const gedungId = gedungSelect.value;
    const tanggal = tanggalInput.value;
    const jamMulai = document.querySelector('[name="jam_mulai"]').value;
    const jamSelesai = document.querySelector('[name="jam_selesai"]').value;

    if (!gedungId || !tanggal || !jamMulai) return;

    availStatus.style.display = 'block';
    availStatus.innerHTML = '<span class="av-badge av-checking">Memeriksa ketersediaan…</span>';
    submitBtn.disabled = true;

fetch('{{ route("user.pemesanan.check") }}', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
    },
    body: JSON.stringify({
        gedung_id: gedungId,
        tanggal_booking: tanggal,
        jam_mulai: jamMulai,
        jam_selesai: jamSelesai || null,
    }),
})
    .then(r => r.json())
    .then(data => {
        availStatus.style.display = 'block';
        if (data.available) {
            availStatus.innerHTML = `<span class="av-badge av-available">${data.message}</span>`;
            submitBtn.disabled = false;
        } else {
            availStatus.innerHTML = `<span class="av-badge av-unavailable">${data.message}</span>`;
            submitBtn.disabled = true;
        }
    })
    .catch(() => { availStatus.style.display = 'none'; submitBtn.disabled = false; });
}

if (gedungSelect.value) gedungSelect.dispatchEvent(new Event('change'));
</script>
@endpush
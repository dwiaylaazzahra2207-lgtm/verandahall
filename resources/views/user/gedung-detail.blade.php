@extends('layouts.user')

@section('title', $gedung->nama)
@section('page-title', 'Detail Gedung')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('user.pemesanan.index') }}" class="btn btn-light rounded-pill btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
    <div>
        <h5 class="fw-bold mb-0">{{ $gedung->nama }}</h5>
        <p class="text-muted small mb-0">Detail informasi gedung</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="bg-white rounded-4 shadow-sm overflow-hidden">
            @if($gedung->foto)
                <img src="{{ asset('storage/' . $gedung->foto) }}" alt="{{ $gedung->nama }}"
                     style="width:100%; height:320px; object-fit:cover;">
            @else
                <div style="width:100%;height:320px;background:linear-gradient(135deg,#0f2235,#1e6fba);display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-buildings" style="font-size:5rem;color:rgba(255,255,255,.3);"></i>
                </div>
            @endif
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h4 class="fw-bold mb-0">{{ $gedung->nama }}</h4>
                    @if($gedung->status === 'tersedia')
                        <span class="badge rounded-pill" style="background:#dcfce7;color:#16a34a;font-size:.78rem;padding:5px 14px;">Tersedia</span>
                    @else
                        <span class="badge rounded-pill" style="background:#fee2e2;color:#dc2626;font-size:.78rem;padding:5px 14px;">Tidak Tersedia</span>
                    @endif
                </div>
                <dl class="row small mb-0">
                    <dt class="col-sm-4 text-muted">Kapasitas</dt>
                    <dd class="col-sm-8 fw-semibold">{{ number_format($gedung->kapasitas) }} orang</dd>
                    <dt class="col-sm-4 text-muted">Harga</dt>
                    <dd class="col-sm-8 fw-bold" style="color:#1e6fba;">Rp {{ number_format($gedung->harga, 0, ',', '.') }} / hari</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="bg-white rounded-4 shadow-sm p-4">
            <h6 class="fw-bold mb-3">Pesan Gedung Ini</h6>
            @if($gedung->status === 'tersedia')
                <p class="text-muted small mb-4">Gedung ini tersedia untuk dipesan. Klik tombol di bawah untuk melanjutkan pemesanan.</p>
                <a href="{{ route('user.pemesanan.create', ['gedung_id' => $gedung->id]) }}"
                   class="btn w-100 rounded-pill fw-semibold text-white py-2"
                   style="background:#0f2235;">
                    <i class="bi bi-calendar-plus me-2"></i> Pesan Sekarang
                </a>
            @else
                <div class="alert alert-warning rounded-3 small">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    Gedung ini sedang tidak tersedia untuk dipesan.
                </div>
            @endif
        </div>

        <div class="bg-white rounded-4 shadow-sm p-4 mt-3">
            <h6 class="fw-bold mb-3" style="font-size:.9rem;">
                <i class="bi bi-info-circle text-primary me-1"></i> Ketentuan Pemesanan
            </h6>
            <ul class="list-unstyled small text-muted mb-0" style="line-height:2;">
                <li><i class="bi bi-dot"></i> Pemesanan minimal 1 hari sebelumnya</li>
                <li><i class="bi bi-dot"></i> Pembatalan maksimal H-3</li>
                <li><i class="bi bi-dot"></i> Kapasitas tidak boleh melebihi batas</li>
                <li><i class="bi bi-dot"></i> Dilarang membawa bahan berbahaya</li>
            </ul>
        </div>
    </div>
</div>

@endsection

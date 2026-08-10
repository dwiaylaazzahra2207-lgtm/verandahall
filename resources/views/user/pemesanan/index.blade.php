@extends('layouts.user')

@section('title', 'Pilih Gedung')
@section('page-title', 'Pesan Gedung')

@push('styles')
<style>
    .gedung-card {
        background: #fff;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(15,34,53,.06);
        transition: transform .2s, box-shadow .2s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .gedung-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(15,34,53,.12);
    }
    .gedung-card img {
        width: 100%; height: 200px;
        object-fit: cover;
    }
    .gedung-card-body {
        padding: 1.1rem 1.25rem 1.25rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .gedung-name { font-weight: 700; font-size: 1rem; color: #1a2b3c; margin-bottom: .3rem; }
    .gedung-meta { font-size: .82rem; color: #7a93ad; }
    .gedung-price { font-weight: 800; color: #1e6fba; font-size: 1.05rem; }
    .badge-tersedia { background: #dcfce7; color: #16a34a; font-size: .7rem; padding: 3px 10px; border-radius: 20px; font-weight: 600; }
    .badge-habis    { background: #fee2e2; color: #dc2626; font-size: .7rem; padding: 3px 10px; border-radius: 20px; font-weight: 600; }
</style>
@endpush

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Pilih Gedung</h5>
        <p class="text-muted small mb-0">Pilih gedung yang ingin Anda pesan</p>
    </div>
</div>

@if($gedungs->isEmpty())
    <div class="text-center py-5 text-muted bg-white rounded-4 shadow-sm">
        <i class="bi bi-building-x" style="font-size:3rem;"></i>
        <p class="mt-3">Belum ada gedung tersedia saat ini.</p>
        <p class="small">Silakan coba lagi nanti atau hubungi admin.</p>
    </div>
@else
    <div class="row g-4">
        @foreach($gedungs as $gedung)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="gedung-card">
                @if($gedung->foto)
                    <img src="{{ asset('storage/' . $gedung->foto) }}" alt="{{ $gedung->nama }}">
                @else
                    <div style="width:100%;height:200px;background:linear-gradient(135deg,#0f2235,#1e6fba);display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-buildings" style="font-size:3.5rem;color:rgba(255,255,255,.4);"></i>
                    </div>
                @endif
                <div class="gedung-card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="gedung-name">{{ $gedung->nama }}</div>
                        <span class="badge-tersedia">Tersedia</span>
                    </div>
                    <div class="gedung-meta mb-1">
                        <i class="bi bi-people-fill me-1"></i>Kapasitas {{ number_format($gedung->kapasitas) }} orang
                    </div>
                    <div class="mt-auto pt-3 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="gedung-price">Rp {{ number_format($gedung->harga, 0, ',', '.') }}</div>
                            <div style="font-size:.72rem; color:#7a93ad;">per hari</div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('user.gedung.show', $gedung) }}"
                               class="btn btn-outline-secondary btn-sm rounded-pill px-3" style="font-size:.78rem;">
                                Detail
                            </a>
                            <a href="{{ route('user.pemesanan.create', ['gedung_id' => $gedung->id]) }}"
                               class="btn btn-sm rounded-pill px-3 fw-semibold"
                               style="background:#0f2235;color:#fff;font-size:.78rem;">
                                Pesan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

@endsection

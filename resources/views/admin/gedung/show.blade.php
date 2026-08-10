@extends('layouts.admin')

@section('title', $gedung->nama)

@push('styles')
@include('partials.admin-crud-styles')
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-start mb-3">
    <div>
        <h1 class="h5 fw-bold mb-1" style="font-family:'Plus Jakarta Sans',sans-serif;">{{ $gedung->nama }}</h1>
        <p class="text-muted small mb-0">Kapasitas {{ number_format($gedung->kapasitas) }} orang · {{ number_format((float) $gedung->harga, 0, ',', '.') }}/jam</p>
    </div>
    <a href="{{ route('admin.gedung.edit', $gedung) }}" class="btn btn-outline-primary rounded-pill">Edit</a>
</div>

<div class="row g-3">
    <div class="col-lg-5">
        <div class="card rounded-4 border-0 shadow-sm overflow-hidden">
            @if($gedung->foto)
                <img src="{{ asset('storage/'.$gedung->foto) }}" class="w-100" style="max-height:280px;object-fit:cover;" alt="">
            @else
                <div class="bg-light d-flex align-items-center justify-content-center text-muted" style="height:220px;"><i class="bi bi-image fs-1"></i></div>
            @endif
            <div class="card-body">
                @if($gedung->status === 'pending')
                    <span class="badge-vh-pending">{{ \App\Models\Gedung::statusLabel($gedung->status) }}</span>
                @elseif($gedung->status === 'tersedia')
                    <span class="badge-vh-tersedia">{{ \App\Models\Gedung::statusLabel($gedung->status) }}</span>
                @else
                    <span class="badge-vh-habis">{{ \App\Models\Gedung::statusLabel($gedung->status) }}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card rounded-4 border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Booking terbaru</h6>
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead><tr><th>Tanggal</th><th>User</th><th>Status</th></tr></thead>
                        <tbody>
                            @forelse($gedung->bookings()->latest()->limit(8)->with('user')->get() as $b)
                                <tr>
                                    <td>{{ optional($b->tanggal_booking)->format('d/m/Y') }}</td>
                                    <td>{{ $b->user?->name }}</td>
                                    <td><span class="small">{{ \App\Models\Booking::statusLabel($b->status) }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-muted small">Belum ada booking.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('admin.gedung.index') }}" class="small text-decoration-none">← Kembali ke daftar</a>
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Notifikasi')

@section('content')
<h1 class="h5 fw-bold mb-3" style="font-family:'Plus Jakarta Sans',sans-serif;">Notifikasi</h1>

<div class="card rounded-4 border-0 shadow-sm">
    <div class="list-group list-group-flush">
        @forelse($notifikasi as $n)
            <div class="list-group-item px-4 py-3 {{ !$n->is_read ? 'bg-light' : '' }}">
                <div class="d-flex justify-content-between gap-2">
                    <div>
                        <div class="fw-semibold">{{ $n->title }}</div>
                        <div class="text-muted small">{{ $n->message }}</div>
                        <div class="text-muted mt-1" style="font-size:.75rem;">{{ $n->created_at->diffForHumans() }}</div>
                    </div>
                    @if(!$n->is_read)
                        <span class="badge bg-danger rounded-pill align-self-start">Baru</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="p-5 text-center text-muted small">Belum ada notifikasi.</div>
        @endforelse
    </div>
</div>
@endsection

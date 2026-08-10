@extends('layouts.user')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan')

@push('styles')
<style>
    .vh-set-wrap { max-width: 900px; }
    .vh-set-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: .25rem 1.25rem;
        padding: 0 .25rem 1rem;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 1.25rem;
    }
    .vh-set-tabs a {
        text-decoration: none;
        color: #64748b;
        font-weight: 600;
        font-size: .88rem;
        padding-bottom: .5rem;
        border-bottom: 3px solid transparent;
        margin-bottom: -1px;
        transition: color .15s;
    }
    .vh-set-tabs a:hover { color: #0f2235; }
    .vh-set-tabs a.active { color: #0f2235; border-bottom-color: #1e6fba; }

    .vh-set-card {
        background: #fff;
        border-radius: 1.25rem;
        box-shadow: 0 4px 24px rgba(15,34,53,.06);
        padding: 1.75rem;
    }
    .vh-set-card h2 {
        font-weight: 700;
        font-size: 1.05rem;
        color: #0f2235;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }
    .vh-set-label { font-weight: 600; font-size: .82rem; color: #1e3a4c; margin-bottom: .35rem; }
    .vh-set-input .form-control, .vh-set-input .form-select {
        border-radius: .75rem;
        border-color: #e2e8f0;
        font-size: .9rem;
    }
    .vh-btn-primary {
        background: #0f2235 !important;
        border: none !important;
        border-radius: .75rem !important;
        font-weight: 600;
        padding: .5rem 1.5rem !important;
        color: #fff !important;
    }
    .vh-btn-primary:hover { background: #1e3a4c !important; }
    .vh-btn-soft {
        background: #e0f2fe !important;
        color: #0369a1 !important;
        border: none !important;
        border-radius: .75rem !important;
        font-weight: 600;
    }
</style>
@endpush

@section('content')

@php
    $tabUrl = fn (string $t) => route('user.pengaturan.index', ['tab' => $t]);
@endphp

<div class="vh-set-wrap">
    <h5 class="fw-bold mb-3">Pengaturan Akun</h5>

    <nav class="vh-set-tabs">
        <a href="{{ $tabUrl('profil') }}" class="{{ $tab === 'profil' ? 'active' : '' }}">Profil</a>
        <a href="{{ $tabUrl('keamanan') }}" class="{{ $tab === 'keamanan' ? 'active' : '' }}">Keamanan</a>
        <a href="{{ $tabUrl('notifikasi') }}" class="{{ $tab === 'notifikasi' ? 'active' : '' }}">Notifikasi</a>
        <a href="{{ $tabUrl('bantuan') }}" class="{{ $tab === 'bantuan' ? 'active' : '' }}">Bantuan & Support</a>
    </nav>

    @if($tab === 'profil')
        @include('user.pengaturan.tabs.profil')
    @elseif($tab === 'keamanan')
        @include('user.pengaturan.tabs.keamanan')
    @elseif($tab === 'notifikasi')
        @include('user.pengaturan.tabs.notifikasi')
    @else
        @include('user.pengaturan.tabs.bantuan')
    @endif
</div>

@endsection

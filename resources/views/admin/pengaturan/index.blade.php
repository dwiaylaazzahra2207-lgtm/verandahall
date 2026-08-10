@extends('layouts.admin')

@section('title', 'Pengaturan')

@push('styles')
<style>
    .vh-set-wrap { max-width: 1100px; margin: 0 auto; }
    .vh-set-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 0.25rem 1.25rem;
        padding: 0 0.25rem 1rem;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 1.25rem;
    }
    .vh-set-tabs a {
        text-decoration: none;
        color: #64748b;
        font-weight: 600;
        font-size: 0.88rem;
        padding-bottom: 0.5rem;
        border-bottom: 3px solid transparent;
        margin-bottom: -1px;
        transition: color .15s ease;
    }
    .vh-set-tabs a:hover { color: #0f2235; }
    .vh-set-tabs a.active {
        color: #0f2235;
        border-bottom-color: #1e6fba;
    }
    .vh-set-card {
        background: #fff;
        border-radius: 1.25rem;
        box-shadow: 0 4px 24px rgba(15, 34, 53, 0.06);
        padding: 1.75rem;
    }
    .vh-set-card h2 {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 1.1rem;
        color: #0f2235;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .vh-set-label { font-weight: 600; font-size: 0.82rem; color: #1e3a4c; margin-bottom: 0.35rem; }
    .vh-set-input .form-control, .vh-set-input .form-select {
        border-radius: 0.75rem;
        border-color: #e2e8f0;
        font-size: 0.9rem;
    }
    .vh-btn-teal {
        background: #1e4976 !important;
        border: none !important;
        border-radius: 0.75rem !important;
        font-weight: 600;
        padding: 0.5rem 1.25rem !important;
    }
    .vh-btn-teal:hover { background: #163a5f !important; color: #fff !important; }
    .vh-btn-soft {
        background: #e0f2fe !important;
        color: #0369a1 !important;
        border: none !important;
        border-radius: 0.75rem !important;
        font-weight: 600;
    }
    .vh-upload-zone {
        border: 2px dashed #cbd5e1;
        border-radius: 1rem;
        min-height: 200px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: #f8fafc;
        color: #94a3b8;
    }
</style>
@endpush

@section('content')
@php
    $tabUrl = fn (string $t, array $query = []) => route('admin.pengaturan.index', array_merge(['tab' => $t], $query));
@endphp

<div class="vh-set-wrap">
    <h1 class="h5 fw-bold mb-3" style="font-family:'Plus Jakarta Sans',sans-serif;">Pengaturan</h1>

    <nav class="vh-set-tabs">
        <a href="{{ $tabUrl('profil') }}" class="{{ $tab === 'profil' ? 'active' : '' }}">Profil Akun</a>
        <a href="{{ $tabUrl('venue') }}" class="{{ $tab === 'venue' ? 'active' : '' }}">Manajemen Venue</a>
        <a href="{{ $tabUrl('jadwal', ['hari' => $selectedHari ?? 'senin']) }}" class="{{ $tab === 'jadwal' ? 'active' : '' }}">Jadwal & Slot Waktu</a>
        <a href="{{ $tabUrl('notifikasi') }}" class="{{ $tab === 'notifikasi' ? 'active' : '' }}">Notifikasi</a>
        <a href="{{ $tabUrl('keamanan') }}" class="{{ $tab === 'keamanan' ? 'active' : '' }}">Keamanan</a>
        <a href="{{ $tabUrl('bantuan') }}" class="{{ $tab === 'bantuan' ? 'active' : '' }}">Pusat Bantuan</a>
    </nav>

    @if($tab === 'profil')
        @include('admin.pengaturan.tabs.profil')
    @elseif($tab === 'venue')
        @include('admin.pengaturan.tabs.venue')
    @elseif($tab === 'jadwal')
        @include('admin.pengaturan.tabs.jadwal')
    @elseif($tab === 'notifikasi')
        @include('admin.pengaturan.tabs.notifikasi')
    @elseif($tab === 'keamanan')
        @include('admin.pengaturan.tabs.keamanan')
    @else
        @include('admin.pengaturan.tabs.bantuan')
    @endif
</div>
@endsection

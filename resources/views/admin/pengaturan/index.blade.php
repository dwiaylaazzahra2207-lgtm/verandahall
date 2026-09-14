@extends('layouts.admin')

@section('title', 'Pengaturan')

@push('styles')
<style>
    .vh-set-wrap {
        max-width: 1100px;
        margin: 0 auto;
    }

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
        transition: color 0.15s ease, border-color 0.15s ease;
    }

    .vh-set-tabs a:hover {
        color: #0f2235;
    }

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

    .vh-set-label {
        font-weight: 600;
        font-size: 0.82rem;
        color: #1e3a4c;
        margin-bottom: 0.35rem;
    }

    .vh-set-input .form-control,
    .vh-set-input .form-select {
        border-radius: 0.75rem;
        border-color: #e2e8f0;
        font-size: 0.9rem;
    }

    .vh-set-input .form-control:focus,
    .vh-set-input .form-select:focus {
        border-color: #1e6fba;
        box-shadow: 0 0 0 0.2rem rgba(30, 111, 186, 0.12);
    }

    .vh-btn-teal {
        background: #1e4976 !important;
        border: none !important;
        border-radius: 0.75rem !important;
        font-weight: 600;
        padding: 0.5rem 1.25rem !important;
    }

    .vh-btn-teal:hover {
        background: #163a5f !important;
        color: #fff !important;
    }

    .vh-btn-soft {
        background: #e0f2fe !important;
        color: #0369a1 !important;
        border: none !important;
        border-radius: 0.75rem !important;
        font-weight: 600;
    }

    .vh-btn-soft:hover {
        background: #bae6fd !important;
        color: #075985 !important;
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

    @media (max-width: 768px) {
        .vh-set-wrap {
            max-width: 100%;
        }

        .vh-set-card {
            padding: 1.25rem;
        }

        .vh-set-tabs {
            gap: 0.5rem 1rem;
        }

        .vh-set-tabs a {
            font-size: 0.82rem;
        }
    }
</style>
@endpush

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | Tab aktif
    |--------------------------------------------------------------------------
    | Ambil dari controller jika tersedia.
    | Jika tidak ada, ambil dari query string.
    | Default: profil
    */
    $tab = $tab ?? request()->query('tab', 'profil');

    /*
    |--------------------------------------------------------------------------
    | Tab yang diperbolehkan
    |--------------------------------------------------------------------------
    */
    $allowedTabs = [
        'profil',
        'venue',
        'jadwal',
        'notifikasi',
        'keamanan',
        'bantuan',
    ];

    /*
    |--------------------------------------------------------------------------
    | Validasi tab
    |--------------------------------------------------------------------------
    */
    if (!in_array($tab, $allowedTabs, true)) {
        $tab = 'profil';
    }

    /*
    |--------------------------------------------------------------------------
    | Hari yang dipilih
    |--------------------------------------------------------------------------
    */
    $selectedHari = $selectedHari
        ?? request()->query('hari', 'senin');

    /*
    |--------------------------------------------------------------------------
    | URL untuk masing-masing tab
    |--------------------------------------------------------------------------
    */
    $tabUrl = function (string $tabName, array $query = []) {
        return route(
            'admin.pengaturan.index',
            array_merge(
                ['tab' => $tabName],
                $query
            )
        );
    };
@endphp

<div class="vh-set-wrap">

    {{-- Judul halaman --}}
    <h1
        class="h5 fw-bold mb-3"
        style="font-family:'Plus Jakarta Sans', sans-serif;"
    >
        Pengaturan
    </h1>

    {{-- Navigasi Pengaturan --}}
    <nav
        class="vh-set-tabs"
        aria-label="Navigasi Pengaturan"
    >

        {{-- Profil --}}
        <a
            href="{{ $tabUrl('profil') }}"
            class="{{ $tab === 'profil' ? 'active' : '' }}"
            aria-current="{{ $tab === 'profil' ? 'page' : 'false' }}"
        >
            Profil Akun
        </a>

        {{-- Venue --}}
        <a
            href="{{ $tabUrl('venue') }}"
            class="{{ $tab === 'venue' ? 'active' : '' }}"
            aria-current="{{ $tab === 'venue' ? 'page' : 'false' }}"
        >
            Manajemen Venue
        </a>

        {{-- Jadwal --}}
        <a
            href="{{ $tabUrl('jadwal', ['hari' => $selectedHari]) }}"
            class="{{ $tab === 'jadwal' ? 'active' : '' }}"
            aria-current="{{ $tab === 'jadwal' ? 'page' : 'false' }}"
        >
            Jadwal & Slot Waktu
        </a>

        {{-- Notifikasi --}}
        <a
            href="{{ $tabUrl('notifikasi') }}"
            class="{{ $tab === 'notifikasi' ? 'active' : '' }}"
            aria-current="{{ $tab === 'notifikasi' ? 'page' : 'false' }}"
        >
            Notifikasi
        </a>

        {{-- Keamanan --}}
        <a
            href="{{ $tabUrl('keamanan') }}"
            class="{{ $tab === 'keamanan' ? 'active' : '' }}"
            aria-current="{{ $tab === 'keamanan' ? 'page' : 'false' }}"
        >
            Keamanan
        </a>

        {{-- Bantuan --}}
        <a
            href="{{ $tabUrl('bantuan') }}"
            class="{{ $tab === 'bantuan' ? 'active' : '' }}"
            aria-current="{{ $tab === 'bantuan' ? 'page' : 'false' }}"
        >
            Pusat Bantuan
        </a>

    </nav>

    {{-- =========================================================
         KONTEN TAB
         ========================================================= --}}

    @switch($tab)

        {{-- Profil Akun --}}
        @case('profil')
            @include('admin.pengaturan.tabs.profil')
            @break

        {{-- Manajemen Venue --}}
        @case('venue')
            @include('admin.pengaturan.tabs.venue')
            @break

        {{-- Jadwal & Slot Waktu --}}
        @case('jadwal')
            @include('admin.pengaturan.tabs.jadwal')
            @break

        {{-- Notifikasi --}}
        @case('notifikasi')
            @include('admin.pengaturan.tabs.notifikasi')
            @break

        {{-- Keamanan --}}
        @case('keamanan')
            @include('admin.pengaturan.tabs.keamanan')
            @break

        {{-- Pusat Bantuan --}}
        @case('bantuan')
            @include('admin.pengaturan.tabs.bantuan')
            @break

        {{-- Fallback --}}
        @default
            @include('admin.pengaturan.tabs.profil')

    @endswitch

</div>

@endsection

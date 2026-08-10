{{-- Redirect ke beranda user yang baru --}}
@php
    header('Location: ' . route('user.beranda'));
    exit;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VerandaHall</title>
    <meta name="description" content="Platform booking gedung serbaguna dan lapangan olahraga online yang mudah, cepat, dan terpercaya di Sidoarjo.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy: #1a2e42;
            --navy-mid: #1e4060;
            --green: #2da882;
            --green-dark: #249070;
            --green-light: #e1f5ee;
            --blue-light: #f0f6fb;
            --border: #dceaf6;
            --text-muted: #6b8fa8;
            --text-dark: #1a2e42;
        }

        body { font-family: 'DM Sans', sans-serif; color: var(--text-dark); background: var(--blue-light); }

        /* NAVBAR */
        .navbar {
            background: var(--navy);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 48px; height: 64px;
            position: sticky; top: 0; z-index: 999;
        }
        .navbar-brand {
            display: flex; align-items: center; gap: 10px;
            color: #fff; font-family: 'Playfair Display', serif;
            font-size: 20px; font-weight: 700; text-decoration: none;
        }
        .navbar-brand svg { width: 32px; height: 32px; }
        .navbar-links { display: flex; gap: 28px; align-items: center; list-style: none; }
        .navbar-links a { color: #b8cfe0; font-size: 14px; text-decoration: none; transition: color .2s; }
        .navbar-links a:hover { color: #fff; }
        .btn-nav {
            background: var(--green) !important; color: #fff !important;
            padding: 8px 20px; border-radius: 8px; font-weight: 500; transition: background .2s !important;
        }
        .btn-nav:hover { background: var(--green-dark) !important; }

        /* HERO */
        .hero {
            background: linear-gradient(135deg, #1a2e42 0%, #1e4060 60%, #1a5c7a 100%);
            padding: 80px 48px 90px; position: relative; overflow: hidden;
            display: grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items: center;
        }
        .hero::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(ellipse at 70% 50%, rgba(45,168,130,0.18) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-content { position: relative; z-index: 1; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(45,168,130,0.2); border: 1px solid rgba(45,168,130,0.4);
            color: #5cdcb0; font-size: 12px; font-weight: 500;
            padding: 5px 14px; border-radius: 999px; margin-bottom: 20px;
        }
        .hero h1 {
            font-family: 'Playfair Display', serif; font-size: 48px;
            font-weight: 700; line-height: 1.15; color: #fff; margin-bottom: 18px;
        }
        .hero h1 span { color: var(--green); }
        .hero p { color: #b8cfe0; font-size: 16px; line-height: 1.7; margin-bottom: 32px; max-width: 440px; }
        .hero-cta { display: flex; gap: 12px; flex-wrap: wrap; }
        .btn-primary {
            background: var(--green); color: #fff; padding: 13px 28px;
            border-radius: 10px; font-size: 15px; font-weight: 500;
            text-decoration: none; display: inline-block; transition: background .2s, transform .15s;
        }
        .btn-primary:hover { background: var(--green-dark); transform: translateY(-1px); }
        .btn-outline {
            background: transparent; color: #fff; padding: 13px 28px;
            border-radius: 10px; border: 1.5px solid rgba(255,255,255,0.3);
            font-size: 15px; font-weight: 500; text-decoration: none;
            display: inline-block; transition: border-color .2s, background .2s;
        }
        .btn-outline:hover { border-color: #fff; background: rgba(255,255,255,0.07); }
        .hero-stats { display: flex; gap: 28px; margin-top: 36px; }
        .hero-stat strong { display: block; font-size: 28px; font-weight: 700; color: #fff; }
        .hero-stat span { font-size: 12px; color: #7aa8c0; }

        /* Hero visual */
        .hero-visual {
            position: relative; z-index: 1;
            background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.12);
            border-radius: 20px; padding: 24px;
        }
        .hero-visual-label { color: #7aa8c0; font-size: 15px; margin-bottom: 14px; font-weight: 500px; }
        .mini-card {
            background: rgba(255,255,255,0.1); border-radius: 12px;
            padding: 14px 16px; margin-bottom: 10px;
            display: flex; align-items: center; gap: 12px;
        }
        .mini-card:last-child { margin-bottom: 0; }
        .mini-icon {
            width: 40px; height: 40px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; flex-shrink: 0;
        }
        .ic-green { background: rgba(45,168,130,0.3); }
        .ic-orange { background: rgba(244,148,49,0.3); }
        .ic-blue { background: rgba(59,130,246,0.3); }
        .mini-card-title { color: #fff; font-size: 13px; font-weight: 500; }
        .mini-card-sub { color: #7aa8c0; font-size: 11px; }
        .mini-badge {
            margin-left: auto; font-size: 11px; font-weight: 600;
            padding: 3px 10px; border-radius: 999px; white-space: nowrap;
        }
        .badge-green { background: rgba(45,168,130,0.25); color: #5cdcb0; }
        .badge-orange { background: rgba(244,148,49,0.25); color: #f9c06a; }
        .badge-blue { background: rgba(59,130,246,0.25); color: #93c5fd; }
        .mini-card-empty { color: #7aa8c0; font-size: 13px; text-align: center; padding: 20px 0; }

        /* STATS BAR */
        .stats-bar {
            background: #fff; display: flex; justify-content: space-around;
            padding: 28px 48px; border-bottom: 1px solid var(--border);
        }
        .stats-bar-item { text-align: center; }
        .stats-bar-item strong {
            display: block; font-size: 32px; font-weight: 700;
            color: var(--text-dark); font-family: 'Playfair Display', serif;
        }
        .stats-bar-item span { font-size: 13px; color: var(--text-muted); }

        /* SECTIONS */
        .section { padding: 72px 48px; }
        .section-bg-light { background: var(--blue-light); }
        .section-bg-white { background: #fff; }
        .section-label {
            font-size: 12px; font-weight: 600; color: var(--green);
            letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 10px;
        }
        .section-title {
            font-family: 'Playfair Display', serif; font-size: 36px;
            font-weight: 700; color: var(--text-dark); margin-bottom: 10px;
        }
        .section-sub {
            color: var(--text-muted); font-size: 15px; line-height: 1.6;
            max-width: 520px; margin-bottom: 48px;
        }

        /* FITUR */
        .feat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .feat-card {
            background: #fff; border-radius: 16px; padding: 28px 24px;
            border: 1px solid var(--border); transition: transform .2s, box-shadow .2s;
        }
        .feat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(26,46,66,0.10); }
        .feat-icon {
            width: 52px; height: 52px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; margin-bottom: 18px;
        }
        .fi-teal { background: #e1f5ee; } .fi-orange { background: #fff0e0; }
        .fi-navy { background: #e8f0f8; } .fi-purple { background: #f0eeff; }
        .fi-green { background: #eaf6e8; } .fi-red { background: #feeaea; }
        .feat-title { font-size: 16px; font-weight: 600; color: var(--text-dark); margin-bottom: 8px; }
        .feat-desc { font-size: 13px; color: var(--text-muted); line-height: 1.6; }

        /* GEDUNG */
        .venue-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .venue-card {
            border-radius: 16px; overflow: hidden;
            border: 1px solid var(--border); background: #fff; transition: transform .2s;
        }
        .venue-card:hover { transform: translateY(-3px); }
        .venue-img {
            height: 180px; position: relative;
            display: flex; align-items: center; justify-content: center;
            font-size: 48px; overflow: hidden;
        }
        .venue-img img { width: 100%; height: 100%; object-fit: cover; }
        .venue-img-placeholder {
            width: 100%; height: 100%;
            display: flex; align-items: center; justify-content: center; font-size: 48px;
        }
        .vi-1 { background: linear-gradient(135deg, #1a2e42 0%, #2a5a80 100%); }
        .vi-2 { background: linear-gradient(135deg, #1e5c3a 0%, #2da882 100%); }
        .vi-3 { background: linear-gradient(135deg, #4a2a7a 0%, #7a4ab0 100%); }
        .vi-4 { background: linear-gradient(135deg, #7a2a2a 0%, #c05050 100%); }
        .vi-5 { background: linear-gradient(135deg, #2a4a7a 0%, #4a80c0 100%); }
        .vi-6 { background: linear-gradient(135deg, #4a7a2a 0%, #80c050 100%); }
        .venue-tag {
            position: absolute; top: 12px; right: 12px;
            font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 999px;
        }
        .tag-tersedia { background: rgba(45,168,130,0.9); color: #fff; }
        .tag-habis    { background: rgba(220,38,38,0.85); color: #fff; }
        .venue-body { padding: 18px 20px; }
        .venue-name { font-size: 15px; font-weight: 600; color: var(--text-dark); margin-bottom: 4px; }
        .venue-price { font-size: 13px; color: var(--green); font-weight: 700; margin-bottom: 10px; }
        .venue-info { display: flex; gap: 16px; font-size: 12px; color: var(--text-muted); }
        .venue-info strong { color: var(--text-dark); font-weight: 600; }
        .venue-btn {
            display: block; text-align: center; margin-top: 14px;
            background: var(--blue-light); color: var(--text-dark);
            font-size: 13px; font-weight: 500; padding: 9px; border-radius: 8px;
            text-decoration: none; border: 1px solid var(--border); transition: background .2s;
        }
        .venue-btn:hover { background: var(--border); }
        .section-center { text-align: center; margin-top: 36px; }
        .venue-empty {
            text-align: center; padding: 60px 20px; color: var(--text-muted);
            background: #fff; border-radius: 16px; border: 1px solid var(--border);
        }
        .venue-empty p { margin-top: 12px; font-size: 14px; }

        /* TESTIMONI */
        .testi-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .testi-card { background: #fff; border-radius: 16px; padding: 24px; border: 1px solid var(--border); }
        .stars { color: #f4a429; font-size: 14px; margin-bottom: 12px; letter-spacing: 2px; }
        .testi-text { font-size: 14px; color: #3a5570; line-height: 1.7; margin-bottom: 18px; font-style: italic; }
        .testi-author { display: flex; align-items: center; gap: 10px; }
        .avatar {
            width: 38px; height: 38px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 700; color: #fff; flex-shrink: 0;
        }
        .av-green { background: var(--green); } .av-blue { background: #1a5c9e; } .av-purple { background: #9b4db0; }
        .testi-name { font-size: 13px; font-weight: 600; color: var(--text-dark); }
        .testi-role { font-size: 11px; color: var(--text-muted); }

        /* CTA */
        .cta-band {
            background: linear-gradient(135deg, #1a2e42 0%, #1e4060 100%);
            padding: 64px 48px; text-align: center;
        }
        .cta-band h2 { font-family: 'Playfair Display', serif; font-size: 36px; font-weight: 700; color: #fff; margin-bottom: 14px; }
        .cta-band p { color: #b8cfe0; font-size: 15px; margin-bottom: 32px; }
        .cta-band-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }

        /* FOOTER */
        .footer { background: #111e2b; padding: 48px 48px 28px; color: #7aa8c0; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 40px; margin-bottom: 40px; }
        .footer-brand { font-family: 'Playfair Display', serif; font-size: 22px; color: #fff; font-weight: 700; margin-bottom: 12px; }
        .footer p { font-size: 13px; line-height: 1.7; }
        .footer-col h4 { font-size: 13px; font-weight: 600; color: #fff; margin-bottom: 14px; text-transform: uppercase; letter-spacing: 1px; }
        .footer-col a { display: block; font-size: 13px; color: #7aa8c0; text-decoration: none; margin-bottom: 8px; transition: color .2s; }
        .footer-col a:hover { color: var(--green); }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,0.08); padding-top: 24px; text-align: center; font-size: 12px; }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            .hero { grid-template-columns: 1fr; }
            .hero-visual { display: none; }
            .feat-grid, .venue-grid, .testi-grid { grid-template-columns: 1fr 1fr; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
            .navbar { padding: 0 24px; }
            .section { padding: 48px 24px; }
        }
        @media (max-width: 600px) {
            .navbar-links .hide-mobile { display: none; }
            .hero { padding: 48px 24px 56px; }
            .hero h1 { font-size: 32px; }
            .feat-grid, .venue-grid, .testi-grid { grid-template-columns: 1fr; }
            .stats-bar { flex-wrap: wrap; gap: 20px; padding: 24px; }
            .footer-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar">
        <a href="{{ url('/') }}" class="navbar-brand">
            <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="32" height="32" rx="8" fill="#2da882"/>
                <path d="M6 24V14l10-8 10 8v10H20v-6h-6v6H6z" fill="white"/>
            </svg>
            VerandaHall
        </a>
        <ul class="navbar-links">
            <li class="hide-mobile"><a href="#fitur">Fitur</a></li>
            <li class="hide-mobile"><a href="#gedung">Gedung</a></li>
            <li class="hide-mobile"><a href="#testimoni">Testimoni</a></li>
            @auth
                <li>
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('user.beranda') }}"
                       class="btn-nav">Dashboard</a>
                </li>
            @else
                <li><a href="{{ route('login') }}" class="btn-nav">Masuk / Daftar</a></li>
            @endauth
        </ul>
    </nav>

    {{-- HERO --}}
    <section class="hero">
        <div class="hero-content">
            <div class="hero-badge">✦ Platform Booking Gedung #1 di Sidoarjo</div>
            <h1>Booking Gedung<br><span>Lebih Mudah,</span><br>Lebih Cepat</h1>
            <p>VerandaHall hadir untuk memudahkan kamu memesan gedung serbaguna dan venue acara dengan sistem online yang transparan dan terpercaya.</p>
            <div class="hero-cta">
                @auth
                    <a href="{{ route('user.pemesanan.create') }}" class="btn-primary">Pesan Gedung Sekarang &rarr;</a>
                    <a href="#gedung" class="btn-outline">Lihat Gedung Tersedia</a>
                @else
                    <a href="{{ route('register') }}" class="btn-primary">Mulai Booking Sekarang &rarr;</a>
                    <a href="#gedung" class="btn-outline">Lihat Gedung Tersedia</a>
                @endauth
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <strong>{{ $totalPengguna > 0 ? number_format($totalPengguna) : '0' }}+</strong>
                    <span>Pengguna Terdaftar</span>
                </div>
                <div class="hero-stat">
                    <strong>{{ $totalGedung }}</strong>
                    <span>Gedung Tersedia</span>
                </div>
                <div class="hero-stat">
                    <strong>{{ $totalBooking > 0 ? number_format($totalBooking) : '0' }}+</strong>
                    <span>Booking Selesai</span>
                </div>
            </div>
        </div>

        {{-- Hero Visual: Booking Aktif Hari Ini --}}
        <div class="hero-visual">
            <div class="hero-visual-label">Booking Aktif Hari Ini</div>
            @forelse($bookingHariIni as $bk)
                @php
                    $icons = ['🏛️','🎭','🏟️','🎪','🏢','🎯'];
                    $iconClasses = ['ic-green','ic-orange','ic-blue'];
                    $idx = $loop->index;
                @endphp
                <div class="mini-card">
                    <div class="mini-icon {{ $iconClasses[$idx % 3] }}">{{ $icons[$idx % count($icons)] }}</div>
                    <div>
                        <div class="mini-card-title">{{ $bk->gedung?->nama ?? 'Gedung' }}</div>
                        <div class="mini-card-sub">
                            {{ substr((string)$bk->jam_mulai, 0, 5) }}
                            @if($bk->jam_selesai) – {{ substr((string)$bk->jam_selesai, 0, 5) }} @endif
                            &middot; Kapasitas {{ number_format($bk->gedung?->kapasitas ?? 0) }} orang
                        </div>
                    </div>
                    @if($bk->status === 'disetujui')
                        <span class="mini-badge badge-green">Disetujui</span>
                    @else
                        <span class="mini-badge badge-orange">Menunggu</span>
                    @endif
                </div>
            @empty
                {{-- Fallback jika tidak ada booking hari ini --}}
                @foreach($gedungs->take(3) as $g)
                    @php $icons2 = ['🏛️','🎭','🏢']; $cls2 = ['ic-green','ic-orange','ic-blue']; @endphp
                    <div class="mini-card">
                        <div class="mini-icon {{ $cls2[$loop->index % 3] }}">{{ $icons2[$loop->index % 3] }}</div>
                        <div>
                            <div class="mini-card-title">{{ $g->nama }}</div>
                            <div class="mini-card-sub">Kapasitas {{ number_format($g->kapasitas) }} orang</div>
                        </div>
                        <span class="mini-badge badge-blue">Tersedia</span>
                    </div>
                @endforeach
                @if($gedungs->isEmpty())
                    <div class="mini-card-empty">Belum ada booking hari ini</div>
                @endif
            @endforelse
        </div>
    </section>

    {{-- STATS BAR --}}
    <div class="stats-bar">
        <div class="stats-bar-item">
            <strong>{{ $totalPengguna > 0 ? number_format($totalPengguna) : '0' }}+</strong>
            <span>Pengguna Aktif</span>
        </div>
        <div class="stats-bar-item">
            <strong>{{ $totalGedung }}</strong>
            <span>Gedung &amp; Lapangan</span>
        </div>
        <div class="stats-bar-item">
            <strong>{{ $totalBooking > 0 ? number_format($totalBooking) : '0' }}+</strong>
            <span>Booking Selesai</span>
        </div>
        <div class="stats-bar-item">
            <strong>4.9 ★</strong>
            <span>Rating Kepuasan</span>
        </div>
    </div>

    {{-- FITUR --}}
    <section class="section section-bg-light" id="fitur">
        <div class="section-label">Keunggulan Kami</div>
        <div class="section-title">Mengapa Memilih<br>VerandaHall?</div>
        <p class="section-sub">Sistem booking modern yang dirancang untuk kemudahan Anda, dari awal hingga akhir acara.</p>

        <div class="feat-grid">
            <div class="feat-card">
                <div class="feat-icon fi-teal">📅</div>
                <div class="feat-title">Booking Real-time</div>
                <p class="feat-desc">Periksa ketersediaan gedung secara langsung dan konfirmasi booking dalam hitungan menit tanpa perlu telepon.</p>
            </div>
            <div class="feat-card">
                <div class="feat-icon fi-orange">💳</div>
                <div class="feat-title">Proses Transparan</div>
                <p class="feat-desc">Setiap tahap pemesanan bisa dipantau langsung. Status booking selalu diperbarui secara real-time.</p>
            </div>
            <div class="feat-card">
                <div class="feat-icon fi-navy">📊</div>
                <div class="feat-title">Riwayat Lengkap</div>
                <p class="feat-desc">Pantau semua booking dan riwayat penggunaan dari satu dasbor yang mudah dipahami.</p>
            </div>
            <div class="feat-card">
                <div class="feat-icon fi-purple">🔔</div>
                <div class="feat-title">Notifikasi Otomatis</div>
                <p class="feat-desc">Dapatkan pemberitahuan status booking langsung via email atau browser, tanpa perlu cek manual.</p>
            </div>
            <div class="feat-card">
                <div class="feat-icon fi-green">✅</div>
                <div class="feat-title">Verifikasi Cepat</div>
                <p class="feat-desc">Admin kami memproses setiap permintaan booking dengan cepat dan transparan, biasanya selesai dalam 1x24 jam.</p>
            </div>
            <div class="feat-card">
                <div class="feat-icon fi-red">🎯</div>
                <div class="feat-title">Pilihan Gedung Beragam</div>
                <p class="feat-desc">Dari gedung serbaguna ratusan kapasitas hingga ruang meeting — semua tersedia di satu platform.</p>
            </div>
        </div>
    </section>

    {{-- GEDUNG (dari database) --}}
    <section class="section section-bg-white" id="gedung">
        <div class="section-label">Fasilitas Kami</div>
        <div class="section-title">Gedung &amp; Venue<br>Pilihan</div>
        <p class="section-sub">Temukan venue yang tepat untuk acara, rapat, atau kegiatan Anda.</p>

        @if($gedungs->isEmpty())
            <div class="venue-empty">
                <div style="font-size:3rem;">🏗️</div>
                <p>Belum ada gedung yang tersedia saat ini.<br>Silakan cek kembali nanti.</p>
            </div>
        @else
            @php $viClasses = ['vi-1','vi-2','vi-3','vi-4','vi-5','vi-6']; @endphp
            <div class="venue-grid">
                @foreach($gedungs as $gedung)
                <div class="venue-card">
                    <div class="venue-img">
                        @if($gedung->foto)
                            <img src="{{ asset('storage/' . $gedung->foto) }}" alt="{{ $gedung->nama }}">
                        @else
                            <div class="venue-img-placeholder {{ $viClasses[$loop->index % 6] }}">🏛️</div>
                        @endif
                        <span class="venue-tag {{ $gedung->status === 'tersedia' ? 'tag-tersedia' : 'tag-habis' }}">
                            {{ $gedung->status === 'tersedia' ? 'Tersedia' : 'Tidak Tersedia' }}
                        </span>
                    </div>
                    <div class="venue-body">
                        <div class="venue-name">{{ $gedung->nama }}</div>
                        <div class="venue-price">Rp {{ number_format($gedung->harga, 0, ',', '.') }} / hari</div>
                        <div class="venue-info">
                            <span>👥 <strong>{{ number_format($gedung->kapasitas) }}</strong> org</span>
                        </div>
                        @auth
                            <a href="{{ route('user.pemesanan.create', ['gedung_id' => $gedung->id]) }}"
                               class="venue-btn">Lihat Detail &amp; Booking</a>
                        @else
                            <a href="{{ route('login') }}" class="venue-btn">Lihat Detail &amp; Booking</a>
                        @endauth
                    </div>
                </div>
                @endforeach
            </div>
        @endif

        <div class="section-center">
            @auth
                <a href="{{ route('user.pemesanan.index') }}" class="btn-primary">Lihat Semua Gedung &rarr;</a>
            @else
                <a href="{{ route('login') }}" class="btn-primary">Lihat Semua Gedung &rarr;</a>
            @endauth
        </div>
    </section>

    {{-- TESTIMONI --}}
    <section class="section section-bg-light" id="testimoni">
        <div class="section-label">Testimoni</div>
        <div class="section-title">Apa Kata Mereka?</div>
        <p class="section-sub">Pengguna kami sudah mempercayakan kebutuhan venue mereka kepada VerandaHall.</p>

        <div class="testi-grid">
            <div class="testi-card">
                <div class="stars">★★★★★</div>
                <p class="testi-text">"Booking gedung untuk acara pernikahan saudara saya jadi sangat mudah! Prosesnya cepat, admin responsif, dan gedungnya sesuai foto. Highly recommended!"</p>
                <div class="testi-author">
                    <div class="avatar av-green">MP</div>
                    <div>
                        <div class="testi-name">Melysa Putri</div>
                        <div class="testi-role">Pengguna Aktif &middot; Sidoarjo</div>
                    </div>
                </div>
            </div>
            <div class="testi-card">
                <div class="stars">★★★★★</div>
                <p class="testi-text">"Saya sudah 3 kali booking lewat VerandaHall. Prosesnya mudah dan konfirmasinya cepat. Tidak perlu ribet telepon-telepon lagi!"</p>
                <div class="testi-author">
                    <div class="avatar av-blue">SR</div>
                    <div>
                        <div class="testi-name">Sarah R.</div>
                        <div class="testi-role">Pengguna Aktif &middot; Surabaya</div>
                    </div>
                </div>
            </div>
            <div class="testi-card">
                <div class="stars">★★★★★</div>
                <p class="testi-text">"Platform ini benar-benar membantu kami dalam mengelola booking untuk acara kantor. Tampilan dashboard yang bersih dan laporan yang lengkap!"</p>
                <div class="testi-author">
                    <div class="avatar av-purple">DN</div>
                    <div>
                        <div class="testi-name">Dina N.</div>
                        <div class="testi-role">Event Organizer &middot; Sidoarjo</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA BAND --}}
    <section class="cta-band">
        <h2>Siap Booking Gedungmu?</h2>
        <p>Daftar sekarang gratis dan temukan venue terbaik untuk setiap momen pentingmu.</p>
        <div class="cta-band-btns">
            @auth
                <a href="{{ route('user.pemesanan.create') }}" class="btn-primary" style="padding:14px 36px;font-size:16px;">Pesan Gedung Sekarang &rarr;</a>
                <a href="{{ route('user.beranda') }}" class="btn-outline" style="padding:14px 36px;font-size:16px;">Ke Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="btn-primary" style="padding:14px 36px;font-size:16px;">Daftar Gratis Sekarang &rarr;</a>
                <a href="{{ route('login') }}" class="btn-outline" style="padding:14px 36px;font-size:16px;">Sudah Punya Akun? Masuk</a>
            @endauth
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="footer">
        <div class="footer-grid">
            <div>
                <div class="footer-brand">VerandaHall</div>
                <p>Platform booking gedung online yang mudah, cepat, dan terpercaya.
                    @if($totalGedung > 0)
                        Tersedia {{ $totalGedung }} venue di wilayah Sidoarjo dan sekitarnya.
                    @endif
                </p>
            </div>
            <div class="footer-col">
                <h4>Navigasi</h4>
                <a href="{{ url('/') }}">Beranda</a>
                <a href="#gedung">Daftar Gedung</a>
                <a href="#fitur">Fitur</a>
                <a href="{{ route('login') }}">Masuk</a>
                <a href="{{ route('register') }}">Daftar</a>
            </div>
            <div class="footer-col">
                <h4>Kontak</h4>
                <a href="mailto:admin@verandahall.com">📧 admin@verandahall.com</a>
                <a href="tel:031-123-4567">📞 (031) 123-4567</a>
                <a href="#">📍 Sidoarjo, Jawa Timur</a>
                <a href="#">🕐 Senin – Jumat, 08.00 – 17.00</a>
            </div>
        </div>
        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} VerandaHall. Hak cipta dilindungi.</span>
        </div>
    </footer>

</body>
</html>

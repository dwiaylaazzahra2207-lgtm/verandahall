@props([])

@php
    use App\Models\Booking;
    $menunggu = Booking::query()->where('status', Booking::STATUS_MENUNGGU)->count();
@endphp

<aside class="sidebar" id="sidebar">

    {{-- Brand --}}
    <div class="sidebar-brand">
        <div class="brand-logo">
            <img src="{{ asset('images/logo.png') }}" alt="VerandaHall"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div class="brand-logo-fallback">
                <i class="bi bi-buildings-fill"></i>
            </div>
        </div>
        <h5>VerandaHall</h5>
        <div class="sidebar-divider"></div>
    </div>

    {{-- Navigasi --}}
    <nav class="sidebar-nav">

        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.users.index') }}"
           class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="bi bi-person-fill"></i>
            <span>Manajemen User</span>
        </a>

        <a href="{{ route('admin.pemesanan.index') }}"
           class="nav-link {{ request()->routeIs('admin.pemesanan.*') ? 'active' : '' }}">
            <i class="bi bi-journal-check"></i>
            <span>Manajemen Pemesanan</span>
            @if($menunggu > 0)
                <span class="nav-badge">{{ $menunggu }}</span>
            @endif
        </a>

        <a href="{{ route('admin.riwayat.index') }}"
           class="nav-link {{ request()->routeIs('admin.riwayat.*') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i>
            <span>Riwayat Pemesanan</span>
        </a>

        <a href="{{ route('admin.gedung.index') }}"
           class="nav-link {{ request()->routeIs('admin.gedung.*') ? 'active' : '' }}">
            <i class="bi bi-building-gear"></i>
            <span>Pengelolaan Gedung</span>
        </a>

        <a href="{{ route('admin.laporan.index') }}"
           class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line-fill"></i>
            <span>Laporan</span>
        </a>

        <a href="{{ route('admin.pengaturan.index', ['tab' => 'profil']) }}"
           class="nav-link {{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}">
            <i class="bi bi-gear-fill"></i>
            <span>Pengaturan</span>
        </a>

    </nav>

    {{-- Logout --}}
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}" onsubmit="sessionStorage.removeItem('vh_last_welcomed_user');">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-left"></i>
                <span>Keluar</span>
            </button>
        </form>
    </div>

</aside>

<style>
/* ── SIDEBAR SHELL ──────────────────────────────────── */
.sidebar {
    width: var(--sidebar-w, 240px);
    min-height: 100vh;
    background: var(--sidebar-bg, #0f2235);
    position: fixed;
    top: 0; left: 0;
    z-index: 200;
    display: flex;
    flex-direction: column;
    transition: transform .3s ease;
    /* Garis aksen tipis di kanan */
    border-right: 1px solid rgba(255,255,255,0.04);
}

/* ── BRAND ──────────────────────────────────────────── */
.sidebar-brand {
    padding: 26px 20px 14px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    position: relative;
}

.brand-logo {
    width: 58px; height: 58px;
    background: #fff;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0,0,0,.25);
    flex-shrink: 0;
    transition: transform .25s ease, box-shadow .25s ease;
}
.brand-logo:hover {
    transform: scale(1.06);
    box-shadow: 0 6px 22px rgba(0,0,0,.3);
}
.brand-logo img {
    width: 100%; height: 100%;
    object-fit: contain;
    padding: 6px;
}
.brand-logo-fallback {
    display: none;
    align-items: center; justify-content: center;
    width: 100%; height: 100%;
}
.brand-logo-fallback i {
    font-size: 1.7rem;
    color: var(--accent, #1e6fba);
}

.sidebar-brand h5 {
    color: #fff;
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    font-size: 1.1rem;
    letter-spacing: .3px;
    margin: 0;
    text-align: center;
}

.sidebar-divider {
    width: 80%;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,.18), transparent);
}

/* ── NAV ────────────────────────────────────────────── */
.sidebar-nav {
    padding: 10px 12px;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 2px;
    overflow-y: auto;
    overflow-x: hidden;
}
.sidebar-nav::-webkit-scrollbar { width: 4px; }
.sidebar-nav::-webkit-scrollbar-track { background: transparent; }
.sidebar-nav::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,.12);
    border-radius: 4px;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 10px 14px;
    color: var(--sidebar-text, #a8bdd0);
    text-decoration: none;
    font-size: .875rem;
    font-weight: 500;
    border-radius: 10px;
    transition: background .18s ease, color .18s ease, transform .18s ease;
    position: relative;
}
.nav-link i {
    font-size: 1rem;
    width: 18px;
    text-align: center;
    flex-shrink: 0;
    opacity: .85;
    transition: opacity .18s ease;
}
.nav-link span { flex: 1; }

.nav-link:hover {
    background: var(--sidebar-hover, rgba(255,255,255,.07));
    color: #fff;
    transform: translateX(3px);
}
.nav-link:hover i { opacity: 1; }

/* Active state */
.nav-link.active {
    background: var(--sidebar-active, rgba(255,255,255,.12));
    color: #fff;
}
.nav-link.active i { opacity: 1; }
.nav-link.active::before {
    content: '';
    position: absolute;
    left: 0; top: 20%; bottom: 20%;
    width: 3px;
    background: var(--sidebar-accent, #4db8ff);
    border-radius: 0 3px 3px 0;
}

/* Badge */
.nav-badge {
    background: #f97316;
    color: #fff;
    font-size: .65rem;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 20px;
    margin-left: auto;
    flex-shrink: 0;
    animation: badgePulse 2.5s ease-in-out infinite;
}
@keyframes badgePulse {
    0%, 100% { transform: scale(1); }
    50%       { transform: scale(1.08); }
}

/* ── FOOTER / LOGOUT ────────────────────────────────── */
.sidebar-footer {
    padding: 12px 12px 18px;
    border-top: 1px solid rgba(255,255,255,.07);
}

.logout-btn {
    width: 100%;
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(255,255,255,.09);
    color: var(--sidebar-text, #a8bdd0);
    border-radius: 10px;
    padding: 10px 14px;
    display: flex; align-items: center; gap: 10px;
    font-size: .875rem;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 500;
    cursor: pointer;
    transition: background .2s, color .2s, border-color .2s;
}
.logout-btn:hover {
    background: rgba(239,68,68,.15);
    color: #fca5a5;
    border-color: rgba(239,68,68,.2);
}
.logout-btn i { font-size: 1rem; }
.logout-btn span { flex: 1; text-align: left; }

/* ── RESPONSIVE ─────────────────────────────────────── */
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
    }
    .sidebar.open {
        transform: translateX(0);
    }
}
</style>

<aside class="sidebar" id="sidebar">
    {{-- Brand --}}
    <div class="sidebar-brand">
        <div class="brand-logo">
            <img src="{{ asset('images/logo.png') }}" alt="VerandaHall Logo"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div style="display:none; width:100%; height:100%; align-items:center; justify-content:center;">
                <i class="bi bi-buildings-fill" style="font-size:1.6rem; color:#1e6fba;"></i>
            </div>
        </div>
        <h5>VerandaHall</h5>
        <div class="sidebar-divider-line"></div>
    </div>

    {{-- Nav --}}
    <nav class="sidebar-nav">
        <a href="{{ route('user.beranda') }}"
           class="nav-link {{ request()->routeIs('user.beranda') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Beranda</span>
        </a>

        <a href="{{ route('user.pemesanan.create') }}"
           class="nav-link {{ request()->routeIs('user.pemesanan.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-plus-fill"></i>
            <span>Pesan Gedung</span>
        </a>

        <a href="{{ route('user.riwayat.index') }}"
           class="nav-link {{ request()->routeIs('user.riwayat.*') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i>
            <span>Riwayat Pemesanan</span>
        </a>

        <a href="{{ route('user.pengaturan.index', ['tab' => 'profil']) }}"
           class="nav-link {{ request()->routeIs('user.pengaturan.*') ? 'active' : '' }}">
            <i class="bi bi-gear-fill"></i>
            <span>Pengaturan</span>
        </a>
    </nav>

    {{-- Logout --}}
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-left"></i>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>

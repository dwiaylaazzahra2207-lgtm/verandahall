<header class="topbar">
    {{-- Kiri: hamburger mobile --}}
    <div class="topbar-left">
        <button type="button" class="topbar-icon-btn d-md-none" onclick="toggleSidebar()">
            <i class="bi bi-list" style="font-size:1.3rem;"></i>
        </button>
        <span class="d-none d-md-block fw-semibold text-muted" style="font-size:.85rem;">
            @yield('page-title', 'Dashboard')
        </span>
    </div>

    {{-- Kanan: user info --}}
    <div class="topbar-right">
        <div class="topbar-user"
             onclick="window.location='{{ route('user.pengaturan.index', ['tab' => 'profil']) }}'">
            <div class="user-info">
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">Pengguna</div>
            </div>
            @if(Auth::user()->foto)
                <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                     class="user-avatar" alt="avatar">
            @else
                <div class="user-avatar-placeholder">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
            @endif
        </div>
    </div>
</header>

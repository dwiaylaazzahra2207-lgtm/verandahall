@props([])

@php
    use App\Models\Notifikasi;
    $unreadNotif = Notifikasi::query()->where('is_read', false)->count();
@endphp

<header class="topbar">

    {{-- Kiri: hamburger (mobile) + logo --}}
    <div class="topbar-left">
        <button type="button" class="topbar-icon-btn d-md-none" onclick="toggleSidebar()">
            <i class="bi bi-list" style="font-size:1.3rem;"></i>
        </button>

        <div class="topbar-logo d-none d-md-flex">
            <img src="{{ asset('images/logo.png') }}" alt="Logo"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div style="display:none; align-items:center; justify-content:center;">
                <i class="bi bi-buildings-fill" style="color:#1e6fba; font-size:1.3rem;"></i>
            </div>
        </div>
    </div>

    {{-- Kanan: notifikasi + info admin --}}
    <div class="topbar-right">

        {{-- Bell notifikasi --}}
        <button type="button" class="topbar-icon-btn"
                onclick="window.location='{{ route('admin.notifikasi.index') }}'">
            <i class="bi bi-bell-fill"></i>
            @if($unreadNotif > 0)
                <span class="notif-dot"></span>
            @endif
        </button>

        {{-- Admin info --}}
        <div class="topbar-admin"
             onclick="window.location='{{ route('admin.pengaturan.index', ['tab' => 'profil']) }}'">
            <div class="admin-info">
                <div class="admin-name">{{ Auth::user()->name }}</div>
                <div class="admin-email">{{ Auth::user()->email }}</div>
            </div>
            @if(Auth::user()->foto)
                <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                     class="admin-avatar" alt="avatar">
            @else
                <div class="admin-avatar-placeholder">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
            @endif
        </div>

    </div>
</header>

<style>
/* ── TOPBAR SHELL ───────────────────────────────────── */
.topbar {
    background: #fff;
    padding: 0 24px;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-radius: 0 0 16px 16px;
    box-shadow: 0 2px 14px rgba(15,34,53,.07);
    position: sticky;
    top: 0;
    z-index: 100;
    margin: 0 16px;
    /* Garis aksen bawah tipis */
    border-bottom: 2px solid transparent;
    background-clip: padding-box;
}

/* ── KIRI ───────────────────────────────────────────── */
.topbar-left { display: flex; align-items: center; gap: 12px; }

.topbar-logo {
    width: 36px; height: 36px;
    display: flex; align-items: center; justify-content: center;
}
.topbar-logo img {
    width: 100%; height: 100%;
    object-fit: contain;
}

/* ── KANAN ──────────────────────────────────────────── */
.topbar-right { display: flex; align-items: center; gap: 10px; }

/* Icon button (bell, hamburger) */
.topbar-icon-btn {
    width: 38px; height: 38px;
    border-radius: 10px;
    background: #e8f4fd;
    border: none;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    color: var(--text-dark, #1a2b3c);
    font-size: .95rem;
    position: relative;
    transition: background .2s ease, transform .2s ease;
}
.topbar-icon-btn:hover {
    background: #d0e8f7;
    transform: translateY(-1px);
}
.topbar-icon-btn:active { transform: scale(.95); }

/* Notif dot */
.notif-dot {
    position: absolute;
    top: 7px; right: 8px;
    width: 7px; height: 7px;
    background: #ef4444;
    border-radius: 50%;
    border: 2px solid #fff;
    animation: notifPop 2s ease-in-out infinite;
}
@keyframes notifPop {
    0%, 100% { transform: scale(1); }
    50%       { transform: scale(1.25); }
}

/* Admin card */
.topbar-admin {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    background: #e8f4fd;
    padding: 6px 14px 6px 10px;
    border-radius: 50px;
    transition: background .2s ease, transform .2s ease;
    border: 1px solid transparent;
}
.topbar-admin:hover {
    background: #d0e8f7;
    border-color: rgba(30,111,186,.15);
    transform: translateY(-1px);
}

.admin-info { text-align: right; }
.admin-name {
    font-weight: 700;
    font-size: .84rem;
    color: var(--text-dark, #1a2b3c);
    line-height: 1.2;
    white-space: nowrap;
}
.admin-email {
    font-size: .7rem;
    color: var(--text-muted, #7a93ad);
    white-space: nowrap;
}

.admin-avatar {
    width: 36px; height: 36px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px var(--accent, #1e6fba);
    transition: box-shadow .2s ease, transform .2s ease;
    flex-shrink: 0;
}
.topbar-admin:hover .admin-avatar {
    transform: scale(1.05);
    box-shadow: 0 0 0 3px var(--accent, #1e6fba);
}

.admin-avatar-placeholder {
    width: 36px; height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--accent, #1e6fba), #22c55e);
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    font-weight: 700;
    font-size: .8rem;
    flex-shrink: 0;
    transition: transform .2s ease;
}
.topbar-admin:hover .admin-avatar-placeholder {
    transform: scale(1.05);
}

/* ── RESPONSIVE ─────────────────────────────────────── */
@media (max-width: 768px) {
    .topbar {
        margin: 0;
        border-radius: 0;
        padding: 0 14px;
    }
    .admin-info { display: none; }
    .topbar-admin {
        padding: 4px;
        border-radius: 50%;
        background: transparent;
    }
    .topbar-admin:hover { background: #e8f4fd; }
}
</style>

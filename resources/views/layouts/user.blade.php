<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — VerandaHall</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* ── DESIGN TOKENS ─────────────────────────────────────────────── */
        :root {
            --sidebar-bg:      #0f2235;
            --sidebar-width:   240px;
            --sidebar-text:    #a8bdd0;
            --sidebar-hover:   rgba(255,255,255,0.07);
            --sidebar-active:  rgba(255,255,255,0.12);
            --sidebar-accent:  #4db8ff;
            --body-bg:         #e8f4fd;
            --card-bg:         #ffffff;
            --text-dark:       #1a2b3c;
            --text-muted:      #7a93ad;
            --accent-blue:     #1e6fba;
        }

        *, *::before, *::after { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--body-bg);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
        }

        /* ── SIDEBAR ───────────────────────────────────────────────────── */
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            z-index: 200;
            display: flex;
            flex-direction: column;
            transition: transform .3s ease;
        }

        .sidebar-brand {
            padding: 28px 20px 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .brand-logo {
            width: 60px; height: 60px;
            background: #fff;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        }

        .brand-logo img {
            width: 100%; height: 100%;
            object-fit: contain;
            padding: 6px;
        }

        .sidebar-brand h5 {
            color: #fff;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.15rem;
            letter-spacing: .3px;
            margin: 0;
        }

        .sidebar-divider-line {
            width: 80%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            margin: 4px 0 0;
        }

        .sidebar-nav {
            padding: 10px 12px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 14px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: .875rem;
            font-weight: 500;
            border-radius: 10px;
            transition: all .2s ease;
            position: relative;
        }

        .sidebar-nav .nav-link i {
            font-size: 1rem;
            width: 18px;
            text-align: center;
            flex-shrink: 0;
            opacity: .85;
        }

        .sidebar-nav .nav-link span { flex: 1; }

        .sidebar-nav .nav-link:hover {
            background: var(--sidebar-hover);
            color: #fff;
        }

        .sidebar-nav .nav-link.active {
            background: var(--sidebar-active);
            color: #fff;
        }

        .sidebar-nav .nav-link.active i { opacity: 1; }

        .sidebar-nav .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0; top: 20%; bottom: 20%;
            width: 3px;
            background: var(--sidebar-accent);
            border-radius: 0 3px 3px 0;
        }

        .sidebar-footer {
            padding: 14px 12px;
            border-top: 1px solid rgba(255,255,255,0.07);
        }

        .logout-btn {
            width: 100%;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.09);
            color: var(--sidebar-text);
            border-radius: 10px;
            padding: 10px 14px;
            display: flex; align-items: center; gap: 10px;
            font-size: .875rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 500;
            cursor: pointer;
            transition: all .2s;
        }

        .logout-btn:hover {
            background: rgba(239,68,68,.15);
            color: #fca5a5;
            border-color: rgba(239,68,68,.2);
        }

        /* ── MAIN WRAPPER ──────────────────────────────────────────────── */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ── TOPBAR ────────────────────────────────────────────────────── */
        .topbar {
            background: #fff;
            padding: 12px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-radius: 0 0 18px 18px;
            box-shadow: 0 2px 12px rgba(15,34,53,.07);
            position: sticky;
            top: 0;
            z-index: 100;
            margin: 0 16px;
        }

        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .topbar-right { display: flex; align-items: center; gap: 12px; }

        .topbar-icon-btn {
            width: 38px; height: 38px;
            border-radius: 10px;
            background: var(--body-bg);
            border: none;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            color: var(--text-dark);
            font-size: .95rem;
            position: relative;
            transition: background .2s;
        }

        .topbar-icon-btn:hover { background: #d5eaf9; }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            background: var(--body-bg);
            padding: 6px 14px 6px 8px;
            border-radius: 50px;
            transition: background .2s;
        }

        .topbar-user:hover { background: #d5eaf9; }

        .user-info { text-align: right; }

        .user-name {
            font-weight: 700;
            font-size: .85rem;
            color: var(--text-dark);
            line-height: 1.2;
            white-space: nowrap;
        }

        .user-role {
            font-size: .72rem;
            color: var(--text-muted);
            white-space: nowrap;
        }

        .user-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px var(--accent-blue);
        }

        .user-avatar-placeholder {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1e6fba, #22c55e);
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: .8rem;
            flex-shrink: 0;
        }

        /* ── PAGE CONTENT ──────────────────────────────────────────────── */
        .page-content {
            padding: 24px 28px;
            flex: 1;
        }

        /* ── RESPONSIVE ────────────────────────────────────────────────── */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .topbar { margin: 0 8px; padding: 10px 16px; }
            .page-content { padding: 16px; }
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.4);
            z-index: 199;
        }

        .sidebar-overlay.show { display: block; }
    </style>

    @stack('styles')
</head>
<body>

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <x-user.sidebar />

    <div class="main-wrapper">

        <x-user.navbar />

        <main class="page-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm mb-3" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }
    </script>

    @stack('scripts')
</body>
</html>

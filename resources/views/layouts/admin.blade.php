<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — VerandaHall</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* ── TOKENS ─────────────────────────────────────────── */
        :root {
            --sidebar-w:      240px;
            --sidebar-bg:     #0f2235;
            --sidebar-text:   #a8bdd0;
            --sidebar-hover:  rgba(255,255,255,0.07);
            --sidebar-active: rgba(255,255,255,0.12);
            --sidebar-accent: #4db8ff;
            --body-bg:        #e8f4fd;
            --card-bg:        #ffffff;
            --text-dark:      #1a2b3c;
            --text-muted:     #7a93ad;
            --accent:         #1e6fba;
            --radius:         14px;
            --radius-sm:      10px;
            --shadow:         0 2px 12px rgba(15,34,53,.07);
            --shadow-md:      0 4px 20px rgba(15,34,53,.10);
        }

        /* ── RESET ──────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--body-bg);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
        }

        /* ── LAYOUT ─────────────────────────────────────────── */
        .main-wrapper {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .page-content {
            padding: 24px 28px;
            flex: 1;
        }

        /* ── SIDEBAR OVERLAY (mobile) ───────────────────────── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.45);
            z-index: 199;
        }
        .sidebar-overlay.show { display: block; }

        /* ── GLOBAL: CARD ───────────────────────────────────── */
        .card {
            background: var(--card-bg);
            border: 1px solid rgba(15,34,53,.06) !important;
            border-radius: var(--radius) !important;
            box-shadow: var(--shadow) !important;
            transition: box-shadow .2s ease, transform .2s ease;
        }
        .card:hover {
            box-shadow: var(--shadow-md) !important;
            transform: translateY(-2px);
        }

        /* ── GLOBAL: TABLE ──────────────────────────────────── */
        .table {
            font-size: .875rem;
            color: var(--text-dark);
        }
        .table thead th {
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: var(--text-muted);
            background: #f4f8fc;
            border-bottom: 1px solid #dde8f0;
            padding: 12px 16px;
            white-space: nowrap;
        }
        .table tbody tr {
            transition: background .15s ease;
            border-color: #edf2f7;
        }
        .table tbody tr:hover { background: #f0f7ff; }
        .table td { padding: 11px 16px; vertical-align: middle; }
        .table-light { --bs-table-bg: #f4f8fc; }

        /* ── GLOBAL: FORM ───────────────────────────────────── */
        .form-control, .form-select {
            border-radius: var(--radius-sm) !important;
            border-color: #d0dde8 !important;
            font-size: .9rem;
            padding: 9px 13px;
            color: var(--text-dark);
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 3px rgba(30,111,186,.12) !important;
        }
        .form-label {
            font-size: .82rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: .35rem;
        }

        /* ── GLOBAL: BUTTON ─────────────────────────────────── */
        .btn {
            border-radius: var(--radius-sm) !important;
            font-weight: 600 !important;
            font-size: .85rem !important;
            transition: all .2s ease !important;
        }
        .btn:hover { transform: translateY(-1px); }
        .btn:active { transform: translateY(0) !important; }

        /* ── GLOBAL: ALERT ──────────────────────────────────── */
        .alert {
            border-radius: var(--radius-sm) !important;
            font-size: .875rem;
            border-left-width: 4px !important;
        }

        /* ── GLOBAL: BADGE ──────────────────────────────────── */
        .badge { font-weight: 600; letter-spacing: .02em; }

        /* ── GLOBAL: PAGINATION ─────────────────────────────── */
        .pagination .page-link {
            border-radius: var(--radius-sm) !important;
            margin: 0 2px;
            color: var(--accent);
            border-color: #d0dde8;
            font-size: .85rem;
            transition: all .2s;
        }
        .pagination .page-link:hover { background: var(--accent); color: #fff; border-color: var(--accent); }
        .pagination .page-item.active .page-link { background: var(--accent); border-color: var(--accent); }

        /* ── GLOBAL: ACCORDION ──────────────────────────────── */
        .accordion-button:not(.collapsed) {
            background: #eef5fb;
            color: var(--accent);
            box-shadow: none;
        }
        .accordion-item { border-color: #dde8f0; }

        /* ── RESPONSIVE ─────────────────────────────────────── */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .topbar { margin: 0 8px; padding: 10px 16px; }
            .page-content { padding: 16px; }
        }
    </style>

    @stack('styles')
</head>
<body>

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <x-admin.sidebar />

    <div class="main-wrapper">

        <x-admin.navbar />

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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>AYMD — {{ $title ?? 'Dashboard' }}</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>

    <style>
        :root {
            --aymd-dark:    #1B2B4B;
            --aymd-blue:    #2E75B6;
            --aymd-light:   #EBF1F8;
            --sidebar-w:    250px;
        }

        body {
            background: #f4f6fb;
            font-family: 'Segoe UI', sans-serif;
        }

        /* ── SIDEBAR ── */
        #sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--aymd-dark);
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        #sidebar .sidebar-brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        #sidebar .sidebar-brand h4 {
            color: #fff;
            font-weight: 700;
            margin: 0;
            font-size: 1.2rem;
            letter-spacing: 0.03em;
        }

        #sidebar .sidebar-brand span {
            color: #B8CCE4;
            font-size: 0.75rem;
        }

        #sidebar .nav-link {
            color: #B8CCE4;
            padding: 0.65rem 1.25rem;
            border-radius: 8px;
            margin: 2px 10px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s;
        }

        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }

        #sidebar .nav-link i {
            font-size: 1.1rem;
            width: 20px;
        }

        #sidebar .sidebar-section {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.35);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 1rem 1.25rem 0.25rem;
        }

        #sidebar .sidebar-footer {
            margin-top: auto;
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        /* ── MAIN CONTENT ── */
        #main {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── TOPBAR ── */
        #topbar {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.85rem 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 99;
        }

        #topbar .page-title {
            font-weight: 600;
            font-size: 1.05rem;
            color: var(--aymd-dark);
            margin: 0;
        }

        #topbar .user-badge {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        #topbar .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--aymd-blue);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
        }

        #topbar .user-name {
            font-size: 0.9rem;
            color: var(--aymd-dark);
            font-weight: 500;
        }

        #topbar .user-role {
            font-size: 0.75rem;
            color: #888;
        }

        /* ── PAGE CONTENT ── */
        .page-content {
            padding: 1.75rem;
            flex: 1;
        }

        /* ── CARDS ── */
        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.25rem;
            border: 1px solid #e8ecf4;
        }

        .stat-card .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .card {
            border: 1px solid #e8ecf4;
            border-radius: 12px;
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #e8ecf4;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--aymd-dark);
        }

        /* ── BUTTONS ── */
        .btn-aymd {
            background: var(--aymd-blue);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.45rem 1rem;
            font-size: 0.875rem;
        }

        .btn-aymd:hover {
            background: var(--aymd-dark);
            color: #fff;
        }

        /* ── TABLE ── */
        .table th {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #888;
            font-weight: 600;
            border-bottom: 2px solid #e8ecf4;
        }

        .table td {
            font-size: 0.875rem;
            vertical-align: middle;
            color: #333;
        }
    </style>
</head>
<body>

{{-- ── SIDEBAR ── --}}
<div id="sidebar">
    <div class="sidebar-brand">
        <h4><i class="bi bi-broadcast me-2" style="color:#2E75B6"></i>AYMD</h4>
        <span>Social Media Manager</span>
    </div>

    <nav class="mt-2">
        <div class="sidebar-section">Principal</div>

        <a href="{{ route('dashboard') }}"
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i> Tableau de bord
        </a>

        <a href="{{ route('clients.index') }}"
           class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Clients
        </a>

        <div class="sidebar-section">Gestion</div>

        <a href="#"
           class="nav-link {{ request()->routeIs('posts.*') ? 'active' : '' }}">
            <i class="bi bi-calendar3"></i> Publications
        </a>

        <a href="#"
           class="nav-link {{ request()->routeIs('analytics.*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line"></i> Analytics
        </a>

        <a href="#"
           class="nav-link {{ request()->routeIs('inbox.*') ? 'active' : '' }}">
            <i class="bi bi-chat-dots"></i> Inbox
            @if(isset($unreadCount) && $unreadCount > 0)
                <span class="badge bg-danger ms-auto">{{ $unreadCount }}</span>
            @endif
        </a>

        <a href="#"
           class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-pdf"></i> Rapports
        </a>

        @if(auth()->user()->isAdmin())
        <div class="sidebar-section">Administration</div>
        <a href="{{ route('settings.index') }}"
           class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
            <i class="bi bi-gear"></i> Paramètres
        </a>
        @endif
    </nav>

    <div class="sidebar-footer">
        <div style="color:#B8CCE4; font-size:0.8rem; margin-bottom:8px;">
            <i class="bi bi-building me-1"></i> AYMD Agency
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    style="background:rgba(255,255,255,0.08);border:none;color:#B8CCE4;
                           width:100%;padding:7px;border-radius:8px;font-size:0.85rem;
                           cursor:pointer;text-align:left;">
                <i class="bi bi-box-arrow-left me-2"></i> Déconnexion
            </button>
        </form>
    </div>
</div>

{{-- ── MAIN ── --}}
<div id="main">

    {{-- TOPBAR --}}
    <div id="topbar">
        <h1 class="page-title">{{ $title ?? 'Tableau de bord' }}</h1>
        <div class="user-badge">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->full_name, 0, 2)) }}
            </div>
            <div>
                <div class="user-name">{{ auth()->user()->full_name }}</div>
                <div class="user-role">
                    {{ auth()->user()->isAdmin() ? 'Administrateur' : 'Employé' }}
                </div>
            </div>
        </div>
    </div>

    {{-- PAGE CONTENT --}}
    <div class="page-content">
        {{-- Flash success message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Flash error message --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{ $slot }}
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
{{ $scripts ?? '' }}

</body>
</html>
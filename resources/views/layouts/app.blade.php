<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>AYMD — {{ $title ?? 'Dashboard' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <style>
        :root {
            --navy:   #1B2B4B;
            --blue:   #2E75B6;
            --light:  #EBF1F8;
            --side-w: 64px;
        }
        * { box-sizing: border-box; }
        body {
            background: #F4F6FB;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
        }

        /* ── SIDEBAR ── */
        #sidebar {
            width: var(--side-w);
            height: 100vh;
            background: var(--navy);
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0;
            z-index: 200;
        }
        .sidebar-logo {
            width: 100%;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            margin-bottom: 8px;
        }
        .sidebar-logo span {
            font-weight: 800;
            font-size: 15px;
            color: #fff;
            letter-spacing: 0.04em;
        }
        .nav-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,0.45);
            font-size: 18px;
            margin: 3px 0;
            transition: all 0.15s;
            text-decoration: none;
            position: relative;
        }
        .nav-icon:hover,
        .nav-icon.active {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }
        .nav-icon.active::before {
            content: '';
            position: absolute;
            left: -8px;
            width: 3px;
            height: 24px;
            background: var(--blue);
            border-radius: 0 3px 3px 0;
        }
        .nav-icon .badge-dot {
            position: absolute;
            top: 8px; right: 8px;
            width: 7px; height: 7px;
            background: #E53935;
            border-radius: 50%;
            border: 1px solid var(--navy);
        }
        .sidebar-bottom {
            margin-top: auto;
            margin-bottom: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }
        .user-dot {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: var(--blue);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
        }

        /* ── MAIN ── */
        #main {
            margin-left: var(--side-w);
            min-height: 100vh;
        }

        /* ── TOPBAR ── */
        #topbar {
            height: 60px;
            background: #fff;
            border-bottom: 1px solid #EAECF0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .topbar-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--navy);
        }
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .topbar-icon-btn {
            width: 34px; height: 34px;
            border-radius: 8px;
            background: #F4F6FB;
            border: none;
            color: #666;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .topbar-user {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 4px 10px 4px 4px;
            border-radius: 20px;
            background: #F4F6FB;
        }
        .topbar-avatar {
            width: 28px; height: 28px;
            border-radius: 50%;
            background: var(--blue);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .topbar-name {
            font-size: 13px;
            font-weight: 500;
            color: var(--navy);
        }
        .topbar-role {
            font-size: 11px;
            color: #999;
        }

        /* ── CONTENT ── */
        .page-content {
            padding: 24px 28px;
        }

        /* ── CARDS ── */
        .card {
            background: #fff;
            border: 1px solid #EAECF0;
            border-radius: 14px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .card-header {
            background: transparent;
            border-bottom: 1px solid #EAECF0;
            padding: 14px 20px;
            font-size: 13px;
            font-weight: 600;
            color: var(--navy);
            border-radius: 14px 14px 0 0 !important;
        }
        .stat-card {
            background: #fff;
            border: 1px solid #EAECF0;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .stat-label {
            font-size: 11px;
            font-weight: 600;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 10px;
        }
        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--navy);
            line-height: 1;
            margin-bottom: 8px;
        }
        .stat-badge {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 20px;
        }
        .stat-icon-wrap {
            width: 40px; height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
        }

        /* ── TABLE ── */
        .table th {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #999;
            font-weight: 600;
            border-bottom: 1px solid #EAECF0;
            padding: 10px 20px;
        }
        .table td {
            font-size: 13px;
            color: #333;
            vertical-align: middle;
            padding: 12px 20px;
            border-bottom: 1px solid #F4F6FB;
        }
        .table tbody tr:last-child td { border-bottom: none; }
        .table tbody tr:hover td { background: #FAFBFD; }

        /* ── MISC ── */
        .btn-primary {
            background: var(--blue) !important;
            border-color: var(--blue) !important;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            padding: 7px 14px;
        }
        .btn-primary:hover {
            background: var(--navy) !important;
            border-color: var(--navy) !important;
        }
        .tag {
            display: inline-block;
            font-size: 11px;
            font-weight: 500;
            padding: 3px 9px;
            border-radius: 20px;
        }
        .alert {
            border-radius: 10px;
            font-size: 13px;
            border: none;
        }
        .alert-success { background: #EAF3DE; color: #3B6D11; }
        .alert-danger  { background: #FCEBEB; color: #A32D2D; }

        /* Tooltip on hover sidebar icons */
        .nav-icon[data-label]:hover::after {
            content: attr(data-label);
            position: absolute;
            left: 52px;
            background: #1B2B4B;
            color: #fff;
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 6px;
            white-space: nowrap;
            pointer-events: none;
            z-index: 999;
        }
    </style>
</head>
<body>

{{-- ── SIDEBAR ── --}}
<div id="sidebar">
    <div class="sidebar-logo">
        <span>AY</span>
    </div>

    <a href="{{ route('dashboard') }}"
       data-label="Tableau de bord"
       class="nav-icon {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-1x2"></i>
    </a>

    <a href="{{ route('clients.index') }}"
       data-label="Clients"
       class="nav-icon {{ request()->routeIs('clients.*') ? 'active' : '' }}">
        <i class="bi bi-people"></i>
    </a>

    <a href="#"
       data-label="Publications"
       class="nav-icon {{ request()->routeIs('posts.*') ? 'active' : '' }}">
        <i class="bi bi-calendar3"></i>
    </a>

    <a href="#"
       data-label="Analytics"
       class="nav-icon {{ request()->routeIs('analytics.*') ? 'active' : '' }}">
        <i class="bi bi-bar-chart-line"></i>
    </a>

    <a href="#"
       data-label="Inbox"
       class="nav-icon {{ request()->routeIs('inbox.*') ? 'active' : '' }}">
        <i class="bi bi-chat-dots"></i>
        {{-- Show red dot if unread messages --}}
        @php $unreadCount = \App\Models\Message::where('is_read', false)->count(); @endphp
        @if($unreadCount > 0)
            <span class="badge-dot"></span>
        @endif
    </a>

    <a href="#"
       data-label="Rapports"
       class="nav-icon {{ request()->routeIs('reports.*') ? 'active' : '' }}">
        <i class="bi bi-file-earmark-pdf"></i>
    </a>

    @if(auth()->user()->isAdmin())
    <a href="{{ route('settings.index') }}"
       data-label="Paramètres"
       class="nav-icon {{ request()->routeIs('settings.*') ? 'active' : '' }}">
        <i class="bi bi-gear"></i>
    </a>
    @endif

    <div class="sidebar-bottom">
        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="nav-icon"
                    data-label="Déconnexion"
                    style="background:none;border:none;width:44px;height:44px;
                           border-radius:10px;color:rgba(255,255,255,0.4);
                           font-size:18px;cursor:pointer;display:flex;
                           align-items:center;justify-content:center;">
                <i class="bi bi-box-arrow-left"></i>
            </button>
        </form>
        {{-- User Avatar --}}
        <div class="user-dot" title="{{ auth()->user()->full_name }}">
            {{ strtoupper(substr(auth()->user()->full_name, 0, 2)) }}
        </div>
    </div>
</div>

{{-- ── MAIN ── --}}
<div id="main">

    {{-- TOPBAR --}}
    <div id="topbar">
        <div class="topbar-title">{{ $title ?? 'Tableau de bord' }}</div>
        <div class="topbar-right">
            <button class="topbar-icon-btn"><i class="bi bi-bell"></i></button>
            <button class="topbar-icon-btn"><i class="bi bi-search"></i></button>
            <div class="topbar-user">
                <div class="topbar-avatar">
                    {{ strtoupper(substr(auth()->user()->full_name, 0, 2)) }}
                </div>
                <div>
                    <div class="topbar-name">{{ auth()->user()->full_name }}</div>
                    <div class="topbar-role">
                        {{ auth()->user()->isAdmin() ? 'Admin' : 'Employé' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- PAGE CONTENT --}}
    <div class="page-content">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{ $slot }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
{{ $scripts ?? '' }}
</body>
</html>
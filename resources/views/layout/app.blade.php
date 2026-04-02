<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lumina — Réseau Universitaire</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { font-size: 16px; }
        body {
            font-family: var(--font-sans);
            background: var(--bg);
            color: var(--text);
            font-weight: 400;
            line-height: 1.6;
            min-height: 100vh;
        }

        /* ── TOPNAV ── */
        .topnav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            height: 58px;
            display: flex;
            align-items: center;
            padding: 0 2rem;
            gap: 1.5rem;
        }
        .nav-logo {
            font-family: var(--font-serif);
            font-size: 19px;
            font-weight: 400;
            color: var(--text);
            text-decoration: none;
            white-space: nowrap;
            letter-spacing: -0.01em;
        }
        .nav-logo strong { font-weight: 500; }
        .nav-sep {
            width: 1px;
            height: 22px;
            background: var(--border-md);
            flex-shrink: 0;
        }
        .nav-search {
            flex: 1;
            max-width: 300px;
            height: 34px;
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 0 12px;
            font-family: var(--font-sans);
            font-size: 13px;
            color: var(--text);
            outline: none;
            transition: border-color .15s;
        }
        .nav-search:focus { border-color: var(--border-md); }
        .nav-search::placeholder { color: var(--text-3); }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            flex: 1;
            justify-content: center;
        }
        .nav-link {
            padding: 6px 14px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 700;
            color: var(--text-2);
            text-decoration: none;
            transition: background .12s, color .12s;
            letter-spacing: 0.02em;
        }
        .nav-link:hover { background: var(--surface-2); color: var(--text); }
        .nav-link.active { background: var(--text); color: var(--surface); }
        .nav-spacer { flex: 1; }
        .nav-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .nav-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--surface-2);
            border: 1px solid var(--border-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-2);
            letter-spacing: 0.04em;
            cursor: pointer;
        }
        .nav-username {
            font-size: 13px;
            font-weight: 700;
            color: var(--text);
        }
        .btn-logout {
            font-size: 12px;
            color: var(--text-3);
            text-decoration: none;
            padding: 4px 10px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            transition: all .12s;
        }
        .btn-logout:hover { border-color: var(--border-md); color: var(--text-2); }

        /* ── FLASH ── */
        .flash {
            margin: 1rem 2rem 0;
            padding: 10px 16px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 700;
        }
        .flash-success { background: var(--green-bg); color: var(--green-text); border-left: 3px solid var(--green); }
        .flash-error { background: var(--red-bg); color: var(--red-text); border-left: 3px solid var(--red); }

        /* ── PAGE LAYOUT ── */
        .page-wrap {
            max-width: 1120px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
            display: grid;
            grid-template-columns: 230px minmax(0,1fr) 230px;
            gap: 1.5rem;
            align-items: start;
        }
        .page-wrap.wide {
            grid-template-columns: 230px minmax(0,1fr);
        }

        /* ── SIDEBAR ── */
        .sidebar { display: flex; flex-direction: column; gap: 1rem; position: sticky; top: 74px; }
        .sidebar-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
        }
        .sidebar-head {
            padding: 14px 16px 10px;
            border-bottom: 1px solid var(--border);
        }
        .sidebar-head h4 {
            font-family: var(--font-serif);
            font-size: 13px;
            font-weight: 400;
            color: var(--text-3);
            text-transform: uppercase;
            letter-spacing: 0.09em;
        }
        .sidebar-body { padding: 6px 0; }
        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 16px;
            font-size: 13px;
            color: var(--text-2);
            text-decoration: none;
            font-weight: 400;
            transition: background .1s, color .1s;
            border-left: 2px solid transparent;
        }
        .sidebar-item:hover { background: var(--surface-2); color: var(--text); }
        .sidebar-item.active {
            color: var(--text);
            font-weight: 700;
            border-left-color: var(--text);
            background: var(--surface-2);
        }
        .sidebar-dot {
            width: 4px; height: 4px;
            border-radius: 50%;
            background: var(--border-md);
            flex-shrink: 0;
        }
        .sidebar-item.active .sidebar-dot { background: var(--text); }

        /* Shared utilities */
        .tag {
            display: inline-block;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 2px 8px;
            border-radius: 3px;
        }
        .tag-blue { background: var(--blue-bg); color: var(--blue-text); }
        .tag-green { background: var(--green-bg); color: var(--green-text); }
        .tag-amber { background: var(--amber-bg); color: var(--amber-text); }
        .tag-red { background: var(--red-bg); color: var(--red-text); }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 18px;
            border-radius: var(--radius-sm);
            font-family: var(--font-sans);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: opacity .15s, background .15s;
            border: none;
        }
        .btn-primary { background: var(--text); color: var(--surface); }
        .btn-primary:hover { opacity: 0.82; }
        .btn-ghost {
            background: transparent;
            color: var(--text-2);
            border: 1px solid var(--border-md);
        }
        .btn-ghost:hover { background: var(--surface-2); color: var(--text); }

        @media (max-width: 900px) {
            .page-wrap { grid-template-columns: 1fr; }
            .sidebar { display: none; }
            .topnav { padding: 0 1rem; }
            .nav-links { display: none; }
        }
    </style>

    @stack('styles')
</head>
<body>

<nav class="topnav">
    <a href="{{ route('posts.index') }}" class="nav-logo">Lum<strong>ina</strong></a>
    <div class="nav-sep"></div>
    <input class="nav-search" type="text" placeholder="Rechercher...">
    <div class="nav-links">
        <a href="{{ route('posts.index') }}" class="nav-link {{ request()->routeIs('posts.index') ? 'active' : '' }}">Actualités</a>
        <a href="{{ route('forum.index') }}" class="nav-link {{ request()->routeIs('forum.*') ? 'active' : '' }}">Forum</a>
    </div>
    <div class="nav-spacer"></div>
    @auth
    <div class="nav-user">
        <div class="nav-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
        <span class="nav-username">{{ Auth::user()->name }}</span>
        <a href="{{ route('logout') }}" class="btn-logout"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Déconnexion</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
    </div>
    @endauth
    @guest
    <a href="{{ route('login') }}" class="btn btn-ghost" style="padding:6px 14px;">Connexion</a>
    @endguest
</nav>

@if(session('success'))
    <div class="flash flash-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="flash flash-error">{{ session('error') }}</div>
@endif

@yield('content')

@stack('scripts')
</body>
</html>
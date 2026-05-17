<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Texoffice ERP')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
   <style>
    /* Stat Cards */
.stat-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    border-radius: 16px 16px 0 0;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.08);
}

.border-brouillon::before { background: #6c757d; }
.border-envoye::before { background: #0d6efd; }
.border-accepte::before { background: #198754; }
.border-refuse::before { background: #dc3545; }

.icon-circle {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
}

.bg-icon-brouillon { background: #f1f5f9; color: #6c757d; }
.bg-icon-envoye { background: #eff6ff; color: #0d6efd; }
.bg-icon-accepte { background: #ecfdf5; color: #198754; }
.bg-icon-refuse { background: #fef2f2; color: #dc3545; }

.stat-value {
    font-size: 1.8rem;
    font-weight: 700;
    margin-top: 8px;
    letter-spacing: -1px;
}

.stat-label {
    font-size: 0.85rem;
    color: var(--text-muted);
    font-weight: 500;
}
    :root {
        --sidebar-width: 270px;
        --primary: #1e3a5f;
        --primary-light: #2c5282;
        --accent: #c75b39;
        --accent-light: #e07a5f;
        --bg: #f1f5f9;
        --card-bg: #ffffff;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --border: #e2e8f0;
        --success: #059669;
        --warning: #d97706;
        --danger: #dc2626;
    }

    * { font-family: 'Inter', sans-serif; }

    body {
        background: var(--bg);
        color: var(--text-main);
        margin: 0;
        padding: 0;
    }

    /* Sidebar */
    .sidebar {
        width: var(--sidebar-width);
        height: 100vh;
        background: linear-gradient(180deg, var(--primary) 0%, #152a45 100%);
        color: white;
        position: fixed;
        top: 0; left: 0;
        z-index: 1000;
        box-shadow: 4px 0 24px rgba(0,0,0,0.15);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .brand {
        padding: 24px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.08);
        flex-shrink: 0;
    }

    .brand h4 {
        font-weight: 700;
        letter-spacing: -0.5px;
        font-size: 1.4rem;
        margin: 0;
    }

    .brand small {
        color: rgba(255,255,255,0.5);
        font-size: 0.75rem;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    /* Navigation scrollable */
    .nav-scroll {
        flex: 1;
        overflow-y: auto;
        padding: 12px 0;
    }

    /* Cacher scrollbar mais garder fonctionnalité */
    .nav-scroll::-webkit-scrollbar {
        width: 4px;
    }
    .nav-scroll::-webkit-scrollbar-track {
        background: transparent;
    }
    .nav-scroll::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.2);
        border-radius: 4px;
    }

    .nav-link {
        color: rgba(255,255,255,0.65);
        padding: 12px 20px;
        margin: 2px 12px;
        border-radius: 10px;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.25s ease;
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
    }

    .nav-link:hover, .nav-link.active {
        background: rgba(255,255,255,0.12);
        color: white;
        transform: translateX(4px);
    }

    .nav-link i { font-size: 1.1rem; }

    /* User box fixé en bas */
    .user-box {
        padding: 16px;
        background: rgba(255,255,255,0.06);
        border-top: 1px solid rgba(255,255,255,0.08);
        flex-shrink: 0;
    }

    .user-box .role-badge {
        font-size: 0.7rem;
        padding: 2px 8px;
        border-radius: 20px;
        background: var(--accent);
        color: white;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .logout-btn {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.15);
        color: rgba(255,255,255,0.8);
        padding: 8px;
        border-radius: 8px;
        font-size: 0.85rem;
        transition: all 0.2s;
        width: 100%;
        cursor: pointer;
    }

    .logout-btn:hover {
        background: rgba(220,38,38,0.2);
        border-color: rgba(220,38,38,0.4);
        color: #fecaca;
    }

    /* Main Content */
    .main-content {
        margin-left: var(--sidebar-width);
        padding: 32px;
        min-height: 100vh;
    }

    /* ... garder le reste de tes styles ... */
</style>
    @yield('styles')
</head>
<body>

<!-- Sidebar -->

<div class="sidebar">
    <div class="brand">
        <h4 class="m-0"><i class="bi bi-layers-fill"></i> Texoffice</h4>
        <small>ERP Gestion Textile</small>
    </div>

    <!-- Navigation scrollable -->
    <div class="nav-scroll">
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i> Tableau de bord
        </a>
        <a href="{{ route('devis.index') }}" class="nav-link {{ request()->routeIs('devis.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text-fill"></i> Devis Clients
        </a>
        <a href="{{ route('clients.index') }}" class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> Clients
        </a>
        <a href="{{ route('articles.index') }}" class="nav-link {{ request()->routeIs('articles.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam-fill"></i> Stock & Articles
        </a>
        <a href="{{ route('mouvements.index') }}" class="nav-link {{ request()->routeIs('mouvements.*') ? 'active' : '' }}">
            <i class="bi bi-arrow-left-right"></i> Mouvements
        </a>
        <a href="{{ route('machines.index') }}" class="nav-link {{ request()->routeIs('machines.*') ? 'active' : '' }}">
            <i class="bi bi-gear-wide-connected"></i> Parc Machines
        </a>
        <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="bi bi-shield-lock-fill"></i> Utilisateurs
        </a>
        <a href="{{ route('activity.log') }}" class="nav-link {{ request()->routeIs('activity.log') ? 'active' : '' }}">
            <i class="bi bi-journal-text"></i> Journal d'activité
        </a>
        <a href="{{ route('interventions.index') }}" class="nav-link {{ request()->routeIs('interventions.*') ? 'active' : '' }}">
    <i class="bi bi-wrench-adjustable"></i> Interventions
</a>
    </div>

    <!-- User box fixé en bas -->
    <div class="user-box">
        <div class="d-flex align-items-center gap-3 mb-3">
            <div class="bg-white bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width:42px;height:42px;">
                <i class="bi bi-person-fill fs-5"></i>
            </div>
            <div>
                <div class="fw-semibold" style="font-size:0.9rem;">{{ auth()->user()->name }}</div>
                <span class="role-badge">{{ auth()->user()->role }}</span>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button class="logout-btn border-0">
                <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
            </button>
        </form>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@yield('scripts')

</body>
</html>
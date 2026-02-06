<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Absensi Siswa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-color: #6366f1;
            --primary-dark: #4f46e5;
            --secondary-color: #ec4899;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #06b6d4;
            --dark-color: #1e293b;
            --light-bg: #f8fafc;
            --card-shadow: 0 1px 3px rgba(0,0,0,0.1), 0 1px 2px rgba(0,0,0,0.06);
            --card-shadow-hover: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
        }
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: var(--light-bg); min-height: 100vh; }
        .sidebar {
            position: fixed; top: 0; left: 0; width: 280px; height: 100vh;
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            padding: 0; z-index: 1000; overflow-y: auto;
        }
        .sidebar-header { padding: 1.5rem; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-brand { color: white; font-size: 1.5rem; font-weight: 800; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 0.5rem; }
        .sidebar-brand span { background: linear-gradient(135deg, #fff 0%, #e0e7ff 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .sidebar-menu { padding: 1rem 0; }
        .menu-label { color: rgba(255,255,255,0.5); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; padding: 1rem 1.5rem 0.5rem; }
        .nav-item { padding: 0 1rem; margin-bottom: 0.25rem; }
        .nav-link {
            color: rgba(255,255,255,0.8); padding: 0.75rem 1rem; border-radius: 10px;
            display: flex; align-items: center; gap: 0.75rem; font-weight: 500;
        }
        .nav-link:hover { color: white; background: rgba(255,255,255,0.1); transform: translateX(5px); }
        .nav-link.active { color: var(--primary-color); background: white; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .nav-link i { font-size: 1.25rem; width: 24px; text-align: center; }
        .main-content { margin-left: 280px; min-height: 100vh; }
        .top-navbar {
            background: white; padding: 1rem 2rem; box-shadow: var(--card-shadow);
            position: sticky; top: 0; z-index: 999; display: flex; justify-content: space-between; align-items: center;
        }
        .navbar-title { font-size: 1.5rem; font-weight: 700; color: var(--dark-color); margin: 0; }
        .user-menu { display: flex; align-items: center; gap: 1rem; }
        .user-info { text-align: right; }
        .user-name { font-weight: 600; color: var(--dark-color); margin: 0; }
        .user-role { font-size: 0.8rem; color: #64748b; margin: 0; }
        .user-avatar {
            width: 45px; height: 45px; border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.1rem;
        }
        .page-content { padding: 2rem; }
        .card { border: none; border-radius: 16px; box-shadow: var(--card-shadow); overflow: hidden; }
        .card-header { background: white; border-bottom: 1px solid #e2e8f0; padding: 1.25rem 1.5rem; font-weight: 600; }
        .card-body { padding: 1.5rem; }
        .stat-card { background: white; border-radius: 16px; padding: 1.5rem; box-shadow: var(--card-shadow); position: relative; overflow: hidden; }
        .stat-card::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 4px; }
        .stat-card.primary::before { background: var(--primary-color); }
        .stat-card.success::before { background: var(--success-color); }
        .stat-card.warning::before { background: var(--warning-color); }
        .stat-card.danger::before { background: var(--danger-color); }
        .stat-card.info::before { background: var(--info-color); }
        .stat-card:hover { transform: translateY(-5px); box-shadow: var(--card-shadow-hover); }
        .stat-icon { width: 60px; height: 60px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white; }
        .stat-icon.primary { background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); }
        .stat-icon.success { background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%); }
        .stat-icon.warning { background: linear-gradient(135deg, var(--warning-color) 0%, #d97706 100%); }
        .stat-icon.danger { background: linear-gradient(135deg, var(--danger-color) 0%, #dc2626 100%); }
        .stat-icon.info { background: linear-gradient(135deg, var(--info-color) 0%, #0891b2 100%); }
        .stat-value { font-size: 2rem; font-weight: 800; color: var(--dark-color); line-height: 1; }
        .stat-label { color: #64748b; font-size: 0.9rem; font-weight: 500; }
        .btn { border-radius: 10px; padding: 0.6rem 1.25rem; font-weight: 600; }
        .btn-primary { background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); border: none; }
        .form-control, .form-select { border-radius: 10px; border: 2px solid #e2e8f0; padding: 0.75rem 1rem; }
        .form-control:focus, .form-select:focus { border-color: var(--primary-color); box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); }
        .table thead th { background: #f1f5f9; border: none; padding: 1rem; font-weight: 600; color: var(--dark-color); }
        .table tbody td { padding: 1rem; vertical-align: middle; border-color: #f1f5f9; }
        .badge { padding: 0.5rem 0.75rem; border-radius: 8px; font-weight: 600; font-size: 0.75rem; }
        .live-clock { background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); color: white; padding: 1.5rem; border-radius: 16px; text-align: center; }
        .clock-time { font-size: 3rem; font-weight: 800; line-height: 1; }
        .clock-date { font-size: 1rem; opacity: 0.9; margin-top: 0.5rem; }
        @media (max-width: 991.98px) { .sidebar { transform: translateX(-100%); } .sidebar.show { transform: translateX(0); } .main-content { margin-left: 0; } }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="sidebar-brand">
                <div style="width: 45px; height: 45px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-mortarboard-fill" style="font-size: 1.5rem; color: var(--primary-color);"></i>
                </div>
                <span>Absensi Siswa</span>
            </a>
        </div>
        <div class="sidebar-menu">
            <div class="menu-label">Menu Utama</div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-grid-1x2-fill"></i> Dashboard
                    </a>
                </li>
                @if(Auth::user()->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('qrabsen.*') ? 'active' : '' }}" href="{{ route('qrabsen.show') }}">
                            <i class="bi bi-qr-code-scan"></i> Tampilkan QR Absen
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('absensi.*') ? 'active' : '' }}" href="{{ route('absensi.index') }}">
                            <i class="bi bi-calendar-check-fill"></i> Absensi Harian
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('absensi.bulanan') ? 'active' : '' }}" href="{{ route('absensi.bulanan') }}">
                            <i class="bi bi-calendar-month-fill"></i> Rekap Bulanan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('absensi.tahunan') ? 'active' : '' }}" href="{{ route('absensi.tahunan') }}">
                            <i class="bi bi-calendar-range-fill"></i> Rekap Tahunan
                        </a>
                    </li>
                    <div class="menu-label">Master Data</div>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kelas.*') ? 'active' : '' }}" href="{{ route('kelas.index') }}">
                            <i class="bi bi-building"></i> Data Kelas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('siswa.*') ? 'active' : '' }}" href="{{ route('siswa.index') }}">
                            <i class="bi bi-people-fill"></i> Data Siswa
                        </a>
                    </li>
                    <div class="menu-label">Laporan</div>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('report.*') ? 'active' : '' }}" href="{{ route('report.index') }}">
                            <i class="bi bi-file-earmark-pdf-fill"></i> Download Report
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}#absen-info">
                            <i class="bi bi-qr-code-scan"></i> Scan QR untuk Absen
                        </a>
                    </li>
                @endif
            </ul>
            <div class="menu-label">Akun</div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.show') }}">
                        <i class="bi bi-person-fill"></i> Profil
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <main class="main-content">
        <nav class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light d-lg-none" id="sidebarToggle"><i class="bi bi-list"></i></button>
                <h1 class="navbar-title">@yield('title', 'Dashboard')</h1>
            </div>
            <div class="user-menu">
                <div class="user-info d-none d-md-block">
                    <p class="user-name">{{ Auth::user()->name }}</p>
                    <p class="user-role">{{ ucfirst(Auth::user()->role) }}</p>
                </div>
                <div class="dropdown">
                    <button class="user-avatar dropdown-toggle" type="button" data-bs-toggle="dropdown" style="border: none;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="bi bi-person me-2"></i>Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">@csrf
                                <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="page-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show"><i class="bi bi-info-circle me-2"></i>{{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @yield('content')
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', function() { document.getElementById('sidebar').classList.toggle('show'); });
    </script>
    @stack('scripts')
</body>
</html>

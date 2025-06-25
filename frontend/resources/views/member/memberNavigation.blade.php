<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('dashboard-name') - Member Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --sidebar-width: 250px;
            --topbar-height: 70px;
            --transition-speed: 0.3s;
            --sidebar-bg: #ffffff;
            --topbar-bg: #ffffff;
            --active-color: #6f42c1; /* Ungu untuk tema member */
            --hover-color: #f3eafd;
        }
        body {
            background-color: #f8f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }
        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--sidebar-bg);
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            z-index: 1000;
            transition: all var(--transition-speed) ease;
            padding-top: var(--topbar-height);
            overflow-y: auto;
        }
        .sidebar-brand {
            padding: 1.5rem 1rem;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--active-color);
            text-align: center;
            border-bottom: 1px solid #eaecf4;
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            z-index: 1010;
            background: var(--sidebar-bg);
        }
        .sidebar-menu {
            margin-top: 90px;
        }
        .sidebar-menu a {
            display: block;
            padding: 0.75rem 1rem;
            color: #5a5c69;
            text-decoration: none;
            border-radius: 0.35rem;
            transition: all 0.15s ease;
        }
        .sidebar-menu a:hover {
            background-color: var(--hover-color);
            color: var(--active-color);
        }
        .sidebar-menu a.active {
            background-color: var(--active-color);
            color: #fff;
        }
        /* Topbar Styling */
        .topbar {
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            height: var(--topbar-height);
            background-color: var(--topbar-bg);
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            z-index: 1000;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
        }
        .topbar .toggle-btn {
            background: none;
            border: none;
            font-size: 1.25rem;
            color: #5a5c69;
            cursor: pointer;
            display: none;
        }
        .topbar {
            border-bottom: 2px solid #e5d8fa;
        }
        .topbar .toggle-btn:focus {
            outline: none;
        }
        .main-content {
            margin-top: var(--topbar-height);
            margin-left: var(--sidebar-width);
            padding: 1.5rem;
            transition: all var(--transition-speed) ease;
        }
        /* Responsive Design */
        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .topbar { left: 0; }
            .main-content { margin-left: 0; }
            .topbar .toggle-btn { display: block; }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-people-fill me-2"></i>@yield('dashboard-name')
        </div>
        <div class="sidebar-menu">
            <a href="{{ route('member.dashboard') }}" class="sidebar-link {{ request()->routeIs('member.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 sidebar-icon me-2"></i>Dashboard
            </a>
            <a href="{{ route('events.index') }}" class="sidebar-link {{ request()->routeIs('events.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-event sidebar-icon me-2"></i>Events
            </a>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();" class="sidebar-link">
                <i class="bi bi-box-arrow-right sidebar-icon me-2"></i>Logout
            </a>
        </div>
    </div>
    
    <!-- Topbar -->
    <div class="topbar">
        <button class="toggle-btn" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>
        <div class="d-flex align-items-center flex-grow-1">
            <span class="me-3">Selamat datang, {{ Session::get('user')['nama'] ?? 'Member' }}</span>
        </div>
        <form id="logoutForm" action="{{ route('logout') }}" method="POST">
            @csrf
        </form>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
        <footer class="mt-5 text-center text-muted">
            <p>© 2025 Member Dashboard. All rights reserved.</p>
        </footer>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });
    </script>
</body>
</html>

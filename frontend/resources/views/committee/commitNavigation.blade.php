<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Committee Dashboard - @yield('title', 'Dashboard')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --sidebar-width: 250px;
            --topbar-height: 70px;
            --transition-speed: 0.3s;
            --sidebar-bg: #ffffff;
            --topbar-bg: #ffffff;
            --active-color: #28a745;
            --hover-color: #f8f9fc;
        }
        body {
            background-color: #f8f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--sidebar-bg);
            box-shadow: 0 0.15rem 1.75rem rgba(58,59,69,0.15);
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
            background: var(--sidebar-bg);
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            z-index: 1010;
        }
        .sidebar-menu { padding: 1rem 0; }
        .sidebar-item { margin: .5rem 1rem; }
        .sidebar-link {
            display: flex; align-items: center;
            padding: .75rem 1rem;
            color: #5a5c69; text-decoration: none;
            border-radius: .35rem;
            transition: all 0.15s ease;
        }
        .sidebar-link:hover {
            background-color: var(--hover-color);
            color: var(--active-color);
        }
        .sidebar-link.active {
            background-color: var(--active-color);
            color: #fff;
        }
        .sidebar-icon { margin-right: .75rem; font-size: 1.1rem; }
        .topbar {
            position: fixed;
            top: 0; left: var(--sidebar-width); right: 0;
            height: var(--topbar-height);
            background-color: var(--topbar-bg);
            box-shadow: 0 0.15rem 1.75rem rgba(58,59,69,0.1);
            z-index: 1000;
            display: flex; align-items: center;
            padding: 0 1.5rem;
            transition: all var(--transition-speed) ease;
        }
        .topbar-content {
            width: 100%;
            display: flex; justify-content: space-between; align-items: center;
        }
        .toggle-btn {
            display: none;
            background: none; border: none;
            font-size: 1.25rem; color: #5a5c69; cursor: pointer;
        }
        .main-content {
            margin-top: var(--topbar-height);
            margin-left: var(--sidebar-width);
            padding: 1.5rem;
            transition: all var(--transition-speed) ease;
        }
        footer {
            margin-top: 5rem;
            text-align: center;
            color: #6c757d;
        }
        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .topbar { left: 0; }
            .main-content { margin-left: 0; }
            .toggle-btn { display: block; }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-calendar-event me-2"></i>Committee Panel
        </div>
        <div class="sidebar-menu">
            <div class="sidebar-item">
                <a href="{{ route('committee.dashboard') }}" class="sidebar-link @if(request()->routeIs('committee.dashboard')) active @endif">
                    <i class="bi bi-speedometer2 sidebar-icon"></i> Dashboard
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('committee.event.index') }}" class="sidebar-link @if(request()->routeIs('committee.event.*')) active @endif">
                    <i class="bi bi-calendar-check sidebar-icon"></i> Events
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('committee.event.scan') }}" class="sidebar-link @if(request()->routeIs('committee.event.scan')) active @endif">
                    <i class="bi bi-qr-code sidebar-icon"></i> Scan Absensi
                </a>
            </div>
            <!-- ... tambahkan menu lain jika perlu -->
        </div>
    </div>

    <!-- Topbar -->
    <div class="topbar">
        <div class="topbar-content">
            <button class="toggle-btn" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <div class="d-flex align-items-center">
                <span class="me-3">Selamat datang, {{ Auth::user()->name ?? 'Committee' }}</span>
                <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="button" id="logoutBtn" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
        <footer>
            <p>© 2025 Committee Dashboard. Evan Kristian Pratama. All rights reserved.</p>
        </footer>
    </div>

    <!-- Core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Tambahan CDN untuk QR scanner & generator --}}
    <script src="https://unpkg.com/html5-qrcode@2.3.7/minified/html5-qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>

    {{-- Inject scripts from child views (@push('scripts')) --}}
    @stack('scripts')

    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', () => {
            document.querySelector('.sidebar').classList.toggle('active');
        });
        // Logout confirmation
        document.getElementById('logoutBtn').addEventListener('click', () => {
            Swal.fire({
                title: 'Konfirmasi',
                text: "Yakin ingin logout?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, logout!',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        });
    </script>
</body>
</html>

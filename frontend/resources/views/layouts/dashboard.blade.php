<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Bootstrap CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        :root {
            --sidebar-width: 250px;
            --topbar-height: 70px;
            --transition-speed: 0.3s;
            --sidebar-bg: #ffffff;
            --topbar-bg: #ffffff;
            --active-color: #4e73df;
            --hover-color: #f8f9fc;
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
            color: #4e73df;
            text-align: center;
            border-bottom: 1px solid #eaecf4;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            z-index: 1010;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .sidebar-item {
            margin: 0.5rem 1rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #5a5c69;
            text-decoration: none;
            border-radius: 0.35rem;
            transition: all 0.15s ease;
        }

        .sidebar-link:hover {
            background-color: var(--hover-color);
            color: var(--active-color);
        }

        .sidebar-link.active {
            background-color: var(--active-color);
            color: white;
        }

        .sidebar-icon {
            margin-right: 0.75rem;
            font-size: 1.1rem;
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
            transition: all var(--transition-speed) ease;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
        }

        .topbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .toggle-btn {
            background: none;
            border: none;
            font-size: 1.25rem;
            color: #5a5c69;
            cursor: pointer;
            display: none;
        }

        /* Main Content Styling */
        .main-content {
            margin-top: var(--topbar-height);
            margin-left: var(--sidebar-width);
            padding: 1.5rem;
            transition: all var(--transition-speed) ease;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .topbar {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .toggle-btn {
                display: block;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-speedometer2 me-2"></i>Admin Panel
        </div>

        <div class="sidebar-menu">
            <div class="sidebar-item">
                <a href="#" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 sidebar-icon"></i>
                    Dashboard
                </a>
            </div>

            <div class="sidebar-item">
                <a href="#" class="sidebar-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <i class="bi bi-people sidebar-icon"></i>
                    Pengguna
                </a>
            </div>

           

        </div>
    </div>

    <!-- Topbar -->
    <div class="topbar @yield('nav-color')">
        <div class="topbar-content">
            <button class="toggle-btn" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>

            <div class="d-flex align-items-center">
                <span class="me-3">@yield('dashboard-name')</span>
                <form class="d-inline" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    <!-- Bootstrap JS & Chart.js (jika nanti diperlukan) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Toggle sidebar di mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });
    </script>
</body>
</html>

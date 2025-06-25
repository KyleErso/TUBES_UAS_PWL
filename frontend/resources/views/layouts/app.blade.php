<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Where2Go')</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        /* ========== GLOBAL STYLES ========== */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        main {
            flex: 1;
            padding-top: 20px;
            padding-bottom: 40px;
        }
        
        /* ========== NAVBAR STYLES ========== */
        .navbar-custom {
            background-color: #fff;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            padding-top: 10px;
            padding-bottom: 10px;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: #6f42c1 !important;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .navbar-brand:hover {
            transform: translateY(-2px);
        }
        
        .navbar-brand i {
            margin-right: 8px;
            font-size: 1.5rem;
        }
        
        .navbar-toggler {
            border: none;
            outline: none !important;
            box-shadow: none !important;
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28111, 66, 193, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        /* Search bar in navbar */
        .search-container {
            max-width: 700px;
            margin: 0 auto;
            width: 100%;
        }
        
        .search-form {
            background: white;
            border-radius: 50px;
            padding: 5px 15px;
            box-shadow: 0 4px 15px rgba(111, 66, 193, 0.12);
            border: 1px solid #e9e1ff;
            transition: all 0.3s ease;
        }
        
        .search-form:hover {
            box-shadow: 0 6px 20px rgba(111, 66, 193, 0.18);
        }
        
        .search-input {
            border: none;
            background: transparent;
            padding: 8px 12px;
            font-size: 0.95rem;
        }
        
        .search-input:focus {
            outline: none;
            box-shadow: none;
        }
        
        .search-button {
            background: #6f42c1;
            color: white;
            border-radius: 30px;
            padding: 8px 25px;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .search-button:hover {
            background: #5a33a0;
            transform: translateY(-2px);
        }
        
        /* User actions */
        .user-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .user-greeting {
            color: #6f42c1;
            font-weight: 500;
            margin-right: 5px;
        }
        
        .btn-login {
            background-color: #6f42c1;
            color: white;
            border-radius: 20px;
            padding: 6px 20px;
            border: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            background-color: #5a33a0;
            color: white;
            transform: translateY(-2px);
        }
        
        .btn-outline-primary {
            border-color: #6f42c1;
            color: #6f42c1;
            border-radius: 20px;
            padding: 6px 15px;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background-color: #6f42c1;
            color: white;
        }
        
        .btn-outline-secondary {
            border-radius: 20px;
            padding: 6px 15px;
        }
        
        /* ========== MAIN CONTENT ========== */
        .page-header {
            margin-bottom: 30px;
            padding: 20px 0;
            border-bottom: 1px solid #eaeaea;
        }
        
        .page-title {
            color: #6f42c1;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .page-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
        }
        
        /* ========== FOOTER STYLES ========== */
        .main-footer {
            background: #f8f6fc;
            padding: 60px 0 30px;
            margin-top: auto;
        }
        
        .footer-column {
            padding: 0 25px;
            margin-bottom: 30px;
        }
        
        .footer-title {
            color: #6f42c1;
            font-weight: 700;
            margin-bottom: 20px;
            font-size: 1.2rem;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 2px;
            background: #8a63d2;
        }
        
        .footer-link {
            color: #6c757d !important;
            padding: 8px 0;
            display: block;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .footer-link:hover {
            color: #6f42c1 !important;
            transform: translateX(5px);
        }
        
        .footer-contact {
            color: #6c757d;
            line-height: 1.8;
        }
        
        .footer-contact a {
            color: #6f42c1;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .footer-contact a:hover {
            color: #4e2a97;
            text-decoration: underline;
        }
        
        .social-links {
            display: flex;
            gap: 12px;
            margin-top: 15px;
        }
        
        .social-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            color: #6f42c1;
            border: 1px solid #e9e1ff;
            transition: all 0.3s ease;
        }
        
        .social-btn:hover {
            background: #6f42c1;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(111, 66, 193, 0.2);
        }
        
        .footer-bottom {
            border-top: 1px solid #e9ecef;
            margin-top: 40px;
            padding-top: 25px;
        }
        
        .footer-links {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-bottom: 15px;
        }
        
        .footer-links a {
            color: #6c757d;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .footer-links a:hover {
            color: #6f42c1;
        }
        
        .copyright {
            color: #6c757d;
            font-size: 0.95rem;
        }
        
        /* ========== RESPONSIVE ADJUSTMENTS ========== */
        @media (max-width: 992px) {
            .navbar-collapse {
                padding-top: 20px;
            }
            
            .search-container {
                margin: 15px 0;
                max-width: 100%;
            }
            
            .user-actions {
                margin-top: 15px;
                padding-top: 15px;
                border-top: 1px solid #f0f0f0;
                width: 100%;
                justify-content: flex-start;
            }
        }
        
        @media (max-width: 768px) {
            .footer-column {
                margin-bottom: 30px;
            }
            
            .footer-links {
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }
        }

        .user-greeting.small {
            font-size: 0.95rem;
            padding-right: 4px;
        }
        .btn-login.btn-sm,
        .btn-outline-primary.btn-sm,
        .btn-outline-secondary.btn-sm {
            font-size: 0.95rem;
            padding: 4px 14px;
            border-radius: 16px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom shadow-sm sticky-top">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-geo-alt-fill"></i>Where2Go
            </a>
            
            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Search Bar -->
                <div class="search-container">
                    <form class="search-form d-flex align-items-center" method="GET" action="{{ url('/events') }}">
                        <i class="bi bi-search text-purple me-2"></i>
                        <input
                            class="search-input flex-grow-1"
                            type="search"
                            name="q"
                            placeholder="Temukan event seru di sekitarmu..."
                            aria-label="Search events"
                        />
                        <button class="search-button btn" type="submit">Cari</button>
                    </form>
                </div>
                
                <!-- User Actions -->
                <div class="user-actions ms-auto align-items-center">
                    @if(Session::has('user'))
                        <span class="user-greeting small">Hai, {{ Session::get('user')['nama'] }}</span>
                        @if(Session::get('user')['role'] === 'member')
                            <a href="{{ route('member.dashboard') }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-calendar-check me-1"></i>
                                <span class="d-none d-md-inline">Events Saya</span>
                                <span class="d-inline d-md-none">Event</span>
                            </a>
                        @endif
                        <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-box-arrow-right me-1"></i>
                                <span class="d-none d-md-inline">Logout</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-login btn-sm">
                            <i class="bi bi-box-arrow-in-right me-1"></i>
                            <span class="d-none d-md-inline">Login</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container">
        <!-- Optional Page Header -->
        @hasSection('page-header')
            @yield('page-header')
        @endif
        
        <!-- Page Content -->
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="row">
                <!-- Explore Column -->
                <div class="col-lg-3 col-md-6 footer-column">
                    <h5 class="footer-title">Jelajahi</h5>
                    <a href="#" class="footer-link">Event Terpopuler</a>
                    <a href="#" class="footer-link">Event Terdekat</a>
                    <a href="#" class="footer-link">Event Virtual</a>
                    <a href="#" class="footer-link">Semua Kategori</a>
                </div>
                
                <!-- Company Column -->
                <div class="col-lg-3 col-md-6 footer-column">
                    <h5 class="footer-title">Perusahaan</h5>
                    <a href="#" class="footer-link">Tentang Kami</a>
                    <a href="#" class="footer-link">Blog</a>
                    <a href="#" class="footer-link">Karir</a>
                    <a href="#" class="footer-link">Partner</a>
                </div>
                
                <!-- Help Column -->
                <div class="col-lg-3 col-md-6 footer-column">
                    <h5 class="footer-title">Bantuan</h5>
                    <a href="#" class="footer-link">Pusat Bantuan</a>
                    <a href="#" class="footer-link">FAQ</a>
                    <a href="#" class="footer-link">Kebijakan Privasi</a>
                    <a href="#" class="footer-link">Syarat & Ketentuan</a>
                </div>
                
                <!-- Contact Column -->
                <div class="col-lg-3 col-md-6 footer-column">
                    <h5 class="footer-title">Hubungi Kami</h5>
                    <div class="footer-contact">
                        <p>
                            <i class="bi bi-geo-alt me-2"></i>Jl. Digital Nomad No.123<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;Jakarta, Indonesia
                        </p>
                        <p>
                            <i class="bi bi-envelope me-2"></i>
                            <a href="mailto:hello@where2go.id">hello@where2go.id</a>
                        </p>
                        <p>
                            <i class="bi bi-telephone me-2"></i>
                            <a href="tel:+622112345678">(021) 1234-5678</a>
                        </p>
                        
                        <div class="social-links">
                            <a href="#" class="social-btn"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="social-btn"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="social-btn"><i class="bi bi-twitter-x"></i></a>
                            <a href="#" class="social-btn"><i class="bi bi-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom text-center">
                <div class="footer-links">
                    <a href="#">Kebijakan Privasi</a>
                    <a href="#">Syarat Layanan</a>
                    <a href="#">Peta Situs</a>
                    <a href="#">FAQ</a>
                    <a href="#">Karir</a>
                </div>
                <p class="copyright mb-0">&copy; 2025 Where2Go. All rights reserved</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
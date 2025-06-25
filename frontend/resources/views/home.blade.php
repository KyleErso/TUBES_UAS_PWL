@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Event - Beranda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4e73df;
            --secondary: #6f42c1;
            --accent: #36b9cc;
            --light: #f8f9fc;
            --dark: #2e4374;
        }
        
        body {
            background-color: #f8f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            padding-top: 20px;
        }
        
        .hero-section {
            margin-bottom: 40px;
        }
        
        /* Carousel Styling */
        .event-carousel {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
        
        .carousel-img {
            height: 480px;
            object-fit: cover;
            object-position: center;
        }
        
        .carousel-caption {
            background: rgba(0, 0, 0, 0.65);
            border-radius: 12px;
            padding: 20px;
            max-width: 80%;
            margin: 0 auto;
            bottom: 40px;
            left: 0;
            right: 0;
        }
        
        .carousel-caption h5 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 12px;
        }
        
        .carousel-caption p {
            font-size: 1.1rem;
            margin-bottom: 0;
        }
        
        .carousel-control-prev, 
        .carousel-control-next {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
            top: 50%;
            transform: translateY(-50%);
            margin: 0 20px;
        }
        
        /* Sponsors Section */
        .sponsors-section {
            background: linear-gradient(135deg, #ffffff, #f1f5f9);
            border-radius: 16px;
            padding: 40px 30px;
            margin: 50px 0;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }
        
        .section-title {
            position: relative;
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            text-align: center;
            margin-bottom: 40px;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 2px;
        }
        
        .sponsor-track {
            overflow: hidden;
            padding: 20px 0;
        }
        
        .sponsor-marquee {
            display: inline-flex;
            white-space: nowrap;
            animation: marquee 25s linear infinite;
        }
        
        .sponsor-logo {
            height: 60px;
            margin: 0 40px;
            filter: grayscale(100%);
            opacity: 0.7;
            transition: all 0.3s ease;
        }
        
        .sponsor-logo:hover {
            filter: grayscale(0%);
            opacity: 1;
            transform: scale(1.08);
        }
        
        /* Popular Events Section */
        .events-section {
            background: white;
            border-radius: 16px;
            padding: 40px 30px;
            margin: 50px 0;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }
        
        .events-track {
            overflow: hidden;
            padding: 20px 0;
        }
        
        .events-marquee {
            display: inline-flex;
            white-space: nowrap;
            animation: marqueeRight 60s linear infinite;
        }
        
        .event-card {
            width: 340px;
            min-width: 320px;
            margin: 0 20px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            background: white;
            display: inline-block;
        }
        
        .event-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }
        
        .event-img {
            height: 220px;
            width: 100%;
            object-fit: cover;
            object-position: center;
        }
        
        .event-content {
            padding: 20px;
        }
        
        .event-title {
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--dark);
            font-size: 1.4rem;
        }
        
        .event-desc {
            color: #6c757d;
            margin-bottom: 15px;
            line-height: 1.5;
        }
        
        .event-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .event-capacity {
            font-weight: 600;
            color: var(--primary);
            background: rgba(78, 115, 223, 0.1);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
        }
        
        .event-date {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        /* Animations */
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        
        @keyframes marqueeRight {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        
        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .carousel-img {
                height: 380px;
            }
            
            .carousel-caption {
                padding: 15px;
                bottom: 20px;
            }
            
            .carousel-caption h5 {
                font-size: 1.5rem;
            }
            
            .carousel-caption p {
                font-size: 1rem;
            }
            
            .sponsor-logo {
                height: 50px;
                margin: 0 30px;
            }
        }
        
        @media (max-width: 768px) {
            .carousel-img {
                height: 300px;
            }
            
            .carousel-caption {
                max-width: 90%;
                bottom: 10px;
            }
            
            .carousel-caption h5 {
                font-size: 1.2rem;
            }
            
            .carousel-caption p {
                font-size: 0.9rem;
                display: none;
            }
            
            .sponsor-logo {
                height: 40px;
                margin: 0 20px;
            }
            
            .section-title {
                font-size: 1.7rem;
            }
            
            .event-card {
                width: 300px;
                min-width: 280px;
            }
        }
        
        @media (max-width: 576px) {
            .carousel-img {
                height: 250px;
            }
            
            .sponsor-logo {
                height: 35px;
                margin: 0 15px;
            }
            
            .section-title {
                font-size: 1.5rem;
            }
            
            .event-img {
                height: 180px;
            }
            
            .event-title {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Hero Section - Carousel -->
        <section class="hero-section">
            <div id="eventCarousel" class="carousel slide event-carousel" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @forelse($events as $index => $event)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ $event['poster'] ?? 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?q=80&w=2669&auto=format&fit=crop' }}" 
                                 class="d-block w-100 carousel-img" alt="{{ $event['judul'] }}">
                            <div class="carousel-caption">
                                <h5>{{ $event['judul'] }}</h5>
                                <p>{{ \Illuminate\Support\Str::limit($event['deskripsi'], 100) }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="carousel-item active">
                            <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?q=80&w=2669&auto=format&fit=crop" 
                                 class="d-block w-100 carousel-img" alt="Default Event">
                            <div class="carousel-caption">
                                <h5>Belum Ada Event</h5>
                                <p>Event akan tampil di sini jika sudah tersedia.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#eventCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Sebelumnya</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#eventCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Berikutnya</span>
                </button>
            </div>
        </section>

        <!-- Sponsors Section -->
        <section class="sponsors-section">
            <h2 class="section-title">Our Trusted Company & Sponsors</h2>
            <div class="sponsor-track">
                <div class="sponsor-marquee">
                    <!-- Duplicate logos for seamless animation -->
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg" alt="Google" class="sponsor-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/aa/TED_three_letter_logo.svg/2560px-TED_three_letter_logo.svg.png" alt="TED Talk" class="sponsor-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/44/Microsoft_logo.svg/2048px-Microsoft_logo.svg.png" alt="Microsoft" class="sponsor-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg" alt="Apple" class="sponsor-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7b/Meta_Platforms_Inc._logo.svg/2560px-Meta_Platforms_Inc._logo.svg.png" alt="Meta" class="sponsor-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/0/08/Netflix_2015_logo.svg" alt="Netflix" class="sponsor-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/01/LinkedIn_Logo.svg/2560px-LinkedIn_Logo.svg.png" alt="LinkedIn" class="sponsor-logo">
                    
                    <!-- Duplicate for seamless animation -->
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg" alt="Google" class="sponsor-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/aa/TED_three_letter_logo.svg/2560px-TED_three_letter_logo.svg.png" alt="TED Talk" class="sponsor-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/44/Microsoft_logo.svg/2048px-Microsoft_logo.svg.png" alt="Microsoft" class="sponsor-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg" alt="Apple" class="sponsor-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7b/Meta_Platforms_Inc._logo.svg/2560px-Meta_Platforms_Inc._logo.svg.png" alt="Meta" class="sponsor-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/0/08/Netflix_2015_logo.svg" alt="Netflix" class="sponsor-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/01/LinkedIn_Logo.svg/2560px-LinkedIn_Logo.svg.png" alt="LinkedIn" class="sponsor-logo">
                </div>
            </div>
        </section>

        <!-- Popular Events Section -->
        <section class="events-section">
            <h2 class="section-title">Our Popular Event</h2>
            <div class="events-track">
                <div class="events-marquee">
                    @php
                        // Ambil 5 event dengan kapasitas terbesar sebagai popular
                        $popularEvents = collect($events)->sortByDesc('kapasitas')->take(5);
                    @endphp
                    @forelse($popularEvents as $event)
                        <div class="event-card">
                            <img src="{{ $event['poster'] ?? 'https://images.unsplash.com/photo-1558008258-3256797b43f3?q=80&w=2662&auto=format&fit=crop' }}" 
                                 class="event-img" alt="{{ $event['judul'] }}">
                            <div class="event-content">
                                <h5 class="event-title">{{ $event['judul'] }}</h5>
                                <p class="event-desc">{{ \Illuminate\Support\Str::limit($event['deskripsi'], 80) }}</p>
                                <div class="event-meta">
                                    <span class="event-capacity">Kapasitas: {{ $event['kapasitas'] }} peserta</span>
                                    <span class="event-date">
                                        {{ \Carbon\Carbon::parse($event['tanggal'])->format('d M Y') }}
                                        @if(!empty($event['waktu']))
                                            - {{ $event['waktu'] }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="event-card">
                            <img src="https://images.unsplash.com/photo-1558008258-3256797b43f3?q=80&w=2662&auto=format&fit=crop" 
                                 class="event-img" alt="Default Event">
                            <div class="event-content">
                                <h5 class="event-title">Belum Ada Event Populer</h5>
                                <p class="event-desc">Event populer akan tampil di sini jika sudah tersedia.</p>
                                <div class="event-meta">
                                    <span class="event-capacity">-</span>
                                    <span class="event-date">-</span>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection

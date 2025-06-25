@extends('layouts.app')
@section('title', 'Daftar Event')
@section('content')
<div class="container">
    <div class="page-header text-center mb-5">
        <h1 class="page-title display-5 fw-bold" style="color: #6f42c1;">Daftar Event</h1>
    </div>

    @if(count($events))
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($events as $event)
                <div class="col">
                    <div class="card feature-card h-100 border-0 shadow-sm overflow-hidden">
                        <img 
                            src="{{ $event['poster'] ?? 'https://images.unsplash.com/photo-1505373877841-8d25f7d46678?q=80&w=2224&auto=format&fit=crop' }}" 
                            class="card-img-top event-poster" 
                            alt="Foto Event">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $event['judul'] }}</h5>
                            <p class="card-text mb-2">
                                <i class="bi bi-calendar-event text-primary me-1"></i>
                                {{ \Carbon\Carbon::parse($event['tanggal'])->translatedFormat('d M Y') }}
                            </p>
                            <p class="card-text mb-2">
                                <i class="bi bi-geo-alt text-primary me-1"></i>
                                {{ $event['lokasi'] }}
                            </p>
                            <p class="card-text mb-0">
                                <strong>Status:</strong> {{ ucfirst($event['status']) }}
                            </p>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-primary px-3 py-2">
                                    Rp{{ number_format($event['biaya'], 0, ',', '.') }}
                                </span>
                                <span class="text-muted small">
                                    Kapasitas: {{ $event['kapasitas'] }}
                                </span>
                            </div>
                            @if(Session::has('token'))
                                <a href="{{ route('events.show', $event['_id']) }}" 
                                   class="btn btn-purple w-100 py-2 fw-semibold rounded-3">
                                    Lihat Detail
                                </a>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="btn btn-purple w-100 py-2 fw-semibold rounded-3"
                                   onclick="return confirm('Silakan login terlebih dahulu untuk melihat detail event.')">
                                    Lihat Detail
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-calendar-x display-1 text-muted mb-3"></i>
            <p class="text-muted fs-5">Tidak ada event tersedia saat ini.</p>
        </div>
    @endif
</div>

<style>
    .feature-card {
        transition: transform 0.3s, box-shadow 0.3s;
        border-radius: 16px;
    }
    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 25px rgba(111, 66, 193, 0.15);
    }
    .event-poster {
        height: 200px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .feature-card:hover .event-poster {
        transform: scale(1.05);
    }
    .page-header {
        background: #f8f6fc;
        padding: 2rem 1rem;
        border-radius: 12px;
    }
    .btn-purple {
        background-color: #6f42c1;
        color: #fff;
        border: none;
    }
    .btn-purple:hover, .btn-purple:focus {
        background-color: #59359c;
        color: #fff;
    }
</style>
@endsection

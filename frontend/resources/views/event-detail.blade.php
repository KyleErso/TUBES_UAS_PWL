@extends('layouts.app')
@section('title', $event['judul'])
@section('content')
<div class="container my-5">
    @if(Session::has('error'))
        <div class="alert alert-danger mb-4">
            {{ Session::get('error') }}
        </div>
    @endif

    @if(Session::has('token'))
        <div class="card feature-card border-0 shadow-sm overflow-hidden">
            <div class="row g-0">
                <div class="col-md-5">
                    <img 
                        src="{{ $event['poster'] ?? 'https://images.unsplash.com/photo-1505373877841-8d25f7d46678?q=80&w=2224&auto=format&fit=crop' }}" 
                        class="img-fluid h-100 object-cover" 
                        alt="Poster {{ $event['judul'] }}">
                </div>
                <div class="col-md-7">
                    <div class="card-body">
                        <h2 class="card-title fw-bold mb-3">{{ $event['judul'] }}</h2>
                        <p class="card-text mb-4 text-muted">{{ $event['deskripsi'] }}</p>

                        <ul class="list-unstyled mb-4">
                            <li class="mb-2">
                                <i class="bi bi-calendar-event text-primary me-2"></i>
                                <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($event['tanggal'])->translatedFormat('d M Y') }}
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-clock text-primary me-2"></i>
                                <strong>Waktu:</strong> {{ $event['waktu_mulai'] ?? '-' }} @if(isset($event['waktu_selesai']))– {{ $event['waktu_selesai'] }} @endif
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-geo-alt text-primary me-2"></i>
                                <strong>Lokasi:</strong> {{ $event['lokasi'] }}
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-people text-primary me-2"></i>
                                <strong>Kapasitas:</strong> {{ $event['terisi'] ?? 0 }}/{{ $event['kapasitas'] }}
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-tag" style="color: #6f42c1 !important;" class="me-2"></i>
                                <strong>Biaya:</strong>
                                <span class="text-purple fw-semibold">
                                    Rp{{ number_format($event['biaya'], 0, ',', '.') }}
                                </span>
                            </li>
                            <li>
                                <i class="bi bi-info-circle text-primary me-2"></i>
                                <strong>Status:</strong> 
                                <span class="badge 
                                    @if($event['status']=='aktif') bg-success 
                                    @elseif($event['status']=='selesai') bg-secondary 
                                    @else bg-warning text-dark 
                                    @endif rounded-pill">
                                    {{ ucfirst($event['status']) }}
                                </span>
                            </li>
                        </ul>

                        <div class="d-flex gap-3">
                            <a href="{{ url('/events') }}" class="btn btn-outline-primary px-4">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>

                            @if(session('user') && session('user.role') === 'member')
                                @if(!empty($registrationStatus))
                                    <button class="btn btn-secondary px-4" disabled>
                                        Status: {{ ucfirst($registrationStatus) }}
                                    </button>
                                @else
                                    <form method="POST" action="{{ route('member.register', ['eventId' => $event['_id']]) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-success px-4">
                                            <i class="bi bi-ticket-perforated me-1"></i> Register
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <h2 class="fw-bold mb-3">Silakan Login</h2>
            <p class="text-muted mb-4">Untuk melihat detail event, silakan login terlebih dahulu.</p>
            <a href="{{ route('login') }}" class="btn btn-primary px-4 py-2">
                <i class="bi bi-box-arrow-in-right me-1"></i> Login
            </a>
        </div>
    @endif
</div>

@push('scripts')
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(Session::has('registrationSuccess'))
        <script>
            Swal.fire({
                title: 'Pendaftaran Berhasil!',
                text: 'Silakan lanjutkan pembayaran di dashboard Anda.',
                icon: 'success',
                confirmButtonText: 'Ke Dashboard'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = "{{ route('member.dashboard') }}";
                }
            });
        </script>
    @endif
@endpush

@push('styles')
<style>
.text-purple {
    color: #6f42c1 !important;
}
</style>
@endpush

<style>
    .feature-card {
        border-radius: 16px;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(111, 66, 193, 0.15);
    }
    .object-cover {
        object-fit: cover;
    }
    @media (max-width: 767px) {
        .feature-card .row > .col-md-5,
        .feature-card .row > .col-md-7 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>
@endsection

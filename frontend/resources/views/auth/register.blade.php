@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="register-container d-flex align-items-center justify-content-center py-5">
    <div class="register-card bg-white rounded-4 shadow-lg overflow-hidden animate-fade" style="max-width: 500px;">
        <div class="register-header text-center py-4" style="background: linear-gradient(135deg, #6f42c1, #8a63d2);">
            <h2 class="text-white mb-2 fw-bold">Buat Akun Baru</h2>
            <p class="text-white-50 mb-0">Isi data di bawah untuk mendaftar</p>
        </div>
        
        <div class="register-body p-4">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4 position-relative">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-person-fill text-primary"></i>
                        </span>
                        <input 
                            type="text" 
                            class="form-control form-control-lg border-start-0 @error('nama') is-invalid @enderror" 
                            id="nama" 
                            name="nama" 
                            placeholder="Nama Lengkap"
                            value="{{ old('nama') }}" 
                            required
                        >
                    </div>
                    @error('nama')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4 position-relative">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-envelope-fill text-primary"></i>
                        </span>
                        <input 
                            type="email" 
                            class="form-control form-control-lg border-start-0 @error('email') is-invalid @enderror" 
                            id="email" 
                            name="email" 
                            placeholder="email@example.com"
                            value="{{ old('email') }}" 
                            required
                        >
                    </div>
                    @error('email')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4 position-relative">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-credit-card-2-front-fill text-primary"></i>
                        </span>
                        <input 
                            type="text" 
                            class="form-control form-control-lg border-start-0 @error('nim') is-invalid @enderror" 
                            id="nim" 
                            name="nim" 
                            placeholder="NIM"
                            value="{{ old('nim') }}" 
                            required
                        >
                    </div>
                    @error('nim')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4 position-relative">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-lock-fill text-primary"></i>
                        </span>
                        <input 
                            type="password" 
                            class="form-control form-control-lg border-start-0 @error('password') is-invalid @enderror" 
                            id="password" 
                            name="password" 
                            placeholder="Password"
                            required
                        >
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4 position-relative">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-lock-fill text-primary"></i>
                        </span>
                        <input 
                            type="password" 
                            class="form-control form-control-lg border-start-0" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            placeholder="Konfirmasi Password"
                            required
                        >
                    </div>
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="terms" required>
                    <label class="form-check-label small text-muted" for="terms">
                        Saya setuju dengan <a href="#" class="text-primary">Syarat & Ketentuan</a> dan <a href="#" class="text-primary">Kebijakan Privasi</a>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3 mb-3">
                    Daftar Sekarang
                </button>

                <div class="text-center pt-3">
                    <p class="mb-0 text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="text-primary fw-semibold">Login di sini</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .register-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8f6fc 0%, #f0ebff 100%);
        padding: 2rem 1rem;
    }
    
    .register-card {
        width: 100%;
        border: none;
        transition: all 0.4s ease;
    }
    
    .register-card:hover {
        box-shadow: 0 15px 40px rgba(111, 66, 193, 0.2);
        transform: translateY(-5px);
    }
    
    .register-header {
        padding: 2.5rem 1rem;
    }
    
    .input-group-text {
        padding: 0.75rem 1.25rem;
        background: white;
        border: 1px solid #e6e6f2;
        border-right: none;
    }
    
    .form-control {
        border: 1px solid #e6e6f2;
        border-left: none;
        padding: 0.75rem 1.25rem;
        height: auto;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.15);
        border-color: #8a63d2;
    }
    
    .form-control-lg {
        font-size: 1rem;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #6f42c1, #8a63d2);
        border: none;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #5a33a0, #7149c1);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(111, 66, 193, 0.3);
    }
    
    .animate-fade {
        animation: fadeIn 0.6s ease forwards;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .form-check-input:checked {
        background-color: #6f42c1;
        border-color: #6f42c1;
    }
    
    .form-check-input:focus {
        box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25);
    }
</style>
@endsection

@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="login-container py-5">
    <div class="login-card mx-auto animate-fade">
        <div class="login-header text-center py-4">
            <h2 class="fw-bold mb-2">Masuk ke Akun Anda</h2>
            <p class="mb-0 opacity-75">Selamat datang kembali! Silakan masuk untuk melanjutkan</p>
        </div>
        
        <div class="login-body p-4">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4 position-relative">
                    <i class="bi bi-envelope-fill input-group-icon"></i>
                    <input 
                        type="email" 
                        class="form-control form-control-custom @error('email') is-invalid @enderror" 
                        id="email" 
                        name="email" 
                        placeholder="email@example.com"
                        value="{{ old('email') }}" 
                        required
                    >
                    @error('email')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4 position-relative">
                    <i class="bi bi-lock-fill input-group-icon"></i>
                    <input 
                        type="password" 
                        class="form-control form-control-custom @error('password') is-invalid @enderror" 
                        id="password" 
                        name="password" 
                        placeholder="Masukkan password"
                        required
                    >
                    @error('password')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary w-100 py-2 mb-3 fw-bold">
                    Masuk Sekarang
                </button>
                
                <div class="text-center pt-3">
                    <p class="mb-0">Belum punya akun? <a href="{{ route('register') }}" class="text-primary fw-semibold text-decoration-none">Daftar sekarang</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .login-container {
        min-height: calc(100vh - 150px);
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, #f9f7ff 0%, #f0ebff 100%);
        padding: 2rem 1rem;
    }
    
    .login-card {
        max-width: 500px;
        width: 100%;
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(111, 66, 193, 0.15);
        transition: all 0.4s ease;
    }
    
    .login-card:hover {
        box-shadow: 0 15px 40px rgba(111, 66, 193, 0.2);
        transform: translateY(-5px);
    }
    
    .login-header {
        background: linear-gradient(135deg, #6f42c1, #8a63d2);
        color: white;
        padding: 2rem;
    }
    
    .input-group-icon {
        position: absolute;
        top: 50%;
        left: 15px;
        transform: translateY(-50%);
        color: #6f42c1;
        font-size: 1.1rem;
    }
    
    .form-control-custom {
        padding-left: 45px;
        height: 50px;
        border: 1px solid #e6e6f2;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    
    .form-control-custom:focus {
        border-color: #8a63d2;
        box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.15);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #6f42c1, #8a63d2);
        border: none;
        border-radius: 12px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #5a33a0, #7149c1);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(111, 66, 193, 0.25);
    }
    
    .divider {
        border-bottom: 1px solid #e6e6f2;
    }
    
    .divider span {
        color: #6c757d;
        background: white;
        position: relative;
        top: -10px;
        padding: 0 15px;
    }
    
    .social-btn {
        width: 45px;
        height: 45px;
        border: 1px solid #e6e6f2;
        background: white;
        color: #6f42c1;
        transition: all 0.3s ease;
    }
    
    .social-btn:hover {
        background: #f5f2ff;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(111, 66, 193, 0.15);
    }
    
    .animate-fade {
        animation: fadeIn 0.6s ease forwards;
        opacity: 0;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .invalid-feedback {
        font-size: 0.85rem;
    }
</style>
@endsection
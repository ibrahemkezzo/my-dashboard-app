{{-- resources/views/auth/passwords/email.blade.php --}}
@extends('layouts.frontend')

@section('title', 'نسيت كلمة المرور | غلوزيلي')

@section('main')
<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100 py-5">
            <div class="col-lg-7 col-md-9">
                <div class="auth-card large">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold auth-title">نسيت كلمة المرور؟</h2>
                        <p class="text-muted">لا تقلقي، أدخلي بريدك الإلكتروني وسيصلك رابط لإعادة تعيين كلمة المرور</p>
                    </div>

                    <!-- Success Message -->
                    @session('status')
                        <div class="alert alert-success text-center mb-4">
                            <i class="fas fa-check-circle me-2"></i>{{ $value }}
                        </div>
                    @endsession

                    <!-- Forget Password Form -->
                    <div class="auth-form active">
                        <form method="POST" action="{{ route('password.email') }}" id="forgetPasswordForm">
                            @csrf

                            <!-- Email -->
                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">البريد الإلكتروني</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                                <i class="fas fa-paper-plane me-2"></i>إرسال رابط إعادة التعيين
                            </button>

                            <!-- Back to Login -->
                            <div class="text-center">
                                <a href="{{ route('login') }}" class="text-decoration-none text-muted">
                                    <i class="fas fa-arrow-left me-1"></i> العودة إلى تسجيل الدخول
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/auth.css?v='.config('app.version')) }}">
    <style>
        .btn-primary {
            padding: 12px 20px;
        }
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 0.95rem;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/assets/js/auth.js') }}"></script>
@endpush

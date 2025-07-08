@extends('layouts.frontend')

@section('title', 'تسجيل/تسجيل الدخول | كوافيري | My Kawafir')

@section('main')
    <div class="auth-container">
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100 py-5">
                <div class="col-lg-7 col-md-9">
                    <div class="auth-card large">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold auth-title">مرحباً بك</h2>
                            <p class="text-muted">انضمي إلى كوافيري واستمتعي بأفضل خدمات التجميل</p>
                        </div>

                        <!-- Auth Tabs -->
                        <div class="auth-tabs mb-4">
                            <button class="auth-tab active" data-tab="login">
                                <i class="fas fa-sign-in-alt me-2"></i>تسجيل الدخول
                            </button>
                            <button class="auth-tab" data-tab="register">
                                <i class="fas fa-user-plus me-2"></i>إنشاء حساب
                            </button>
                        </div>

                        <!-- Login Form -->
                        <div class="auth-form active" id="loginForm">
                            <form method="POST" action="{{ route('login') }}" id="userLoginForm">
                                @csrf
                                <div class="form-group mb-3">
                                    <label class="form-label fw-semibold">البريد الإلكتروني</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input type="email" class="form-control" id="loginEmail" name="email" value="{{old('email')}}" required autofocus autocomplete="username">
                                        {{-- <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" /> --}}
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label fw-semibold">كلمة المرور</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input name="password" type="password" class="form-control" id="loginPassword" required autocomplete="current-password">
                                        {{-- <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" /> --}}
                                        <button class="btn btn-outline-secondary" type="button" id="toggleLoginPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">
                                        تذكرني
                                    </label>
                                    <a href="#" class="float-start text-decoration-none">نسيت كلمة المرور؟</a>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                                    <i class="fas fa-sign-in-alt me-2"></i>تسجيل الدخول
                                </button>
                            </form>

                            <div class="divider mb-3">
                                <span>أو</span>
                            </div>

                            <button class="btn btn-google w-100">
                                <i class="fab fa-google me-2"></i>
                                تسجيل الدخول بـ Google
                            </button>
                        </div>

                        <!-- Register Form -->
                        <div class="auth-form" id="registerForm">
                            <form method="POST" action="{{ route('register') }}" id="userRegisterForm">
                                @csrf
                                <div class="form-group mb-3">
                                    <label class="form-label fw-semibold">الاسم</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-address-card"></i>
                                        </span>
                                        <input name="name" type="text" class="form-control" value="{{old('name')}}" id="firstName" required autofocus autocomplete="name" >
                                    </div>

                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label fw-semibold">البريد الإلكتروني</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input name="email" type="email" class="form-control" id="registerEmail" required value="{{old('email')}}" required autocomplete="username" >
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label fw-semibold">رقم الهاتف</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                        <input name="phone_number" type="tel" class="form-control" id="phone" required>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label fw-semibold">المدينة</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </span>
                                        <select name="city_id" class="form-select" id="city" required>
                                            <option value="">اختر المدينة</option>
                                            <option value="1">الرياض</option>
                                            <option value="jeddah">جدة</option>
                                            <option value="dammam">الدمام</option>
                                            <option value="mecca">مكة المكرمة</option>
                                            <option value="medina">المدينة المنورة</option>
                                            <option value="taif">الطائف</option>
                                            <option value="abha">أبها</option>
                                            <option value="tabuk">تبوك</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label fw-semibold">كلمة المرور</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input name="password" type="password" class="form-control" id="registerPassword" required>
                                        <button class="btn btn-outline-secondary" type="button" id="toggleRegisterPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="form-text">يجب أن تحتوي على 8 أحرف على الأقل</div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label fw-semibold">تأكيد كلمة المرور</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input name="password_confirmation" type="password" class="form-control" id="confirmPassword" required>
                                    </div>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                                    <label class="form-check-label" for="agreeTerms">
                                        أوافق على <a href="{{ route('terms.conditions') }}" class="text-decoration-none">الشروط والأحكام</a> و <a href="{{ route('privacy.policy') }}" class="text-decoration-none">سياسة الخصوصية</a>
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg ">
                                    <i class="fas fa-user-plus me-2"></i>إنشاء حساب
                                </button>
                                <x-button class="ms-4">
                                    {{ __('Register') }}
                                </x-button>
                            </form>

                            <div class="divider mb-3">
                                <span>أو</span>
                            </div>

                            <button class="btn btn-google w-100">
                                <i class="fab fa-google me-2"></i>
                                التسجيل بـ Google
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/auth.css') }}">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/assets/js/auth.js') }}"></script>
@endpush
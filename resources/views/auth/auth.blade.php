<div class="auth-container" data-active-tab="{{ $activeTab }}">
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
                        <button class="auth-tab {{ $activeTab == 'login' ? 'active' : '' }}" data-tab="login">
                            <i class="fas fa-sign-in-alt me-2"></i>تسجيل الدخول
                        </button>
                        <button class="auth-tab {{ $activeTab == 'register' ? 'active' : '' }}" data-tab="register">
                            <i class="fas fa-user-plus me-2"></i>إنشاء حساب
                        </button>
                    </div>

                    <!-- Login Form -->
                    <div class="auth-form {{ $activeTab == 'login' ? 'active' : '' }}" id="loginForm">
                        <form method="POST" action="{{ route('login') }}" id="userLoginForm">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">البريد الإلكتروني</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="loginEmail" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">كلمة المرور</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="loginPassword" required autocomplete="current-password">
                                    <button class="btn btn-outline-secondary" type="button" id="toggleLoginPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                                <label class="form-check-label" for="rememberMe">
                                    تذكرني
                                </label>
                                <a href="{{ route('password.request') }}" class="float-start text-decoration-none">نسيت كلمة المرور؟</a>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                                <i class="fas fa-sign-in-alt me-2"></i>تسجيل الدخول
                            </button>
                        </form>

                        <div class="divider mb-3">
                            <span>أو</span>
                        </div>
                        <div class="btn btn-google-f w-100">
                            <a href="{{ route('auth.google') }}" style="text-decoration: none; color-text:black;">
                                <i class="fab fa-google me-2"></i>
                                تسجيل الدخول بـ Google
                            </a>
                        </div>
                    </div>

                    <!-- Register Form -->
                    <div class="auth-form {{ $activeTab == 'register' ? 'active' : '' }}" id="registerForm">
                        <form method="POST" action="{{ route('register') }}" id="userRegisterForm">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">الاسم</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa fa-address-card"></i>
                                    </span>
                                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" id="firstName" required autofocus autocomplete="name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">البريد الإلكتروني</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="registerEmail" value="{{ old('email') }}" required autocomplete="username">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">رقم الهاتف</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-phone"></i>
                                    </span>
                                    <input name="phone_number" type="tel" class="form-control @error('phone_number') is-invalid @enderror" id="phone" value="{{ old('phone_number') }}" required>
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">المدينة</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </span>
                                    {{-- <select name="city_id" class="form-select @error('city_id') is-invalid @enderror" id="city" required>
                                        <option value="">اختر المدينة</option>
                                        <option value="1">الرياض</option>
                                        <option value="jeddah">جدة</option>
                                        <option value="dammam">الدمام</option>
                                        <option value="mecca">مكة المكرمة</option>
                                        <option value="medina">المدينة المنورة</option>
                                        <option value="taif">الطائف</option>
                                        <option value="abha">أبها</option>
                                        <option value="tabuk">تبوك</option>
                                        {{-- @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                        @endforeach
                                    </select> --}}
                                    <x-form.city-select name="city_id" class="form-select" />
                                    @error('city_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">كلمة المرور</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="registerPassword" required>
                                    <button class="btn btn-outline-secondary" type="button" id="toggleRegisterPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                <input class="form-check-input @error('agree_terms') is-invalid @enderror" type="checkbox" id="agreeTerms" name="agree_terms" required>
                                <label class="form-check-label" for="agreeTerms">
                                    أوافق على <a href="{{ route('front.terms') }}" class="text-decoration-none">الشروط والأحكام</a> و <a href="{{ route('front.privacy') }}" class="text-decoration-none">سياسة الخصوصية</a>
                                </label>
                                @error('agree_terms')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                                <i class="fas fa-user-plus me-2"></i>إنشاء حساب
                            </button>
                        </form>

                        <div class="divider mb-3">
                            <span>أو</span>
                        </div>
{{-- @dd(5) --}}
                        <a href="{{ route('auth.google') }}" class="btn-google-f btn w-100">
                            <i class="fab fa-google me-2"></i>
                            التسجيل بـ Google
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('styles')
<style>
    .btn-google-f {
    text-decoration: none;
    background: var(--white);
    border: 2px solid #ddd;
    color: var(--dark);
    padding: 12px 20px;
    font-weight: 500;
    border-radius: 8px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.btn-google-f:hover {
    text-decoration: none;
    border-color: #f56476;
    color: #f56476;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(66, 133, 244, 0.2);
}

   .btn-primary,
    .btn-google-f {
        padding: 12px 20px;
    }
</style>
@endpush

<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100 py-5">
            <div class="col-lg-7 col-md-9">
                <div class="auth-card large">

                    <!-- العنوان -->
                    <div class="text-center mb-4">
                        <h2 class="fw-bold auth-title">مرحباً بك</h2>
                        <p class="text-muted">انضمي إلى غلوزيلي واستمتعي بأفضل خدمات التجميل</p>
                    </div>

                    <!-- أزرار السوشيال -->
                    <div class="mb-4">
                        @foreach ([
                            // ['name' => 'Apple', 'icon' => 'apple-logo.png', 'text' => 'تسجيل الدخول عبر Apple', 'route' => '#'],
                            // ['name' => 'Facebook', 'icon' => 'facebook-logo.png', 'text' => 'تسجيل الدخول عبر Facebook', 'route' => route('auth.redirect', 'facebook')],
                            ['name' => 'Google', 'icon' => 'google-logo.png', 'text' => 'تسجيل الدخول باستخدام جوجل', 'route' => route('auth.redirect', 'google')],
                            ['name' => 'X', 'icon' => 'x-logo.png', 'text' => 'تسجيل الدخول عبر X', 'route' => route('auth.redirect', 'x')]
                            ] as $social)
                            <div class="btn-google-a btn w-100 mb-2 d-flex align-items-center px-2 px-sm-3">
                                <a href="{{ $social['route'] }}"
                                    class="d-flex align-items-center w-100 text-black text-decoration-none">
                                    <!-- الأيقونة (ثابتة في اليسار) -->
                                    <div class="d-flex justify-content-center" style="width: 40px; flex-shrink: 0;">
                                        <img src="{{ asset('frontend/assets/img/' . $social['icon']) }}"
                                            alt="{{ $social['name'] }}" style="width: 24px; height: 24px;">
                                    </div>

                                    <!-- النص (مرن ومتجاوب) -->
                                    <div class="flex-grow-1 text-center px-1">
                                        <span class="d-inline-block text-truncate w-100"
                                            style="color: black; font-weight: 500; font-size: 14px; max-width: 100%;">
                                            {{ $social['text'] }}
                                        </span>
                                    </div>

                                    <!-- مساحة فارغة في اليمين (للتوازن) -->
                                    <div style="width: 40px; flex-shrink: 0;"></div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- خط فاصل -->
                    <div class="text-center auth-title mb-4">
                        <span>لتسجيل الدخول أو انشاء حساب</span>
                    </div>

                    <!-- خطوة 1: البريد الإلكتروني -->
                    @if ($step === 'email')
                        <form wire:submit.prevent="checkEmail">
                            <div class="form-group mb-4">
                                <label class="form-label fw-semibold">البريد الإلكتروني</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" wire:model.live="email"
                                        class="form-control @error('email') is-invalid @enderror" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-auth btn-lg w-100 mb-3">
                                التالي
                            </button>
                        </form>
                    @endif

                    <!-- خطوة 2: تسجيل الدخول -->
                    @if ($step === 'login')
                        <form wire:submit.prevent="attemptLogin">
                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">كلمة المرور</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" wire:model="password"
                                        class="form-control @error('password') is-invalid @enderror" id="loginPassword"
                                        required>
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="togglePassword('loginPassword')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" wire:model="remember"
                                        id="remember">
                                    <label class="form-check-label" for="remember">تذكرني</label>
                                </div>
                                <a href="{{ route('password.request') }}" class="text-decoration-none small">نسيت كلمة
                                    المرور؟</a>
                            </div>

                            <button type="submit" class="btn btn-auth btn-lg w-100 mb-3"
                                style="border-radius: 12px; height: 50px;">
                                <i class="fas fa-sign-in-alt me-2"></i>تسجيل الدخول
                            </button>

                            <button type="button" wire:click="backToEmail" class="btn btn-link w-100 text-center" style="color: black">
                                العودة
                            </button>
                        </form>
                    @endif

                    <!-- خطوة 3: إنشاء حساب -->
                    @if ($step === 'register')
                        <form wire:submit.prevent="attemptRegister">
                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">الاسم</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa fa-address-card"></i></span>
                                    <input type="text" wire:model="name"
                                        class="form-control @error('name') is-invalid @enderror" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">رقم الهاتف</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="tel" wire:model="phone_number"
                                        class="form-control @error('phone_number') is-invalid @enderror" required>
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">المدينة</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <x-form.city-select name="city_id" class="form-select" />
                                    @error('city_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">كلمة المرور</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" wire:model="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        id="registerPassword" required>
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="togglePassword('registerPassword')">
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
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" wire:model="password_confirmation" class="form-control"
                                        required>
                                </div>
                            </div>

                            <div class="form-check mb-3">
                                <input style="border: 1px solid #87365b" class="form-check-input @error('agree_terms') is-invalid @enderror"
                                    type="checkbox" wire:model="agree_terms" required>
                                <label class="form-check-label">
                                    أوافق على <a href="{{ route('front.terms') }}"
                                        class="text-decoration-none">الشروط والأحكام</a> و
                                    <a href="{{ route('front.privacy') }}" class="text-decoration-none">سياسة
                                        الخصوصية</a>
                                </label>
                                @error('agree_terms')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-auth btn-lg w-100 mb-3"
                                style="border-radius: 12px; height: 50px;">
                                <i class="fas fa-user-plus me-2"></i>إنشاء حساب
                            </button>

                            <button type="button" wire:click="backToEmail" class="btn btn-link w-100 text-center" style="color: black">
                                العودة
                            </button>
                        </form>
                    @endif

                    <!-- روابط إضافية -->
                    {{-- <div class="text-center mt-4">
                        <a href="#" class="text-muted small d-block mb-1">هل لديك حساب مسجل؟</a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/auth.css?v=' . config('app.version')) }}">
    <style>
        .btn-auth {
            background: #87365b;
            border-color: #87365b;
            padding: 14px 30px;
            font-weight: 600;
            color:white;
            border-radius: 12px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        /* إلغاء اللون الأزرق الافتراضي للأزرار عند الضغط */
        .btn-auth:active,
        .btn-auth:focus,
        .btn-auth:active:focus,
        .btn-auth:focus-visible,
        .btn-auth:hover{

            color:white;
            background-color: #87365b !important;
            border-color: #87365b !important;
            box-shadow: 0 0 0 0.2rem rgba(135, 54, 91, 0.5) !important;
        }

        /* درجة مضيئة عند الضغط (أفتح من #87365b) */
        .btn-auth:active,
        .btn-auth:focus-visible {
            background-color: #a04570 !important; /* درجة أفتح ومضيئة */
            border-color: #a04570 !important;
        }

        /* نفس الشيء للـ btn العادي إذا كنت تستخدمه */
        .btn:active,
        .btn:focus,
        .btn:focus-visible {
            background-color: #a04570 !important;
            border-color: #a04570 !important;
            box-shadow: 0 0 0 0.2rem rgba(135, 54, 91, 0.3) !important;
        }

        /* زر "العودة" (btn-link) - نريد أن يبقى أسود */
        .btn-link:active,
        .btn-link:focus {
            color: #000 !important;
            text-decoration: none !important;
        }

        /* تحسين الـ hover (اختياري) */
        .btn-auth:hover {
            background-color: #9a3f6a !important;
            border-color: #9a3f6a !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/assets/js/auth.js') }}"></script>
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = input.nextElementSibling.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
@endpush

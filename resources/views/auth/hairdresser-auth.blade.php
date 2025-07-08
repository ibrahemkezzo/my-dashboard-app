@extends('layouts.frontend')

@section('title', 'تسجيل/تسجيل الدخول الكوافيرة | كوافيري | My Kawafir')

@section('main')
    <div class="auth-container hairdresser-auth">
        <div class="container">
            <div class="row justify-content-center py-5">
                <div class="col-lg-8 col-md-10">
                    <div class="auth-card large">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold auth-title">انضمي كخبيرة تجميل</h2>
                            <p class="text-muted">ابدئي رحلتك المهنية مع كوافيري وانضمي لآلاف خبيرات التجميل</p>
                        </div>

                        <!-- Auth Tabs -->
                        <div class="auth-tabs mb-4">
                            <button class="auth-tab active" data-tab="hairdresser-login">
                                <i class="fas fa-sign-in-alt me-2"></i>تسجيل الدخول
                            </button>
                            <button class="auth-tab" data-tab="hairdresser-register">
                                <i class="fas fa-store me-2"></i>تسجيل صالون جديد
                            </button>
                        </div>

                        <!-- Hairdresser Login Form -->
                        <div class="auth-form active" id="hairdresserLoginForm">
                            <form id="hairdresserLogin">
                                <div class="row">
                                    <div class="col-md-8 mx-auto">
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-semibold">البريد الإلكتروني</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-envelope"></i>
                                                </span>
                                                <input type="email" class="form-control" id="hairdresserLoginEmail" required>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="form-label fw-semibold">كلمة المرور</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-lock"></i>
                                                </span>
                                                <input type="password" class="form-control" id="hairdresserLoginPassword" required>
                                                <button class="btn btn-outline-secondary" type="button" id="toggleHairdresserLoginPassword">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="hairdresserRememberMe">
                                            <label class="form-check-label" for="hairdresserRememberMe">
                                                تذكرني
                                            </label>
                                            <a href="#" class="float-start text-decoration-none">نسيت كلمة المرور؟</a>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-lg w-100">
                                            <i class="fas fa-sign-in-alt me-2"></i>تسجيل الدخول
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Hairdresser Register Form -->
                        <div class="auth-form" id="hairdresserRegisterForm">
                            <form id="hairdresserRegister">
                                <!-- Salon Information -->
                                <div class="form-section mb-4">
                                    <h5 class="section-title">
                                        <i class="fas fa-store me-2"></i>معلومات الصالون
                                    </h5>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">اسم الصالون</label>
                                            <input type="text" class="form-control" id="salonName" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">البريد الإلكتروني</label>
                                            <input type="email" class="form-control" id="salonEmail" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">وصف الصالون</label>
                                        <textarea class="form-control" id="salonDescription" rows="3" placeholder="اكتبي وصفاً مختصراً عن صالونك وخدماتك..." required></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">نوع الصالون</label>
                                            <select class="form-select" id="salonType" required>
                                                <option value="">اختر نوع الصالون</option>
                                                <option value="certified">مركز معتمد</option>
                                                <option value="home-based">صالون منزلي</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">رقم الهاتف</label>
                                            <input type="tel" class="form-control" id="salonPhone" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">العنوان الكامل</label>
                                        <input type="text" class="form-control" id="salonAddress" placeholder="المدينة، الحي، الشارع، رقم المبنى" required>
                                    </div>
                                </div>

                                <!-- Salon Images -->
                                <div class="form-section mb-4">
                                    <h5 class="section-title">
                                        <i class="fas fa-images me-2"></i>صور الصالون
                                    </h5>

                                    <div class="image-upload-grid">
                                        <div class="image-upload-item">
                                            <input type="file" id="salonImage1" accept="image/*" class="d-none">
                                            <label for="salonImage1" class="image-upload-label">
                                                <i class="fas fa-camera fa-2x mb-2"></i>
                                                <span>الصورة الرئيسية</span>
                                            </label>
                                        </div>
                                        <div class="image-upload-item">
                                            <input type="file" id="salonImage2" accept="image/*" class="d-none">
                                            <label for="salonImage2" class="image-upload-label">
                                                <i class="fas fa-camera fa-2x mb-2"></i>
                                                <span>صورة إضافية</span>
                                            </label>
                                        </div>
                                        <div class="image-upload-item">
                                            <input type="file" id="salonImage3" accept="image/*" class="d-none">
                                            <label for="salonImage3" class="image-upload-label">
                                                <i class="fas fa-camera fa-2x mb-2"></i>
                                                <span>صورة إضافية</span>
                                            </label>
                                        </div>
                                        <div class="image-upload-item">
                                            <input type="file" id="salonImage4" accept="image/*" class="d-none">
                                            <label for="salonImage4" class="image-upload-label">
                                                <i class="fas fa-camera fa-2x mb-2"></i>
                                                <span>صورة إضافية</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Services -->
                                <div class="form-section mb-4">
                                    <h5 class="section-title">
                                        <i class="fas fa-list me-2"></i>الخدمات المقدمة
                                    </h5>

                                    <div id="servicesContainer">
                                        <div class="service-item">
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label fw-semibold">اسم الخدمة</label>
                                                    <input type="text" class="form-control service-name" placeholder="مثال: قص الشعر" required>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label fw-semibold">السعر (ريال)</label>
                                                    <input type="number" class="form-control service-price" placeholder="150" required>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label fw-semibold">المدة (دقيقة)</label>
                                                    <input type="number" class="form-control service-duration" placeholder="60" required>
                                                </div>
                                                <div class="col-md-2 mb-3 d-flex align-items-end">
                                                    <button type="button" class="btn btn-outline-danger remove-service" style="display: none;">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">وصف الخدمة</label>
                                                <textarea class="form-control service-description" rows="2" placeholder="اكتبي وصفاً مختصراً للخدمة..." required></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-outline-primary" id="addService">
                                        <i class="fas fa-plus me-2"></i>إضافة خدمة أخرى
                                    </button>
                                </div>

                                <!-- Features -->
                                <div class="form-section mb-4">
                                    <h5 class="section-title">
                                        <i class="fas fa-star me-2"></i>المميزات المتوفرة
                                    </h5>

                                    <div class="features-grid">
                                        <label class="feature-item">
                                            <input type="checkbox" class="feature-checkbox" value="parking">
                                            <i class="fas fa-car"></i>
                                            <span>موقف سيارات</span>
                                        </label>
                                        <label class="feature-item">
                                            <input type="checkbox" class="feature-checkbox" value="wifi">
                                            <i class="fas fa-wifi"></i>
                                            <span>واي فاي مجاني</span>
                                        </label>
                                        <label class="feature-item">
                                            <input type="checkbox" class="feature-checkbox" value="ac">
                                            <i class="fas fa-snowflake"></i>
                                            <span>تكييف</span>
                                        </label>
                                        <label class="feature-item">
                                            <input type="checkbox" class="feature-checkbox" value="waiting-area">
                                            <i class="fas fa-couch"></i>
                                            <span>منطقة انتظار</span>
                                        </label>
                                        <label class="feature-item">
                                            <input type="checkbox" class="feature-checkbox" value="refreshments">
                                            <i class="fas fa-coffee"></i>
                                            <span>مشروبات مجانية</span>
                                        </label>
                                        <label class="feature-item">
                                            <input type="checkbox" class="feature-checkbox" value="child-care">
                                            <i class="fas fa-baby"></i>
                                            <span>رعاية أطفال</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Account Security -->
                                <div class="form-section mb-4">
                                    <h5 class="section-title">
                                        <i class="fas fa-shield-alt me-2"></i>أمان الحساب
                                    </h5>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">كلمة المرور</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-lock"></i>
                                                </span>
                                                <input type="password" class="form-control" id="hairdresserPassword" required>
                                                <button class="btn btn-outline-secondary" type="button" id="toggleHairdresserPassword">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            <div class="form-text">يجب أن تحتوي على 8 أحرف على الأقل</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">تأكيد كلمة المرور</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-lock"></i>
                                                </span>
                                                <input type="password" class="form-control" id="hairdresserConfirmPassword" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" id="hairdresserAgreeTerms" required>
                                    <label class="form-check-label" for="hairdresserAgreeTerms">
                                        أوافق على <a href="{{ route('terms.conditions') }}" class="text-decoration-none">الشروط والأحكام</a> و <a href="{{ route('privacy.policy') }}" class="text-decoration-none">سياسة الخصوصية</a> وأتعهد بصحة المعلومات المقدمة
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-store me-2"></i>تسجيل الصالون
                                </button>
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
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/auth.css') }}">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/assets/js/auth.js') }}"></script>
@endpush
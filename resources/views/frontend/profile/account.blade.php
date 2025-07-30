@extends('layouts.frontend')

@section('title', 'منصة حجز خدمات التجميل | كوافيري | My Kawafir')

@section('main')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="account-page-header mb-4">
                    <h1 class="h2 fw-bold text-dark title">حسابي</h1>
                    <p class="text-muted">إدارة معلومات حسابك الشخصي</p>
                </div>

                <!-- Account Form -->
                <div class="card">
                    <div class="card-body p-4">
                        <form method="POST" action="{{route('front.profile.update', $user->id)}}" >
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label fw-semibold">الاسم الكامل</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name', $user->name ?? '') }}" required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">البريد الإلكتروني</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email', $user->email ?? '') }}" required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">رقم الهاتف</label>
                                <input type="phone_number" name="phone_number" id="phone_number" class="form-control"
                                    value="{{ old('phone_number', $user->phone_number ?? '') }}" required>
                                @error('phone_number') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">المدينة</label>
                                    <x-form.city-select name="city_id" :selected="$user->city_id ?? null" class="form-control" />
                                    {{-- <select class="form-select" id="city">
                                <option value="">اختر المدينة</option>
                                <option value="riyadh" selected>الرياض</option>
                                <option value="jeddah">جدة</option>
                                <option value="dammam">الدمام</option>
                                <option value="mecca">مكة المكرمة</option>
                                <option value="medina">المدينة المنورة</option>
                                <option value="taif">الطائف</option>
                            </select> --}}
                                </div>

                                <hr class="my-4">

                                <h5 class="fw-semibold mb-3">تغيير كلمة المرور</h5>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">كلمة المرور الحالية</label>
                                    <input name="old_password" type="password" class="form-control" id="currentPassword">
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">كلمة المرور الجديدة</label>
                                        <input name="password" type="password" class="form-control" id="newPassword">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">تأكيد كلمة المرور الجديدة</label>
                                        <input name="password_confirmation" type="password" class="form-control" id="confirmPassword">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                                    <a href="{{ route('front.home') }}"><button type="button"
                                            class="btn btn-secondary">إلغاء</button></a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Account Stats -->
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="stat-card text-center p-3">
                                <i class="fas fa-calendar-check fa-2x text-primary mb-2"></i>
                                <h4 class="fw-bold">12</h4>
                                <p class="text-muted mb-0">إجمالي الحجوزات</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card text-center p-3">
                                <i class="fas fa-heart fa-2x text-danger mb-2"></i>
                                <h4 class="fw-bold">8</h4>
                                <p class="text-muted mb-0">الصالونات المفضلة</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card text-center p-3">
                                <i class="fas fa-star fa-2x text-warning mb-2"></i>
                                <h4 class="fw-bold">7</h4>
                                <p class="text-muted mb-0">عدد التقييمات</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection


    @push('styles')
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/pages-styles.css') }}">
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('frontend/assets/js/pages-scripts.js') }}"></script>
    @endpush

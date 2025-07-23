
    <div class="auth-container hairdresser-auth">
        <div class="container">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="row justify-content-center py-5">
                <div class="col-lg-8 col-md-10">
                    <div class="auth-card large">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold auth-title">انضمي كخبيرة تجميل</h2>
                            <p class="text-muted">ابدئي رحلتك المهنية مع كوافيري وانضمي لآلاف خبيرات التجميل</p>
                        </div>
                        {{-- @dump($errors->all()) --}}
                        <!-- Auth Tabs -->
                        {{-- <div class="auth-tabs mb-4">
                            <button class="auth-tab active" data-tab="hairdresser-register">
                                <i class="fas fa-store me-2"></i>تسجيل صالون جديد
                            </button>
                        </div> --}}



                        <!-- Hairdresser Register Form -->
                        <div class="auth-form active" id="hairdresserRegisterForm">

                                <!-- Salon Information -->
                                <div class="form-section mb-4">
                                    <h5 class="section-title">
                                        <i class="fas fa-store me-2"></i>معلومات الصالون
                                    </h5>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label fw-semibold">اسم الصالون</label>
                                            <input  type="text" class="form-control" id="name" name="name" value="{{ old('name', $salon->name ?? '') }}" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">البريد الإلكتروني</label>
                                            <input type="email" value="{{Auth::user()->email ?? ''}}" class="form-control" id="salonEmail" readonly>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">وصف الصالون</label>
                                        <textarea name="description" class="form-control" id="salonDescription" rows="3" placeholder="اكتبي وصفاً مختصراً عن صالونك وخدماتك..." required>
                                            {{ old('description', $salon->description ?? '') }}
                                        </textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">نوع الصالون</label>
                                            <select name="type" class="form-select" id="salonType" required>
                                                <option value="">اختر نوع الصالون</option>
                                                <option value="beauty_center">مركز معتمد</option>
                                                <option value="home_salon">صالون منزلي</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">رقم الهاتف</label>
                                            <input type="text" class="form-control" id="salonPhone"  name="phone" value="{{ old('phone', $salon->phone ?? '') }}" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">المدينة</label>
                                            <x-form.city-select name="city_id" :selected="$salon->city_id ?? null" class="form-control"/>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">العنوان الكامل</label>
                                            <input type="text" name="address" value="{{ old('address', $salon->address ?? '') }}" class="form-control" id="salonAddress" placeholder="الحي، الشارع، رقم المبنى" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Logo and Cover Image -->
                                <div class="form-section mb-4">
                                    <h5 class="section-title">
                                        <i class="fas fa-image me-2"></i>الشعار والصورة الغلاف
                                    </h5>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">شعار الصالون</label>
                                            <div class="image-upload-item">
                                                <input type="file"  name="logo" id="salonLogo" accept="image/*" class="d-none">
                                                <label for="salonLogo" class="image-upload-label">
                                                    <i class="fas fa-upload fa-2x mb-2"></i>
                                                    <span>اختر شعار الصالون</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">صورة الغلاف</label>
                                            <div class="image-upload-item">
                                                <input type="file"  name="cover_image" id="salonCover" accept="image/*" class="d-none">
                                                <label for="salonCover" class="image-upload-label">
                                                    <i class="fas fa-upload fa-2x mb-2"></i>
                                                    <span>اختر صورة الغلاف</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                       <!-- Salon Images -->
                                <div class="form-section mb-4">
                                    <h5 class="section-title">
                                        <i class="fas fa-images me-2"></i>معرض الصور
                                    </h5>

                                    <div class="image-upload-grid">
                                        @for ($i = 1; $i <= 4; $i++)
                                            <div class="image-upload-item">
                                                <input type="file" id="salonImage{{ $i }}" name="gallery_images[{{ $i }}]" accept="image/*" class="d-none">
                                                <label for="salonImage{{ $i }}" class="image-upload-label">
                                                    <i class="fas fa-camera fa-2x mb-2"></i>
                                                    <span>صورة إضافية</span>
                                                </label>
                                            </div>
                                        @endfor

                                    </div>
                                </div>


                                <!-- Working Hours -->
                                <div class="form-section mb-4">
                                    <h5 class="section-title">
                                        <i class="fas fa-clock me-2"></i>ساعات العمل
                                    </h5>
                                    @php
                                    $days = ['sunday','monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', ];
                                    $workingHours = old('working_hours', $salon->working_hours ?? []);
                                    @endphp

                                    <div class="working-hours-container">
                                        @foreach($days as $day)

                                        <div class="working-day mb-3">
                                            <div class="row align-items-center">
                                                <div class="col-md-3">
                                                    <label for="working_hours_{{ $day }}" class="form-label fw-semibold">{{ __('dashboard.'.$day) }}</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="time" name="working_hours[{{ $day }}][open]" class="form-control" value="{{ $workingHours[$day]['open'] ?? '' }}" id="saturdayStart" placeholder="من">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="time" name="working_hours[{{ $day }}][close]" class="form-control" value="{{ $workingHours[$day]['close'] ?? '' }}" id="saturdayEnd" placeholder="إلى">
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="working_hours[{{ $day }}][closed]"  id="saturdayClosed">
                                                        <label class="form-check-label" for="saturdayClosed">مغلق</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach

                                    </div>
                                </div>

                                <!-- Social Media Links -->
                                <div class="form-section mb-4">
                                    <h5 class="section-title">
                                        <i class="fas fa-share-alt me-2"></i>روابط التواصل الاجتماعي (اختياري)
                                    </h5>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">فيسبوك</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fab fa-facebook"></i>
                                                </span>
                                                <input type="url"  name="social_links[facebook]" class="form-control" id="facebookLink" placeholder="https://facebook.com/your-page">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">إنستغرام</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fab fa-instagram"></i>
                                                </span>
                                                <input type="url"  name="social_links[instagram]" class="form-control" id="instagramLink" placeholder="https://instagram.com/your-account">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">سناب شات</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fab fa-snapchat"></i>
                                                </span>
                                                <input type="url"  name="social_links[snapchat]" class="form-control" id="snapchatLink" placeholder="https://snapchat.com/add/your-username">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">تيك توك</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fab fa-tiktok"></i>
                                                </span>
                                                <input type="url"  name="social_links[tiktok]" class="form-control" id="tiktokLink" placeholder="https://tiktok.com/@your-username">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">يوتيوب</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fab fa-youtube"></i>
                                                </span>
                                                <input type="url"  name="social_links[youtube]" class="form-control" id="youtubeLink" placeholder="https://youtube.com/your-channel">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">X (تويتر)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fab fa-x-twitter"></i>
                                                </span>
                                                <input type="url"  name="social_links[twitter]" class="form-control" id="twitterLink" placeholder="https://x.com/your-username">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Features -->
                                <div class="form-section mb-4">
                                    <h5 class="section-title">
                                        <i class="fas fa-star me-2"></i>المميزات المتوفرة
                                    </h5>

                                    <div class="features-grid">
                                        <label class="feature-item">
                                            <input name="features[parking]" type="checkbox" class="feature-checkbox" value="on">
                                            <i class="fas fa-car"></i>
                                            <span>موقف سيارات</span>
                                        </label>
                                        <label class="feature-item">
                                            <input name="features[wifi]" type="checkbox" class="feature-checkbox" value="on">
                                            <i class="fas fa-wifi"></i>
                                            <span>واي فاي مجاني</span>
                                        </label>
                                        <label class="feature-item">
                                            <input name="features[ac]" type="checkbox" class="feature-checkbox" value="on">
                                            <i class="fas fa-snowflake"></i>
                                            <span>تكييف</span>
                                        </label>
                                        <label class="feature-item">
                                            <input name="features[waiting-area]" type="checkbox" class="feature-checkbox" value="on">
                                            <i class="fas fa-couch"></i>
                                            <span>منطقة انتظار</span>
                                        </label>
                                        <label class="feature-item">
                                            <input name="features[refreshments]" type="checkbox" class="feature-checkbox" value="on">
                                            <i class="fas fa-coffee"></i>
                                            <span>مشروبات مجانية</span>
                                        </label>
                                        <label class="feature-item">
                                            <input name="features[child-care]" type="checkbox" class="feature-checkbox" value="on">
                                            <i class="fas fa-baby"></i>
                                            <span>رعاية أطفال</span>
                                        </label>
                                    </div>
                                </div>
                                <!-- Account Security -->
                                {{-- <div class="form-section mb-4">
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
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">تأكيد كلمة المرور</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-lock"></i>
                                                </span>
                                                <input type="password" class="form-control" id="hairdresserConfirmPassword" required>
                                                <button class="btn btn-outline-secondary" type="button" id="toggleHairdresserConfirmPassword">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                                <!-- Terms Agreement -->
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" id="hairdresserAgreeTerms" required>
                                    <label class="form-check-label" for="hairdresserAgreeTerms">
                                        أوافق على <a href="{{ route('front.terms') }}" class="text-decoration-none">الشروط والأحكام</a> و <a href="{{ route('front.privacy') }}" class="text-decoration-none">سياسة الخصوصية</a>
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100" id="nextStepBtn">
                                    <i class="fas fa-arrow-left me-2"></i>التالي
                                </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/auth.css') }}">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/assets/js/auth.js') }}"></script>
@endpush
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
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $salon->name ?? '') }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">البريد الإلكتروني</label>
                                    <input type="email" value="{{ Auth::user()->email ?? '' }}" class="form-control"
                                        id="salonEmail" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">وصف الصالون</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="salonDescription"
                                    rows="3" placeholder="اكتبي وصفاً مختصراً عن صالونك وخدماتك..." required>
                                    {{ old('description', $salon->description ?? '') }}
                                </textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">نوع الصالون</label>
                                    <select name="type" class="form-select @error('type') is-invalid @enderror"
                                        id="salonType" required>
                                        <option value="">اختر نوع الصالون</option>
                                        <option value="beauty_center"
                                            {{ old('type', $salon->type ?? '') === 'beauty_center' ? 'selected' : '' }}>
                                            مركز معتمد
                                        </option>
                                        <option value="home_salon"
                                            {{ old('type', $salon->type ?? '') === 'home_salon' ? 'selected' : '' }}>
                                            صالون منزلي
                                        </option>
                                        <option value="cosmetic_clinic"
                                            {{ old('type', $salon->type ?? '') === 'cosmetic_clinic' ? 'selected' : '' }}>
                                            عيادة تجميل
                                        </option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">رقم الهاتف</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="salonPhone" name="phone" value="{{ old('phone', $salon->phone ?? '') }}"
                                        required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">المدينة</label>
                                    <x-form.city-select name="city_id" :selected="$salon->city_id ?? null"
                                        class="form-control @error('city_id')
is-invalid
@enderror" />
                                    @error('city_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">العنوان الكامل</label>
                                    <input type="text" name="address"
                                        class="form-control @error('address') is-invalid @enderror"
                                        value="{{ old('address', $salon->address ?? '') }}" id="salonAddress"
                                        placeholder="الحي، الشارع، رقم المبنى" required>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="form-group">
                                <label class="form-label fw-semibold">حدد موقع الصالون على الخريطة</label>

                                <div id="map" style="height: 400px; width: 100%;"></div>
                                <input type="hidden" name="latitude" id="latitude">
                                <input type="hidden" name="longitude" id="longitude">
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
                                        <input type="file" name="logo" id="salonLogo" accept="image/*"
                                            class="d-none @error('logo') is-invalid @enderror">
                                        <label for="salonLogo" class="image-upload-label">
                                            <i class="fas fa-upload fa-2x mb-2"></i>
                                            <span>اختر شعار الصالون</span>
                                        </label>
                                    </div>
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">صورة الغلاف</label>
                                    <div class="image-upload-item">
                                        <input type="file" name="cover_image" id="salonCover" accept="image/*"
                                            class="d-none @error('cover_image') is-invalid @enderror">
                                        <label for="salonCover" class="image-upload-label">
                                            <i class="fas fa-upload fa-2x mb-2"></i>
                                            <span>اختر صورة الغلاف</span>
                                        </label>
                                    </div>
                                    @error('cover_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                        <input type="file" id="salonImage{{ $i }}"
                                            name="gallery_images[{{ $i }}]" accept="image/*"
                                            class="d-none @error('gallery_images.' . $i) is-invalid @enderror">
                                        <label for="salonImage{{ $i }}" class="image-upload-label">
                                            <i class="fas fa-camera fa-2x mb-2"></i>
                                            <span>صورة إضافية</span>
                                        </label>
                                    </div>
                                    @error('gallery_images.' . $i)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @endfor
                            </div>
                        </div>

                        <!-- Working Hours -->
                        <div class="form-section mb-4">
                            <h5 class="section-title">
                                <i class="fas fa-clock me-2"></i>ساعات العمل
                            </h5>
                            @php
                                $days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
                                $workingHours = old('working_hours', $salon->working_hours ?? []);
                            @endphp

                            <div class="working-hours-container">
                                @foreach ($days as $day)
                                    <div class="working-day mb-3">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <label for="working_hours_{{ $day }}"
                                                    class="form-label fw-semibold">{{ __('dashboard.' . $day) }}</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="time" name="working_hours[{{ $day }}][open]"
                                                    class="form-control @error('working_hours.' . $day . '.open') is-invalid @enderror"
                                                    value="{{ $workingHours[$day]['open'] ?? '' }}"
                                                    id="saturdayStart" placeholder="من">
                                                @error('working_hours.' . $day . '.open')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3">
                                                <input type="time"
                                                    name="working_hours[{{ $day }}][close]"
                                                    class="form-control @error('working_hours.' . $day . '.close') is-invalid @enderror"
                                                    value="{{ $workingHours[$day]['close'] ?? '' }}" id="saturdayEnd"
                                                    placeholder="إلى">
                                                @error('working_hours.' . $day . '.close')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('working_hours.' . $day . '.closed') is-invalid @enderror"
                                                        type="checkbox"
                                                        name="working_hours[{{ $day }}][closed]"
                                                        id="saturdayClosed"
                                                        {{ $workingHours[$day]['closed'] ?? false ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="saturdayClosed">مغلق</label>
                                                </div>
                                                @error('working_hours.' . $day . '.closed')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
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
                                        <input type="url" name="social_links[facebook]"
                                            class="form-control @error('social_links.facebook') is-invalid @enderror"
                                            id="facebookLink" placeholder="https://facebook.com/your-page">
                                        @error('social_links.facebook')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">إنستغرام</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fab fa-instagram"></i>
                                        </span>
                                        <input type="url" name="social_links[instagram]"
                                            class="form-control @error('social_links.instagram') is-invalid @enderror"
                                            id="instagramLink" placeholder="https://instagram.com/your-account">
                                        @error('social_links.instagram')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                        <input type="url" name="social_links[snapchat]"
                                            class="form-control @error('social_links.snapchat') is-invalid @enderror"
                                            id="snapchatLink" placeholder="https://snapchat.com/add/your-username">
                                        @error('social_links.snapchat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">تيك توك</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fab fa-tiktok"></i>
                                        </span>
                                        <input type="url" name="social_links[tiktok]"
                                            class="form-control @error('social_links.tiktok') is-invalid @enderror"
                                            id="tiktokLink" placeholder="https://tiktok.com/@your-username">
                                        @error('social_links.tiktok')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                        <input type="url" name="social_links[youtube]"
                                            class="form-control @error('social_links.youtube') is-invalid @enderror"
                                            id="youtubeLink" placeholder="https://youtube.com/your-channel">
                                        @error('social_links.youtube')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">X (تويتر)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fab fa-x-twitter"></i>
                                        </span>
                                        <input type="url" name="social_links[twitter]"
                                            class="form-control @error('social_links.twitter') is-invalid @enderror"
                                            id="twitterLink" placeholder="https://x.com/your-username">
                                        @error('social_links.twitter')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                    <input name="features[parking]" type="checkbox"
                                        class="feature-checkbox @error('features.parking') is-invalid @enderror"
                                        value="on">
                                    <i class="fas fa-car"></i>
                                    <span>موقف سيارات</span>
                                    @error('features.parking')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </label>
                                <label class="feature-item">
                                    <input name="features[wifi]" type="checkbox"
                                        class="feature-checkbox @error('features.wifi') is-invalid @enderror"
                                        value="on">
                                    <i class="fas fa-wifi"></i>
                                    <span>واي فاي مجاني</span>
                                    @error('features.wifi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </label>
                                <label class="feature-item">
                                    <input name="features[ac]" type="checkbox"
                                        class="feature-checkbox @error('features.ac') is-invalid @enderror"
                                        value="on">
                                    <i class="fas fa-snowflake"></i>
                                    <span>تكييف</span>
                                    @error('features.ac')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </label>
                                <label class="feature-item">
                                    <input name="features[waiting-area]" type="checkbox"
                                        class="feature-checkbox @error('features.waiting-area') is-invalid @enderror"
                                        value="on">
                                    <i class="fas fa-couch"></i>
                                    <span>منطقة انتظار</span>
                                    @error('features.waiting-area')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </label>
                                <label class="feature-item">
                                    <input name="features[refreshments]" type="checkbox"
                                        class="feature-checkbox @error('features.refreshments') is-invalid @enderror"
                                        value="on">
                                    <i class="fas fa-coffee"></i>
                                    <span>مشروبات مجانية</span>
                                    @error('features.refreshments')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </label>
                                <label class="feature-item">
                                    <input name="features[child-care]" type="checkbox"
                                        class="feature-checkbox @error('features.child-care') is-invalid @enderror"
                                        value="on">
                                    <i class="fas fa-baby"></i>
                                    <span>رعاية أطفال</span>
                                    @error('features.child-care')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </label>
                            </div>
                        </div>

                        <!-- License and Verification -->
                        <div class="form-section mb-4">
                            <h5 class="section-title">
                                <i class="fas fa-image me-2"></i>الرخصة و التوثيق
                            </h5>

                            <div class="row">
                                <div class="col-md-6 row mb-3">
                                    <div class="col-md-9">
                                        <label class="form-label fw-semibold">تاريخ بداية الرخصة</label>
                                        <input name="license_start_date" type="date"
                                            class="form-control no-hover-effects @error('license_start_date') is-invalid @enderror"
                                            id="date" />
                                        @error('license_start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-9">
                                        <label class="form-label fw-semibold">تاريخ نهاية الرخصة</label>
                                        <input name="license_end_date" type="date"
                                            class="form-control no-hover-effects @error('license_end_date') is-invalid @enderror"
                                            id="date" />
                                        @error('license_end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">صورة واضحة عن الرخصة</label>
                                    <div class="image-upload-item">
                                        <input type="file" name="license_document" id="salonlicence"
                                            accept="image/*"
                                            class="d-none @error('license_document') is-invalid @enderror">
                                        <label for="salonlicence" class="image-upload-label">
                                            <i class="fas fa-upload fa-2x mb-2"></i>
                                            <span>اختر صورة</span>
                                        </label>
                                    </div>
                                    @error('license_document')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Terms Agreement -->
                        <div class="form-check mb-4">
                            <input class="form-check-input @error('hairdresserAgreeTerms') is-invalid @enderror"
                                type="checkbox" id="hairdresserAgreeTerms" name="hairdresserAgreeTerms" required>
                            <label class="form-check-label" for="hairdresserAgreeTerms">
                                أوافق على <a href="{{ route('front.terms') }}" class="text-decoration-none">الشروط
                                    والأحكام</a> و <a href="{{ route('front.privacy') }}"
                                    class="text-decoration-none">سياسة
                                    الخصوصية</a>
                            </label>
                            @error('hairdresserAgreeTerms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/auth.css?v='.config('app.version')) }}">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/assets/js/auth.js') }}"></script>
@endpush
@push('scripts')
    <script>
        window.initMap = function() {
            var salonLat = {{ $salon->latitude ?? '24.7135517' }};
            var salonLng = {{ $salon->longitude ?? '46.6752957' }};

            var map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: salonLat, lng: salonLng },
                zoom: 12,
                zoomControl: true,
                mapTypeControl: false,
                streetViewControl: true,
                fullscreenControl: true,

                // === التحسينات الرئيسية للسلاسة والأداء ===
                gestureHandling: 'greedy',        // يسمح بالتمرير باللمس دون الحاجة للنقر مرتين (مهم جدًا على الموبايل)
                clickableIcons: false,            // يمنع النقر على أيقونات جوجل (مثل الأعمال) لتحسين الأداء
                disableDoubleClickZoom: true,     // نمنع التكبير بالنقر المزدوج لأننا نستخدمه لوضع الدبوس
                keyboardShortcuts: false,         // إيقاف اختصارات الكيبورد غير الضرورية
                restriction: null,                // لا قيود على الحركة
                styles: [                         // أسلوب بسيط لتقليل العناصر الثقيلة بصريًا (اختياري لكن يساعد)
                    { featureType: "poi", elementType: "labels", stylers: [{ visibility: "off" }] },
                    { featureType: "transit", stylers: [{ visibility: "off" }] }
                ],

                // تحسين الأداء والرسوم المتحركة
                // هذه الخيارات تجعل الحركة أكثر سلاسة خاصة على الموبايل والأجهزة الضعيفة
                panControl: false,
                scaleControl: true,
                rotateControl: false
            });

            var marker = new google.maps.Marker({
                position: { lat: salonLat, lng: salonLng },
                map: map,
                draggable: true,
                animation: google.maps.Animation.DROP
            });

            function updateMarkerPosition(latLng) {
                marker.setPosition(latLng);
                document.getElementById('latitude').value = latLng.lat();
                document.getElementById('longitude').value = latLng.lng();
            }

            // سحب الدبوس
            marker.addListener('dragend', function(event) {
                updateMarkerPosition(event.latLng);
            });

            // نقر مزدوج أو ضغط مطوّل → وضع الدبوس دون تمركز
            map.addListener('dblclick', function(event) {
                updateMarkerPosition(event.latLng);
            });

            // ضغط مطوّل على الموبايل
            var longPressTimer;
            map.addListener('mousedown', function(e) {
                longPressTimer = setTimeout(() => updateMarkerPosition(e.latLng), 800);
            });
            map.addListener('mouseup', () => clearTimeout(longPressTimer));
            map.addListener('mousemove', () => clearTimeout(longPressTimer));

            map.addListener('touchstart', function(e) {
                var touch = e.touches[0];
                var latLng = map.getProjection().fromPointToLatLng(
                    new google.maps.Point(touch.clientX, touch.clientY)
                );
                longPressTimer = setTimeout(() => updateMarkerPosition(latLng), 800);
            });
            map.addListener('touchend', () => clearTimeout(longPressTimer));
            map.addListener('touchmove', () => clearTimeout(longPressTimer));

            // زر تحديد الموقع الحالي
            var locationButton = document.createElement('button');
            locationButton.type = 'button';
            locationButton.title = 'تحديد موقعي الحالي';
            locationButton.className = 'custom-map-control-button';
            locationButton.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24px" height="24px" fill="#1a73e8">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg>
            `;
            Object.assign(locationButton.style, {
                backgroundColor: 'white',
                border: 'none',
                borderRadius: '50%',
                boxShadow: '0 2px 6px rgba(0,0,0,0.3)',
                cursor: 'pointer',
                padding: '10px',
                margin: '10px'
            });
            map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(locationButton);

            locationButton.addEventListener('click', function() {
                if (navigator.geolocation) {
                    locationButton.disabled = true;
                    locationButton.style.opacity = '0.6';
                    navigator.geolocation.getCurrentPosition(
                        pos => {
                            var position = { lat: pos.coords.latitude, lng: pos.coords.longitude };
                            map.setCenter(position);
                            map.setZoom(15);
                            updateMarkerPosition(position);
                            locationButton.disabled = false;
                            locationButton.style.opacity = '1';
                        },
                        () => {
                            alert('تعذر تحديد موقعك. تأكد من تفعيل خدمة الموقع.');
                            locationButton.disabled = false;
                            locationButton.style.opacity = '1';
                        }
                    );
                } else {
                    alert('المتصفح لا يدعم تحديد الموقع.');
                }
            });

            // Places Autocomplete
            var input = document.createElement('input');
            input.id = 'place-autocomplete-card';
            input.placeholder = 'ابحث عن عنوان أو مكان...';
            Object.assign(input.style, {
                backgroundColor: '#fff',
                borderRadius: '24px',
                boxShadow: '0 2px 6px rgba(0,0,0,0.3)',
                margin: '10px',
                padding: '8px 16px',
                fontFamily: 'Roboto, Arial, sans-serif',
                fontSize: '15px',
                width: '300px',
                maxWidth: '90%',
                border: 'none',
                outline: 'none'
            });
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);
            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                if (place.geometry) {
                    map.setCenter(place.geometry.location);
                    map.setZoom(15);
                    updateMarkerPosition(place.geometry.location);
                }
            });
        };
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initMap"></script>
@endpush

@push('styles')
    <style>
        #map {
            height: 100%;
            min-height: 400px;
            border-radius: 8px;
        }

        .custom-map-control-button:hover {
            background-color: #f1f1f1;
        }

        @media (max-width: 576px) {
            #place-autocomplete-card {
                width: calc(100% - 40px);
            }
        }
    </style>
@endpush

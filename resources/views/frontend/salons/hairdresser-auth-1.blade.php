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
                                        id="name" name="name" value="{{ old('name', $salon->name ?? '') }}"
                                        required>
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
                                            مركز معتمد</option>
                                        <option value="home_salon"
                                            {{ old('type', $salon->type ?? '') === 'home_salon' ? 'selected' : '' }}>
                                            صالون منزلي</option>
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
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/auth.css') }}">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/assets/js/auth.js') }}"></script>
@endpush
@push('scripts')
    <script>
        function initMap() {
            // الحصول على إحداثيات المدينة إذا كانت موجودة، وإلا استخدام إحداثيات السعودية
            var salonLat = {{ $salon->latitude ?? '24.7135517' }};
            var salonLng = {{ $salon->longitude ?? '46.6752957' }};

            // إنشاء الخريطة مع مركز في إحداثيات المدينة أو السعودية
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: salonLat,
                    lng: salonLng
                },
                zoom: 12
            });

            // إضافة دبوس (Marker) قابل للسحب في موقع المدينة أو السعودية
            var marker = new google.maps.Marker({
                position: {
                    lat: salonLat,
                    lng: salonLng
                },
                map: map,
                draggable: true
            });

            // تحديث الإحداثيات عند سحب الدبوس
            google.maps.event.addListener(marker, 'dragend', function(event) {
                document.getElementById('latitude').value = event.latLng.lat();
                document.getElementById('longitude').value = event.latLng.lng();
            });

            // البحث عن العناوين باستخدام Places Autocomplete
            var input = document.createElement('input');
            input.id = 'place-autocomplete-card';
            input.className = 'place-autocomplete-card';
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);

            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                if (place.geometry) {
                    map.setCenter(place.geometry.location);
                    marker.setPosition(place.geometry.location);
                    document.getElementById('latitude').value = place.geometry.location.lat();
                    document.getElementById('longitude').value = place.geometry.location.lng();
                }
            });
        }
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initMap"
        async defer></script>
@endpush
@push('styles')
    <style>
        #map {
            height: 100%;
        }

        .custom-map-control-button {
            background-color: #fff;
            border: 0;
            border-radius: 2px;
            box-shadow: 0 1px 4px -1px rgba(242, 237, 237, 0.3);
            margin: 10px;
            padding: 0 0.5em;
            font: 400 18px Roboto, Arial, sans-serif;
            overflow: hidden;
            height: 40px;
            cursor: pointer;
        }

        .custom-map-control-button:hover {
            background: rgb(235, 235, 235);
        }

        #place-autocomplete-card {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: rgba(189, 174, 174, 0.35) 0px 5px 15px;
            margin: 10px;
            padding: 5px;
            font-family: Roboto, sans-serif;
            font-size: large;
            font-weight: bold;
        }

        gmp-place-autocomplete {
            width: 300px;
        }

        #infowindow-content .title {
            font-weight: bold;
        }
    </style>
@endpush

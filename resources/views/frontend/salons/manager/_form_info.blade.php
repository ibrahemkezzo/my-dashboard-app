<form action="{{ route('front.profile.salon.manager.updateInfo') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="name" class="form-label">اسم الصالون</label>
            <input type="text" class="form-control" id="name" name="name"
                value="{{ old('name', $salon->name) }}" required>
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label">البريد الاكتروني(لايمكن تعديله تستطيع تعديل ايميل
                البروفايل)</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $salon->owner->email }}"
                readonly>
        </div>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">وصف الصالون</label>
        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $salon->description) }}</textarea>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="city_id" class="form-label">المدينة</label>
            <x-form.city-select name="city_id" :selected="$salon->city_id" class="form-control" />
        </div>
        <div class="col-md-6">
            <label for="address" class="form-label">العنوان</label>
            <input type="text" class="form-control" id="address" name="address"
                value="{{ old('address', $salon->address) }}" required>
        </div>
    </div>
    <div class="row mb-3">
        <div class="form-group">
            <label>حدد موقع الصالون على الخريطة</label>

            <div id="map" style="height: 400px; width: 100%;"></div>
            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $salon->latitude ?? '') }}" >
            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $salon->longitude ?? '') }}" >
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="phone" class="form-label">رقم الهاتف</label>
            <input type="text" class="form-control" id="phone" name="phone"
                value="{{ old('phone', $salon->phone) }}" required>
        </div>
        <div class="col-md-3">
            <label for="logo" class="form-label">شعار الصالون</label>
            <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
            @if ($salon->logo_url)
                <img src="{{ $salon->logo_url }}" alt="logo"
                    style="width:40px;height:40px;object-fit:cover;border-radius:50%;" class="mt-2">
            @endif
        </div>
        <div class="col-md-3">
            <label for="cover_image" class="form-label">صورة الغلاف</label>
            <input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/*">
            @if ($salon->cover_image_url)
                <img src="{{ $salon->cover_image_url }}" alt="cover" style="width:40px;height:40px;object-fit:cover;"
                    class="mt-2">
            @endif
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">ساعات العمل</label>
        @php
            $days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
            $workingHours = old('working_hours', $salon->working_hours ?? []);
        @endphp
        <div class="working-hours-container">
            @foreach ($days as $day)
                <div class="working-day mb-2 row align-items-center">
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">{{ __('dashboard.' . $day) }}</label>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">وقت الفتح</label>
                        <input type="time" name="working_hours[{{ $day }}][open]" class="form-control"
                            value="{{ $workingHours[$day]['open'] ?? '' }}" placeholder="من">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">وقت الاغلاق</label>
                        <input type="time" name="working_hours[{{ $day }}][close]" class="form-control"
                            value="{{ $workingHours[$day]['close'] ?? '' }}" placeholder="إلى">
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="working_hours[{{ $day }}][closed]"
                                id="working_hours[{{ $day }}][closed]"
                                {{ !empty($workingHours[$day]['closed']) ? 'checked' : '' }}>
                            <label for="working_hours[{{ $day }}][closed]" class="form-check-label">عطلة
                                عمل</label>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">روابط التواصل الاجتماعي</label>
        <div class="row g-2">
            <div class="col-md-4">
                <input type="url" name="social_links[facebook]"
                    value="{{ old('social_links.facebook', $salon->social_links['facebook'] ?? '') }}"
                    class="form-control" placeholder="Facebook URL">
            </div>
            <div class="col-md-4">
                <input type="url" name="social_links[instagram]"
                    value="{{ old('social_links.instagram', $salon->social_links['instagram'] ?? '') }}"
                    class="form-control" placeholder="Instagram URL">
            </div>
            <div class="col-md-4">
                <input type="url" name="social_links[twitter]"
                    value="{{ old('social_links.twitter', $salon->social_links['twitter'] ?? '') }}"
                    class="form-control" placeholder="Twitter URL">
            </div>
            <div class="col-md-4">
                <input type="url" name="social_links[tiktok]"
                    value="{{ old('social_links.tiktok', $salon->social_links['tiktok'] ?? '') }}"
                    class="form-control" placeholder="tiktok URL">
            </div>
            <div class="col-md-4">
                <input type="url" name="social_links[snapchat]"
                    value="{{ old('social_links.snapchat', $salon->social_links['snapchat'] ?? '') }}"
                    class="form-control" placeholder="snapchat URL">
            </div>
            <div class="col-md-4">
                <input type="url" name="social_links[youtube]"
                    value="{{ old('social_links.youtube', $salon->social_links['youtube'] ?? '') }}"
                    class="form-control" placeholder="youtube URL">
            </div>
        </div>
    </div>
    <!-- Features -->
    <div class="mb-3">

        <label class="form-label">المميزات المتوفرة</label>

        <div class="row g-2">
            <div class="col-md-4">
                <label class="form-check-label">
                    <input name="features[parking]" type="checkbox" @checked(old('features.parking', isset($salon->features['parking'])))
                        class="form-checkbox" value="on">
                    <i class="fas fa-car"></i>
                    <span>موقف سيارات</span>
                </label>
            </div>
            <div class="col-md-4">
                <label class="form-check-label">
                    <input name="features[wifi]" type="checkbox" @checked(old('features.wifi', isset($salon->features['wifi']))) class="form-checkbox"
                        value="on">
                    <i class="fas fa-wifi"></i>
                    <span>واي فاي مجاني</span>
                </label>
            </div>
            <div class="col-md-4">
                <label class="form-check-label">
                    <input name="features[ac]" type="checkbox" @checked(old('features.ac', isset($salon->features['ac']))) class="form-checkbox"
                        value="on">
                    <i class="fas fa-snowflake"></i>
                    <span>تكييف</span>
                </label>
            </div>
            <div class="col-md-4">
                <label class="form-check-label">
                    <input name="features[waiting-area]" type="checkbox" @checked(old('features.waiting-area', isset($salon->features['waiting-area'])))
                        class="form-checkbox" value="on">
                    <i class="fas fa-couch"></i>
                    <span>منطقة انتظار</span>
                </label>
            </div>
            <div class="col-md-4">
                <label class="form-check-label">
                    <input name="features[refreshments]" type="checkbox" @checked(old('features.refreshments', isset($salon->features['refreshments'])))
                        class="form-checkbox" value="on">
                    <i class="fas fa-coffee"></i>
                    <span>مشروبات مجانية</span>
                </label>
            </div>
            <div class="col-md-4">
                <label class="form-check-label">
                    <input name="features[child-care]" type="checkbox" @checked(old('features.child-care', isset($salon->features['child-care'])))
                        class="form-checkbox" value="on">
                    <i class="fas fa-baby"></i>
                    <span>رعاية أطفال</span>
                </label>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label fw-semibold">تاريخ بداية الرخصة</label>
            <input name="license_start_date" type="date"
                class="form-control no-hover-effects @error('license_start_date') is-invalid @enderror"
                id="date" />
            @error('license_start_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">تاريخ نهاية الرخصة</label>
            <input name="license_end_date" type="date"
                class="form-control no-hover-effects @error('license_end_date') is-invalid @enderror"
                id="date" />
            @error('license_end_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4">
            <label for="license_document" class="form-label">تحديث الترخيص</label>
            <input type="file" class="form-control" id="license_document" name="license_document"
                accept="image/*">
            @if ($salon->license_url)
                <img src="{{ $salon->license_url }}" alt="license"
                    style="width:40px;height:40px;object-fit:license;" class="mt-2">
            @endif
        </div>
    </div>
    {{-- @dd(env('GOOGLE_MAPS_API_KEY') ) --}}
    <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
</form>
{{-- @dd($salon) --}}
@push('scripts')
        <script>
            function initMap() {
                // الحصول على إحداثيات المدينة إذا كانت موجودة، وإلا استخدام إحداثيات السعودية
                var salonLat = {{ $salon->latitude ?? '24.7135517' }};
                var salonLng = {{ $salon->longitude ?? '46.6752957' }};

                // إنشاء الخريطة مع مركز في إحداثيات المدينة أو السعودية
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: { lat: salonLat, lng: salonLng },
                    zoom: 12
                });

                // إضافة دبوس (Marker) قابل للسحب في موقع المدينة أو السعودية
                var marker = new google.maps.Marker({
                    position: { lat: salonLat, lng: salonLng },
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
            async defer>
        </script>
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

<form action="{{ route('front.profile.salon.manager.updateInfo') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="name" class="form-label">اسم الصالون</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ old('name', $salon->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label">البريد الإلكتروني (لا يمكن تعديله، يمكنك تعديل إيميل البروفايل)</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $salon->owner->email }}"
                readonly>
        </div>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">وصف الصالون</label>
        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $salon->description) }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="city_id" class="form-label">المدينة</label>
            <x-form.city-select name="city_id" :selected="$salon->city_id" class="form-control @error('city_id') is-invalid @enderror" />
            @error('city_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="address" class="form-label">العنوان</label>
            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                value="{{ old('address', $salon->address) }}" required>
            @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="row mb-3">
        <div class="form-group">
            <label>حدد موقع الصالون على الخريطة</label>
            <div id="map" style="height: 400px; width: 100%;"></div>
            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $salon->latitude ?? '') }}">
            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $salon->longitude ?? '') }}">
            @error('latitude')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            @error('longitude')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="phone" class="form-label">رقم الهاتف</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone"
                value="{{ old('phone', $salon->phone) }}" required>
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-3">
            <label for="logo" class="form-label">شعار الصالون</label>
            <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" accept="image/*">
            @error('logo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            @if ($salon->logo_url)
                <img src="{{ $salon->logo_url }}" alt="logo"
                    style="width:40px;height:40px;object-fit:cover;border-radius:50%;" class="mt-2">
            @endif
        </div>
        <div class="col-md-3">
            <label for="cover_image" class="form-label">صورة الغلاف</label>
            <input type="file" class="form-control @error('cover_image') is-invalid @enderror" id="cover_image" name="cover_image" accept="image/*">
            @error('cover_image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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
                        <input type="time" name="working_hours[{{ $day }}][open]"
                            class="form-control @error('working_hours.' . $day . '.open') is-invalid @enderror"
                            value="{{ $workingHours[$day]['open'] ?? '' }}" placeholder="من">
                        @error('working_hours.' . $day . '.open')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">وقت الإغلاق</label>
                        <input type="time" name="working_hours[{{ $day }}][close]"
                            class="form-control @error('working_hours.' . $day . '.close') is-invalid @enderror"
                            value="{{ $workingHours[$day]['close'] ?? '' }}" placeholder="إلى">
                        @error('working_hours.' . $day . '.close')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input @error('working_hours.' . $day . '.closed') is-invalid @enderror"
                                type="checkbox" name="working_hours[{{ $day }}][closed]"
                                id="working_hours[{{ $day }}][closed]"
                                {{ !empty($workingHours[$day]['closed']) ? 'checked' : '' }}>
                            <label for="working_hours[{{ $day }}][closed]" class="form-check-label">عطلة عمل</label>
                            @error('working_hours.' . $day . '.closed')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @error('working_hours')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">روابط التواصل الاجتماعي</label>
        <div class="row g-2">
            <div class="col-md-4">
                <input type="url" name="social_links[facebook]"
                    value="{{ old('social_links.facebook', $salon->social_links['facebook'] ?? '') }}"
                    class="form-control @error('social_links.facebook') is-invalid @enderror" placeholder="Facebook URL">
                @error('social_links.facebook')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <input type="url" name="social_links[instagram]"
                    value="{{ old('social_links.instagram', $salon->social_links['instagram'] ?? '') }}"
                    class="form-control @error('social_links.instagram') is-invalid @enderror" placeholder="Instagram URL">
                @error('social_links.instagram')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <input type="url" name="social_links[twitter]"
                    value="{{ old('social_links.twitter', $salon->social_links['twitter'] ?? '') }}"
                    class="form-control @error('social_links.twitter') is-invalid @enderror" placeholder="Twitter URL">
                @error('social_links.twitter')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <input type="url" name="social_links[tiktok]"
                    value="{{ old('social_links.tiktok', $salon->social_links['tiktok'] ?? '') }}"
                    class="form-control @error('social_links.tiktok') is-invalid @enderror" placeholder="TikTok URL">
                @error('social_links.tiktok')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <input type="url" name="social_links[snapchat]"
                    value="{{ old('social_links.snapchat', $salon->social_links['snapchat'] ?? '') }}"
                    class="form-control @error('social_links.snapchat') is-invalid @enderror" placeholder="Snapchat URL">
                @error('social_links.snapchat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <input type="url" name="social_links[youtube]"
                    value="{{ old('social_links.youtube', $salon->social_links['youtube'] ?? '') }}"
                    class="form-control @error('social_links.youtube') is-invalid @enderror" placeholder="YouTube URL">
                @error('social_links.youtube')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        @error('social_links')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
    <!-- Features -->
    <div class="mb-3">
        <label class="form-label">المميزات المتوفرة</label>
        <div class="row g-2">
            <div class="col-md-4">
                <label class="form-check-label">
                    <input name="features[parking]" type="checkbox"
                        @checked(old('features.parking', isset($salon->features['parking'])))
                        class="form-checkbox @error('features.parking') is-invalid @enderror" value="on">
                    <i class="fas fa-car"></i>
                    <span>موقف سيارات</span>
                </label>
                @error('features.parking')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-check-label">
                    <input name="features[wifi]" type="checkbox"
                        @checked(old('features.wifi', isset($salon->features['wifi'])))
                        class="form-checkbox @error('features.wifi') is-invalid @enderror" value="on">
                    <i class="fas fa-wifi"></i>
                    <span>واي فاي مجاني</span>
                </label>
                @error('features.wifi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-check-label">
                    <input name="features[ac]" type="checkbox"
                        @checked(old('features.ac', isset($salon->features['ac'])))
                        class="form-checkbox @error('features.ac') is-invalid @enderror" value="on">
                    <i class="fas fa-snowflake"></i>
                    <span>تكييف</span>
                </label>
                @error('features.ac')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-check-label">
                    <input name="features[waiting-area]" type="checkbox"
                        @checked(old('features.waiting-area', isset($salon->features['waiting-area'])))
                        class="form-checkbox @error('features.waiting-area') is-invalid @enderror" value="on">
                    <i class="fas fa-couch"></i>
                    <span>منطقة انتظار</span>
                </label>
                @error('features.waiting-area')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-check-label">
                    <input name="features[refreshments]" type="checkbox"
                        @checked(old('features.refreshments', isset($salon->features['refreshments'])))
                        class="form-checkbox @error('features.refreshments') is-invalid @enderror" value="on">
                    <i class="fas fa-coffee"></i>
                    <span>مشروبات مجانية</span>
                </label>
                @error('features.refreshments')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-check-label">
                    <input name="features[child-care]" type="checkbox"
                        @checked(old('features.child-care', isset($salon->features['child-care'])))
                        class="form-checkbox @error('features.child-care') is-invalid @enderror" value="on">
                    <i class="fas fa-baby"></i>
                    <span>رعاية أطفال</span>
                </label>
                @error('features.child-care')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        @error('features')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label fw-semibold">تاريخ بداية الرخصة</label>
            <input name="license_start_date" type="date"
                class="form-control no-hover-effects @error('license_start_date') is-invalid @enderror"
                id="license_start_date" value="{{ old('license_start_date', $salon->license_start_date) }}" />
            @error('license_start_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">تاريخ نهاية الرخصة</label>
            <input name="license_end_date" type="date"
                class="form-control no-hover-effects @error('license_end_date') is-invalid @enderror"
                id="license_end_date" value="{{ old('license_end_date', $salon->license_end_date) }}" />
            @error('license_end_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4">
            <label for="license_document" class="form-label">تحديث الترخيص</label>
            <input type="file" class="form-control @error('license_document') is-invalid @enderror"
                id="license_document" name="license_document" accept="image/*">
            @error('license_document')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            @if ($salon->license_url)
                <img src="{{ $salon->license_url }}" alt="license"
                    style="width:40px;height:40px;object-fit:cover;" class="mt-2">
            @endif
        </div>
    </div>
    <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
</form>

@push('scripts')
<script>
    function initMap() {
        // Initialize coordinates with existing salon values or fallback to Saudi Arabia
        var salonLat = {{ $salon->latitude ?? '24.7135517' }};
        var salonLng = {{ $salon->longitude ?? '46.6752957' }};

        // Initialize the map
        var map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: salonLat, lng: salonLng },
            zoom: 12
        });

        // Initialize marker at the salon's coordinates
        var marker = new google.maps.Marker({
            position: { lat: salonLat, lng: salonLng },
            map: map,
            draggable: true
        });

        // Update hidden inputs only when the marker is dragged
        google.maps.event.addListener(marker, 'dragend', function(event) {
            document.getElementById('latitude').value = event.latLng.lat();
            document.getElementById('longitude').value = event.latLng.lng();
        });

        // Places Autocomplete for address search
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

    .place-autocomplete-card {
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

    .invalid-feedback {
        font-size: 0.875rem;
    }

    .form-check-input.is-invalid ~ .form-check-label {
        color: #dc3545;
    }
</style>
@endpush

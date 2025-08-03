<div class="row mb-3">
    <div class="col-md-6">
        <label for="name" class="form-label">{{ __('dashboard.name') }}</label>
        <input type="text" class="form-control" id="name" name="name"
            value="{{ old('name', $salon->name ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label for="owner_id" class="form-label">{{ __('dashboard.owner') }}</label>
        <select name="owner_id" id="owner_id" class="form-control" required>
            <option value="">{{ __('dashboard.choose_owner') }}</option>
            @foreach ($owners as $owner)
                <option value="{{ $owner->id }}"
                    {{ old('owner_id', $salon->owner_id ?? '') == $owner->id ? 'selected' : '' }}>{{ $owner->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <label for="description" class="form-label">{{ __('dashboard.description') }}</label>
        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $salon->description ?? '') }}</textarea>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label for="address" class="form-label">{{ __('dashboard.address') }}</label>
        <input type="text" class="form-control" id="address" name="address"
            value="{{ old('address', $salon->address ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label for="city_id" class="form-label">{{ __('dashboard.city') }}</label>
        <x-form.city-select name="city_id" :selected="$salon->city_id ?? null" class="form-control" />
    </div>
</div>
<div class="row mb-3">
    <div class="form-group">
        <label>حدد موقع الصالون على الخريطة</label>

        <div id="map" style="height: 400px; width: 100%;"></div>
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-6">
        <label for="phone" class="form-label">{{ __('dashboard.phone') }}</label>
        <input type="text" class="form-control" id="phone" name="phone"
            value="{{ old('phone', $salon->phone ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label for="promotion" class="form-label">{{ __('dashboard.promotion') }}</label>
        <select name="is_promoted" id="promotion" class="form-control">
            <option value="1" {{ old('status', $salon->is_promoted ?? 1) == 1 ? 'selected' : '' }}>
                {{ __('dashboard.active') }}</option>
            <option value="0" {{ old('status', $salon->is_promoted ?? 1) == 0 ? 'selected' : '' }}>
                {{ __('dashboard.inactive') }}</option>
        </select>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-6">
        <label for="status" class="form-label">{{ __('dashboard.status') }}</label>
        <select name="status" id="status" class="form-control">
            <option value="1" {{ old('status', $salon->status ?? 1) == 1 ? 'selected' : '' }}>
                {{ __('dashboard.active') }}</option>
            <option value="0" {{ old('status', $salon->status ?? 1) == 0 ? 'selected' : '' }}>
                {{ __('dashboard.inactive') }}</option>
        </select>
    </div>

    <div class="col-md-6">
        <label for="type" class="form-label">{{ __('dashboard.type_salon') }}</label>
        <select name="type" id="type" class="form-control">
            <option value="beauty_center"
                {{ old('type', $salon->type ?? 'beauty_center') == 'beauty_center' ? 'selected' : '' }}>
                {{ __('dashboard.beauty_center') }}</option>
            <option value="home_salon"
                {{ old('type', $salon->type ?? 'beauty_center') == 'home_salon' ? 'selected' : '' }}>
                {{ __('dashboard.home_salon') }}</option>
        </select>
    </div>

</div>
{{-- @dd(10) --}}
<div class="row mb-3">
    <div class="col-md-6">
        <label for="logo" class="form-label">{{ __('dashboard.logo') }}</label>
        <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
        @if (!empty($salon) && $salon->logo)
            <img src="{{ asset('storage/' . $salon->logo) }}" alt="logo"
                style="width:40px;height:40px;object-fit:cover;border-radius:50%;" class="mt-2">
        @endif
    </div>
    <div class="col-md-6">
        <label for="cover_image" class="form-label">{{ __('dashboard.cover_image') }}</label>
        <input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/*">
        @if (!empty($salon) && $salon->cover_image)
            <img src="{{ asset('storage/' . $salon->cover_image) }}" alt="cover"
                style="width:40px;height:40px;object-fit:cover;" class="mt-2">
        @endif
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <label class="form-label">{{ __('dashboard.working_hours') }}</label>

        @php
            $days = ['friday', 'saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday'];
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
                                class="form-control" value="{{ $workingHours[$day]['open'] ?? '' }}"
                                id="saturdayStart" placeholder="من">
                        </div>
                        <div class="col-md-3">
                            <input type="time" name="working_hours[{{ $day }}][close]"
                                class="form-control" value="{{ $workingHours[$day]['close'] ?? '' }}"
                                id="saturdayEnd" placeholder="إلى">
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                    name="working_hours[{{ $day }}][closed]" id="saturdayClosed"
                                    @checked(isset($workingHours[$day]['closed']))>
                                <label class="form-check-label" for="saturdayClosed">مغلق</label>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <label class="form-label">{{ __('dashboard.social_links') }}</label>
        <div class="row g-2">
            <div class="col-md-4">
                <input type="url" name="social_links[facebook]"
                    value="{{ old('social_links.facebook', $salon->social_links['facebook'] ?? '') }}"
                    class="form-control" placeholder="Facebook URL">
            </div>
            <div class="col-md-4">
                <input type="url" name="social_links[twitter]"
                    value="{{ old('social_links.twitter', $salon->social_links['twitter'] ?? '') }}"
                    class="form-control" placeholder="Twitter URL">
            </div>
            <div class="col-md-4">
                <input type="url" name="social_links[instagram]"
                    value="{{ old('social_links.instagram', $salon->social_links['instagram'] ?? '') }}"
                    class="form-control" placeholder="Instagram URL">
            </div>
            <div class="col-md-4">
                <input type="url" name="social_links[snapchat]"
                    value="{{ old('social_links.snapchat', $salon->social_links['snapchat'] ?? '') }}"
                    class="form-control" placeholder="snapchat URL">
            </div>
            <div class="col-md-4">
                <input type="url" name="social_links[tiktok]"
                    value="{{ old('social_links.tiktok', $salon->social_links['tiktok'] ?? '') }}"
                    class="form-control" placeholder="tiktok URL">
            </div>
            <div class="col-md-4">
                <input type="url" name="social_links[youtube]"
                    value="{{ old('social_links.youtube', $salon->social_links['youtube'] ?? '') }}"
                    class="form-control" placeholder="youtube URL">
            </div>
        </div>
    </div>
</div>
<div class="mb-3">

    <label class="form-label">المميزات المتوفرة</label>

    <div class="row g-2">
        <div class="col-md-4">
            <label class="form-check-label">
                <input name="features[parking]" type="checkbox" class="form-checkbox" @checked(old('features.parking', isset($salon->features['parking'])))
                    value="on">
                <i class="fa fa-car"></i>
                <span>موقف سيارات</span>
            </label>
        </div>
        <div class="col-md-4">
            <label class="form-check-label">
                <input name="features[wifi]" type="checkbox" class="form-checkbox" @checked(old('features.wifi', isset($salon->features['wifi'])))
                    value="on">
                <i class="fa fa-wifi"></i>
                <span>واي فاي مجاني</span>
            </label>
        </div>
        <div class="col-md-4">
            <label class="form-check-label">
                <input name="features[ac]" type="checkbox" class="form-checkbox" @checked(old('features.ac', isset($salon->features['ac'])))
                    value="on">
                <i class="fa fa-fan"></i>
                <span>تكييف</span>
            </label>
        </div>
        <div class="col-md-4">
            <label class="form-check-label">
                <input name="features[waiting-area]" type="checkbox" class="form-checkbox"
                    @checked(old('features.waiting-area', isset($salon->features['waiting-area']))) value="on">
                <i class="fa fa-clock"></i>
                <span>منطقة انتظار</span>
            </label>
        </div>
        <div class="col-md-4">
            <label class="form-check-label">
                <input name="features[refreshments]" type="checkbox" class="form-checkbox"
                    @checked(old('features.refreshments', isset($salon->features['refreshments']))) value="on">
                <i class="fa fa-coffee"></i>
                <span>مشروبات مجانية</span>
            </label>
        </div>
        <div class="col-md-4">
            <label class="form-check-label">
                <input name="features[child-care]" type="checkbox" class="form-checkbox" @checked(old('features.child-care', isset($salon->features['child-care'])))
                    value="on">
                <i class="fa fa-child"></i>
                <span>رعاية أطفال</span>
            </label>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <label class="form-label">{{ __('dashboard.seo_meta') }}</label>
        <input type="text" class="form-control mb-2" name="seo_meta[title]"
            value="{{ old('seo_meta.title', $salon->seo_meta['title'] ?? '') }}"
            placeholder="{{ __('dashboard.seo_title') }}">
        <textarea class="form-control" name="seo_meta[description]" placeholder="{{ __('dashboard.seo_description') }}">{{ old('seo_meta.description', $salon->seo_meta['description'] ?? '') }}</textarea>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <label class="form-label">{{ __('dashboard.gallery_images') }}</label>
        <input type="file" class="form-control" name="gallery_images[]" multiple accept="image/*">
        @if (isset($salon) && $salon->media)
            <div class="row mt-2">
                @foreach ($salon->media as $media)
                    <div class="col-md-2 text-center mb-2">
                        <img src="{{ asset('storage/' . $media->path) }}" alt="gallery"
                            style="width:100px;height:100px;object-fit:cover;border-radius:8px;">
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
<button type="submit" class="btn btn-primary">{{ $nextText ?? __('Next') }}</button>

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

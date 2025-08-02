


    <div class="row mb-3">
        <div class="col-md-6">
            <label for="name" class="form-label">{{ __('dashboard.city') }}</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $city->name ?? '') }}" required>
            <div class="invalid-feedback">{{ __('validation.required', ['attribute' => __('dashboard.name')]) }}</div>
        </div>
        <div class="col-md-6">
            <label for="country" class="form-label">{{ __('dashboard.country') }}</label>
            <input type="text" class="form-control" id="country" name="country" value="{{ $city->country ?? 'السعودية' }}" readonly>
        </div>
    </div>
    <div class="row mb-3">
        <div class="form-group">
            <label>حدد المدينة على الخريطة</label>

            <div id="map" style="height: 400px; width: 100%;"></div>
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">
        </div>
    </div>
    <button type="submit" class="btn btn-primary">{{ $submitText }}</button>
    <a href="{{ route('dashboard.cities.index') }}" class="btn btn-outline-primary">{{ __('dashboard.cancel') }}</a>

    @push('scripts')
        <script>
            function initMap() {
                // الحصول على إحداثيات المدينة إذا كانت موجودة، وإلا استخدام إحداثيات السعودية
                var cityLat = {{ $city->latitude ?? '24.7135517' }};
                var cityLng = {{ $city->longitude ?? '46.6752957' }};

                // إنشاء الخريطة مع مركز في إحداثيات المدينة أو السعودية
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: { lat: cityLat, lng: cityLng },
                    zoom: 6
                });

                // إضافة دبوس (Marker) قابل للسحب في موقع المدينة أو السعودية
                var marker = new google.maps.Marker({
                    position: { lat: cityLat, lng: cityLng },
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

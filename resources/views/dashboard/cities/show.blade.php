@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.cities'), 'url' => route('dashboard.cities.index')],
        ['label' => __('dashboard.show_city'), 'url' => route('dashboard.cities.show', $city->id)],
    ]" :pageName="__('dashboard.show_city')" />
@endsection

@section('content')
    <x-alert-message />
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>{{ __('dashboard.city_details') }}</h3>
            <div>
                <a href="{{ route('dashboard.cities.edit', $city->id) }}" class="btn btn-warning btn-sm"><i
                        class="fa fa-edit"></i> {{ __('dashboard.edit') }}</a>
                <a href="{{ route('dashboard.cities.index') }}" class="btn btn-outline-primary btn-sm"><i
                        class="fa fa-arrow-left"></i> {{ __('dashboard.back') }}</a>
            </div>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">{{ __('dashboard.name') }}</dt>
                <dd class="col-sm-9">{{ $city->name }}</dd>
                <dt class="col-sm-3">{{ __('dashboard.country') }}</dt>
                <dd class="col-sm-9">{{ $city->country }}</dd>
                <dt class="col-sm-3">{{ __('dashboard.latitude') }}</dt>
                <dd class="col-sm-9">{{ $city->latitude }}</dd>
                <dt class="col-sm-3">{{ __('dashboard.longitude') }}</dt>
                <dd class="col-sm-9">{{ $city->longitude }}</dd>
                {{-- <dt class="col-sm-3">{{ __('dashboard.timezone') }}</dt> --}}
                {{-- <dd class="col-sm-9">{{ $city->timezone }}</dd> --}}
                {{-- <dt class="col-sm-3">{{ __('dashboard.is_active') }}</dt> --}}
                {{-- <dd class="col-sm-9">
                    @if ($city->is_active)
                        <span class="badge bg-success">{{ __('dashboard.active') }}</span>
                    @else
                        <span class="badge bg-danger">{{ __('dashboard.inactive') }}</span>
                    @endif
                </dd> --}}
                {{-- <dt class="col-sm-3">{{ __('dashboard.google_place_id') }}</dt> --}}
                <dd class="col-sm-9">
                    <div class="row mb-3">
                        <div class="form-group">
                            <label>موقع المدينة على الخريطة</label>
                            <div id="map" style="height: 400px; width: 100%;"></div>
                        </div>
                    </div>
                </dd>
            </dl>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function initMap() {
            // الحصول على إحداثيات المدينة من المتغيرات
            var cityLat = {{ $city->latitude }};
            var cityLng = {{ $city->longitude }};

            // إنشاء الخريطة مع مركز في إحداثيات المدينة
            var map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: cityLat, lng: cityLng },
                zoom: 10
            });

            // إضافة دبوس (Marker) ثابت في موقع المدينة
            var marker = new google.maps.Marker({
                position: { lat: cityLat, lng: cityLng },
                map: map
            });

            // إضافة نافذة معلومات تحتوي على اسم المدينة
            var infoWindow = new google.maps.InfoWindow({
                content: '<h3 style="text-align: center;">{{ $city->name }}</h3>'
            });

            // فتح النافذة المعلوماتية عند النقر على العلامة
            marker.addListener('click', function() {
                infoWindow.open(map, marker);
            });

            // فتح النافذة المعلوماتية تلقائيًا عند تحميل الخريطة
            infoWindow.open(map, marker);
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

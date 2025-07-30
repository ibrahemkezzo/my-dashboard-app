@extends('layouts.dashboard')

@section('breadcrumbs')
<x-dashboard.dashboard-breadcrumb :breadcrumbs="[
    ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
    ['label' => __('dashboard.cities'), 'url' => route('dashboard.cities.index')],
    ['label' => __('dashboard.show_city'), 'url' => route('dashboard.cities.show',$city->id)],
]" :pageName="__('dashboard.show_city')" />
@endsection

@section('content')
    <x-alert-message />
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>{{ __('dashboard.city_details') }}</h3>
            <div>
                <a href="{{ route('dashboard.cities.edit', $city->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> {{ __('dashboard.edit') }}</a>
                <a href="{{ route('dashboard.cities.index') }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-arrow-left"></i> {{ __('dashboard.back') }}</a>
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
                <dt class="col-sm-3">{{ __('dashboard.timezone') }}</dt>
                <dd class="col-sm-9">{{ $city->timezone }}</dd>
                {{-- <dt class="col-sm-3">{{ __('dashboard.is_active') }}</dt> --}}
                {{-- <dd class="col-sm-9">
                    @if($city->is_active)
                        <span class="badge bg-success">{{ __('dashboard.active') }}</span>
                    @else
                        <span class="badge bg-danger">{{ __('dashboard.inactive') }}</span>
                    @endif
                </dd> --}}
                <dt class="col-sm-3">{{ __('dashboard.google_place_id') }}</dt>
                <dd class="col-sm-9">
                    <span class="text-muted">{{ __('dashboard.google_maps_integration_coming_soon') }}</span>
                </dd>
            </dl>
        </div>
    </div>
@endsection
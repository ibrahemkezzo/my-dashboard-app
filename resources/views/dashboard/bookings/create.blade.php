@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.bookings'), 'url' => route('dashboard.bookings.index')],
        ['label' => __('dashboard.create_booking'), 'url' => route('dashboard.bookings.create')],
    ]" :pageName="__('dashboard.create_booking')" />
@endsection

@section('content')
    <x-alert-message />
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('dashboard.create_booking') }}</h5>
            </div>
            <div class="card-body">
                <x-form.booking-form 
                    :users="$users"
                    :salons="$salons"
                    :salonSubServices="$salonSubServices"
                    :action="route('dashboard.bookings.store')"
                    :method="'POST'"
                    :submitButtonText="__('dashboard.create_booking')"
                />
            </div>
        </div>
    </div>
@endsection

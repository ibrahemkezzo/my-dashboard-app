@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.bookings'), 'url' => route('dashboard.bookings.index')],
        ['label' => __('dashboard.edit_booking'), 'url' => route('dashboard.bookings.edit', $booking)],
    ]" :pageName="__('dashboard.edit_booking')" />
@endsection

@section('content')
    <x-alert-message />
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('dashboard.edit_booking') }} - {{ $booking->booking_number }}</h5>
            </div>
            <div class="card-body">
                <x-form.booking-form 
                    :users="$users"
                    :salons="$salons"
                    :salonSubServices="$salonSubServices"
                    :booking="$booking"
                    :action="route('dashboard.bookings.update', $booking)"
                    :method="'PUT'"
                    :submitButtonText="__('dashboard.update_booking')"
                />
            </div>
        </div>
    </div>
@endsection
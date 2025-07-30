@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.bookings'), 'url' => route('dashboard.bookings.index')],
        ['label' => __('dashboard.show_booking'), 'url' => route('dashboard.bookings.show', $booking)],
    ]" :pageName="__('dashboard.show_booking')" />
@endsection

@section('content')
    <x-alert-message />
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('dashboard.booking_details') }} - {{ $booking->booking_number }}</h4>
                        <div class="btn-group" role="group">
                            <a href="{{ route('dashboard.bookings.edit', $booking) }}" class="btn btn-warning me-2 mb-5">
                                <i class="fa fa-edit"></i> {{ __('dashboard.edit') }}
                            </a>

                            @if($booking->canBeConfirmedBySalon())
                                <a href="{{ route('dashboard.bookings.salon-confirm-form', $booking) }}" class="btn btn-success me-2 mb-5">
                                    <i class="fa fa-check"></i> {{ __('dashboard.salon_confirmation') }}
                                </a>
                            @endif

                            @if($booking->canBeConfirmedByUser())
                                <a href="{{ route('dashboard.bookings.user-confirm-form', $booking) }}" class="btn btn-info me-2 mb-5">
                                    <i class="fa fa-user-check"></i> {{ __('dashboard.user_confirmation') }}
                                </a>
                            @endif

                            @if($booking->canBeCompleted())
                                <form action="{{ route('dashboard.bookings.complete', $booking) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary me-2 mb-3" onclick="return confirm('{{ __('dashboard.confirm_mark_complete') }}')">
                                        <i class="fa fa-check-double"></i> {{ __('dashboard.mark_as_complete') }}
                                    </button>
                                </form>
                            @endif

                            @if($booking->canBeRejected())
                                <a href="{{ route('dashboard.bookings.reject-form', $booking) }}" class="btn btn-danger me-2 mb-5">
                                    <i class="fa fa-times"></i> {{ __('dashboard.reject') }}
                                </a>
                            @endif

                            @if($booking->canBeCancelled())
                                <form action="{{ route('dashboard.bookings.cancel', $booking) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary" onclick="return confirm('{{ __('dashboard.confirm_cancel_booking') }}')">
                                        <i class="fa fa-ban"></i> {{ __('dashboard.cancel') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Booking Information -->
                            <div class="col-md-6">
                                <h5>{{ __('dashboard.booking_information') }}</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>{{ __('dashboard.booking_number') }}:</strong></td>
                                        <td>{{ $booking->booking_number }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('dashboard.status') }}:</strong></td>
                                        <td>
                                            <span class="badge {{ $booking->status_badge_class }}">
                                                {{ $booking->status_text }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('dashboard.user') }}:</strong></td>
                                        <td>{{ $booking->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('dashboard.salon') }}:</strong></td>
                                        <td>{{ $booking->salon->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('dashboard.service') }}:</strong></td>
                                        <td>{{ $booking->salonSubService->subService->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('dashboard.service_description') }}:</strong></td>
                                        <td>{{ $booking->service_description }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('dashboard.preferred_datetime') }}:</strong></td>
                                        <td>{{ $booking->preferred_datetime->format('F j, Y \a\t g:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('dashboard.created_at') }}:</strong></td>
                                        <td>{{ $booking->created_at->format('F j, Y \a\t g:i A') }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Salon Response Information -->
                            <div class="col-md-6">
                                <h5>{{ __('dashboard.salon_response') }}</h5>
                                @if($booking->status === 'pending')
                                    <div class="alert alert-warning">
                                        <i class="fa fa-clock"></i> {{ __('dashboard.waiting_for_salon_response') }}
                                    </div>
                                @else
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>{{ __('dashboard.salon_confirmed_at') }}:</strong></td>
                                            <td>{{ $booking->salon_confirmed_datetime->format('F j, Y \a\t g:i A') }}</td>
                                        </tr>

                                        @if($booking->isModifiedBySalon())
                                            <tr>
                                                <td><strong>{{ __('dashboard.salon_proposed_datetime') }}:</strong></td>
                                                <td>{{ $booking->salon_proposed_datetime->format('F j, Y \a\t g:i A') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{{ __('dashboard.salon_proposed_price') }}:</strong></td>
                                                <td>{{ $booking->salon_proposed_price }} {{ __('dashboard.currency') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{{ __('dashboard.salon_proposed_duration') }}:</strong></td>
                                                <td>{{ $booking->salon_proposed_duration }} {{ __('dashboard.minutes') }}</td>
                                            </tr>
                                            @if($booking->salon_modification_reason)
                                                <tr>
                                                    <td><strong>{{ __('dashboard.salon_modification_reason') }}:</strong></td>
                                                    <td>{{ $booking->salon_modification_reason }}</td>
                                                </tr>
                                            @endif
                                        @endif

                                        @if($booking->salon_notes)
                                            <tr>
                                                <td><strong>{{ __('dashboard.salon_notes') }}:</strong></td>
                                                <td>{{ $booking->salon_notes }}</td>
                                            </tr>
                                        @endif
                                    </table>
                                @endif
                            </div>
                        </div>

                        <!-- User Confirmation Information -->
                        @if($booking->status === 'user_confirmed')
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h5>{{ __('dashboard.user_confirmation') }}</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>{{ __('dashboard.user_confirmed_at') }}:</strong></td>
                                            <td>{{ $booking->user_confirmed_datetime->format('F j, Y \a\t g:i A') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        @endif

                        <!-- Final Details -->
                        @if($booking->status === 'user_confirmed')
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h5>{{ __('dashboard.final_details') }}</h5>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p><strong>{{ __('dashboard.final_datetime') }}:</strong><br>
                                                    {{ $booking->final_datetime->format('F j, Y \a\t g:i A') }}</p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p><strong>{{ __('dashboard.final_price') }}:</strong><br>
                                                    {{ $booking->final_price }} {{ __('dashboard.currency') }}</p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p><strong>{{ __('dashboard.final_duration') }}:</strong><br>
                                                    {{ $booking->final_duration }} {{ __('dashboard.minutes') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Rejection Information -->
                        @if($booking->status === 'rejected' && $booking->rejection_reason)
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h5>{{ __('dashboard.rejection_information') }}</h5>
                                    <div class="alert alert-danger">
                                        <p><strong>{{ __('dashboard.rejection_reason') }}:</strong><br>
                                        {{ $booking->rejection_reason }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Related Links -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5>{{ __('dashboard.related_links') }}</h5>
                                <div class="list-group">
                                    <a href="{{ route('dashboard.salons.show', $booking->salon) }}?tab=bookings" class="list-group-item list-group-item-action">
                                        <i class="fa fa-building"></i> {{ __('dashboard.view_salon_bookings') }}
                                    </a>
                                    <a href="{{ route('dashboard.users.show', $booking->user) }}?tab=bookings" class="list-group-item list-group-item-action">
                                        <i class="fa fa-user"></i> {{ __('dashboard.view_user_bookings') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .list-group-item {
        border: none;
        padding: 0.75rem 0;
    }

    .list-group-item i {
        margin-right: 0.5rem;
        width: 16px;
    }
</style>
@endpush

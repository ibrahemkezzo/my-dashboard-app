@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.bookings'), 'url' => route('dashboard.bookings.index')],
        ['label' => __('dashboard.show_booking'), 'url' => route('dashboard.bookings.show', $booking->id)],
    ]" :pageName="__('dashboard.show_booking')" />
@endsection

@section('content')
    <x-alert-message />
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ __('dashboard.booking_details') }}</h5>
                        <div class="btn-group" role="group">
                            <a href="{{ route('dashboard.bookings.edit', $booking) }}" class="btn btn-warning me-2 mb-3">
                                <i class="fa fa-edit"></i> {{ __('dashboard.edit') }}
                            </a>

                            @if($booking->canBeConfirmed())
                                <a href="{{ route('dashboard.bookings.confirm-form', $booking) }}" class="btn btn-success me-2 mb-3">
                                    <i class="fa fa-check"></i> {{ __('dashboard.confirm') }}
                                </a>
                            @endif

                            @if($booking->canBeRejected())
                                <a href="{{ route('dashboard.bookings.reject-form', $booking) }}" class="btn btn-danger me-2 mb-3">
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-bold text-muted">{{ __('dashboard.booking_number') }}:</label>
                                    <p class="mb-0">{{ $booking->booking_number }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="fw-bold text-muted">{{ __('dashboard.status') }}:</label>
                                    <p class="mb-0">
                                        <span class="badge {{ $booking->status_badge_class }}">
                                            {{ $booking->status_text }}
                                        </span>
                                    </p>
                                </div>

                                <div class="mb-3">
                                    <label class="fw-bold text-muted">{{ __('dashboard.preferred_datetime') }}:</label>
                                    <p class="mb-0">{{ $booking->preferred_datetime->format('F j, Y \a\t g:i A') }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="fw-bold text-muted">{{ __('dashboard.created_at') }}:</label>
                                    <p class="mb-0">{{ $booking->created_at->format('F j, Y \a\t g:i A') }}</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-bold text-muted">{{ __('dashboard.user') }}:</label>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $booking->user->url }}" alt="{{ $booking->user->name }}" class="rounded-circle me-2" style="width: 40px; height: 40px;">
                                        <div>
                                            <p class="mb-0">{{ $booking->user->name }}</p>
                                            <small class="text-muted">{{ $booking->user->email }}</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="fw-bold text-muted">{{ __('dashboard.salon') }}:</label>
                                    <p class="mb-0">{{ $booking->salon->name }}</p>
                                    <small class="text-muted">{{ $booking->salon->address }}, {{ $booking->salon->city->name }}</small>
                                </div>

                                <div class="mb-3">
                                    <label class="fw-bold text-muted">{{ __('dashboard.service') }}:</label>
                                    <p class="mb-0">{{ $booking->salonSubService->subService->name }}</p>
                                    <small class="text-muted">{{ $booking->salonSubService->subService->service->name }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold text-muted">{{ __('dashboard.service_description') }}:</label>
                            <p class="mb-0">{{ $booking->service_description }}</p>
                        </div>

                        @if($booking->special_requirements)
                            <div class="mb-3">
                                <label class="fw-bold text-muted">{{ __('dashboard.special_requirements') }}:</label>
                                <p class="mb-0">{{ $booking->special_requirements }}</p>
                            </div>
                        @endif

                        @if($booking->rejection_reason)
                            <div class="mb-3">
                                <label class="fw-bold text-muted">{{ __('dashboard.rejection_reason') }}:</label>
                                <p class="mb-0 text-danger">{{ $booking->rejection_reason }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                @if($booking->appointment)
                    <div class="card mt-4">
                        <div class="card-header">
                            <h6 class="mb-0">{{ __('dashboard.appointment_details') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-bold text-muted">{{ __('dashboard.appointment_number') }}:</label>
                                        <p class="mb-0">{{ $booking->appointment->appointment_number }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold text-muted">{{ __('dashboard.scheduled_datetime') }}:</label>
                                        <p class="mb-0">{{ $booking->appointment->scheduled_datetime->format('F j, Y \a\t g:i A') }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold text-muted">{{ __('dashboard.duration') }}:</label>
                                        <p class="mb-0">{{ $booking->appointment->duration_minutes }} {{ __('dashboard.minutes') }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="fw-bold text-muted">{{ __('dashboard.status') }}:</label>
                                        <p class="mb-0">
                                            <span class="badge {{ $booking->appointment->status_badge_class }}">
                                                {{ $booking->appointment->status_text }}
                                            </span>
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold text-muted">{{ __('dashboard.total_price') }}:</label>
                                        <p class="mb-0">{{ number_format($booking->appointment->total_price, 2) }} {{ __('dashboard.currency') }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold text-muted">{{ __('dashboard.payment_status') }}:</label>
                                        <p class="mb-0">
                                            <span class="badge {{ $booking->appointment->payment_status_badge_class }}">
                                                {{ $booking->appointment->payment_status_text }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            @if($booking->appointment->notes)
                                <div class="mb-3">
                                    <label class="fw-bold text-muted">{{ __('dashboard.notes') }}:</label>
                                    <p class="mb-0">{{ $booking->appointment->notes }}</p>
                                </div>
                            @endif

                            <div class="mt-3">
                                <a href="{{ route('dashboard.appointments.show', $booking->appointment) }}" class="btn btn-info">
                                    <i class="fa fa-eye"></i> {{ __('dashboard.view_appointment') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">{{ __('dashboard.quick_actions') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            @if($booking->canBeConfirmed())
                                <a href="{{ route('dashboard.bookings.confirm-form', $booking) }}" class="btn btn-success">
                                    <i class="fa fa-check"></i> {{ __('dashboard.confirm_booking') }}
                                </a>
                            @endif

                            @if($booking->canBeRejected())
                                <a href="{{ route('dashboard.bookings.reject-form', $booking) }}" class="btn btn-danger">
                                    <i class="fa fa-times"></i> {{ __('dashboard.reject_booking') }}
                                </a>
                            @endif

                            @if($booking->canBeCancelled())
                                <form action="{{ route('dashboard.bookings.cancel', $booking) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary w-100" onclick="return confirm('{{ __('dashboard.confirm_cancel_booking') }}')">
                                        <i class="fa fa-ban"></i> {{ __('dashboard.cancel_booking') }}
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('dashboard.bookings.edit', $booking) }}" class="btn btn-warning">
                                <i class="fa fa-edit"></i> {{ __('dashboard.edit_booking') }}
                            </a>

                            <a href="{{ route('dashboard.bookings.index') }}" class="btn btn-outline-secondary">
                                <i class="fa fa-arrow-left"></i> {{ __('dashboard.back_to_bookings') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">{{ __('dashboard.related_links') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('dashboard.salons.show', $booking->salon) }}?tab=bookings" class="list-group-item list-group-item-action">
                                <i class="fa fa-building"></i> {{ __('dashboard.view_salon_bookings') }}
                            </a>
                            <a href="{{ route('dashboard.users.show', $booking->user) }}?tab=bookings" class="list-group-item list-group-item-action">
                                <i class="fa fa-user"></i> {{ __('dashboard.view_user_bookings') }}
                            </a>
                            <a href="{{ route('dashboard.salons.show', $booking->salon) }}" class="list-group-item list-group-item-action">
                                <i class="fa fa-eye"></i> {{ __('dashboard.view_salon_details') }}
                            </a>
                            <a href="{{ route('dashboard.users.show', $booking->user) }}" class="list-group-item list-group-item-action">
                                <i class="fa fa-user"></i> {{ __('dashboard.view_user_details') }}
                            </a>
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
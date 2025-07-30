@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.appointments'), 'url' => route('dashboard.appointments.index')],
        ['label' => __('dashboard.show_appointment'), 'url' => route('dashboard.appointments.show', $appointment)],
    ]" :pageName="__('dashboard.show_appointment')" />
@endsection

@section('content')
    <x-alert-message />
    <div class="container-fluid">
        <!-- Action Buttons -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="mb-0">{{ __('dashboard.appointment_details') }}</h5>
                    <div class="btn-group" role="group">
                        <a href="{{ route('dashboard.appointments.edit', $appointment) }}" class="btn btn-warning">
                            <i class="fa fa-edit"></i> {{ __('dashboard.edit') }}
                        </a>
                        
                        @if($appointment->canBeInProgress())
                            <form action="{{ route('dashboard.appointments.in-progress', $appointment) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-play"></i> {{ __('dashboard.mark_in_progress') }}
                                </button>
                            </form>
                        @endif
                        
                        @if($appointment->canBeCompleted())
                            <form action="{{ route('dashboard.appointments.completed', $appointment) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-check"></i> {{ __('dashboard.mark_completed') }}
                                </button>
                            </form>
                        @endif
                        
                        @if($appointment->canBeCancelled())
                            <form action="{{ route('dashboard.appointments.cancel', $appointment) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('dashboard.confirm_cancel_appointment') }}')">
                                    <i class="fa fa-ban"></i> {{ __('dashboard.cancel') }}
                                </button>
                            </form>
                        @endif
                        
                        @if($appointment->status === 'scheduled')
                            <form action="{{ route('dashboard.appointments.no-show', $appointment) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-secondary" onclick="return confirm('{{ __('dashboard.confirm_no_show') }}')">
                                    <i class="fa fa-user-times"></i> {{ __('dashboard.mark_no_show') }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Appointment Information -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('dashboard.appointment_information') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="fw-bold text-muted">{{ __('dashboard.appointment_number') }}:</label>
                                <p class="mb-0">{{ $appointment->appointment_number }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-bold text-muted">{{ __('dashboard.status') }}:</label>
                                <p class="mb-0">
                                    <span class="badge {{ $appointment->status_badge_class }}">
                                        {{ $appointment->status_text }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-bold text-muted">{{ __('dashboard.payment_status') }}:</label>
                                <p class="mb-0">
                                    <span class="badge {{ $appointment->payment_status_badge_class }}">
                                        {{ $appointment->payment_status_text }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="fw-bold text-muted">{{ __('dashboard.scheduled_datetime') }}:</label>
                                <p class="mb-0">{{ $appointment->scheduled_datetime->format('F j, Y \a\t g:i A') }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold text-muted">{{ __('dashboard.duration') }}:</label>
                                <p class="mb-0">{{ $appointment->duration_minutes }} {{ __('dashboard.minutes') }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="fw-bold text-muted">{{ __('dashboard.end_time') }}:</label>
                                <p class="mb-0">{{ $appointment->end_time->format('g:i A') }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold text-muted">{{ __('dashboard.total_price') }}:</label>
                                <p class="mb-0">{{ number_format($appointment->total_price, 2) }} {{ __('dashboard.currency') }}</p>
                            </div>
                        </div>

                        @if($appointment->deposit_amount > 0)
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="fw-bold text-muted">{{ __('dashboard.deposit_amount') }}:</label>
                                <p class="mb-0">{{ number_format($appointment->deposit_amount, 2) }} {{ __('dashboard.currency') }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-bold text-muted">{{ __('dashboard.deposit_paid') }}:</label>
                                <p class="mb-0">{{ number_format($appointment->deposit_paid, 2) }} {{ __('dashboard.currency') }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-bold text-muted">{{ __('dashboard.remaining_deposit') }}:</label>
                                <p class="mb-0">{{ number_format($appointment->remaining_deposit, 2) }} {{ __('dashboard.currency') }}</p>
                            </div>
                        </div>
                        @endif

                        @if($appointment->notes)
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="fw-bold text-muted">{{ __('dashboard.notes') }}:</label>
                                <p class="mb-0">{{ $appointment->notes }}</p>
                            </div>
                        </div>
                        @endif

                        @if($appointment->cancellation_reason)
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="fw-bold text-muted">{{ __('dashboard.cancellation_reason') }}:</label>
                                <p class="mb-0 text-danger">{{ $appointment->cancellation_reason }}</p>
                            </div>
                        </div>
                        @endif

                        @if($appointment->cancelled_at)
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="fw-bold text-muted">{{ __('dashboard.cancelled_at') }}:</label>
                                <p class="mb-0">{{ $appointment->cancelled_at->format('F j, Y \a\t g:i A') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- User and Salon Information -->
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0">{{ __('dashboard.user_information') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ $appointment->booking->user->url }}" alt="{{ $appointment->booking->user->name }}" class="rounded-circle me-3" style="width: 60px; height: 60px;">
                            <div>
                                <h6 class="mb-0">{{ $appointment->booking->user->name }}</h6>
                                <small class="text-muted">{{ $appointment->booking->user->email }}</small>
                            </div>
                        </div>
                        <a href="{{ route('dashboard.bookings.user', $appointment->booking->user) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-eye"></i> {{ __('dashboard.view_user_bookings') }}
                        </a>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0">{{ __('dashboard.salon_information') }}</h6>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-1">{{ $appointment->booking->salon->name }}</h6>
                        <p class="text-muted mb-2">{{ $appointment->booking->salon->address }}, {{ $appointment->booking->salon->city->name }}</p>
                        <a href="{{ route('dashboard.bookings.salon', $appointment->booking->salon) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-eye"></i> {{ __('dashboard.view_salon_bookings') }}
                        </a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">{{ __('dashboard.service_information') }}</h6>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-1">{{ $appointment->booking->salonSubService->subService->name }}</h6>
                        <p class="text-muted mb-2">{{ $appointment->booking->salonSubService->subService->service->name }}</p>
                        <p class="mb-0"><strong>{{ __('dashboard.service_description') }}:</strong> {{ $appointment->booking->service_description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Booking Information -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">{{ __('dashboard.related_booking') }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label class="fw-bold text-muted">{{ __('dashboard.booking_number') }}:</label>
                        <p class="mb-0">{{ $appointment->booking->booking_number }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold text-muted">{{ __('dashboard.booking_status') }}:</label>
                        <p class="mb-0">
                            <span class="badge {{ $appointment->booking->status_badge_class }}">
                                {{ $appointment->booking->status_text }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold text-muted">{{ __('dashboard.preferred_datetime') }}:</label>
                        <p class="mb-0">{{ $appointment->booking->preferred_datetime->format('F j, Y \a\t g:i A') }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold text-muted">{{ __('dashboard.created_at') }}:</label>
                        <p class="mb-0">{{ $appointment->booking->created_at->format('F j, Y \a\t g:i A') }}</p>
                    </div>
                </div>
                


                <div class="mt-3">
                    <a href="{{ route('dashboard.bookings.show', $appointment->booking) }}" class="btn btn-info">
                        <i class="fa fa-eye"></i> {{ __('dashboard.view_booking_details') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection 
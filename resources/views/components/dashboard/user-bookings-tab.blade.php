@props(['user', 'bookings', 'statistics'])

<div class="booking-summary mb-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h4>{{ $statistics['total'] }}</h4>
                    <p class="mb-0">{{ __('dashboard.total_bookings') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h4>{{ $statistics['confirmed'] }}</h4>
                    <p class="mb-0">{{ __('dashboard.confirmed_bookings') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h4>{{ $statistics['pending'] }}</h4>
                    <p class="mb-0">{{ __('dashboard.pending_bookings') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h4>{{ $statistics['cancelled'] }}</h4>
                    <p class="mb-0">{{ __('dashboard.cancelled_bookings') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bookings-list">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">{{ __('dashboard.user_bookings') }}</h5>
        <a href="{{ route('dashboard.bookings.create') }}" class="btn btn-primary btn-sm">
            <i class="fa fa-plus"></i> {{ __('dashboard.create_booking') }}
        </a>
    </div>

    @forelse($bookings as $booking)
        <div class="card mb-3">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <strong>{{ __('dashboard.booking_number') }}:</strong>
                        <span class="text-muted">{{ $booking->booking_number }}</span>
                    </div>
                    <div class="col-md-2">
                        <strong>{{ __('dashboard.salon') }}:</strong>
                        <span class="text-muted">{{ $booking->salon->name }}</span>
                    </div>
                    <div class="col-md-2">
                        <strong>{{ __('dashboard.service') }}:</strong>
                        <span class="text-muted">{{ $booking->salonSubService->subService->name }}</span>
                    </div>
                    <div class="col-md-2">
                        <strong>{{ __('dashboard.date') }}:</strong>
                        <span class="text-muted">{{ $booking->preferred_datetime->format('M j, Y') }}</span>
                    </div>
                    <div class="col-md-2">
                        <strong>{{ __('dashboard.status') }}:</strong>
                        <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : ($booking->status === 'pending' ? 'warning' : ($booking->status === 'rejected' ? 'danger' : 'secondary')) }}">
                            {{ __('dashboard.' . $booking->status) }}
                        </span>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#booking-{{ $booking->id }}">
                            <i class="fa fa-chevron-down"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="collapse" id="booking-{{ $booking->id }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-3">{{ __('dashboard.booking_details') }}</h6>
                            <p><strong>{{ __('dashboard.service_description') }}:</strong> {{ $booking->service_description }}</p>
                            @if($booking->special_requirements)
                                <p><strong>{{ __('dashboard.special_requirements') }}:</strong> {{ $booking->special_requirements }}</p>
                            @endif
                            <p><strong>{{ __('dashboard.preferred_datetime') }}:</strong> {{ $booking->preferred_datetime->format('F j, Y \a\t g:i A') }}</p>
                            @if($booking->rejection_reason)
                                <p><strong>{{ __('dashboard.rejection_reason') }}:</strong> {{ $booking->rejection_reason }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-3">{{ __('dashboard.appointment_details') }}</h6>
                            @if($booking->appointment)
                                <p><strong>{{ __('dashboard.appointment_number') }}:</strong> {{ $booking->appointment->appointment_number }}</p>
                                <p><strong>{{ __('dashboard.scheduled_datetime') }}:</strong> {{ $booking->appointment->scheduled_datetime->format('F j, Y \a\t g:i A') }}</p>
                                <p><strong>{{ __('dashboard.duration') }}:</strong> {{ $booking->appointment->duration_minutes }} {{ __('dashboard.minutes') }}</p>
                                <p><strong>{{ __('dashboard.total_price') }}:</strong> {{ $booking->appointment->total_price }} {{ __('dashboard.currency') }}</p>
                                <p><strong>{{ __('dashboard.payment_status') }}:</strong> 
                                    <span class="badge bg-{{ $booking->appointment->payment_status === 'paid' ? 'success' : ($booking->appointment->payment_status === 'partial' ? 'warning' : 'secondary') }}">
                                        {{ __('dashboard.' . $booking->appointment->payment_status) }}
                                    </span>
                                </p>
                                <p><strong>{{ __('dashboard.appointment_status') }}:</strong> 
                                    <span class="badge bg-{{ $booking->appointment->status === 'completed' ? 'success' : ($booking->appointment->status === 'in_progress' ? 'primary' : ($booking->appointment->status === 'scheduled' ? 'info' : 'secondary')) }}">
                                        {{ __('dashboard.' . $booking->appointment->status) }}
                                    </span>
                                </p>
                            @else
                                <p class="text-muted">{{ __('dashboard.no_appointment_scheduled') }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <div class="d-flex gap-2">
                            <a href="{{ route('dashboard.bookings.show', $booking) }}" class="btn btn-sm btn-info">
                                <i class="fa fa-eye"></i> {{ __('dashboard.view_details') }}
                            </a>
                            <a href="{{ route('dashboard.bookings.edit', $booking) }}" class="btn btn-sm btn-warning">
                                <i class="fa fa-edit"></i> {{ __('dashboard.edit') }}
                            </a>
                            @if($booking->appointment)
                                <a href="{{ route('dashboard.appointments.show', $booking->appointment) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-calendar"></i> {{ __('dashboard.view_appointment') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <i class="fa fa-calendar-times fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">{{ __('dashboard.no_bookings_found') }}</h5>
            <p class="text-muted">{{ __('dashboard.no_bookings_description') }}</p>
            <a href="{{ route('dashboard.bookings.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> {{ __('dashboard.create_first_booking') }}
            </a>
        </div>
    @endforelse

    <!-- Pagination -->
    @if($bookings->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $bookings->links() }}
        </div>
    @endif
</div> 
@props(['salon', 'bookings', 'statistics'])

<div class="booking-summary mb-4">
    <div class="row">
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body text-center">
                    <h4>{{ $statistics['total'] }}</h4>
                    <p class="mb-0 text-white">إجمالي الحجوزات</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-warning text-white shadow-sm">
                <div class="card-body text-center">
                    <h4>{{ $statistics['pending'] }}</h4>
                    <p class="mb-0 text-white">بانتظار التأكيد</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-info text-white shadow-sm">
                <div style="padding-right: 7%; padding-left: 7%;" class="card-body text-center">
                    <h4>{{ $statistics['salon_confirmed'] }}</h4>
                    <p class="mb-0 text-white">تم تأكيدها من الصالون</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-success text-white shadow-sm">
                <div style="padding-right: 7%; padding-left: 7%;" class="card-body text-center">
                    <h4>{{ $statistics['user_confirmed'] }}</h4>
                    <p class="mb-0 text-white">تم تأكيدها من العميل</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-danger text-white shadow-sm">
                <div class="card-body text-center">
                    <h4>{{ $statistics['rejected'] + $statistics['cancelled'] }}</h4>
                    <p class="mb-0 text-white"> ملغية أو مرفوضة </p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-info text-white shadow-sm">
                <div class="card-body text-center">
                    <h4>{{ $statistics['completed'] }}</h4>
                    <p class="mb-0 text-white">{{ __('dashboard.completed_bookings') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bookings-list">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">{{ __('dashboard.salon_bookings') }}</h5>
        {{-- <a href="{{ route('dashboard.bookings.create') }}" class="btn btn-primary btn-sm">
            <i class="fa fa-plus"></i> {{ __('dashboard.create_booking') }}
        </a> --}}
    </div>

    @forelse($bookings as $booking)
        <div class="card mb-3 shadow-sm">
            <div class="card-header">
                <div class="col-md-12 row align-items-center">
                    <div class="col-md-1">
                        <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#booking-{{ $booking->id }}">
                            <i class="fa fa-chevron-down toggle-icon"></i>
                        </button>
                    </div>
                    <div class="col-md-2">
                        <strong>{{ __('dashboard.booking_number') }}:</strong>
                        <p class="text-muted no-wrap-date">{{ $booking->booking_number }}</p>
                    </div>
                    <div class="col-md-2">
                        <strong>{{ __('dashboard.user') }}:</strong>
                        <p class="text-muted">{{ $booking->user->name }}</p>
                    </div>
                    <div class="col-md-2">
                        <strong>{{ __('dashboard.price') }}:</strong>
                        <p class="text-muted">{{ $booking->salon_proposed_price}} - {{$booking->salon_proposed_max_price}}</p>
                    </div>
                    <div class="col-md-2">
                        <strong>{{ __('dashboard.duration') }}:</strong>
                        <p class="text-muted">{{ $booking->salon_proposed_duration }} دقيقة</p>
                    </div>
                    <div class="col-md-2">
                        <strong>{{ __('dashboard.date') }}:</strong> <br>
                        <p class="text-muted"><span class="no-wrap-date">{{ $booking->preferred_datetime->format('Y-m-d') }}</span> {{ $booking->preferred_datetime->format('H:i') }}</ح>
                    </div>
                    <div class="col-md-1">
                        <strong>{{ __('dashboard.status') }}:</strong>
                        <span class="badge {{ $booking->status_badge_class }}">
                            {{ $booking->status_text }}
                        </span>
                    </div>

                    {{-- @if($booking->canBeCompleted())
                        <form action="{{ route('dashboard.bookings.complete', $booking) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary ms-2" onclick="return confirm('{{ __('dashboard.confirm_mark_complete') }}')">
                                <i class="fa fa-check-double"></i> {{ __('dashboard.mark_as_complete') }}
                            </button>
                        </form>
                    @endif --}}
                </div>
            </div>

            <div class="collapse" id="booking-{{ $booking->id }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="mb-3">{{ __('dashboard.booking_details') }}</h6>
                            <p><strong>{{ __('dashboard.service_description') }}:</strong> {{ $booking->service_description }}</p>
                            <p><strong>{{ __('dashboard.preferred_datetime') }}:</strong><br> {{ $booking->preferred_datetime->format('F j, Y \a\t g:i A') }}</p>
                            @if($booking->rejection_reason)
                                <p><strong>{{ __('dashboard.rejection_reason') }}:</strong> {{ $booking->rejection_reason }}</p>
                            @endif
                            @if($booking->services->isNotEmpty())
                                <h6 class="mt-3">{{ __('dashboard.services') }}</h6>
                                <div class="row g-3">
                                    @foreach($booking->services as $service)
                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                            <div class="card service-card shadow-sm">
                                                <div class="card-body">
                                                    <h6 class="card-title">{{ $service->salonSubService->subService->name }}</h6>
                                                    <p class="card-text mb-1"><strong>الفئة:</strong> {{ $service->salonSubService->subService->service->name }}</p>
                                                    <p class="card-text mb-1"><strong>ادنى سعر:</strong> {{ number_format($service->salonSubService->price, 2) }}</p>
                                                    <p class="card-text mb-1"><strong>السعر الأقصى:</strong> {{ number_format($service->salonSubService->max_price, 2) }} ريال</p>
                                                    <p class="card-text"><strong>المدة:</strong> {{ $service->salonSubService->duration ?? '-' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted mt-3">لا توجد خدمات</p>
                            @endif
                        </div>
                        {{-- <div class="col-md-6">
                            <h6 class="mb-3">{{ __('dashboard.appointment_details') }}</h6>
                            @if($booking->appointment)
                                <p><strong>{{ __('dashboard.final_datetime') }}:</strong> {{ $booking->appointment->datetime->format('F j, Y \a\t g:i A') }}</p>
                                <p><strong>{{ __('dashboard.final_price') }}:</strong> {{ number_format($booking->appointment->price, 2) }} {{ __('dashboard.currency') }}</p>
                                <p><strong>{{ __('dashboard.final_duration') }}:</strong> {{ $booking->appointment->duration }} {{ __('dashboard.minutes') }}</p>
                            @else
                                <p class="text-muted">{{ __('dashboard.no_appointment_scheduled') }}</p>
                            @endif
                        </div> --}}
                    </div>

                    <div class="mt-3">
                        <div class="d-flex gap-2">
                            <a href="{{ route('dashboard.bookings.show', $booking) }}" class="btn btn-sm btn-info">
                                <i class="fa fa-eye"></i> {{ __('dashboard.view_details') }}
                            </a>
                            {{-- <a href="{{ route('dashboard.bookings.edit', $booking) }}" class="btn btn-sm btn-warning">
                                <i class="fa fa-edit"></i> {{ __('dashboard.edit') }}
                            </a> --}}
                            @if($booking->appointment)
                                <a href="{{ route('dashboard.appointments.show', $booking->appointment) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-calendar"></i> {{ __('dashboard.view_appointment') }}
                                </a>
                            @endif
                            @if($booking->canBeConfirmedBySalon())
                                <a href="{{ route('dashboard.bookings.salon-confirm-form', $booking) }}" class="btn btn-sm btn-success">
                                    <i class="fa fa-check"></i> {{ __('dashboard.confirm') }}
                                </a>
                            @endif
                            @if($booking->canBeRejected())
                                <a href="{{ route('dashboard.bookings.reject-form', $booking) }}" class="btn btn-sm btn-danger">
                                    <i class="fa fa-times"></i> {{ __('dashboard.reject') }}
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
            {{-- <a href="{{ route('dashboard.bookings.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> {{ __('dashboard.create_first_booking') }}
            </a> --}}
        </div>
    @endforelse

    <!-- Pagination -->
    @if($bookings->hasPages())
        <div class="d-flex justify-content-center mt-4" dir="ltr">
            {{ $bookings->appends(request()->query())->links('pagination::simple-tailwind') }}
        </div>
    @endif
</div>

@push('styles')
<style>
    .card {
        transition: transform 0.2s;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .service-card {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease;
    }

    .service-card:hover {
        transform: translateY(-3px);
    }

    .service-card .card-body {
        padding: 1rem;
    }

    .service-card .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .service-card .card-text {
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .toggle-icon {
        transition: transform 0.3s ease;
    }

    .toggle-icon.active {
        transform: rotate(180deg);
    }

    .no-wrap-date {
        white-space: nowrap;
    }
    .btn-outline-primary {
    color: #87365b;
    border-color: #87365b;
    padding: 8px 10px;
    font-weight: 500;
    border-radius: 8px;
    transition: all 0.3s ease;
    }


    @media (max-width: 576px) {
        .card-body {
            font-size: 0.85rem;
        }

        .btn-sm {
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
        }

        .badge {
            font-size: 0.75rem;
        }

        .service-card .card-title {
            font-size: 1rem;
        }

        .service-card .card-text {
            font-size: 0.8rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.collapse').forEach(collapse => {
            collapse.addEventListener('show.bs.collapse', function () {
                const targetId = this.id;
                const toggleButton = document.querySelector(`[data-bs-target="#${targetId}"]`);
                const icon = toggleButton.querySelector('.toggle-icon');
                icon.classList.add('active');
            });
            collapse.addEventListener('hide.bs.collapse', function () {
                const targetId = this.id;
                const toggleButton = document.querySelector(`[data-bs-target="#${targetId}"]`);
                const icon = toggleButton.querySelector('.toggle-icon');
                icon.classList.remove('active');
            });
        });
    });
</script>
@endpush

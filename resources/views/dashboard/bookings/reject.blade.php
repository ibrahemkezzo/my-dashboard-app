@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.bookings'), 'url' => route('dashboard.bookings.index')],
        ['label' => __('dashboard.reject_booking'), 'url' => route('dashboard.bookings.reject-form', $booking)],
    ]" :pageName="__('dashboard.reject_booking')" />
@endsection

@section('content')
    <x-alert-message />
    <div class="container-fluid">
        <div class="row">
            <!-- Booking Details -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('dashboard.booking_details') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="fw-bold text-muted">{{ __('dashboard.booking_number') }}:</label>
                                <p class="mb-0">{{ $booking->booking_number }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-bold text-muted">{{ __('dashboard.status') }}:</label>
                                <p class="mb-0">
                                    <span class="badge {{ $booking->status_badge_class }}">
                                        {{ $booking->status_text }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-bold text-muted">{{ __('dashboard.preferred_date') }}:</label>
                                <p class="mb-0">{{ $booking->preferred_datetime->format('F j, Y') }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="fw-bold text-muted">{{ __('dashboard.user') }}:</label>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $booking->user->url }}" alt="{{ $booking->user->name }}" class="rounded-circle me-2" style="width: 40px; height: 40px;">
                                    <div>
                                        <p class="mb-0">{{ $booking->user->name }}</p>
                                        <small class="text-muted">{{ $booking->user->email }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold text-muted">{{ __('dashboard.salon') }}:</label>
                                <p class="mb-0">{{ $booking->salon->name }}</p>
                                <small class="text-muted">{{ $booking->salon->address }}, {{ $booking->salon->city->name }}</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="fw-bold text-muted">{{ __('dashboard.service') }}:</label>
                                <p class="mb-0">{{ $booking->salonSubService->subService->name }}</p>
                                <small class="text-muted">{{ $booking->salonSubService->subService->service->name }}</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="fw-bold text-muted">{{ __('dashboard.service_description') }}:</label>
                                <p class="mb-0">{{ $booking->service_description }}</p>
                            </div>
                        </div>



                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="fw-bold text-muted">{{ __('dashboard.created_at') }}:</label>
                                <p class="mb-0">{{ $booking->created_at->format('F j, Y \a\t g:i A') }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold text-muted">{{ __('dashboard.preferred_time') }}:</label>
                                <p class="mb-0">{{ $booking->preferred_datetime->format('g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rejection Form -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('dashboard.reject_booking') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning">
                            <i class="fa fa-exclamation-triangle"></i>
                            <strong>{{ __('dashboard.warning') }}:</strong> {{ __('dashboard.rejecting_booking_warning') }}
                        </div>

                        <form action="{{ route('dashboard.bookings.reject', $booking) }}" method="POST">
                            @csrf
                            
                            <!-- Rejection Reason -->
                            <div class="mb-3">
                                <label for="rejection_reason" class="form-label">{{ __('dashboard.rejection_reason') }} <span class="text-danger">*</span></label>
                                <textarea name="rejection_reason" id="rejection_reason" rows="4" 
                                          class="form-control @error('rejection_reason') is-invalid @enderror" 
                                          placeholder="{{ __('dashboard.please_provide_reason_for_rejection') }}" required>{{ old('rejection_reason') }}</textarea>
                                @error('rejection_reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">{{ __('dashboard.rejection_reason_help') }}</small>
                            </div>

                            <!-- Common Rejection Reasons -->
                            <div class="mb-3">
                                <label class="form-label">{{ __('dashboard.common_reasons') }}:</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-outline-secondary btn-sm mb-1 reason-btn" 
                                                data-reason="{{ __('dashboard.unavailable_time_slot') }}">
                                            {{ __('dashboard.unavailable_time_slot') }}
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-outline-secondary btn-sm mb-1 reason-btn" 
                                                data-reason="{{ __('dashboard.service_not_available') }}">
                                            {{ __('dashboard.service_not_available') }}
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-outline-secondary btn-sm mb-1 reason-btn" 
                                                data-reason="{{ __('dashboard.staff_unavailable') }}">
                                            {{ __('dashboard.staff_unavailable') }}
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-outline-secondary btn-sm mb-1 reason-btn" 
                                                data-reason="{{ __('dashboard.salon_closed') }}">
                                            {{ __('dashboard.salon_closed') }}
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-outline-secondary btn-sm mb-1 reason-btn" 
                                                data-reason="{{ __('dashboard.technical_issues') }}">
                                            {{ __('dashboard.technical_issues') }}
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-outline-secondary btn-sm mb-1 reason-btn" 
                                                data-reason="{{ __('dashboard.other') }}">
                                            {{ __('dashboard.other') }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('dashboard.bookings.show', $booking) }}" class="btn btn-secondary">
                                    <i class="fa fa-times"></i> {{ __('dashboard.cancel') }}
                                </a>
                                <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('dashboard.confirm_reject_booking') }}')">
                                    <i class="fa fa-times"></i> {{ __('dashboard.reject_booking') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rejectionReasonTextarea = document.getElementById('rejection_reason');
            const reasonButtons = document.querySelectorAll('.reason-btn');

            reasonButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    const reason = this.getAttribute('data-reason');
                    rejectionReasonTextarea.value = reason;
                    rejectionReasonTextarea.focus();
                });
            });
        });
    </script>
    @endpush
@endsection 
@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.bookings'), 'url' => route('dashboard.bookings.index')],
        ['label' => __('dashboard.confirm_booking'), 'url' => route('dashboard.bookings.confirm-form', $booking)],
    ]" :pageName="__('dashboard.confirm_booking')" />
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


                    </div>
                </div>
            </div>

            <!-- Confirmation Form -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('dashboard.confirm_booking') }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('dashboard.bookings.confirm', $booking) }}" method="POST">
                            @csrf
                            
                            <!-- Scheduled Date & Time -->
                            <div class="mb-3">
                                <label for="scheduled_datetime" class="form-label">{{ __('dashboard.scheduled_datetime') }} <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="scheduled_datetime" id="scheduled_datetime" 
                                       class="form-control @error('scheduled_datetime') is-invalid @enderror" 
                                       value="{{ old('scheduled_datetime') }}" required>
                                @error('scheduled_datetime')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Duration -->
                            <div class="mb-3">
                                <label for="duration_minutes" class="form-label">{{ __('dashboard.duration_minutes') }} <span class="text-danger">*</span></label>
                                <input type="number" name="duration_minutes" id="duration_minutes" 
                                       class="form-control @error('duration_minutes') is-invalid @enderror" 
                                       value="{{ old('duration_minutes', $booking->salonSubService->duration ?? 60) }}" 
                                       min="15" max="480" required>
                                @error('duration_minutes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Total Price -->
                            <div class="mb-3">
                                <label for="total_price" class="form-label">{{ __('dashboard.total_price') }} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="total_price" id="total_price" 
                                           class="form-control @error('total_price') is-invalid @enderror" 
                                           value="{{ old('total_price', $booking->salonSubService->price ?? 0) }}" 
                                           step="0.01" min="0" required>
                                    <span class="input-group-text">{{ __('dashboard.currency') }}</span>
                                </div>
                                @error('total_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Deposit Amount -->
                            <div class="mb-3">
                                <label for="deposit_amount" class="form-label">{{ __('dashboard.deposit_amount') }}</label>
                                <div class="input-group">
                                    <input type="number" name="deposit_amount" id="deposit_amount" 
                                           class="form-control @error('deposit_amount') is-invalid @enderror" 
                                           value="{{ old('deposit_amount', 0) }}" 
                                           step="0.01" min="0">
                                    <span class="input-group-text">{{ __('dashboard.currency') }}</span>
                                </div>
                                @error('deposit_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div class="mb-3">
                                <label for="notes" class="form-label">{{ __('dashboard.notes') }}</label>
                                <textarea name="notes" id="notes" rows="3" 
                                          class="form-control @error('notes') is-invalid @enderror" 
                                          placeholder="{{ __('dashboard.additional_notes_for_appointment') }}">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('dashboard.bookings.show', $booking) }}" class="btn btn-secondary">
                                    <i class="fa fa-times"></i> {{ __('dashboard.cancel') }}
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-check"></i> {{ __('dashboard.confirm_booking') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Available Time Slots -->
                @if(!empty($availableSlots))
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">{{ __('dashboard.available_time_slots') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($availableSlots as $slot)
                            <div class="col-md-6 mb-2">
                                <button type="button" class="btn btn-outline-primary btn-sm w-100 time-slot-btn" 
                                        data-datetime="{{ $slot['datetime'] }}">
                                    {{ $slot['time'] }}
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scheduledDatetimeInput = document.getElementById('scheduled_datetime');
            const timeSlotButtons = document.querySelectorAll('.time-slot-btn');

            // Set default scheduled datetime to preferred datetime
            const preferredDate = '{{ $booking->preferred_datetime->format("Y-m-d") }}';
            const preferredTime = '{{ $booking->preferred_datetime->format("H:i") }}';
            scheduledDatetimeInput.value = preferredDate + 'T' + preferredTime;

            // Handle time slot button clicks
            timeSlotButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    const datetime = this.getAttribute('data-datetime');
                    scheduledDatetimeInput.value = datetime;
                    
                    // Update button states
                    timeSlotButtons.forEach(btn => btn.classList.remove('btn-primary'));
                    timeSlotButtons.forEach(btn => btn.classList.add('btn-outline-primary'));
                    this.classList.remove('btn-outline-primary');
                    this.classList.add('btn-primary');
                });
            });

            // Auto-calculate deposit amount (20% of total price)
            const totalPriceInput = document.getElementById('total_price');
            const depositAmountInput = document.getElementById('deposit_amount');

            function calculateDeposit() {
                const totalPrice = parseFloat(totalPriceInput.value) || 0;
                const depositAmount = totalPrice * 0.2; // 20% deposit
                depositAmountInput.value = depositAmount.toFixed(2);
            }

            totalPriceInput.addEventListener('input', calculateDeposit);
        });
    </script>
    @endpush
@endsection 
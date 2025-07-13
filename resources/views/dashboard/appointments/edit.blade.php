@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.appointments'), 'url' => route('dashboard.appointments.index')],
        ['label' => __('dashboard.edit_appointment'), 'url' => route('dashboard.appointments.edit', $appointment)],
    ]" :pageName="__('dashboard.edit_appointment')" />
@endsection

@section('content')
    <x-alert-message />
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('dashboard.edit_appointment') }} - {{ $appointment->appointment_number }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('dashboard.appointments.update', $appointment) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <!-- Scheduled Date & Time -->
                        <div class="col-md-6 mb-3">
                            <label for="scheduled_datetime" class="form-label">{{ __('dashboard.scheduled_datetime') }} <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="scheduled_datetime" id="scheduled_datetime" 
                                   class="form-control @error('scheduled_datetime') is-invalid @enderror" 
                                   value="{{ old('scheduled_datetime', $appointment->scheduled_datetime->format('Y-m-d\TH:i')) }}" required>
                            @error('scheduled_datetime')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Duration -->
                        <div class="col-md-6 mb-3">
                            <label for="duration_minutes" class="form-label">{{ __('dashboard.duration_minutes') }} <span class="text-danger">*</span></label>
                            <input type="number" name="duration_minutes" id="duration_minutes" 
                                   class="form-control @error('duration_minutes') is-invalid @enderror" 
                                   value="{{ old('duration_minutes', $appointment->duration_minutes) }}" 
                                   min="15" max="480" required>
                            @error('duration_minutes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Total Price -->
                        <div class="col-md-6 mb-3">
                            <label for="total_price" class="form-label">{{ __('dashboard.total_price') }} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="total_price" id="total_price" 
                                       class="form-control @error('total_price') is-invalid @enderror" 
                                       value="{{ old('total_price', $appointment->total_price) }}" 
                                       step="0.01" min="0" required>
                                <span class="input-group-text">{{ __('dashboard.currency') }}</span>
                            </div>
                            @error('total_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deposit Amount -->
                        <div class="col-md-6 mb-3">
                            <label for="deposit_amount" class="form-label">{{ __('dashboard.deposit_amount') }}</label>
                            <div class="input-group">
                                <input type="number" name="deposit_amount" id="deposit_amount" 
                                       class="form-control @error('deposit_amount') is-invalid @enderror" 
                                       value="{{ old('deposit_amount', $appointment->deposit_amount) }}" 
                                       step="0.01" min="0">
                                <span class="input-group-text">{{ __('dashboard.currency') }}</span>
                            </div>
                            @error('deposit_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deposit Paid -->
                        <div class="col-md-6 mb-3">
                            <label for="deposit_paid" class="form-label">{{ __('dashboard.deposit_paid') }}</label>
                            <div class="input-group">
                                <input type="number" name="deposit_paid" id="deposit_paid" 
                                       class="form-control @error('deposit_paid') is-invalid @enderror" 
                                       value="{{ old('deposit_paid', $appointment->deposit_paid) }}" 
                                       step="0.01" min="0">
                                <span class="input-group-text">{{ __('dashboard.currency') }}</span>
                            </div>
                            @error('deposit_paid')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Payment Status -->
                        <div class="col-md-6 mb-3">
                            <label for="payment_status" class="form-label">{{ __('dashboard.payment_status') }}</label>
                            <select name="payment_status" id="payment_status" class="form-control @error('payment_status') is-invalid @enderror">
                                <option value="pending" {{ old('payment_status', $appointment->payment_status) == 'pending' ? 'selected' : '' }}>{{ __('dashboard.payment_pending') }}</option>
                                <option value="partial" {{ old('payment_status', $appointment->payment_status) == 'partial' ? 'selected' : '' }}>{{ __('dashboard.partial_payment') }}</option>
                                <option value="paid" {{ old('payment_status', $appointment->payment_status) == 'paid' ? 'selected' : '' }}>{{ __('dashboard.payment_completed') }}</option>
                                <option value="refunded" {{ old('payment_status', $appointment->payment_status) == 'refunded' ? 'selected' : '' }}>{{ __('dashboard.payment_refunded') }}</option>
                            </select>
                            @error('payment_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">{{ __('dashboard.status') }}</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="scheduled" {{ old('status', $appointment->status) == 'scheduled' ? 'selected' : '' }}>{{ __('dashboard.scheduled') }}</option>
                                <option value="in_progress" {{ old('status', $appointment->status) == 'in_progress' ? 'selected' : '' }}>{{ __('dashboard.in_progress') }}</option>
                                <option value="completed" {{ old('status', $appointment->status) == 'completed' ? 'selected' : '' }}>{{ __('dashboard.completed') }}</option>
                                <option value="cancelled" {{ old('status', $appointment->status) == 'cancelled' ? 'selected' : '' }}>{{ __('dashboard.cancelled') }}</option>
                                <option value="no_show" {{ old('status', $appointment->status) == 'no_show' ? 'selected' : '' }}>{{ __('dashboard.no_show') }}</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="col-md-12 mb-3">
                            <label for="notes" class="form-label">{{ __('dashboard.notes') }}</label>
                            <textarea name="notes" id="notes" rows="3" 
                                      class="form-control @error('notes') is-invalid @enderror" 
                                      placeholder="{{ __('dashboard.additional_notes_for_appointment') }}">{{ old('notes', $appointment->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Cancellation Reason (if status is cancelled) -->
                        <div class="col-md-12 mb-3" id="cancellation_reason_div" style="display: none;">
                            <label for="cancellation_reason" class="form-label">{{ __('dashboard.cancellation_reason') }}</label>
                            <textarea name="cancellation_reason" id="cancellation_reason" rows="3" 
                                      class="form-control @error('cancellation_reason') is-invalid @enderror" 
                                      placeholder="{{ __('dashboard.reason_for_cancellation') }}">{{ old('cancellation_reason', $appointment->cancellation_reason) }}</textarea>
                            @error('cancellation_reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('dashboard.appointments.show', $appointment) }}" class="btn btn-secondary">
                            <i class="fa fa-times"></i> {{ __('dashboard.cancel') }}
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> {{ __('dashboard.update_appointment') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Appointment Information Card -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">{{ __('dashboard.appointment_information') }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label class="fw-bold text-muted">{{ __('dashboard.appointment_number') }}:</label>
                        <p class="mb-0">{{ $appointment->appointment_number }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold text-muted">{{ __('dashboard.user') }}:</label>
                        <p class="mb-0">{{ $appointment->booking->user->name }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold text-muted">{{ __('dashboard.salon') }}:</label>
                        <p class="mb-0">{{ $appointment->booking->salon->name }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold text-muted">{{ __('dashboard.service') }}:</label>
                        <p class="mb-0">{{ $appointment->booking->salonSubService->subService->name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('status');
            const cancellationReasonDiv = document.getElementById('cancellation_reason_div');
            const totalPriceInput = document.getElementById('total_price');
            const depositAmountInput = document.getElementById('deposit_amount');

            function toggleCancellationReason() {
                if (statusSelect.value === 'cancelled') {
                    cancellationReasonDiv.style.display = 'block';
                } else {
                    cancellationReasonDiv.style.display = 'none';
                }
            }

            function calculateDeposit() {
                const totalPrice = parseFloat(totalPriceInput.value) || 0;
                const currentDepositPaid = parseFloat(document.getElementById('deposit_paid').value) || 0;
                
                // Auto-calculate deposit amount (20% of total price) if not manually set
                if (depositAmountInput.value === '0' || depositAmountInput.value === '') {
                    const depositAmount = totalPrice * 0.2; // 20% deposit
                    depositAmountInput.value = depositAmount.toFixed(2);
                }
            }

            statusSelect.addEventListener('change', toggleCancellationReason);
            totalPriceInput.addEventListener('input', calculateDeposit);

            // Initialize
            toggleCancellationReason();
        });
    </script>
    @endpush
@endsection 
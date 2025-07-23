@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.bookings'), 'url' => route('dashboard.bookings.index')],
        ['label' => __('dashboard.salon_confirmation'), 'url' => route('dashboard.bookings.salon-confirm-form', $booking)],
    ]" :pageName="__('dashboard.salon_confirmation')" />
@endsection

@section('content')
    <x-alert-message />
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('dashboard.salon_confirmation') }} - {{ $booking->booking_number }}</h4>
                    </div>
                    <div class="card-body">
                        <!-- Booking Details -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5>{{ __('dashboard.original_request') }}</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <p><strong>{{ __('dashboard.user') }}:</strong> {{ $booking->user->name }}</p>
                                        <p><strong>{{ __('dashboard.service') }}:</strong> {{ $booking->salonSubService->subService->name }}</p>
                                        <p><strong>{{ __('dashboard.preferred_datetime') }}:</strong> {{ $booking->preferred_datetime->format('F j, Y \a\t g:i A') }}</p>
                                        <p><strong>{{ __('dashboard.service_description') }}:</strong> {{ $booking->service_description }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5>{{ __('dashboard.service_details') }}</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <p><strong>{{ __('dashboard.price') }}:</strong> {{ $booking->salonSubService->price }} {{ __('dashboard.currency') }}</p>
                                        <p><strong>{{ __('dashboard.duration') }}:</strong> {{ $booking->salonSubService->duration }} {{ __('dashboard.minutes') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Salon Response Form -->
                        <form action="{{ route('dashboard.bookings.salon-confirm', $booking) }}" method="POST">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">{{ __('dashboard.action') }} <span class="text-danger">*</span></label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="action" id="action_confirm" value="confirm" checked>
                                        <label class="form-check-label" for="action_confirm">
                                            {{ __('dashboard.confirm_as_requested') }}
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="action" id="action_modify" value="modify">
                                        <label class="form-check-label" for="action_modify">
                                            {{ __('dashboard.modify_and_confirm') }}
                                        </label>
                                    </div>
                                </div>

                                <!-- Modification Fields (hidden by default) -->
                                <div id="modification_fields" style="display: none;">
                                    <div class="col-md-6 mb-3">
                                        <label for="salon_proposed_datetime" class="form-label">{{ __('dashboard.salon_proposed_datetime') }}</label>
                                        <input type="datetime-local" name="salon_proposed_datetime" id="salon_proposed_datetime"
                                               class="form-control @error('salon_proposed_datetime') is-invalid @enderror"
                                               value="{{ old('salon_proposed_datetime') }}">
                                        @error('salon_proposed_datetime')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="salon_proposed_price" class="form-label">{{ __('dashboard.salon_proposed_price') }}</label>
                                        <input type="number" step="0.01" name="salon_proposed_price" id="salon_proposed_price"
                                               class="form-control @error('salon_proposed_price') is-invalid @enderror"
                                               value="{{ old('salon_proposed_price') }}">
                                        @error('salon_proposed_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="salon_proposed_duration" class="form-label">{{ __('dashboard.salon_proposed_duration') }}</label>
                                        <input type="number" name="salon_proposed_duration" id="salon_proposed_duration"
                                               class="form-control @error('salon_proposed_duration') is-invalid @enderror"
                                               value="{{ old('salon_proposed_duration') }}">
                                        @error('salon_proposed_duration')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="salon_modification_reason" class="form-label">{{ __('dashboard.salon_modification_reason') }}</label>
                                        <textarea name="salon_modification_reason" id="salon_modification_reason" rows="3"
                                                  class="form-control @error('salon_modification_reason') is-invalid @enderror"
                                                  placeholder="{{ __('dashboard.reason_for_modification') }}">{{ old('salon_modification_reason') }}</textarea>
                                        @error('salon_modification_reason')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="salon_notes" class="form-label">{{ __('dashboard.salon_notes') }}</label>
                                    <textarea name="salon_notes" id="salon_notes" rows="3"
                                              class="form-control @error('salon_notes') is-invalid @enderror"
                                              placeholder="{{ __('dashboard.additional_notes_for_user') }}">{{ old('salon_notes') }}</textarea>
                                    @error('salon_notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('dashboard.bookings.show', $booking) }}" class="btn btn-secondary">
                                    <i class="fa fa-times"></i> {{ __('dashboard.cancel') }}
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-check"></i> {{ __('dashboard.confirm') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const actionRadios = document.querySelectorAll('input[name="action"]');
        const modificationFields = document.getElementById('modification_fields');
        const modificationReasonField = document.getElementById('salon_modification_reason');

        function toggleModificationFields() {
            const selectedAction = document.querySelector('input[name="action"]:checked').value;
            
            if (selectedAction === 'modify') {
                modificationFields.style.display = 'block';
                modificationReasonField.setAttribute('required', 'required');
            } else {
                modificationFields.style.display = 'none';
                modificationReasonField.removeAttribute('required');
            }
        }

        actionRadios.forEach(radio => {
            radio.addEventListener('change', toggleModificationFields);
        });

        // Initialize
        toggleModificationFields();
    });
</script>
@endpush 
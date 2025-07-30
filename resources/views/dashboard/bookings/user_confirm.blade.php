@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.bookings'), 'url' => route('dashboard.bookings.index')],
        ['label' => __('dashboard.user_confirmation'), 'url' => route('dashboard.bookings.user-confirm-form', $booking)],
    ]" :pageName="__('dashboard.user_confirmation')" />
@endsection

@section('content')
    <x-alert-message />
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('dashboard.user_confirmation') }} - {{ $booking->booking_number }}</h4>
                    </div>
                    <div class="card-body">
                        <!-- Original Request -->
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

                        <!-- Salon Response -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5>{{ __('dashboard.salon_proposal') }}</h5>
                                <div class="card">
                                    <div class="card-body">
                                        @if($booking->isModifiedBySalon())
                                            <div class="alert alert-info">
                                                <i class="fa fa-info-circle"></i> {{ __('dashboard.booking_modified_by_salon') }}
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p><strong>{{ __('dashboard.salon_proposed_datetime') }}:</strong><br>
                                                    {{ $booking->salon_proposed_datetime->format('F j, Y \a\t g:i A') }}</p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p><strong>{{ __('dashboard.salon_proposed_price') }}:</strong><br>
                                                    {{ $booking->salon_proposed_price }} {{ __('dashboard.currency') }}</p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p><strong>{{ __('dashboard.salon_proposed_duration') }}:</strong><br>
                                                    {{ $booking->salon_proposed_duration }} {{ __('dashboard.minutes') }}</p>
                                                </div>
                                            </div>
                                            
                                            @if($booking->salon_modification_reason)
                                                <div class="mt-3">
                                                    <p><strong>{{ __('dashboard.salon_modification_reason') }}:</strong><br>
                                                    {{ $booking->salon_modification_reason }}</p>
                                                </div>
                                            @endif
                                        @else
                                            <div class="alert alert-success">
                                                <i class="fa fa-check-circle"></i> {{ __('dashboard.salon_confirmed_as_requested') }}
                                            </div>
                                        @endif
                                        
                                        @if($booking->salon_notes)
                                            <div class="mt-3">
                                                <p><strong>{{ __('dashboard.salon_notes') }}:</strong><br>
                                                {{ $booking->salon_notes }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Final Details -->
                        <div class="row mb-4">
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

                        <!-- User Response Form -->
                        <form action="{{ route('dashboard.bookings.user-confirm', $booking) }}" method="POST">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">{{ __('dashboard.action') }} <span class="text-danger">*</span></label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="action" id="action_confirm" value="confirm" checked>
                                        <label class="form-check-label" for="action_confirm">
                                            {{ __('dashboard.confirm_salon_response') }}
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="action" id="action_reject" value="reject">
                                        <label class="form-check-label" for="action_reject">
                                            {{ __('dashboard.reject_salon_response') }}
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3" id="user_notes_div" style="display: none;">
                                    <label for="user_notes" class="form-label">{{ __('dashboard.user_notes') }}</label>
                                    <textarea name="user_notes" id="user_notes" rows="3"
                                              class="form-control @error('user_notes') is-invalid @enderror"
                                              placeholder="{{ __('dashboard.reason_for_rejection') }}">{{ old('user_notes') }}</textarea>
                                    @error('user_notes')
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
        const userNotesDiv = document.getElementById('user_notes_div');
        const userNotesField = document.getElementById('user_notes');

        function toggleUserNotes() {
            const selectedAction = document.querySelector('input[name="action"]:checked').value;
            
            if (selectedAction === 'reject') {
                userNotesDiv.style.display = 'block';
                userNotesField.setAttribute('required', 'required');
            } else {
                userNotesDiv.style.display = 'none';
                userNotesField.removeAttribute('required');
            }
        }

        actionRadios.forEach(radio => {
            radio.addEventListener('change', toggleUserNotes);
        });

        // Initialize
        toggleUserNotes();
    });
</script>
@endpush 
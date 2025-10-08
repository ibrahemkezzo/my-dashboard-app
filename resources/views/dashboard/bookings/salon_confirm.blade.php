@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.bookings'), 'url' => route('dashboard.bookings.index')],
        [
            'label' => __('dashboard.salon_confirmation'),
            'url' => route('dashboard.bookings.salon-confirm-form', $booking),
        ],
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
                                        <p><strong>{{ __('dashboard.preferred_datetime') }}:</strong>
                                            {{ $booking->preferred_datetime->format('F j, Y \a\t g:i A') }}</p>
                                        <p><strong>{{ __('dashboard.service_description') }}:</strong>
                                            {{ $booking->service_description }}</p>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5>{{ __('dashboard.service_details') }}</h5>
                                <div class="card">
                                    <div class="card-body">
                                        @if ($booking->services->isNotEmpty())
                                            <p><strong>{{ __('dashboard.low_price') }}:</strong>
                                                {{ number_format($booking->salon_proposed_price, 2) }}
                                                {{ __('dashboard.currency') }}</p>
                                            <p><strong>{{ __('dashboard.max_price') }}:</strong>
                                                {{ number_format($booking->salon_proposed_max_price, 2) }}
                                                {{ __('dashboard.currency') }}</p>
                                            <p><strong>{{ __('dashboard.duration') }}:</strong>
                                                {{ $booking->salon_proposed_duration }}
                                                {{ __('dashboard.minutes') }}</p>
                                        @else
                                            <p class="text-muted">{{ __('dashboard.no_service_details') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                @if ($booking->services->isNotEmpty())
                                    <h6 class="mt-3">{{ __('dashboard.services') }}</h6>
                                    <div class="row g-3">
                                        @foreach ($booking->services as $service)
                                            <div class="col-4">
                                                <div class="card service-card">
                                                    <div class="card-body">
                                                        <h6 class="card-title">
                                                            {{ $service->salonSubService->subService->name }}</h6>
                                                        <p class="card-text mb-1">
                                                            <strong>{{ __('dashboard.category') }}:</strong>
                                                            {{ $service->salonSubService->subService->service->name }}
                                                        </p>
                                                        {{-- <p class="card-text mb-1">
                                                            <strong>{{ __('dashboard.quantity') }}:</strong>
                                                            {{ $service->quantity }}</p> --}}
                                                        <p class="card-text mb-1">
                                                            <strong>{{ __('dashboard.price') }}:</strong>
                                                            {{ number_format($service->salonSubService->price, 2) }}
                                                        </p>
                                                        <p class="card-text mb-1">
                                                            <strong>{{ __('dashboard.max_price') }}:</strong>
                                                            {{ number_format($service->salonSubService->max_price, 2) }}ريال
                                                        </p>
                                                        <p class="card-text">
                                                            <strong>{{ __('dashboard.duration') }}:</strong>
                                                            {{ $service->salonSubService->duration ?? '-' }}

                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted mt-3">{{ __('dashboard.no_services') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Salon Response Form -->
                        <form action="{{ route('dashboard.bookings.salon-confirm', $booking) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mb-3 row">
                                    <label class="form-label">{{ __('dashboard.action') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="action" id="action_confirm"
                                            value="confirm" checked>
                                        <label class="form-check-label" for="action_confirm">
                                            {{ __('dashboard.confirm_as_requested') }}
                                        </label>
                                    </div>
                                    {{-- <div class="form-check">
                                        <input class="form-check-input" type="radio" name="action" id="action_modify"
                                            value="modify">
                                        <label class="form-check-label" for="action_modify">
                                            {{ __('dashboard.modify_and_confirm') }}
                                        </label>
                                    </div> --}}
                                </div>

                                <!-- Modification Fields (hidden by default) -->
                                <div id="modification_fields" style="display: none;" class="col-md-12 row">
                                    <div class="col-md-6 mb-3">
                                        <label for="salon_proposed_datetime"
                                            class="form-label">{{ __('dashboard.salon_proposed_datetime') }}</label>
                                        <input type="datetime-local" name="salon_proposed_datetime"
                                            id="salon_proposed_datetime"
                                            class="form-control @error('salon_proposed_datetime') is-invalid @enderror"
                                            value="{{ old('salon_proposed_datetime') }}">
                                        @error('salon_proposed_datetime')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="salon_proposed_price"
                                            class="form-label">{{ __('dashboard.salon_proposed_price') }}</label>
                                        <input type="number" step="0.01" name="salon_proposed_price"
                                            id="salon_proposed_price"
                                            class="form-control @error('salon_proposed_price') is-invalid @enderror"
                                            value="{{ old('salon_proposed_price') }}">
                                        @error('salon_proposed_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="salon_proposed_max_price"
                                            class="form-label">{{ __('dashboard.salon_proposed_max_price') }}</label>
                                        <input type="number" step="0.01" name="salon_proposed_max_price"
                                            id="salon_proposed_max_price"
                                            class="form-control @error('salon_proposed_max_price') is-invalid @enderror"
                                            value="{{ old('salon_proposed_max_price') }}">
                                        @error('salon_proposed_max_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- <div class="col-md-3 mb-3">
                                        <label for="salon_proposed_duration"
                                            class="form-label">{{ __('dashboard.salon_proposed_duration') }}</label>
                                        <input type="number" name="salon_proposed_duration" id="salon_proposed_duration"
                                            class="form-control @error('salon_proposed_duration') is-invalid @enderror"
                                            value="{{ old('salon_proposed_duration') }}">
                                        @error('salon_proposed_duration')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div> --}}
                                    <div class="col-md-12 mb-3">
                                        <label for="salon_modification_reason"
                                            class="form-label">{{ __('dashboard.salon_modification_reason') }}</label>
                                        <textarea name="salon_modification_reason" id="salon_modification_reason" rows="3"
                                            class="form-control @error('salon_modification_reason') is-invalid @enderror"
                                            placeholder="{{ __('dashboard.reason_for_modification') }}">{{ old('salon_modification_reason') }}</textarea>
                                        @error('salon_modification_reason')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="col-md-12 mb-3">
                                    <label for="salon_notes" class="form-label">{{ __('dashboard.salon_notes') }}</label>
                                    <textarea name="salon_notes" id="salon_notes" rows="3"
                                        class="form-control @error('salon_notes') is-invalid @enderror"
                                        placeholder="{{ __('dashboard.additional_notes_for_user') }}">{{ old('salon_notes') }}</textarea>
                                    @error('salon_notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> --}}
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

        @media (max-width: 576px) {
            .service-card .card-title {
                font-size: 1rem;
            }

            .service-card .card-text {
                font-size: 0.8rem;
            }

            .card-body p {
                font-size: 0.85rem;
            }

            .btn {
                font-size: 0.8rem;
                padding: 0.25rem 0.5rem;
            }
        }
    </style>
@endpush

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

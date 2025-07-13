@props([
    'users' => [],
    'salons' => [],
    'salonSubServices' => [],
    'booking' => null,
    'action' => '',
    'method' => 'POST',
    'submitButtonText' => __('dashboard.create_booking')
])

<form action="{{ $action }}" method="POST">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <div class="row">
        <!-- User Selection -->
        <div class="col-md-6 mb-3">
            <label for="user_id" class="form-label">{{ __('dashboard.user') }} <span class="text-danger">*</span></label>
            <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                <option value="">{{ __('dashboard.select_user') }}</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" 
                        {{ old('user_id', $booking?->user_id) == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Salon Selection -->
        <div class="col-md-6 mb-3">
            <label for="salon_id" class="form-label">{{ __('dashboard.salon') }} <span class="text-danger">*</span></label>
            <select name="salon_id" id="salon_id" class="form-control @error('salon_id') is-invalid @enderror" required>
                <option value="">{{ __('dashboard.select_salon') }}</option>
                @foreach($salons as $salon)
                    <option value="{{ $salon->id }}" 
                        {{ old('salon_id', $booking?->salon_id) == $salon->id ? 'selected' : '' }}>
                        {{ $salon->name }} - {{ $salon->city->name }}
                    </option>
                @endforeach
            </select>
            @error('salon_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Service Selection -->
        <div class="col-md-6 mb-3">
            <label for="salon_sub_service_id" class="form-label">{{ __('dashboard.service') }} <span class="text-danger">*</span></label>
            <select name="salon_sub_service_id" id="salon_sub_service_id" class="form-control @error('salon_sub_service_id') is-invalid @enderror" required>
                <option value="">{{ __('dashboard.select_service') }}</option>
            </select>
            @error('salon_sub_service_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Preferred Date & Time -->
        <div class="col-md-6 mb-3">
            <label for="preferred_datetime" class="form-label">{{ __('dashboard.preferred_datetime') }} <span class="text-danger">*</span></label>
            <input type="datetime-local" name="preferred_datetime" id="preferred_datetime"
                   class="form-control @error('preferred_datetime') is-invalid @enderror"
                   value="{{ old('preferred_datetime', $booking?->preferred_datetime?->format('Y-m-d\TH:i')) }}" required>
            @error('preferred_datetime')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Service Description -->
        <div class="col-md-12 mb-3">
            <label for="service_description" class="form-label">{{ __('dashboard.service_description') }} <span class="text-danger">*</span></label>
            <textarea name="service_description" id="service_description" rows="3"
                      class="form-control @error('service_description') is-invalid @enderror"
                      placeholder="{{ __('dashboard.describe_service_details') }}" required>{{ old('service_description', $booking?->service_description) }}</textarea>
            @error('service_description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Special Requirements -->
        <div class="col-md-12 mb-3">
            <label for="special_requirements" class="form-label">{{ __('dashboard.special_requirements') }}</label>
            <textarea name="special_requirements" id="special_requirements" rows="3"
                      class="form-control @error('special_requirements') is-invalid @enderror"
                      placeholder="{{ __('dashboard.any_special_requirements') }}">{{ old('special_requirements', $booking?->special_requirements) }}</textarea>
            @error('special_requirements')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Status -->
        <div class="col-md-6 mb-3">
            <label for="status" class="form-label">{{ __('dashboard.status') }}</label>
            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                <option value="pending" {{ old('status', $booking?->status ?? 'pending') == 'pending' ? 'selected' : '' }}>
                    {{ __('dashboard.pending') }}
                </option>
                <option value="confirmed" {{ old('status', $booking?->status) == 'confirmed' ? 'selected' : '' }}>
                    {{ __('dashboard.confirmed') }}
                </option>
                <option value="rejected" {{ old('status', $booking?->status) == 'rejected' ? 'selected' : '' }}>
                    {{ __('dashboard.rejected') }}
                </option>
                <option value="cancelled" {{ old('status', $booking?->status) == 'cancelled' ? 'selected' : '' }}>
                    {{ __('dashboard.cancelled') }}
                </option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Rejection Reason (if status is rejected) -->
        <div class="col-md-6 mb-3" id="rejection_reason_div" style="display: none;">
            <label for="rejection_reason" class="form-label">{{ __('dashboard.rejection_reason') }}</label>
            <textarea name="rejection_reason" id="rejection_reason" rows="3"
                      class="form-control @error('rejection_reason') is-invalid @enderror"
                      placeholder="{{ __('dashboard.reason_for_rejection') }}">{{ old('rejection_reason', $booking?->rejection_reason) }}</textarea>
            @error('rejection_reason')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        @if($booking)
            <a href="{{ route('dashboard.bookings.show', $booking) }}" class="btn btn-secondary">
                <i class="fa fa-times"></i> {{ __('dashboard.cancel') }}
            </a>
        @else
            <a href="{{ route('dashboard.bookings.index') }}" class="btn btn-secondary">
                <i class="fa fa-times"></i> {{ __('dashboard.cancel') }}
            </a>
        @endif
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"></i> {{ $submitButtonText }}
        </button>
    </div>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const salonSelect = document.getElementById('salon_id');
        const serviceSelect = document.getElementById('salon_sub_service_id');
        const statusSelect = document.getElementById('status');
        const rejectionReasonDiv = document.getElementById('rejection_reason_div');
        const salonSubServices = @json($salonSubServices);
        const currentServiceId = {{ $booking?->salon_sub_service_id ?? 'null' }};

        function updateServices() {
            const salonId = salonSelect.value;
            serviceSelect.innerHTML = '<option value="">{{ __('dashboard.select_service') }}</option>';

            if (salonId && salonSubServices[salonId]) {
                salonSubServices[salonId].forEach(function(service) {
                    const option = document.createElement('option');
                    option.value = service.id;
                    option.textContent = `${service.sub_service.name} (${service.sub_service.service.name}) - ${service.price} {{ __('dashboard.currency') }}`;
                    if (service.id == currentServiceId) {
                        option.selected = true;
                    }
                    serviceSelect.appendChild(option);
                });
            }
        }

        function toggleRejectionReason() {
            if (statusSelect.value === 'rejected') {
                rejectionReasonDiv.style.display = 'block';
            } else {
                rejectionReasonDiv.style.display = 'none';
            }
        }

        salonSelect.addEventListener('change', updateServices);
        statusSelect.addEventListener('change', toggleRejectionReason);

        // Initialize
        updateServices();
        toggleRejectionReason();
    });
</script>
@endpush 
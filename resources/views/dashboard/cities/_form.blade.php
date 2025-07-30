
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="name" class="form-label">{{ __('dashboard.name') }}</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $city->name ?? '') }}" required>
            <div class="invalid-feedback">{{ __('validation.required', ['attribute' => __('dashboard.name')]) }}</div>
        </div>
        <div class="col-md-6">
            <label for="country" class="form-label">{{ __('dashboard.country') }}</label>
            <input type="text" class="form-control" id="country" name="country" value="{{ old('country', $city->country ?? '') }}">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="latitude" class="form-label">{{ __('dashboard.latitude') }}</label>
            <input type="number" {{--step="0.00000001"--}}  class="form-control" id="latitude" name="latitude" value="{{ old('latitude', $city->latitude ?? '') }}" required>
            <div class="invalid-feedback">{{ __('validation.required', ['attribute' => __('dashboard.latitude')]) }}</div>
        </div>
        <div class="col-md-4">
            <label for="longitude" class="form-label">{{ __('dashboard.longitude') }}</label>
            <input type="number" {{--step="0.00000001"--}} class="form-control" id="longitude" name="longitude" value="{{ old('longitude', $city->longitude ?? '') }}" required>
            <div class="invalid-feedback">{{ __('validation.required', ['attribute' => __('dashboard.longitude')]) }}</div>
        </div>
        <div class="col-md-4">
            <label for="timezone" class="form-label">{{ __('dashboard.timezone') }}</label>
            <input type="text" class="form-control" id="timezone" name="timezone" value="{{ old('timezone', $city->timezone ?? '') }}">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="google_place_id" class="form-label">{{ __('dashboard.google_place_id') }}</label>
            <input type="text" class="form-control" id="google_place_id" name="google_place_id" value="{{ old('google_place_id', $city->google_place_id ?? '') }}" disabled placeholder="{{ __('dashboard.google_maps_integration_coming_soon') }}">
            {{-- <small class="form-text text-muted">{{ __('dashboard.google_maps_integration_coming_soon') }}</small> --}}
        </div>
        {{-- <div class="col-md-6 d-flex align-items-center">
            <div class="form-check form-switch mt-4">
                <input class="form-check-input" type="checkbox" id="is_active" name="is_active_checkbox" {{ old('is_active', $city->is_active ?? true) ? 'checked' : '' }}>
                <input type="hidden" name="is_active" id="is_active_hidden" value="{{ old('is_active', $city->is_active ?? true) ? 'true' : 'false' }}">
                <label class="form-check-label" for="is_active">{{ __('dashboard.active') }}</label>
            </div>
        </div> --}}

    </div>
    <button type="submit" class="btn btn-primary">{{ $submitText }}</button>
    <a href="{{ route('dashboard.cities.index') }}" class="btn btn-outline-primary">{{ __('dashboard.cancel') }}</a>

    {{-- @push('script')
        <script>
            document.getElementById('is_active').addEventListener('change', function() {
                document.getElementById('is_active_hidden').value = this.checked ? 'true' : 'false';
            });
        </script>
    @endpush --}}

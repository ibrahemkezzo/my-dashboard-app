<div class="row mb-3">
    <div class="col-md-4">
        <label for="name" class="form-label">{{ __('dashboard.name') }}</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $subscriptionPlan->name ?? '') }}" required>
    </div>
    <div class="col-md-4">
        <label for="price" class="form-label">{{ __('dashboard.price') }}</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price', $subscriptionPlan->price ?? '') }}" required>
    </div>
    <div class="col-md-4">
        <label for="duration_days" class="form-label">{{ __('dashboard.duration_days') }}</label>
        <input type="number" class="form-control" id="duration_days" name="duration_days" value="{{ old('duration_days', $subscriptionPlan->duration_days ?? '') }}" required>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="is_active" class="form-label">{{ __('dashboard.status') }}</label>
        <select name="is_active" id="is_active" class="form-control">
            <option value="1" {{ old('is_active', $subscriptionPlan->is_active ?? 1) == 1 ? 'selected' : '' }}>{{ __('dashboard.active') }}</option>
            <option value="0" {{ old('is_active', $subscriptionPlan->is_active ?? 1) == 0 ? 'selected' : '' }}>{{ __('dashboard.inactive') }}</option>
        </select>
    </div>
</div>
<button type="submit" class="btn btn-primary">{{ $submitText }}</button>
<a href="{{ route('dashboard.subscription-plans.index') }}" class="btn btn-outline-primary">{{ __('dashboard.cancel') }}</a>

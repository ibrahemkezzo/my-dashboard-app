<div class="row mb-3">
    <div class="col-md-4">
        <label for="service_id" class="form-label">{{ __('dashboard.service') }}</label>
        <select name="service_id" id="service_id" class="form-control" required>
            <option value="">{{ __('dashboard.choose_service') }}</option>
            @foreach($services as $service)
                <option value="{{ $service->id }}" {{ old('service_id', $subService->service_id ?? '') == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label for="name" class="form-label">{{ __('dashboard.name') }}</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $subService->name ?? '') }}" required>
    </div>
    <div class="col-md-4">
        <label for="status" class="form-label">{{ __('dashboard.status') }}</label>
        <select name="status" id="status" class="form-control">
            <option value="1" {{ old('status', $subService->status ?? 1) == 1 ? 'selected' : '' }}>{{ __('dashboard.active') }}</option>
            <option value="0" {{ old('status', $subService->status ?? 1) == 0 ? 'selected' : '' }}>{{ __('dashboard.inactive') }}</option>
        </select>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <label for="description" class="form-label">{{ __('dashboard.description') }}</label>
        <textarea class="form-control" id="description" name="description">{{ old('description', $subService->description ?? '') }}</textarea>
    </div>
</div>
<div class="row mb-3">
    {{-- <div class="col-md-4">
        <label for="order" class="form-label">{{ __('dashboard.order') }}</label>
        <input type="number" class="form-control" id="order" name="order" value="{{ old('order', $subService->order ?? 0) }}" min="0">
    </div> --}}

    {{-- <div class="col-md-4">
        <label for="icon_or_image" class="form-label">{{ __('dashboard.icon_or_image') }}</label>
        <input type="file" class="form-control" id="icon_or_image" name="icon_or_image" accept="image/*">
        @if(!empty($subService) && $subService->icon_or_image)
            <img src="{{ asset('storage/'.$subService->icon_or_image) }}" alt="icon" style="width:40px;height:40px;object-fit:cover;" class="mt-2">
        @endif
    </div> --}}
</div>
{{-- <div class="row mb-3">
    <div class="col-md-12">
        <label for="seo_meta_title" class="form-label">{{ __('dashboard.seo_meta') }}</label>
        <input type="text" class="form-control mb-2" id="seo_meta_title" name="seo_meta[title]" value="{{ old('seo_meta.title', $subService->seo_meta['title'] ?? '') }}" placeholder="{{ __('dashboard.seo_title') }}">
        <textarea class="form-control" id="seo_meta_description" name="seo_meta[description]" placeholder="{{ __('dashboard.seo_description') }}">{{ old('seo_meta.description', $subService->seo_meta['description'] ?? '') }}</textarea>
    </div>
</div> --}}
<button type="submit" class="btn btn-primary">{{ $submitText }}</button>
<a href="{{ route('dashboard.sub_services.index') }}" class="btn btn-outline-primary">{{ __('dashboard.cancel') }}</a>

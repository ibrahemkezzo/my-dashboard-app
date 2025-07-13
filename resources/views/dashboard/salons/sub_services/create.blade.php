@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.salons'), 'url' => route('dashboard.salons.index')],
        ['label' => $salon->name, 'url' => route('dashboard.salons.show', $salon)],
        ['label' => __('dashboard.add_service'), 'url' => route('dashboard.salons.sub-services.create', $salon)],
    ]" :pageName="__('dashboard.add_service')" />
@endsection

@section('content')
    <x-alert-message />
    <div class="card">
        <div class="card-header">
            <h3>{{ __('dashboard.add_service') }} - {{ $salon->name }}</h3>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('dashboard.salons.sub-services.store', $salon) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('dashboard.service') }}</label>
                        <select name="service_id" class="form-control main-service-select" required>
                            <option value="">{{ __('dashboard.choose_service') }}</option>
                            @foreach($allServices as $service)
                                <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ __('dashboard.sub_service') }}</label>
                        <select name="sub_service_id" class="form-control sub-service-select" required>
                            <option value="">{{ __('dashboard.choose_sub_service') }}</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label">{{ __('dashboard.price') }}</label>
                        <input type="number" step="0.01" class="form-control" name="price" value="{{ old('price', 0) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('dashboard.duration') }} ({{ __('dashboard.minutes') }})</label>
                        <input type="number" class="form-control" name="duration" value="{{ old('duration', 0) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('dashboard.status') }}</label>
                        <select class="form-control" name="status">
                            <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>{{ __('dashboard.active') }}</option>
                            <option value="0" {{ old('status', 1) == 0 ? 'selected' : '' }}>{{ __('dashboard.inactive') }}</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('dashboard.service_images') }}</label>
                        <input type="file" class="form-control" name="images[]" multiple accept="image/*">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label">{{ __('dashboard.materials_used') }}</label>
                        <textarea class="form-control" rows="2" name="materials_used">{{ old('materials_used') }}</textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('dashboard.requirements') }}</label>
                        <textarea class="form-control" rows="2" name="requirements">{{ old('requirements') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ __('dashboard.special_notes') }}</label>
                        <textarea class="form-control" rows="2" name="special_notes">{{ old('special_notes') }}</textarea>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">{{ __('dashboard.save') }}</button>
                    <a href="{{ route('dashboard.salons.show', $salon) }}" class="btn btn-secondary">{{ __('dashboard.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const allServices = @json($allServices->map(function($s){ return ['id'=>$s->id,'name'=>$s->name]; }));
    const subServices = @json($subServices->map(function($ss){ return ['id'=>$ss->id,'name'=>$ss->name,'service_id'=>$ss->service_id]; }));

    document.querySelector('.main-service-select').addEventListener('change', function() {
        const serviceId = this.value;
        const subSelect = document.querySelector('.sub-service-select');
        subSelect.innerHTML = `<option value="">{{ __('dashboard.choose_sub_service') }}</option>`;
        
        subServices.forEach(function(ss) {
            if (ss.service_id == serviceId) {
                subSelect.innerHTML += `<option value="${ss.id}">${ss.name}</option>`;
            }
        });
    });
</script>
@endpush 
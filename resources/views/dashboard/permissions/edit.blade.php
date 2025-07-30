@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.permissions'), 'url' => route('dashboard.permissions.index')],
        ['label' => __('dashboard.edit_permission'), 'url' => '#'],
    ]" :pageName="__('dashboard.edit_permission')" />
@endsection

@section('content')
    <x-alert-message />
    
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="mb-0">{{ __('dashboard.edit_permission') }}</h5>
                <a href="{{ route('dashboard.permissions.index') }}" class="btn" style="border-color: #f56476; color: #f56476;">{{ __('dashboard.back_to_permissions') }}</a>
            </div>
            <div class="card-body">
                <form action="{{ route('dashboard.permissions.update', $permission) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label fw-semibold">
                                    {{ __('dashboard.permission_name') }} <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       placeholder="{{ __('dashboard.enter_permission_name') }}"
                                       value="{{ old('name', $permission->name) }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    {{ __('dashboard.permission_name_tip') }}
                                </small>
                            </div>

                            <div class="form-group mb-3">
                                <label for="description" class="form-label fw-semibold">{{ __('dashboard.description') }}</label>
                                <textarea name="description" 
                                          id="description" 
                                          class="form-control @error('description') is-invalid @enderror" 
                                          rows="4"
                                          placeholder="{{ __('dashboard.enter_permission_description') }}">{{ old('description', $permission->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    {{ __('dashboard.permission_description_tip') }}
                                </small>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title fw-semibold">{{ __('dashboard.permission_info') }}</h6>
                                    <div class="mb-3">
                                        <small class="text-muted d-block">{{ __('dashboard.created') }}</small>
                                        <strong>{{ $permission->created_at->format('M d, Y H:i') }}</strong>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted d-block">{{ __('dashboard.last_updated') }}</small>
                                        <strong>{{ $permission->updated_at->format('M d, Y H:i') }}</strong>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted d-block">{{ __('dashboard.permission_id') }}</small>
                                        <span class="badge" style="background-color: #f56476;">{{ $permission->id }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card bg-warning mt-3">
                                <div class="card-body">
                                    <h6 class="card-title fw-semibold">{{ __('dashboard.warning') }}</h6>
                                    <p class="card-text small mb-0">
                                        {{ __('dashboard.permission_change_warning') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <hr class="my-3">
                            <div class="d-flex justify-content-end gap-2">
                                                                        <a href="{{ route('dashboard.permissions.index') }}" class="btn" style="border-color: #f56476; color: #f56476;">
                                            {{ __('dashboard.cancel') }}
                                        </a>
                                        <button type="submit" class="btn" style="background-color: #f56476; border-color: #f56476;">
                                            {{ __('dashboard.update_permission') }}
                                        </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@push('scripts')
<script>
    // Form validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
@endpush
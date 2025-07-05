@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('Permissions'), 'url' => route('dashboard.permissions.index')],
        ['label' => __('Edit Permission'), 'url' => '#'],
    ]" :pageName="__('EDIT PERMISSION')" />
@endsection

@section('content')
    <x-alert-message />
    
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="mb-0">{{ __('Edit Permission') }}</h5>
                <a href="{{ route('dashboard.permissions.index') }}" class="btn" style="border-color: #f56476; color: #f56476;">{{ __('Back to Permissions') }}</a>
            </div>
            <div class="card-body">
                <form action="{{ route('dashboard.permissions.update', $permission) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label fw-semibold">
                                    {{ __('Permission Name') }} <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       placeholder="{{ __('Enter permission name (e.g., create-users)') }}"
                                       value="{{ old('name', $permission->name) }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    {{ __('Use lowercase letters and hyphens (e.g., manage-users, view-reports)') }}
                                </small>
                            </div>

                            <div class="form-group mb-3">
                                <label for="description" class="form-label fw-semibold">{{ __('Description') }}</label>
                                <textarea name="description" 
                                          id="description" 
                                          class="form-control @error('description') is-invalid @enderror" 
                                          rows="4"
                                          placeholder="{{ __('Enter a brief description of this permission...') }}">{{ old('description', $permission->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    {{ __('Optional: Provide a clear description of what this permission allows') }}
                                </small>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title fw-semibold">{{ __('Permission Info') }}</h6>
                                    <div class="mb-3">
                                        <small class="text-muted d-block">{{ __('Created') }}</small>
                                        <strong>{{ $permission->created_at->format('M d, Y H:i') }}</strong>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted d-block">{{ __('Last Updated') }}</small>
                                        <strong>{{ $permission->updated_at->format('M d, Y H:i') }}</strong>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted d-block">{{ __('Permission ID') }}</small>
                                        <span class="badge" style="background-color: #f56476;">{{ $permission->id }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card bg-warning mt-3">
                                <div class="card-body">
                                    <h6 class="card-title fw-semibold">{{ __('Warning') }}</h6>
                                    <p class="card-text small mb-0">
                                        {{ __('Changing permission names may affect existing role assignments. Please review all affected roles after making changes.') }}
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
                                            {{ __('Cancel') }}
                                        </a>
                                        <button type="submit" class="btn" style="background-color: #f56476; border-color: #f56476;">
                                            {{ __('Update Permission') }}
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
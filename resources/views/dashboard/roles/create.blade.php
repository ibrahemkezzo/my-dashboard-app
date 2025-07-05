@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('Roles'), 'url' => route('dashboard.roles.index')],
        ['label' => __('Create Role'), 'url' => '#'],
    ]" :pageName="__('CREATE ROLE')" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <h5 class="mb-0">{{ __('Create New Role') }}</h5>
            <a href="{{ route('dashboard.roles.index') }}" class="btn" style="border-color: #f56476; color: #f56476;">{{ __('Back to Roles') }}</a>
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.roles.store') }}" method="POST" class="needs-validation">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label fw-semibold">
                                {{ __('Role Name') }} <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="{{ __('Enter role name (e.g., admin, moderator)') }}"
                                   required >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                {{ __('Use descriptive names that clearly indicate the role\'s purpose') }}
                            </small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description" class="form-label fw-semibold">{{ __('Description') }}</label>
                            <textarea name="description"
                                      id="description"
                                      class="form-control @error('description') is-invalid @enderror"
                                      rows="4"
                                      placeholder="{{ __('Enter a brief description of this role...') }}"></textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                {{ __('Optional: Provide a clear description of what this role allows users to do') }}
                            </small>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">{{ __('Permissions') }}</label>
                            <div class="permissions-container bg-light p-3 rounded">
                                @if(isset($permissions) && $permissions->count() > 0)
                                    <div class="row">
                                        @foreach($permissions as $permission)
                                            <div class="col-md-6 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input"
                                                           type="checkbox"
                                                           name="permissions[]"
                                                           value="{{ $permission->name }}"
                                                           id="permission_{{ $permission->id }}" >
                                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                        <span class="fw-semibold">{{ $permission->name }}</span>
                                                        @if($permission->description)
                                                            <br><small class="text-muted">{{ $permission->description }}</small>
                                                        @endif
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-3">
                                        <i class="fa fa-shield-alt text-muted" style="font-size: 2rem; opacity: 0.5;"></i>
                                        <p class="text-muted mb-0">{{ __('No permissions available. Please create permissions first.') }}</p>
                                        <a href="{{ route('dashboard.permissions.create') }}" class="btn btn-sm mt-2" style="border-color: #f56476; color: #f56476;">
                                            {{ __('Create Permission') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                            @error('permissions')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                {{ __('Select the permissions that should be granted to users with this role') }}
                            </small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title fw-semibold">{{ __('Role Creation Tips') }}</h6>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <i class="fa fa-check-circle text-success me-2"></i>
                                        {{ __('Use clear, descriptive names') }}
                                    </li>
                                    <li class="mb-2">
                                        <i class="fa fa-check-circle text-success me-2"></i>
                                        {{ __('Follow the principle of least privilege') }}
                                    </li>
                                    <li class="mb-2">
                                        <i class="fa fa-check-circle text-success me-2"></i>
                                        {{ __('Consider security implications') }}
                                    </li>
                                    <li class="mb-2">
                                        <i class="fa fa-check-circle text-success me-2"></i>
                                        {{ __('Document the role\'s purpose') }}
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card mt-3" style="background-color: #f56476;">
                            <div class="card-body text-white">
                                <h6 class="card-title fw-semibold">{{ __('About Roles') }}</h6>
                                <p class="card-text small mb-0">
                                    {{ __('Roles are collections of permissions that define what users can do in the system. Assign roles to users to control their access levels.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <hr class="my-3">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('dashboard.roles.index') }}" class="btn" style="border-color: #f56476; color: #f56476;">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="btn" style="background-color: #f56476; border-color: #f56476;">
                                {{ __('Create Role') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
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
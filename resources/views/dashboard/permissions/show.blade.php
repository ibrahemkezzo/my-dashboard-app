@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('Permissions'), 'url' => route('dashboard.permissions.index')],
        ['label' => __('View Permission'), 'url' => '#'],
    ]" :pageName="__('PERMISSION DETAILS')" />
@endsection

@section('content')
    <x-alert-message />

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="mb-0">{{ __('Permission Details') }}</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('dashboard.permissions.index') }}" class="btn btn-outline-primary" style="border-color: #f56476;">{{ __('Back to Permissions') }}</a>
                    <a href="{{ route('dashboard.permissions.edit', $permission) }}" class="btn btn-warning">{{ __('Edit Permission') }}</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Permission ID') }}</label>
                                <div class="mb-2">
                                    <span class="badge" style="background-color: #f56476;">{{ $permission->id }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Created Date') }}</label>
                                <div class="mb-2">
                                    <strong>{{ $permission->created_at->format('F d, Y \a\t H:i') }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Permission Name') }}</label>
                                <div class="mb-2">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle me-2" style="background-color: #f56476; color:white; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa fa-shield"></i>
                                        </div>
                                        <span class="fw-semibold">{{ $permission->name }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Last Updated') }}</label>
                                <div class="mb-2">
                                    <strong>{{ $permission->updated_at->format('F d, Y \a\t H:i') }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold text-muted">{{ __('Description') }}</label>
                                <div class="mb-2">
                                    @if($permission->description)
                                        <div class="bg-light p-3 rounded">
                                            <p class="mb-0">{{ $permission->description }}</p>
                                        </div>
                                    @else
                                        <div class="bg-light p-3 rounded">
                                            <p class="mb-0 text-muted">{{ __('No description provided for this permission.') }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title fw-semibold">{{ __('Quick Stats') }}</h6>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">{{ __('Roles Using') }}</span>
                                        <span class="badge" style="background-color: #f56476;">{{ $permission->roles->count() ?? 0 }}</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">{{ __('Users Affected') }}</span>
                                        <span class="badge" style="background-color: #f56476;">{{ $permission->users->count() ?? 0 }}</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">{{ __('Status') }}</span>
                                        <span class="badge" style="background-color: #1fdd50;">{{ __('Active') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3" style="background-color: #fff691;">
                            <div class="card-body text-white">
                                <h6 class="card-title fw-semibold">{{ __('Permission Type') }}</h6>
                                <p class="card-text small mb-0">
                                    {{ __('This is a system-level permission that controls access to specific features and functionality within the application.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <hr class="my-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0 fw-semibold">{{ __('Permission Actions') }}</h6>
                                <small class="text-muted">{{ __('Manage this permission') }}</small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('dashboard.permissions.edit', $permission) }}" class="btn btn-warning mb-3 ">
                                    {{ __('Edit Permission') }}
                                </a>
                                <form action="{{ route('dashboard.permissions.destroy', $permission) }}"
                                      method="POST"
                                      style="display:inline;"
                                      onsubmit="return confirm('{{ __('Are you sure you want to delete this permission? This action cannot be undone.') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        {{ __('Delete Permission') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@push('styles')
<style>
    .detail-item {
        margin-bottom: 1.5rem;
    }

    .detail-value {
        margin-top: 0.5rem;
    }

    .stats-item {
        padding: 0.5rem 0;
        border-bottom: 1px solid rgba(0,0,0,0.1);
    }

    .stats-item:last-child {
        border-bottom: none;
    }
</style>
@endpush
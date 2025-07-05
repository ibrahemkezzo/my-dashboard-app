@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('Roles'), 'url' => route('dashboard.roles.index')],
        ['label' => __('View Role'), 'url' => '#'],
    ]" :pageName="__('ROLE DETAILS')" />
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="mb-0">{{ __('Role Details') }}</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('dashboard.roles.index') }}" class="btn btn-outline-primary"
                        style="border-color: #f56476;">{{ __('Back to Roles') }}</a>
                    <a href="{{ route('dashboard.roles.edit', $role) }}" class="btn btn-warning">{{ __('Edit Role') }}</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Role ID') }}</label>
                                <div class="mb-2">
                                    <span class="badge" style="background-color: #f56476;">{{ $role->id }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Created Date') }}</label>
                                <div class="mb-2">
                                    <strong>{{ $role->created_at->format('F d, Y \a\t H:i') }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Role Name') }}</label>
                                <div class="mb-2">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle me-2"
                                            style="background-color: #f56476; color:white; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa fa-unlock-alt"></i>
                                        </div>
                                        <span class="fw-semibold">{{ $role->name }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">{{ __('Last Updated') }}</label>
                                <div class="mb-2">
                                    <strong>{{ $role->updated_at->format('F d, Y \a\t H:i') }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold text-muted">{{ __('Description') }}</label>
                                <div class="mb-2">
                                    @if ($role->description)
                                        <div class="bg-light p-3 rounded">
                                            <p class="mb-0">{{ $role->description }}</p>
                                        </div>
                                    @else
                                        <div class="bg-light p-3 rounded">
                                            <p class="mb-0 text-muted">{{ __('No description provided for this role.') }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold text-muted">{{ __('Permissions') }}</label>
                                <div class="mb-2">
                                    @if ($role->permissions->count() > 0)
                                        <div class="bg-light p-3 rounded">
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach ($role->permissions as $permission)
                                                    <span class="badge" style="background-color: #f56476;">
                                                        {{ $permission->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <div class="bg-light p-3 rounded">
                                            <p class="mb-0 text-muted">{{ __('No permissions assigned to this role.') }}
                                            </p>
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
                                        <span class="text-muted">{{ __('Total Permissions') }}</span>
                                        <span class="badge"
                                            style="background-color: #f56476;">{{ $role->permissions->count() }}</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">{{ __('Users with Role') }}</span>
                                        <span class="badge"
                                            style="background-color: #f56476;">{{ $role->users->count() }}</span>
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
                                <h6 class="card-title fw-semibold">{{ __('Role Type') }}</h6>
                                <p class="card-text small mb-0">
                                    {{ __('This is a user role that defines specific permissions and access levels within the system.') }}
                                </p>
                            </div>
                        </div>

                        @if ($role->users->count() > 0)
                            <div class="card mt-3" style="background-color: #fff691;">
                                <div class="card-body text-white">
                                    <h6 class="card-title fw-semibold">{{ __('Users with this Role') }}</h6>
                                    <div class="user-list">
                                        @foreach ($role->users->take(3) as $user)
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="bg-white rounded-circle me-2"
                                                    style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa fa-user text-info"></i>
                                                </div>
                                                <span class="small" style="color: #777;">{{ $user->name }}</span>
                                            </div>
                                        @endforeach
                                        @if ($role->users->count() > 3)
                                            <small class="text-white-50">+{{ $role->users->count() - 3 }} more
                                                users</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <hr class="my-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0 fw-semibold">{{ __('Role Actions') }}</h6>
                                <small class="text-muted">{{ __('Manage this role') }}</small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('dashboard.roles.edit', $role) }}" class="btn btn-warning mb-3">
                                    {{ __('Edit Role') }}
                                </a>
                                <form action="{{ route('dashboard.roles.destroy', $role) }}" method="POST"
                                    style="display:inline;"
                                    onsubmit="return confirm('{{ __('Are you sure you want to delete this role? This action cannot be undone.') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        {{ __('Delete Role') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .user-list {
            max-height: 150px;
            overflow-y: auto;
        }
    </style>
@endpush

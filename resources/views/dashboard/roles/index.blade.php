@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('Roles'), 'url' => route('dashboard.roles.index')],
    ]" :pageName="__('ROLES LIST')" />
@endsection

@section('content')
    <x-alert-message />

    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <a href="{{ route('dashboard.roles.create') }}" class="btn" style="background-color: #f56476; border-color: #f56476;">{{ __('Create Role') }}</a>
            </div>

            <div class="card-body">
                <div class="table-responsive table-desi">
                    <table class="all-package coupon-table table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Role Name') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Permissions') }}</th>
                                <th>{{ __('Created') }}</th>
                                <th>{{ __('Procedures') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle me-2" style="background-color: #f56476; color:white; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa fa-unlock-alt"></i>
                                        </div>
                                        <span class="fw-semibold">{{ $role->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $role->description ?? __('No description') }}</td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        @if($role->permissions->count() > 0)
                                            @foreach($role->permissions->take(3) as $permission)
                                                <span class="badge badge-sm" style="background-color: #f56476;" >{{ $permission->name }}</span>
                                            @endforeach
                                            @if($role->permissions->count() > 3)
                                                <span class="badge bg-light badge-sm text-dark">+{{ $role->permissions->count() - 3 }} more</span>
                                            @endif
                                        @else
                                            <span class="badge bg-light badge-sm text-dark">{{ __('No permissions') }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $role->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('dashboard.roles.show', $role) }}" class="mr-2" style="color: #f56476;" title="{{ __('Show') }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('dashboard.roles.edit', $role) }}" class="text-yellow-500 hover:text-yellow-700 mr-2" title="{{ __('Edit') }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('dashboard.roles.destroy', $role) }}" method="POST" id="destroy-form-{{ $role->id }}" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <a href="#" class="text-red-500 hover:text-red-700" title="{{ __('Delete') }}" onclick="event.preventDefault(); return confirm('{{ __('Are you sure you want to delete this role?') }}') && document.getElementById('destroy-form-{{ $role->id }}').submit();">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">{{ __('No roles found') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
</script>
@endpush
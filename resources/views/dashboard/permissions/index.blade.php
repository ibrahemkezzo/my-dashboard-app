@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.permissions'), 'url' => route('dashboard.permissions.index')],
    ]" :pageName="__('dashboard.permissions_list')" />
@endsection

@section('content')
    <x-alert-message />

    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <a href="{{ route('dashboard.permissions.create') }}" class="btn btn-primary">{{ __('dashboard.create_permission') }}</a>
            </div>

            <div class="card-body">
                <div class="table-responsive table-desi">
                    <table class="all-package coupon-table table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('dashboard.id') }}</th>
                                <th>{{ __('dashboard.name') }}</th>
                                <th>{{ __('dashboard.description') }}</th>
                                <th>{{ __('dashboard.created') }}</th>
                                <th>{{ __('dashboard.procedures') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($permissions as $permission)
                            <tr>
                                <td>{{ $permission->id }}</td>
                                <td>
                                                                    <div class="d-flex align-items-center">
                                    <div class="rounded-circle me-2" style="background-color: #f56476; color:white; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fa fa-shield"></i>
                                    </div>
                                    <span class="fw-semibold">{{ $permission->name }}</span>
                                </div>
                                </td>
                                <td>{{ $permission->description ?? __('dashboard.no_description') }}</td>
                                <td>{{ $permission->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('dashboard.permissions.show', $permission) }}" class="mr-2" style="color: #f56476;" title="{{ __('dashboard.show') }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('dashboard.permissions.edit', $permission) }}" class="text-yellow-500 hover:text-yellow-700 mr-2" title="{{ __('dashboard.edit') }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('dashboard.permissions.destroy', $permission) }}" method="POST" id="destroy-form-{{ $permission->id }}" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <a href="#" class="text-red-500 hover:text-red-700" title="{{ __('dashboard.delete') }}" onclick="event.preventDefault(); return confirm('{{ __('dashboard.confirm_delete_permission') }}') && document.getElementById('destroy-form-{{ $permission->id }}').submit();">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">{{ __('dashboard.no_permissions_found') }}</td>
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
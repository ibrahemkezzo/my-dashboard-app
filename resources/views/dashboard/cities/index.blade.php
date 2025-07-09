@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.cities'), 'url' => route('dashboard.cities.index')],
    ]" :pageName="__('dashboard.cities')" />
@endsection

@section('content')
    <x-alert-message />
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap" >
                <h5 class="mb-0">{{ __('dashboard.cities') }}</h5>
                <a href="{{ route('dashboard.cities.create') }}" class="btn" style="background-color: #680d48; color: #fff; border-color: #680d48;">
                    <i class="fa fa-plus"></i> {{ __('dashboard.create_city') }}
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive table-desi">
                    <table class="all-package coupon-table table table-striped">
                        <thead style="background-color: #f56476; color: #fff;">
                            <tr>
                                <th>{{ __('dashboard.id') }}</th>
                                <th>{{ __('dashboard.name') }}</th>
                                <th>{{ __('dashboard.country') }}</th>
                                <th>{{ __('dashboard.latitude') }}</th>
                                <th>{{ __('dashboard.longitude') }}</th>
                                <th>{{ __('dashboard.timezone') }}</th>
                                {{-- <th>{{ __('dashboard.is_active') }}</th> --}}
                                <th>{{ __('dashboard.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cities as $city)
                                <tr>
                                    <td>{{ $city->id }}</td>
                                    <td>{{ $city->name }}</td>
                                    <td>{{ $city->country }}</td>
                                    <td>{{ $city->latitude }}</td>
                                    <td>{{ $city->longitude }}</td>
                                    <td>{{ $city->timezone }}</td>
                                    {{-- <td>
                                        @if($city->is_active)
                                            <span class="badge" style="background-color: #1fdd50;">{{ __('dashboard.active') }}</span>
                                        @else
                                            <span class="badge" style="background-color: #E43F6F;">{{ __('dashboard.inactive') }}</span>
                                        @endif
                                    </td> --}}
                                    <td>
                                        <a href="{{ route('dashboard.cities.show', $city->id) }}" class="mr-2" style="color: #f56476;" title="{{ __('dashboard.show') }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('dashboard.cities.edit', $city->id) }}" class="text-yellow-500 hover:text-yellow-700 mr-2" title="{{ __('dashboard.edit') }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('dashboard.cities.destroy', $city->id) }}" method="POST" id="destroy-form-{{ $city->id }}" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <a href="#" class="text-red-500 hover:text-red-700" title="{{ __('dashboard.delete') }}" onclick="event.preventDefault(); return confirm('{{ __('dashboard.confirm_delete_city') }}') && document.getElementById('destroy-form-{{ $city->id }}').submit();">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">{{ __('dashboard.no_cities_found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .btn-primary {
        background-color: #f56476 !important;
        border-color: #f56476 !important;
    }
    .btn-primary:hover, .btn-primary:focus {
        background-color: #e43f6f !important;
        border-color: #e43f6f !important;
    }
    .btn-outline-primary:hover, .btn-outline-primary:focus {
        background-color: #f56476 !important;
        color: #fff !important;
        border-color: #f56476 !important;
    }
    .btn-outline-warning:hover, .btn-outline-warning:focus {
        background-color: #fff3cd !important;
        color: #856404 !important;
        border-color: #ffeeba !important;
    }
    .btn-outline-danger:hover, .btn-outline-danger:focus {
        background-color: #f8d7da !important;
        color: #721c24 !important;
        border-color: #f5c6cb !important;
    }
</style>
@endpush
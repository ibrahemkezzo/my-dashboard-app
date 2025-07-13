@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.salons'), 'url' => route('dashboard.salons.index')],
    ]" :pageName="__('dashboard.salons')" />
@endsection
@push('styles')


<style>
    .search-container {
        display: flex;
        align-items: center;
        width: 300px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #fff;
        padding: 5px 5px;
    }

    .search-input {
        flex: 1;
        border: none;
        outline: none;
        font-size: 16px;
        color: #666;
        background: transparent;
        direction: ltr;
    }

    .search-input::placeholder {
        color: #999;
    }

    .search-icon, .clear-icon {
        margin-right: 5px;
        width: 16px;
        height: 16px;
    }

    .search-icon-button, .clear-icon-button {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        display: flex;
        align-items: center;
    }

    .search-container.input-has-text .clear-icon-button {
        display: flex;
    }
</style>
@endpush
@section('content')
    <x-alert-message />
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="mb-0">{{ __('dashboard.salons') }}</h5>
                <a href="{{ route('dashboard.salons.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> {{ __('dashboard.create_salon') }}
                </a>
            </div>
            <div class="card-body">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                    <!-- Search Form -->
                    <form action="{{route('dashboard.salons.index')}}" method="GET" class="search-container">
                        <button type="submit" class="search-icon-button">
                            <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2">
                                <circle cx="10" cy="10" r="7"></circle>
                                <line x1="21" y1="21" x2="15" y2="15"></line>
                            </svg>
                        </button>
                        <input class="search-input" type="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="{{ __('dashboard.search_placeholder') }}">
                        <button type="button" class="clear-icon-button" style="display:none;">
                            <svg class="clear-icon" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </form>
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        <form method="GET" action="{{ route('dashboard.salons.index') }}" class="d-flex flex-wrap gap-2 align-items-center">
                            {{-- <div class="col-md-3">
                                <input type="text" name="search" class="form-control" placeholder="{{ __('dashboard.search_placeholder') }}" value="{{ $filters['search'] ?? '' }}">
                            </div> --}}
                            <div class="form-group mb-0">
                                <select name="city_id" class="form-control" style="min-width: 100px;" >
                                    <option value="">{{ __('dashboard.all_cities') }}</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ ($filters['city_id'] ?? '') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-0">
                                <select name="owner_id" class="form-control" style="min-width: 100px;" >
                                    <option value="">{{ __('dashboard.all_owners') }}</option>
                                    @foreach($owners as $owner)
                                        <option value="{{ $owner->id }}" {{ ($filters['owner_id'] ?? '') == $owner->id ? 'selected' : '' }}>{{ $owner->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-0">
                                <select name="status" class="form-control" style="min-width: 100px;" >
                                    <option value="">{{ __('dashboard.all_statuses') }}</option>
                                    <option value="1" {{ ($filters['status'] ?? '') === '1' ? 'selected' : '' }}>{{ __('dashboard.active') }}</option>
                                    <option value="0" {{ ($filters['status'] ?? '') === '0' ? 'selected' : '' }}>{{ __('dashboard.inactive') }}</option>
                                </select>
                            </div>
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary">{{ __('dashboard.apply_filters') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive table-desi">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('dashboard.logo') }}</th>
                                <th>{{ __('dashboard.name') }}</th>
                                <th>{{ __('dashboard.owner') }}</th>
                                <th>{{ __('dashboard.city') }}</th>
                                <th>{{ __('dashboard.phone') }}</th>
                                <th>{{ __('dashboard.rating') }}</th>
                                <th>{{ __('dashboard.status') }}</th>
                                <th>{{ __('dashboard.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($salons as $salon)
                                <tr>
                                    <td>{{ $salon->id }}</td>
                                    <td>
                                        @if($salon->logo)
                                            <img src="{{ asset('storage/'.$salon->logo) }}" alt="logo" style="width:40px;height:40px;object-fit:cover;border-radius:50%;">
                                        @else
                                            <div style="width:40px;height:40px;background:#f0f0f0;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                                <i class="fa fa-building"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $salon->name }}</td>
                                    <td>{{ $salon->owner->name ?? '-' }}</td>
                                    <td>{{ $salon->city->name ?? '-' }}</td>
                                    <td>{{ $salon->phone }}</td>
                                    <td>
                                        @if($salon->rating > 0)
                                            <span class="badge bg-warning">{{ $salon->rating }}/5</span>
                                        @else
                                            <span class="text-muted">{{ __('dashboard.no_rating') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($salon->status)
                                            <span class="badge bg-success">{{ __('dashboard.active') }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ __('dashboard.inactive') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('dashboard.salons.show', $salon) }}" class="text-info me-2" title="{{ __('dashboard.show') }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('dashboard.salons.edit', $salon) }}" class="text-warning me-2" title="{{ __('dashboard.edit') }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('dashboard.salons.destroy', $salon) }}" method="POST" id="destroy-form-{{ $salon->id }}" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <a href="#" class="text-red-500 hover:text-red-700" title="{{ __('dashboard.delete') }}" onclick="event.preventDefault(); return confirm('{{ __('dashboard.are_you_sure_delete_salon') }}') && document.getElementById('destroy-form-{{ $salon->id }}').submit();">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">{{ __('dashboard.no_salons_found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $salons->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
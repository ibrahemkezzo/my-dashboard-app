@extends('layouts.dashboard')

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

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('User'), 'url' => route('dashboard.users.index')],
    ]" :pageName="__('USER LIST')" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
        <!-- Search Form -->
            <form action="{{route('dashboard.users.index')}}" method="GET" class="search-container">
                <button type="submit" class="search-icon-button">
                    <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2">
                        <circle cx="10" cy="10" r="7"></circle>
                        <line x1="21" y1="21" x2="15" y2="15"></line>
                    </svg>
                </button>
                <input class="search-input" type="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="{{ __('Search..') }}">
                <button type="button" class="clear-icon-button" style="display:none;">
                    <svg class="clear-icon" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </form>
            <!-- Filter Form and Create Button -->
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <form method="GET" action="{{ route('dashboard.users.index') }}" class="d-flex flex-wrap gap-2 align-items-center">
                    <div class="form-group mb-0">
                        <select name="status" class="form-control" style="min-width: 120px;">
                            <option value="">{{ __('All') }}</option>
                            <option value="1" {{ isset($filters['status']) && $filters['status'] == '1' ? 'selected' : '' }}>{{ __('Active') }}</option>
                            <option value="0" {{ isset($filters['status']) && $filters['status'] == '0' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <select name="roles[]" class="form-control" style="min-width: 150px;">
                            <option value="">{{ __('All Roles') }}</option>
                            @foreach($roles as $id => $name)
                                <option value="{{ $name }}" {{ in_array($name, $filters['roles'] ?? []) ? 'selected' : '' }} >{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary">{{ __('Filter') }}</button>
                    </div>
                </form>
            </div>

        </div>
        <div class="card-header d-flex justify-content-between align-items-right flex-wrap">
            <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary">{{ __('Create User') }}</a>
        </div>

        <div class="card-body">
            <div class="table-responsive table-desi">
                <table class="all-package coupon-table table table-striped">
                    <thead>
                        <tr>
                            <th>{{__('Avtar')}}</th>
                            <th>{{__('First Name')}}</th>
                            <th>{{__('Email')}}</th>
                            <th>{{__('Status')}}</th>
                            <th>{{__('Last Login')}}</th>
                            <th>{{__('Role')}}</th>
                            <th>{{ __('Procedures') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td>
                                <img src="{{$user->url}}" alt="{{$user->name}}" style="width: 40px; height: 40px; border-radius: 50%;">
                            </td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{ $user->is_active ? __('Active') : __('Inactive') }}</td>
                            <td>{{ $user->sessions_max_updated_at ? \Carbon\Carbon::parse($user->sessions_max_updated_at)->diffForHumans() : __('Never') }}</td>
                            <td>{{ $user->roles->pluck('name')->implode(', ') ?: __('Customer') }} </td>
                            <td>
                                <a href="{{ route('dashboard.users.show', $user) }}" class="text-blue-500 hover:text-blue-700 mr-2" title="{{ __('Show') }}">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('dashboard.users.edit', $user->id) }}" class="text-yellow-500 hover:text-yellow-700 mr-2" title="{{ __('Edit') }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="{{ route('dashboard.users.editRoles', $user->id) }}" class="text-purple-500 hover:text-purple-700 mr-2" title="{{ __('Manage Roles') }}">
                                    <i class="fa fa-users-cog"></i>
                                </a>
                                <form action="{{ route('dashboard.users.toggleStatus', $user) }}" method="POST" id="toggle-status-form-{{ $user->id }}" style="display:none;">
                                    @csrf
                                    @method('PATCH')
                                </form>
                                <a href="#" class="text-{{ $user->is_active ? 'orange-500' : 'green-500' }} hover:text-{{ $user->is_active ? 'orange-700' : 'green-700' }} mr-2" title="{{ $user->is_active ? __('Deactivate') : __('Activate') }}" onclick="event.preventDefault(); return confirm('{{ __('Are you sure you want to') }} {{ $user->is_active ? __('deactivate') : __('activate') }} {{ __('this user?') }}') && document.getElementById('toggle-status-form-{{ $user->id }}').submit();">
                                    <i class="fa fa-{{ $user->is_active ? 'ban' : 'check' }}"></i>
                                </a>
                                <form action="{{ route('dashboard.users.destroy', $user) }}" method="POST" id="destroy-form-{{ $user->id }}" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <a href="#" class="text-red-500 hover:text-red-700" title="{{ __('Delete') }}" onclick="event.preventDefault(); return confirm('{{ __('Are you sure you want to delete this user?') }}') && document.getElementById('destroy-form-{{ $user->id }}').submit();">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">{{ __('No users found') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $users->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    const searchContainer = document.querySelector('.search-container');
    const searchInput = document.querySelector('.search-input');
    const clearButton = document.querySelector('.clear-icon-button');

    searchInput.addEventListener('input', () => {
        searchContainer.classList.toggle('input-has-text', searchInput.value.length > 0);
    });

    clearButton.addEventListener('click', () => {
        searchInput.value = '';
        searchContainer.classList.remove('input-has-text');
        searchContainer.submit();
    });

    searchInput.addEventListener('focus', () => {
        searchInput.placeholder = '';
    });

    searchInput.addEventListener('blur', () => {
        searchInput.placeholder = '{{ __('Search..') }}';
    });
</script>
@endpush
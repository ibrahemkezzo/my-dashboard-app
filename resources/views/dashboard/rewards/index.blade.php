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

        .search-icon,
        .clear-icon {
            margin-right: 5px;
            width: 16px;
            height: 16px;
        }

        .search-icon-button,
        .clear-icon-button {
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

        .no-wrap-label {
            white-space: nowrap;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .search-container {
                width: 100%;
            }

            .form-group {
                width: 100%;
            }

            .d-flex.flex-wrap.gap-2 {
                flex-direction: column;
                align-items: stretch;
            }
        }

        @media (max-width: 900px) {
            .point-ptn {
                padding: 0.6rem 1rem;
            }
        }
    </style>
@endpush

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.rewards'), 'url' => route('dashboard.rewards.index')],
    ]" :pageName="__('dashboard.rewards_list')" />
@endsection

@section('content')
    <x-alert-message />
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="mb-0">{{ __('dashboard.rewards') }}</h5>
            </div>
            <div class="card-body">
                <!-- قسم النماذج أعلى الجدول (ريسبونسيف) -->
                <div class="col-md-12 row mb-4">
                    <!-- نموذج تحديث النقاط لكل حجز -->
                    <div class="col-12 col-md-4 mb-3">
                        <h6>{{ __('dashboard.edit_points_per_booking') }}</h6>
                        <form method="POST" action="{{ route('dashboard.rewards.update_points') }}" class="col-md-12 row">
                            @csrf
                            <div class="col-md-8">
                                <label class="no-wrap-label" for="points_per_booking">{{ __('dashboard.points_per_booking') }}</label>
                                <input type="number" name="points_per_booking" id="points_per_booking" class="form-control"
                                    value="{{ $pointsPerBooking ?? 5 }}" required min="1">
                                @error('points_per_booking')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-1">
                                <br>
                                <button type="submit" class="point-ptn btn btn-primary mt-1">{{ __('dashboard.save') }}</button>
                            </div>
                        </form>
                    </div>
                    <!-- نموذج إضافة جائزة جديدة -->
                    <div class="col-md-8 mb-3">
                        <h6>{{ __('dashboard.create_reward') }}</h6>
                        <form method="POST" action="{{ route('dashboard.rewards.store') }}" class="col-md-12 row">
                            @csrf
                            <div class="form-group col-md-4">
                                <label class="no-wrap-label" for="required_points">{{ __('dashboard.required_points') }}</label>
                                <input type="number" name="required_points" id="required_points" class="form-control" required>
                                @error('required_points')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="no-wrap-label" for="description">{{ __('dashboard.description') }}</label>
                                <input type="text" name="description" id="description" class="form-control" required>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <br>
                                <button type="submit" class="btn btn-primary mt-1">{{ __('dashboard.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- قسم البحث والفلتر -->
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <!-- Search Form -->
                    <form action="{{ route('dashboard.rewards.index') }}" method="GET" class="search-container">
                        <button type="submit" class="search-icon-button">
                            <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2">
                                <circle cx="10" cy="10" r="7"></circle>
                                <line x1="21" y1="21" x2="15" y2="15"></line>
                            </svg>
                        </button>
                        <input class="search-input" type="search" name="description" value="{{ request('description') }}"
                            placeholder="{{ __('dashboard.search_by_description') }}">
                        <button type="button" class="clear-icon-button" style="display:none;">
                            <svg class="clear-icon" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </form>
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('dashboard.rewards.index') }}"
                        class="d-flex flex-wrap gap-2 align-items-center">
                        <div class="form-group mb-0">
                            <input type="number" name="required_points" class="form-control" style="min-width: 100px;"
                                value="{{ request('required_points') }}"
                                placeholder="{{ __('dashboard.required_points') }}">
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">{{ __('dashboard.apply_filters') }}</button>
                        </div>
                    </form>
                </div>

                <div class="table-responsive table-desi">
                    <table class="all-package coupon-table table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('dashboard.required_points') }}</th>
                                <th>{{ __('dashboard.description') }}</th>
                                <th>{{ __('dashboard.created_at') }}</th>
                                <th>{{ __('dashboard.procedures') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rewards as $reward)
                                <tr>
                                    <td>{{ $reward->required_points }}</td>
                                    <td>{{ $reward->description }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reward->created_at)->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editRewardModal{{ $reward->id }}"
                                            title="{{ __('dashboard.edit') }}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <!-- Delete Button -->
                                        <form action="{{ route('dashboard.rewards.destroy', $reward) }}" method="POST"
                                            id="destroy-form-{{ $reward->id }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('{{ __('dashboard.are_you_sure_delete_reward') }}')"
                                                title="{{ __('dashboard.delete') }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editRewardModal{{ $reward->id }}" tabindex="-1"
                                            aria-labelledby="editRewardModalLabel{{ $reward->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editRewardModalLabel{{ $reward->id }}">
                                                            {{ __('dashboard.edit_reward') }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('dashboard.rewards.update', $reward) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="mb-2">
                                                                <label class="no-wrap-label" for="required_points_{{ $reward->id }}">{{ __('dashboard.required_points') }}</label>
                                                                <input type="number" name="required_points"
                                                                    id="required_points_{{ $reward->id }}"
                                                                    class="form-control"
                                                                    value="{{ $reward->required_points }}" required>
                                                                @error('required_points')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-2">
                                                                <label class="no-wrap-label" for="description_{{ $reward->id }}">{{ __('dashboard.description') }}</label>
                                                                <input type="text" name="description"
                                                                    id="description_{{ $reward->id }}"
                                                                    class="form-control"
                                                                    value="{{ $reward->description }}" required>
                                                                @error('description')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">{{ __('dashboard.cancel') }}</button>
                                                            <button type="submit" class="btn btn-primary">{{ __('dashboard.save') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">{{ __('dashboard.no_rewards_found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-center" dir="ltr">
                {{ $rewards->appends(request()->query())->links('pagination::simple-tailwind') }}
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
            searchInput.placeholder = '{{ __('dashboard.search_by_description') }}';
        });
    </script>
@endpush

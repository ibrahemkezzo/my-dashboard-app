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
        .all-package tbody tr td a{
            color: #a2416d
        }
        .all-package tbody tr td a:hover{
            color: #be4c7f;
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
        ['label' => __('dashboard.user_rewards'), 'url' => route('dashboard.user-rewards.index')],
    ]" :pageName="__('dashboard.user_rewards_list')" />
@endsection

@section('content')
    <x-alert-message />
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="mb-0">{{ __('dashboard.user_rewards') }}</h5>
            </div>
            <div class="card-body">
                <!-- قسم البحث والفلتر -->
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <!-- Search Form (by user name) -->
                    <form action="{{ route('dashboard.user-rewards.index') }}" method="GET" class="search-container">
                        <button type="submit" class="search-icon-button">
                            <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2">
                                <circle cx="10" cy="10" r="7"></circle>
                                <line x1="21" y1="21" x2="15" y2="15"></line>
                            </svg>
                        </button>
                        <input class="search-input" type="search" name="user_name" value="{{ request('user_name') }}"
                            placeholder="{{ __('dashboard.search_by_user_name') }}">
                        <button type="button" class="clear-icon-button" style="display:none;">
                            <svg class="clear-icon" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </form>
                    <!-- Filter Form (by status) -->
                    <form method="GET" action="{{ route('dashboard.user-rewards.index') }}"
                        class="d-flex flex-wrap gap-2 align-items-center">
                        <div class="form-group mb-0">
                            <select name="status" class="form-control" style="min-width: 150px;">
                                <option value="">{{ __('dashboard.all_statuses') }}</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('dashboard.pending') }}</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>{{ __('dashboard.processing') }}</option>
                                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>{{ __('dashboard.shipped') }}</option>
                                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>{{ __('dashboard.delivered') }}</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ __('dashboard.cancelled') }}</option>
                            </select>
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
                                <th>{{ __('dashboard.user_name') }}</th>
                                <th>{{ __('dashboard.reward_description') }}</th>
                                <th>{{ __('dashboard.reward_points_required') }}</th>
                                <th>{{ __('dashboard.user_points_currently') }}</th>
                                <th>{{ __('dashboard.status') }}</th>
                                <th>{{ __('dashboard.created_at') }}</th>
                                <th>{{ __('dashboard.procedures') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($userRewards as $userReward)
                                <tr>
                                    <td><a style=" color: #a2416d;" class="link" href="{{route('dashboard.users.show',$userReward->user_id)}}">{{ $userReward->user->name }}</a></td>
                                    <td>{{ $userReward->reward->description }}</td>
                                    <td>{{ $userReward->reward->required_points }}</td>
                                    <td>{{ $userReward->user->points }}</td>
                                    <td>{{ __('dashboard.' . $userReward->status) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($userReward->created_at)->format('Y-m-d') }}</td>
                                    <td>
                                        <!-- Edit Status Button -->
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editUserRewardModal{{ $userReward->id }}"
                                            title="{{ __('dashboard.edit_status') }}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <!-- Delete Button (if needed) -->
                                        {{-- <!-- <form action="{{ route('dashboard.user-rewards.destroy', $userReward) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('dashboard.are_you_sure_delete') }}')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form> --> --}}

                                        <!-- Edit Status Modal -->
                                        <div class="modal fade" id="editUserRewardModal{{ $userReward->id }}" tabindex="-1"
                                            aria-labelledby="editUserRewardModalLabel{{ $userReward->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editUserRewardModalLabel{{ $userReward->id }}">
                                                            {{ __('dashboard.edit_status') }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('dashboard.user-rewards.update_status', $userReward) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="mb-2">
                                                                <label for="status_{{ $userReward->id }}">{{ __('dashboard.status') }}</label>
                                                                <select name="status" id="status_{{ $userReward->id }}" class="form-control" required>
                                                                    <option value="pending" {{ $userReward->status == 'pending' ? 'selected' : '' }}>{{ __('dashboard.pending') }}</option>
                                                                    <option value="processing" {{ $userReward->status == 'processing' ? 'selected' : '' }}>{{ __('dashboard.processing') }}</option>
                                                                    <option value="shipped" {{ $userReward->status == 'shipped' ? 'selected' : '' }}>{{ __('dashboard.shipped') }}</option>
                                                                    <option value="delivered" {{ $userReward->status == 'delivered' ? 'selected' : '' }}>{{ __('dashboard.delivered') }}</option>
                                                                    <option value="cancelled" {{ $userReward->status == 'cancelled' ? 'selected' : '' }}>{{ __('dashboard.cancelled') }}</option>
                                                                </select>
                                                                @error('status')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">{{ __('dashboard.cancel') }}</button>
                                                            <button type="submit" class="btn btn-success">{{ __('dashboard.save') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">{{ __('dashboard.no_user_rewards_found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-center" dir="ltr">
                {{ $userRewards->appends(request()->query())->links('pagination::simple-tailwind') }}
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
            searchInput.placeholder = '{{ __('dashboard.search_by_user_name') }}';
        });
    </script>
@endpush

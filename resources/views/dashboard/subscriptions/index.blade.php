@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.subscriptions'), 'url' => route('dashboard.subscriptions.index')],
    ]" :pageName="__('dashboard.subscriptions')" />
@endsection

@section('content')
    <x-alert-message />
    <div class="container-fluid">
        <!-- Statistics -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card bg-primary text-white shadow-sm border-0">
                    <div class="card-body text-center py-4">
                        <h4 class="mb-0">{{ number_format($statistics['revenue'], 2) }} ريال</h4>
                        <p class="mb-0 mt-2 opacity-75">{{ __('dashboard.total_revenue') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card bg-success text-white shadow-sm border-0">
                    <div class="card-body text-center py-4">
                        <h4 class="mb-0">{{ $statistics['subscribed'] }}</h4>
                        <p class="mb-0 mt-2 opacity-75">{{ __('dashboard.subscribed_salons') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card bg-info text-white shadow-sm border-0">
                    <div class="card-body text-center py-4">
                        <h4 class="mb-0">{{ $statistics['trial'] }}</h4>
                        <p class="mb-0 mt-2 opacity-75">{{ __('dashboard.trial_salons') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card bg-warning text-white shadow-sm border-0">
                    <div class="card-body text-center py-4">
                        <h4 class="mb-0">{{ $statistics['paid'] }}</h4>
                        <p class="mb-0 mt-2 opacity-75">{{ __('dashboard.paid_subscriptions') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ __('dashboard.subscriptions') }}</h5>
            </div>
            <div class="card-body">
                <form method="GET" class="row g-3 mb-4 align-items-end">
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control" placeholder="{{ __('dashboard.search') }}"
                            value="{{ $filters['search'] ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">{{ __('dashboard.all_statuses') }}</option>
                            <option value="active" {{ ($filters['status'] ?? '') == 'active' ? 'selected' : '' }}>
                                {{ __('dashboard.active') }}</option>
                            <option value="trial" {{ ($filters['status'] ?? '') == 'trial' ? 'selected' : '' }}>
                                {{ __('dashboard.trial') }}</option>
                            <option value="expired" {{ ($filters['status'] ?? '') == 'expired' ? 'selected' : '' }}>
                                {{ __('dashboard.expired') }}</option>
                            <option value="suspended" {{ ($filters['status'] ?? '') == 'suspended' ? 'selected' : '' }}>
                                {{ __('dashboard.suspended') }}</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="period" class="form-select">
                            <option value="all" {{ ($filters['period'] ?? 'all') == 'all' ? 'selected' : '' }}>
                                {{ __('dashboard.all') }}</option>
                            <option value="daily" {{ ($filters['period'] ?? '') == 'daily' ? 'selected' : '' }}>
                                {{ __('dashboard.daily') }}</option>
                            <option value="weekly" {{ ($filters['period'] ?? '') == 'weekly' ? 'selected' : '' }}>
                                {{ __('dashboard.weekly') }}</option>
                            <option value="monthly" {{ ($filters['period'] ?? '') == 'monthly' ? 'selected' : '' }}>
                                {{ __('dashboard.monthly') }}</option>
                            <option value="yearly" {{ ($filters['period'] ?? '') == 'yearly' ? 'selected' : '' }}>
                                {{ __('dashboard.yearly') }}</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">{{ __('dashboard.apply_filters') }}</button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('dashboard.salon') }}</th>
                                <th>{{ __('dashboard.current_plan') }}</th>
                                <th>{{ __('dashboard.start_date') }}</th>
                                <th>{{ __('dashboard.end_date') }}</th>
                                <th>{{ __('dashboard.status') }}</th>
                                <th class="text-center">{{ __('dashboard.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($salons as $salon)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($salon->logo)
                                                <img src="{{ $salon->logo_url }}" alt="{{ $salon->name }}"
                                                    class="rounded-circle me-3"
                                                    style="width:40px;height:40px;object-fit:cover;">
                                            @else
                                                <div class="bg-light rounded-circle me-3 d-flex align-items-center justify-content-center"
                                                    style="width:40px;height:40px;">
                                                    <i class="fa fa-building text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <strong>{{ $salon->name }}</strong>
                                                <small class="text-muted d-block">{{ $salon->city->name ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $salon->subscription?->plan?->name ?? __('dashboard.no_plan') }}
                                        @if ($salon->subscription)
                                            <a href="{{ route('dashboard.subscriptions.history', $salon) }}"
                                                class="text-primary small d-block">
                                                <i class="fa fa-history me-1"></i>{{ __('dashboard.view_history') }}
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{ $salon->subscription?->start_date?->format('d/m/Y') ?? '-' }}</td>
                                    <td>
                                        @if ($salon->subscription?->end_date)
                                            {{ $salon->subscription->end_date->format('d/m/Y') }}
                                            <small
                                                class="text-muted d-block">{{ $salon->subscription->end_date->diffForHumans() }}</small>
                                        @else
                                            {{ __('dashboard.indefinite') }}
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $badgeClass = match ($salon->subscription?->status ?? 'no_subscription') {
                                                'active' => 'bg-success',
                                                'trial' => 'bg-info',
                                                'expired' => 'bg-danger',
                                                'suspended' => 'bg-secondary',
                                                default => 'bg-light text-dark',
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">
                                            {{ __('dashboard.' . ($salon->subscription?->status ?? 'no_subscription')) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('dashboard.subscriptions.assign-form', $salon) }}"
                                                class="btn btn-sm btn-primary"
                                                title="{{ $salon->subscription ? __('dashboard.renew_subscription') : __('dashboard.assign_subscription') }}">
                                                <i class="fa fa-plus-circle me-1"></i>
                                                {{ $salon->subscription ? __('dashboard.renew') : __('dashboard.assign') }}
                                            </a>
                                            @if ($salon->subscription)
                                                @if (in_array($salon->subscription->status, ['active', 'trial']))
                                                    <button type="button" class="btn btn-sm btn-warning"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#suspendModal{{ $salon->subscription->id }}">
                                                        <i class="fa fa-pause-circle me-1"></i> إيقاف
                                                    </button>
                                                @elseif($salon->subscription->status === 'suspended')
                                                    <button type="button" class="btn btn-sm btn-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#activateModal{{ $salon->subscription->id }}">
                                                        <i class="fa fa-play-circle me-1"></i> تفعيل
                                                    </button>
                                                @endif

                                                <button type="button" class="btn btn-sm btn-secondary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#updateEndDateModal{{ $salon->subscription->id }}">
                                                    <i class="fa fa-calendar-alt me-1"></i> تعديل التاريخ
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                @if ($salon->subscription)
                                    <!-- Suspend Modal -->
                                    <div class="modal fade" id="suspendModal{{ $salon->subscription->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-warning text-white">
                                                    <h5 class="modal-title"><i class="fa fa-exclamation-triangle me-2"></i>
                                                        تأكيد الإيقاف</h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>هل أنت متأكد من إيقاف اشتراك {{ $salon->name }}؟</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">إلغاء</button>
                                                    <form
                                                        action="{{ route('dashboard.subscriptions.suspend', $salon->subscription) }}"
                                                        method="POST" style="display:inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-warning">إيقاف</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($salon->subscription)
                                    <!-- Update End Date Modal -->
                                    <div class="modal fade" id="updateEndDateModal{{ $salon->subscription->id }}"
                                        tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title"><i class="fa fa-calendar-alt me-2"></i> تعديل
                                                        تاريخ الانتهاء</h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="updateEndDateForm{{ $salon->subscription->id }}"
                                                        action="{{ route('dashboard.subscriptions.update-end-date', $salon->subscription) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label class="form-label">تاريخ الانتهاء الجديد</label>
                                                            <input type="date" name="end_date" class="form-control"
                                                                value="{{ $salon->subscription->end_date?->format('Y-m-d') }}"
                                                                required>
                                                            <div class="form-text">
                                                                التاريخ الحالي:
                                                                <strong>{{ $salon->subscription->end_date?->format('d/m/Y') ?? 'غير محدد' }}</strong>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">إلغاء</button>
                                                    <button type="submit"
                                                        form="updateEndDateForm{{ $salon->subscription->id }}"
                                                        class="btn btn-primary">تحديث</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                {{-- Activate Modal جديد --}}
                                @if ($salon->subscription && $salon->subscription->status === 'suspended')
                                    <div class="modal fade" id="activateModal{{ $salon->subscription->id }}"
                                        tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-success text-white">
                                                    <h5 class="modal-title"><i class="fa fa-check-circle me-2"></i> تأكيد
                                                        التفعيل</h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>هل أنت متأكد من إعادة تفعيل اشتراك {{ $salon->name }}؟ سيتم تفعيل
                                                        الصالون.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">إلغاء</button>
                                                    <form
                                                        action="{{ route('dashboard.subscriptions.activate', $salon->subscription) }}"
                                                        method="POST" style="display:inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success">تفعيل</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">لا توجد صالونات</h5>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4" dir="ltr">
                    {{ $salons->appends(request()->query())->links('pagination::simple-tailwind') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .btn-group .btn {
            border-radius: 0.375rem !important;
            margin: 0 2px;
            padding: 0.375rem 0.75rem;
            transition: all 0.2s ease;
            font-size: 0.875rem;
        }

        .btn-group .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .btn-group .btn i {
            font-size: 1rem;
        }

        .badge {
            font-size: 0.85rem;
            padding: 0.35em 0.65em;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.03);
        }

        .card.shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .bg-primary {
            background-color: #680d48 !important;
        }
    </style>
@endpush

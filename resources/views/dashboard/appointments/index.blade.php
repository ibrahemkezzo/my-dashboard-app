@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.appointments'), 'url' => route('dashboard.appointments.index')],
    ]" :pageName="__('dashboard.appointments')" />
@endsection

@section('content')
    <x-alert-message />
    <div class="container-fluid">
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-2">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h4>{{ $statistics['total'] }}</h4>
                        <p class="mb-0">{{ __('dashboard.total_appointments') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h4>{{ $statistics['scheduled'] }}</h4>
                        <p class="mb-0">{{ __('dashboard.scheduled') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <h4>{{ $statistics['in_progress'] }}</h4>
                        <p class="mb-0">{{ __('dashboard.in_progress') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h4>{{ $statistics['completed'] }}</h4>
                        <p class="mb-0">{{ __('dashboard.completed') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <h4>{{ $statistics['cancelled'] + $statistics['no_show'] }}</h4>
                        <p class="mb-0">{{ __('dashboard.cancelled_no_show') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-secondary text-white">
                    <div class="card-body text-center">
                        <h4>{{ $statistics['payment_completed'] }}</h4>
                        <p class="mb-0">{{ __('dashboard.payment_completed') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="mb-0">{{ __('dashboard.appointments') }}</h5>
                <div class="btn-group" role="group">
                    <a href="{{ route('dashboard.appointments.today') }}" class="btn btn-info">
                        <i class="fa fa-calendar-day"></i> {{ __('dashboard.today') }}
                    </a>
                    <a href="{{ route('dashboard.appointments.upcoming') }}" class="btn btn-warning">
                        <i class="fa fa-calendar-week"></i> {{ __('dashboard.upcoming') }}
                    </a>
                    <a href="{{ route('dashboard.appointments.calendar') }}" class="btn btn-success">
                        <i class="fa fa-calendar-alt"></i> {{ __('dashboard.calendar') }}
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <form method="GET" action="{{ route('dashboard.appointments.index') }}" class="row g-3">
                            <div class="col-md-2">
                                <input type="text" name="search" class="form-control" placeholder="{{ __('dashboard.search') }}" value="{{ $filters['search'] ?? '' }}">
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-control">
                                    <option value="">{{ __('dashboard.all_statuses') }}</option>
                                    <option value="scheduled" {{ ($filters['status'] ?? '') == 'scheduled' ? 'selected' : '' }}>{{ __('dashboard.scheduled') }}</option>
                                    <option value="in_progress" {{ ($filters['status'] ?? '') == 'in_progress' ? 'selected' : '' }}>{{ __('dashboard.in_progress') }}</option>
                                    <option value="completed" {{ ($filters['status'] ?? '') == 'completed' ? 'selected' : '' }}>{{ __('dashboard.completed') }}</option>
                                    <option value="cancelled" {{ ($filters['status'] ?? '') == 'cancelled' ? 'selected' : '' }}>{{ __('dashboard.cancelled') }}</option>
                                    <option value="no_show" {{ ($filters['status'] ?? '') == 'no_show' ? 'selected' : '' }}>{{ __('dashboard.no_show') }}</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="payment_status" class="form-control">
                                    <option value="">{{ __('dashboard.all_payment_statuses') }}</option>
                                    <option value="pending" {{ ($filters['payment_status'] ?? '') == 'pending' ? 'selected' : '' }}>{{ __('dashboard.payment_pending') }}</option>
                                    <option value="partial" {{ ($filters['payment_status'] ?? '') == 'partial' ? 'selected' : '' }}>{{ __('dashboard.partial_payment') }}</option>
                                    <option value="paid" {{ ($filters['payment_status'] ?? '') == 'paid' ? 'selected' : '' }}>{{ __('dashboard.payment_completed') }}</option>
                                    <option value="refunded" {{ ($filters['payment_status'] ?? '') == 'refunded' ? 'selected' : '' }}>{{ __('dashboard.payment_refunded') }}</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="salon_id" class="form-control">
                                    <option value="">{{ __('dashboard.all_salons') }}</option>
                                    @foreach($salons as $salon)
                                        <option value="{{ $salon->id }}" {{ ($filters['salon_id'] ?? '') == $salon->id ? 'selected' : '' }}>{{ $salon->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="user_id" class="form-control">
                                    <option value="">{{ __('dashboard.all_users') }}</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ ($filters['user_id'] ?? '') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="date_from" class="form-control" placeholder="{{ __('dashboard.from_date') }}" value="{{ $filters['date_from'] ?? '' }}">
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="date_to" class="form-control" placeholder="{{ __('dashboard.to_date') }}" value="{{ $filters['date_to'] ?? '' }}">
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">{{ __('dashboard.apply_filters') }}</button>
                                <a href="{{ route('dashboard.appointments.index') }}" class="btn btn-secondary">{{ __('dashboard.clear_filters') }}</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Appointments Table -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('dashboard.appointment_number') }}</th>
                                <th>{{ __('dashboard.user') }}</th>
                                <th>{{ __('dashboard.salon') }}</th>
                                <th>{{ __('dashboard.service') }}</th>
                                <th>{{ __('dashboard.scheduled_datetime') }}</th>
                                <th>{{ __('dashboard.duration') }}</th>
                                <th>{{ __('dashboard.status') }}</th>
                                <th>{{ __('dashboard.payment_status') }}</th>
                                <th>{{ __('dashboard.total_price') }}</th>
                                <th>{{ __('dashboard.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($appointments as $appointment)
                                <tr>
                                    <td>
                                        <strong>{{ $appointment->appointment_number }}</strong>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $appointment->booking->user->url }}" alt="{{ $appointment->booking->user->name }}" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                            <div>
                                                <div>{{ $appointment->booking->user->name }}</div>
                                                <small class="text-muted">{{ $appointment->booking->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div>{{ $appointment->booking->salon->name }}</div>
                                            <small class="text-muted">{{ $appointment->booking->salon->city->name }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div>{{ $appointment->booking->salonSubService->subService->name }}</div>
                                            <small class="text-muted">{{ $appointment->booking->salonSubService->subService->service->name }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div>{{ $appointment->scheduled_datetime->format('M j, Y') }}</div>
                                            <small class="text-muted">{{ $appointment->scheduled_datetime->format('g:i A') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $appointment->duration_minutes }} {{ __('dashboard.min') }}</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $appointment->status_badge_class }}">
                                            {{ $appointment->status_text }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $appointment->payment_status_badge_class }}">
                                            {{ $appointment->payment_status_text }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong>{{ number_format($appointment->total_price, 2) }} {{ __('dashboard.currency') }}</strong>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('dashboard.appointments.show', $appointment) }}" class="btn btn-sm btn-info" title="{{ __('dashboard.view') }}">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('dashboard.appointments.edit', $appointment) }}" class="btn btn-sm btn-warning" title="{{ __('dashboard.edit') }}">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            @if($appointment->canBeInProgress())
                                                <form action="{{ route('dashboard.appointments.in-progress', $appointment) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-info" title="{{ __('dashboard.mark_in_progress') }}">
                                                        <i class="fa fa-play"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            @if($appointment->canBeCompleted())
                                                <form action="{{ route('dashboard.appointments.completed', $appointment) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" title="{{ __('dashboard.mark_completed') }}">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            @if($appointment->canBeCancelled())
                                                <form action="{{ route('dashboard.appointments.cancel', $appointment) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger" title="{{ __('dashboard.cancel') }}" onclick="return confirm('{{ __('dashboard.confirm_cancel_appointment') }}')">
                                                        <i class="fa fa-ban"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            @if(in_array($appointment->status, ['scheduled', 'in_progress']))
                                                <form action="{{ route('dashboard.appointments.no-show', $appointment) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-secondary" title="{{ __('dashboard.mark_no_show') }}">
                                                        <i class="fa fa-user-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        <i class="fa fa-calendar-times fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">{{ __('dashboard.no_appointments_found') }}</h5>
                                        <p class="text-muted">{{ __('dashboard.no_appointments_description') }}</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $appointments->appends(request()->query())->links('pagination::simple-tailwind') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .btn-group .btn {
        margin-right: 2px;
    }

    .table img {
        object-fit: cover;
    }
</style>
@endpush

@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.bookings'), 'url' => route('dashboard.bookings.index')],
    ]" :pageName="__('dashboard.bookings')" />
@endsection

@section('content')
    <x-alert-message />
    <div class="container-fluid">
        <!-- Statistics Cards -->
        <div class="booking-summary mb-4">
            <div class="row">
                <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h4>{{ $statistics['total'] }}</h4>
                            <p class="mb-0 text-white">إجمالي الحجوزات</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <h4>{{ $statistics['pending'] }}</h4>
                            <p class="mb-0 text-white">بانتظار التأكيد</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                    <div class="card bg-info text-white">
                        <div style="padding-right: 7%; padding-left: 7%;" class="card-body text-center">
                            <h4>{{ $statistics['salon_confirmed'] }}</h4>
                            <p class="mb-0 text-white">تم تأكيدها من الصالون</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                    <div class="card bg-success text-white">
                        <div style="padding-right: 7%; padding-left: 7%;" class="card-body text-center">
                            <h4>{{ $statistics['user_confirmed'] }}</h4>
                            <p class="mb-0 text-white">تم تأكيدها من العميل</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body text-center">
                            <h4>{{ $statistics['rejected'] + $statistics['cancelled'] }}</h4>
                            <p class="mb-0 text-white"> ملغية أو مرفوضة </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                    <div class="card bg-info text-white ">
                        <div class="card-body text-center">
                            <h4>{{ $statistics['completed'] }}</h4>
                            <p class="mb-0 text-white">{{ __('dashboard.completed_bookings') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="mb-0">{{ __('dashboard.bookings') }}</h5>
                <a href="{{ route('dashboard.bookings.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> {{ __('dashboard.create_booking') }}
                </a>
            </div>
            <div class="card-body">
                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <form method="GET" action="{{ route('dashboard.bookings.index') }}" class="row g-3">
                            <div class="col-md-2">
                                <input type="text" name="search" class="form-control" placeholder="{{ __('dashboard.search') }}" value="{{ $filters['search'] ?? '' }}">
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-control">
                                    <option value="">{{ __('dashboard.all_statuses') }}</option>
                                    <option value="pending" {{ ($filters['status'] ?? '') == 'pending' ? 'selected' : '' }}>{{ __('dashboard.pending') }}</option>
                                    <option value="salon_confirmed" {{ ($filters['status'] ?? '') == 'salon_confirmed' ? 'selected' : '' }}>{{ __('dashboard.salon_confirmed') }}</option>
                                    <option value="user_confirmed" {{ ($filters['status'] ?? '') == 'user_confirmed' ? 'selected' : '' }}>{{ __('dashboard.user_confirmed') }}</option>
                                    <option value="rejected" {{ ($filters['status'] ?? '') == 'rejected' ? 'selected' : '' }}>{{ __('dashboard.rejected') }}</option>
                                    <option value="cancelled" {{ ($filters['status'] ?? '') == 'cancelled' ? 'selected' : '' }}>{{ __('dashboard.cancelled') }}</option>
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
                                <a href="{{ route('dashboard.bookings.index') }}" class="btn btn-secondary">{{ __('dashboard.clear_filters') }}</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Bookings Table -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('dashboard.booking_number') }}</th>
                                <th>{{ __('dashboard.user') }}</th>
                                <th>{{ __('dashboard.salon') }}</th>
                                <th>{{ __('dashboard.service') }}</th>
                                <th>{{ __('dashboard.preferred_datetime') }}</th>
                                <th>{{ __('dashboard.status') }}</th>
                                <th>{{ __('dashboard.created_at') }}</th>
                                <th>{{ __('dashboard.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                                <tr>
                                    <td>
                                        <strong>{{ $booking->booking_number }}</strong>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $booking->user->url }}" alt="{{ $booking->user->name }}" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                            <div>
                                                <div>{{ $booking->user->name }}</div>
                                                <small class="text-muted">{{ $booking->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div>{{ $booking->salon->name }}</div>
                                            <small class="text-muted">{{ $booking->salon->city->name }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div>{{ $booking->salonSubService->subService->name }}</div>
                                            <small class="text-muted">{{ $booking->salonSubService->subService->service->name }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div>{{ $booking->preferred_datetime->format('M j, Y') }}</div>
                                            <small class="text-muted">{{ $booking->preferred_datetime->format('g:i A') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge {{ $booking->status_badge_class }}">
                                            {{ $booking->status_text }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>
                                            <div>{{ $booking->created_at->format('M j, Y') }}</div>
                                            <small class="text-muted">{{ $booking->created_at->format('g:i A') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('dashboard.bookings.show', $booking) }}"  class="text-blue-500 hover:text-blue-700 me-2" title="{{ __('dashboard.view') }}">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('dashboard.bookings.edit', $booking) }}" class="text-yellow-500 hover:text-yellow-700 me-2"  title="{{ __('dashboard.edit') }}">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            @if($booking->canBeConfirmedBySalon())
                                                <a href="{{ route('dashboard.bookings.salon-confirm-form', $booking) }}" class="me-2" title="{{ __('dashboard.salon_confirm') }}">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                            @endif

                                            @if($booking->canBeConfirmedByUser())
                                                <a href="{{ route('dashboard.bookings.user-confirm-form', $booking) }}" class="me-2" title="{{ __('dashboard.user_confirm') }}">
                                                    <i class="fa fa-user-check"></i>
                                                </a>
                                            @endif

                                            @if($booking->canBeRejected())
                                                <a href="{{ route('dashboard.bookings.reject-form', $booking) }}" class="me-2" title="{{ __('dashboard.reject') }}">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            @endif

                                            @if($booking->canBeCancelled())
                                                {{-- <form action="{{ route('dashboard.bookings.cancel', $booking) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-secondary" title="{{ __('dashboard.cancel') }}" onclick="return confirm('{{ __('dashboard.confirm_cancel_booking') }}')">
                                                        <i class="fa fa-ban"></i>
                                                    </button>
                                                </form> --}}
                                                <form action="{{ route('dashboard.bookings.cancel', $booking)  }}" method="POST" id="destroy-form-{{ $booking->id }}" style="display:none;">
                                                    @csrf
                                                </form>
                                                <a href="#" class="text-red-500 hover:text-red-700" title="{{ __('dashboard.delete') }}" onclick="event.preventDefault(); return confirm('{{ __('dashboard.are_you_sure_delete_user') }}') && document.getElementById('destroy-form-{{ $booking->id }}').submit();">
                                                    <i class="fa fa-ban"></i>
                                                </a>
                                            @endif

                                            @if($booking->canBeCompleted())
                                                <form action="{{ route('dashboard.bookings.complete', $booking)  }}" method="POST" id="complete-form-{{ $booking->id }}" style="display:none;">
                                                    @csrf
                                                </form>
                                                <a href="#" class="text-red-500 hover:text-red-700 ms-2" title="{{ __('dashboard.complete') }}" onclick="event.preventDefault(); return confirm('{{ __('dashboard.confirm_mark_complete') }}') && document.getElementById('complete-form-{{ $booking->id }}').submit();">
                                                    <i class="fa fa-check-circle"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fa fa-calendar-times fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">{{ __('dashboard.no_bookings_found') }}</h5>
                                        <p class="text-muted">{{ __('dashboard.no_bookings_description') }}</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $bookings->appends(request()->query())->links() }}
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
@extends('layouts.dashboard')

@push('styles')
<style>
    .btnl {
    padding: 0rem 1rem;
    font-size: 0.875rem;
}
</style>
@endpush

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.user'), 'url' => route('dashboard.users.index')],
        ['label' => __('dashboard.show'), 'url' => route('dashboard.users.show',$user->id)],
    ]" :pageName="__('dashboard.show_user')" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card tab2-card">
                <div class="card-body">
                    <h4>{{ __('dashboard.user_details') }}</h4>

                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs mb-3" id="userDetailTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="info-tab" data-bs-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="true">
                                <i class="fa fa-user me-2"></i>{{ __('dashboard.user_information') }}
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="activity-tab" data-bs-toggle="tab" href="#activity" role="tab" aria-controls="activity" aria-selected="false">
                                <i class="fa fa-chart-line me-2"></i>{{ __('dashboard.user_activity') }}
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="bookings-tab" data-bs-toggle="tab" href="#bookings" role="tab" aria-controls="bookings" aria-selected="false">
                                <i class="fa fa-calendar me-2"></i>{{ __('dashboard.bookings') }}
                            </a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="userDetailTabContent">
                        <!-- User Information Tab -->
                        <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                            <div class="row">
                                <div class="col-md-4 text-center mb-4">
                                    <div class="user-profile-image">
                                        <img src="{{ $user->url }}" alt="{{ $user->name }}" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                    </div>
                                    <h5 class="mt-3">{{ $user->name }}</h5>
                                    <p class="text-muted">{{ $user->email }}</p>
                                    <div class="user-status">
                                        <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">
                                            {{ $user->is_active ? __('dashboard.active') : __('dashboard.inactive') }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="user-details">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="detail-item mb-3">
                                                    <label class="fw-bold text-muted">{{ __('dashboard.full_name') }}:</label>
                                                    <p>{{ $user->name }}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="detail-item mb-3">
                                                    <label class="fw-bold text-muted">{{ __('dashboard.email_address') }}:</label>
                                                    <p>{{ $user->email }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="detail-item mb-3">
                                                    <label class="fw-bold text-muted">{{ __('dashboard.account_status') }}:</label>
                                                    <p>
                                                        <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">
                                                            {{ $user->is_active ? __('dashboard.active') : __('dashboard.inactive') }}
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="detail-item mb-3">
                                                    <label class="fw-bold text-muted">{{ __('dashboard.email_verified') }}:</label>
                                                    <p>
                                                        <span class="badge bg-{{ $user->email_verified_at ? 'success' : 'warning' }}">
                                                            {{ $user->email_verified_at ? __('dashboard.verified') : __('dashboard.not_verified') }}
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="detail-item mb-3">
                                                    <label class="fw-bold text-muted">{{ __('dashboard.account_created') }}:</label>
                                                    <p>{{ $user->created_at->format('F j, Y \a\t g:i A') }}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="detail-item mb-3">
                                                    <label class="fw-bold text-muted">{{ __('dashboard.last_updated') }}:</label>
                                                    <p>{{ $user->updated_at->format('F j, Y \a\t g:i A') }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="detail-item mb-3">
                                            <label class="fw-bold text-muted">{{ __('dashboard.user_roles') }}:</label>
                                            <div class="mt-2">
                                                @forelse($user->roles as $role)
                                                    <span class="badge bg-primary me-2">{{ $role->name }}</span>
                                                @empty
                                                    <span class="text-muted">{{ __('dashboard.no_roles_assigned') }}</span>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('dashboard.users.edit', $user->id) }}" >
                                            <button class="btn btn-primary">
                                                <i class="fa fa-edit me-2"></i>{{ __('dashboard.edit_user') }}
                                            </button>
                                        </a>
                                        <a href="{{ route('dashboard.users.editRoles', $user->id)}}"  >
                                            <button class="btn btn-info">
                                                <i class="fa fa-users-cog me-2"></i>{{ __('dashboard.manage_roles') }}
                                            </button>
                                        </a>
                                        <form action="{{ route('dashboard.users.toggleStatus', $user) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-{{ $user->is_active ? 'warning' : 'success' }}"
                                                    onclick="return confirm('{{ __('dashboard.are_you_sure_toggle_status') }} {{ $user->is_active ? __('dashboard.deactivate') : __('dashboard.activate') }} {{ __('dashboard.this_user') }}')">
                                                <i class="fa fa-{{ $user->is_active ? 'ban' : 'check' }} me-2"></i>
                                                {{ $user->is_active ? __('dashboard.deactivate') : __('dashboard.activate') }}
                                            </button>
                                        </form>
                                        <form action="{{ route('dashboard.users.destroy', $user) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('{{ __('dashboard.are_you_sure_delete_user') }}')">
                                                <i class="fa fa-trash me-2"></i>{{ __('dashboard.delete_user') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User Activity Tab -->
                        <div class="tab-pane fade" id="activity" role="tabpanel" aria-labelledby="activity-tab">
                            <div class="activity-summary mb-4">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card bg-primary text-white">
                                            <div class="card-body text-center">
                                                <h4>{{ $statistics['total_sessions'] }}</h4>
                                                <p class="mb-0">{{ __('dashboard.total_sessions') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-success text-white">
                                            <div class="card-body text-center">
                                                <h4>{{ $statistics['total_visits'] }}</h4>
                                                <p class="mb-0">{{ __('dashboard.total_page_visits') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-info text-white">
                                            <div class="card-body text-center">
                                                <h4>{{ $statistics['last_session'] ? $statistics['last_session']->started_at->diffForHumans() : __('dashboard.never') }}</h4>
                                                <p class="mb-0">{{ __('dashboard.last_session') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-warning text-white">
                                            <div class="card-body text-center">
                                                <h4>{{ $statistics['device_types_count'] }}</h4>
                                                <p class="mb-0">{{ __('dashboard.device_types') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="user-visits-summary mb-4">
                                <h5 class="mb-3">{{ __('Pages Visited') }}</h5>
                                @if($visitsByPage->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('Page URL') }}</th>
                                                    <th>{{ __('Visit Count') }}</th>
                                                    <th>{{ __('Last Visited') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($visitsByPage as $pageVisit)
                                                    <tr>
                                                        <td>
                                                            <code>{{ $pageVisit->page_url }}</code>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-primary">{{ $pageVisit->visit_count }}</span>
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($pageVisit->last_visited)->diffForHumans() }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-3">
                                        <p class="text-muted">{{ __('No page visits recorded for this user.') }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="recent-visits mb-4">
                                <h5 class="mb-3">{{ __('Recent Page Visits') }}</h5>
                                @if($visits->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('Page URL') }}</th>
                                                    <th>{{ __('Device') }}</th>
                                                    <th>{{ __('Country') }}</th>
                                                    <th>{{ __('Visited At') }}</th>
                                                    <th>{{ __('Time Spent') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($visits as $visit)
                                                    <tr>
                                                        <td>
                                                            <code>{{ $visit->page_url }}</code>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-secondary">{{ ucfirst($visit->session->device_type ?? 'Unknown') }}</span>
                                                        </td>
                                                        <td>{{ $visit->session->country ?? __('Unknown') }}</td>
                                                        <td>{{ $visit->visited_at->format('M j, Y g:i A') }}</td>
                                                        <td>
                                                            @if($visit->time_spent)
                                                                {{ gmdate('H:i:s', $visit->time_spent) }}
                                                            @else
                                                                <span class="text-muted">{{ __('Not recorded') }}</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination for visits -->
                                    @if($visits->hasPages())
                                        {{-- <div class="d-flex justify-content-center mt-3"> --}}
                                            {{-- {{ $visits->links() }} --}}
                                        {{-- </div>
                                    @endif
                                @else
                                    <div class="text-center py-3">
                                        <p class="text-muted">{{ __('No recent visits found for this user.') }}</p>
                                    </div>
                                @endif
                            </div> --}}

                            <div class="sessions-list">
                                <h5 class="mb-3">{{ __('dashboard.recent_sessions') }}</h5>

                                @forelse($sessions as $session)
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <div class="row align-items-center">
                                                <div class="col-md-3">
                                                    <strong>{{ __('dashboard.session_id') }}:</strong>
                                                    <span class="text-muted">{{ Str::limit($session->session_id, 20) }}</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <strong>{{ __('dashboard.device') }}:</strong>
                                                    <span class="badge bg-secondary">{{ ucfirst($session->device_type) }}</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <strong>{{ __('dashboard.country') }}:</strong>
                                                    <span class="text-muted">{{ $session->country ?? __('dashboard.unknown') }}</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <strong>{{ __('dashboard.started') }}:</strong>
                                                    <span class="text-muted">{{ $session->started_at->diffForHumans() }}</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <strong>{{ __('dashboard.duration') }}:</strong>
                                                    <span class="text-muted">
                                                        @php
                                                            $totalSeconds = $session->started_at->diffInSeconds($session->updated_at);
                                                            $hours = floor($totalSeconds / 3600);
                                                            $minutes = floor(($totalSeconds % 3600) / 60);
                                                            $seconds = $totalSeconds % 60;
                                                        @endphp

                                                        @if ($session->started_at && $session->updated_at)
                                                            @if ($hours > 0)
                                                                {{ $hours }}{{ $minutes > 0 || $seconds > 0 ? ':' : '' }}
                                                                @if ($minutes > 0)
                                                                    {{ $minutes }}{{ $seconds > 0 ? '.' : '' }}
                                                                @endif
                                                                @if ($seconds > 0)
                                                                    {{ $seconds }}
                                                                @endif
                                                                {{ __('dashboard.hour') }}
                                                            @else
                                                                {{ $minutes}}{{ $seconds > 0 ? '.' : '' }}
                                                                @if ($seconds > 0)
                                                                    {{$seconds }}
                                                                @endif
                                                                {{  __('dashboard.min')  }}
                                                            @endif
                                                        @else
                                                            {{ __('dashboard.unknown') }}
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="col-md-1">
                                                    <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#visits-{{ $session->id }}">
                                                        <i class="fa fa-chevron-down"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="collapse" id="visits-{{ $session->id }}">
                                            <div class="card-body">
                                                <h6 class="mb-3">{{ __('dashboard.page_visits_in_session') }} ({{ $session->visits->count() }})</h6>
                                                @if($session->visits->count() > 0)
                                                    <div class="table-responsive">
                                                        <table class="table table-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th>{{ __('dashboard.page_url') }}</th>
                                                                    <th>{{ __('dashboard.visited_at') }}</th>
                                                                    <th>{{ __('dashboard.time_spent') }}</th>
                                                                    <th>{{ __('dashboard.last_visited') }}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($session->visits as $visit)
                                                                    <tr>
                                                                        <td>
                                                                            <code>{{ $visit->page_url }}</code>
                                                                        </td>
                                                                        <td>{{ $visit->visited_at->format('M j, Y g:i A') }}</td>
                                                                        <td>
                                                                            @if($visit->time_spent)
                                                                                {{ gmdate('H:i:s', $visit->time_spent) }}
                                                                            @else
                                                                                <span class="text-muted">{{ __('dashboard.not_recorded') }}</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ \Carbon\Carbon::parse($visit->visited_at)->diffForHumans() }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @else
                                                    <p class="text-muted">{{ __('dashboard.no_page_visits_session') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-5">
                                        <i class="fa fa-chart-line fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">{{ __('dashboard.no_activity_found') }}</h5>
                                        <p class="text-muted">{{ __('dashboard.no_activity_description') }}</p>
                                    </div>
                                @endforelse
                                    <div dir="ltr">

                                        <!-- Pagination -->
                                        @if($sessions->hasPages())
                                            <div class="d-flex justify-content-center mt-4">
                                                {{ $sessions->appends(request()->query())->links('pagination::simple-tailwind') }}
                                            </div>
                                        @endif
                                    </div>
                            </div>
                        </div>

                        <!-- User Bookings Tab -->
                        <div class="tab-pane fade" id="bookings" role="tabpanel" aria-labelledby="bookings-tab">
                            <x-dashboard.user-bookings-tab
                                :user="$user"
                                :bookings="$bookings"
                                :statistics="$bookingStatistics"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .user-profile-image img {
        border: 3px solid #e9ecef;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .detail-item label {
        font-size: 0.9rem;
        margin-bottom: 0.25rem;
    }

    .detail-item p {
        margin-bottom: 0;
        font-size: 1rem;
    }

    .activity-summary .card {
        transition: transform 0.2s;
    }

    .activity-summary .card:hover {
        transform: translateY(-2px);
    }

    .sessions-list .card-header {
        background-color: #f8f9fa;
    }

    .sessions-list .collapse {
        border-top: 1px solid #dee2e6;
    }

    .user-visits-summary .table,
    .recent-visits .table {
        font-size: 0.9rem;
    }

    .user-visits-summary code,
    .recent-visits code {
        background-color: #f8f9fa;
        padding: 2px 4px;
        border-radius: 3px;
        font-size: 0.85rem;
    }

    .recent-visits .badge {
        font-size: 0.75rem;
    }

    .nav-tabs .nav-link {
        border: none;
        border-bottom: 2px solid transparent;
        color: #6c757d;
        font-weight: 500;
    }

    .nav-tabs .nav-link.active {
        border-bottom-color: #007bff;
        color: #007bff;
        background: none;
    }

    .nav-tabs .nav-link:hover {
        border-bottom-color: #007bff;
        color: #007bff;
    }

    .collapse-icon {
        transition: transform 0.3s ease;
    }

    .collapsed .collapse-icon {
        transform: rotate(-90deg);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle collapse button icon rotation
    const collapseButtons = document.querySelectorAll('[data-bs-toggle="collapse"]');

    collapseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const icon = this.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-chevron-down');
                icon.classList.toggle('fa-chevron-up');
            }
        });
    });

    // Store active tab in localStorage for better UX
    const tabLinks = document.querySelectorAll('#userDetailTab .nav-link');
    const tabPanes = document.querySelectorAll('.tab-pane');

    // Get tab from URL parameter or stored tab or default to first tab
    const urlParams = new URLSearchParams(window.location.search);
    const tabFromUrl = urlParams.get('tab');
    const activeTab = tabFromUrl || localStorage.getItem('userDetailActiveTab') || 'info';

    // Activate the stored tab
    tabLinks.forEach(link => {
        if (link.getAttribute('href') === '#' + activeTab) {
            link.classList.add('active');
            link.setAttribute('aria-selected', 'true');
        } else {
            link.classList.remove('active');
            link.setAttribute('aria-selected', 'false');
        }
    });

    tabPanes.forEach(pane => {
        if (pane.id === activeTab) {
            pane.classList.add('show', 'active');
        } else {
            pane.classList.remove('show', 'active');
        }
    });

    // Store active tab when clicked
    tabLinks.forEach(link => {
        link.addEventListener('click', function() {
            const targetTab = this.getAttribute('href').substring(1);
            localStorage.setItem('userDetailActiveTab', targetTab);
        });
    });
});
</script>
@endpush

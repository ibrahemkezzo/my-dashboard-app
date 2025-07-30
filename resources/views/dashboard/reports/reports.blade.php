@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.reports'), 'url' => route('dashboard.reports')],
    ]" :pageName="__('dashboard.visit_reports')" />
@endsection

@section('content')
<div class="container-fluid" style="max-height: 90vh; overflow-y: auto;">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('dashboard.filters') }}</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('dashboard.reports') }}">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="time_range" class="form-label">{{ __('dashboard.time_range') }}</label>
                                <select name="time_range" id="time_range" class="form-select">
                                    <option value="7" {{ $timeRange == '7' ? 'selected' : '' }}>{{ __('dashboard.last_7_days') }}</option>
                                    <option value="30" {{ $timeRange == '30' ? 'selected' : '' }}>{{ __('dashboard.last_30_days') }}</option>
                                    <option value="90" {{ $timeRange == '90' ? 'selected' : '' }}>{{ __('dashboard.last_90_days') }}</option>
                                    <option value="custom" {{ $timeRange == 'custom' ? 'selected' : '' }}>{{ __('dashboard.custom_range') }}</option>
                                </select>
                            </div>
                            {{-- <div class="col-md-3">
                                <label for="start_date" class="form-label">{{ __('dashboard.start_date') }}</label>
                                <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" class="form-control" {{ $timeRange != 'custom' ? 'disabled' : '' }}>
                            </div>
                            <div class="col-md-3">
                                <label for="end_date" class="form-label">{{ __('dashboard.end_date') }}</label>
                                <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" class="form-control" {{ $timeRange != 'custom' ? 'disabled' : '' }}>
                            </div> --}}
                            <div class="col-md-3">
                                <label for="device_type" class="form-label">{{ __('dashboard.device_type') }}</label>
                                <select name="device_type" id="device_type" class="form-select">
                                    <option value="">{{ __('dashboard.all_devices') }}</option>
                                    <option value="mobile" {{ $deviceType == 'mobile' ? 'selected' : '' }}>{{ __('dashboard.mobile') }}</option>
                                    <option value="desktop" {{ $deviceType == 'desktop' ? 'selected' : '' }}>{{ __('dashboard.desktop') }}</option>
                                    <option value="tablet" {{ $deviceType == 'tablet' ? 'selected' : '' }}>{{ __('dashboard.tablet') }}</option>
                                    <option value="other" {{ $deviceType == 'other' ? 'selected' : '' }}>{{ __('dashboard.other') }}</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="country" class="form-label">{{ __('dashboard.country') }}</label>
                                <select name="country" id="country" class="form-select">
                                    <option value="">{{ __('dashboard.all_countries') }}</option>
                                    @foreach ($countries as $countryItem)
                                        <option value="{{ $countryItem }}" {{ $country == $countryItem ? 'selected' : '' }}>{{ $countryItem }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">{{ __('dashboard.apply_filters') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Widgets -->
    <div class="row mb-4">
        <div class="col-xxl-4 col-md-6 xl-50">
            <div class="card o-hidden widget-cards">
                <div class="primary-box card-body">
                    <div class="media static-top-widget align-items-center">
                        <div class="icons-widgets">
                            <div class="align-self-center text-center">
                                <i class="fa fa-eye font-primary" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                        <div class="media-body media-doller">
                            <span class="m-0">{{ __('dashboard.total_visits') }}</span>
                            <h3 class="mb-0">{{ $totalVisits }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-xxl-3 col-md-6 xl-50">
            <div class="card o-hidden widget-cards">
                <div class="secondary-box card-body">
                    <div class="media static-top-widget align-items-center">
                        <div class="icons-widgets">
                            <div class="align-self-center text-center">
                                <i class="fa fa-clock font-secondary" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                        <div class="media-body media-doller">
                            <span class="m-0">{{ __('dashboard.avg_time_per_page') }}</span>
                            <h3 class="mb-0">
                                @php $avg = collect($averageTimeSpent)->avg('avg_time_spent'); @endphp
                                {{ number_format($avg, 2) }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="col-xxl-4 col-md-6 xl-50">
            <div class="card o-hidden widget-cards">
                <div class="warning-box card-body">
                    <div class="media static-top-widget align-items-center">
                        <div class="icons-widgets">
                            <div class="align-self-center text-center">
                                <i class="fa fa-globe font-warning" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                        <div class="media-body media-doller">
                            <span class="m-0">{{ __('dashboard.countries') }}</span>
                            <h3 class="mb-0">{{ count($visitsByCountry) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-md-6 xl-50">
            <div class="card o-hidden widget-cards">
                <div class="danger-box card-body">
                    <div class="media static-top-widget align-items-center">
                        <div class="icons-widgets">
                            <div class="align-self-center text-center">
                                <i class="fa fa-mobile font-danger" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                        <div class="media-body media-doller">
                            <span class="m-0">{{ __('dashboard.device_types') }}</span>
                            <h3 class="mb-0">{{ count($visitsByDevice) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trend Chart Placeholder -->
    {{-- <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('dashboard.visit_trend_last_period') }}</h5>
                </div>
                <div class="card-body">
                    <div style="height: 300px;">
                        <!-- Chart.js or ApexCharts can be used here -->
                        <canvas id="visitTrendChart" style="width:100%;height:100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Detailed Tables -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('dashboard.visits_by_page') }}</h5>
                </div>
                <div class="card-body table-responsive" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="bg-primary">
                            <tr>
                                <th>{{ __('dashboard.page_url') }}</th>
                                <th>{{ __('dashboard.visits') }}</th>
                                {{-- <th>{{ __('dashboard.avg_time_seconds') }}</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($visitsByPage as $item)
                                <tr>
                                    <td>{{ $item['page_url'] }}</td>
                                    <td>{{ $item['visit_count'] }}</td>
                                    {{-- <td>
                                        @php
                                            $avg = collect($averageTimeSpent)->firstWhere('page_url', $item['page_url'])['avg_time_spent'] ?? 0;
                                        @endphp
                                        {{ number_format($avg, 2) }}
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('dashboard.visits_by_device') }}</h5>
                </div>
                <div class="card-body table-responsive" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="bg-secondary">
                            <tr>
                                <th>{{ __('dashboard.device_type') }}</th>
                                <th>{{ __('dashboard.visits') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($visitsByDevice as $item)
                                <tr>
                                    <td>{{ ucfirst($item['device_type']) }}</td>
                                    <td>{{ $item['visit_count'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('dashboard.visits_by_country') }}</h5>
                </div>
                <div class="card-body table-responsive" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="bg-success">
                            <tr>
                                <th>{{ __('dashboard.country') }}</th>
                                <th>{{ __('dashboard.visits') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($visitsByCountry as $item)
                                <tr>
                                    <td>{{ $item['country'] ?? __('dashboard.unknown') }}</td>
                                    <td>{{ $item['visit_count'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('dashboard.visits_by_referrer') }}</h5>
                </div>
                <div class="card-body table-responsive" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="bg-info">
                            <tr>
                                <th>{{ __('dashboard.referrer') }}</th>
                                <th>{{ __('dashboard.visits') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($visitsByReferrer as $item)
                                <tr>
                                    <td>{{ $item['referrer'] ?? __('dashboard.direct') }}</td>
                                    <td>{{ $item['visit_count'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('time_range').addEventListener('change', function () {
        const isCustom = this.value === 'custom';
        document.getElementById('start_date').disabled = !isCustom;
        document.getElementById('end_date').disabled = !isCustom;
    });
    // Chart.js example for visit trend (replace with real data)
    if (window.Chart) {
        const ctx = document.getElementById('visitTrendChart').getContext('2d');
        const trendData = @json($visitTrend);
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: trendData.map(item => item.date),
                datasets: [{
                    label: '{{ __('dashboard.visits') }}',
                    data: trendData.map(item => item.visit_count),
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0,123,255,0.1)',
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { x: { display: true }, y: { display: true } }
            }
        });
    }
</script>
@endsection

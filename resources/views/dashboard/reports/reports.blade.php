@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('Reports'), 'url' => route('dashboard.reports')],
    ]" :pageName="__('VISIT REPORTS')" />
@endsection

@section('content')
<div class="container-fluid" style="max-height: 90vh; overflow-y: auto;">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Filters') }}</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('dashboard.reports') }}">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="time_range" class="form-label">{{ __('Time Range') }}</label>
                                <select name="time_range" id="time_range" class="form-select">
                                    <option value="7" {{ $timeRange == '7' ? 'selected' : '' }}>{{ __('Last 7 Days') }}</option>
                                    <option value="30" {{ $timeRange == '30' ? 'selected' : '' }}>{{ __('Last 30 Days') }}</option>
                                    <option value="90" {{ $timeRange == '90' ? 'selected' : '' }}>{{ __('Last 90 Days') }}</option>
                                    <option value="custom" {{ $timeRange == 'custom' ? 'selected' : '' }}>{{ __('Custom Range') }}</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="start_date" class="form-label">{{ __('Start Date') }}</label>
                                <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" class="form-control" {{ $timeRange != 'custom' ? 'disabled' : '' }}>
                            </div>
                            <div class="col-md-3">
                                <label for="end_date" class="form-label">{{ __('End Date') }}</label>
                                <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" class="form-control" {{ $timeRange != 'custom' ? 'disabled' : '' }}>
                            </div>
                            <div class="col-md-3">
                                <label for="device_type" class="form-label">{{ __('Device Type') }}</label>
                                <select name="device_type" id="device_type" class="form-select">
                                    <option value="">{{ __('All Devices') }}</option>
                                    <option value="mobile" {{ $deviceType == 'mobile' ? 'selected' : '' }}>{{ __('Mobile') }}</option>
                                    <option value="desktop" {{ $deviceType == 'desktop' ? 'selected' : '' }}>{{ __('Desktop') }}</option>
                                    <option value="tablet" {{ $deviceType == 'tablet' ? 'selected' : '' }}>{{ __('Tablet') }}</option>
                                    <option value="other" {{ $deviceType == 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="country" class="form-label">{{ __('Country') }}</label>
                                <select name="country" id="country" class="form-select">
                                    <option value="">{{ __('All Countries') }}</option>
                                    @foreach ($countries as $countryItem)
                                        <option value="{{ $countryItem }}" {{ $country == $countryItem ? 'selected' : '' }}>{{ $countryItem }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">{{ __('Apply Filters') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Widgets -->
    <div class="row mb-4">
        <div class="col-xxl-3 col-md-6 xl-50">
            <div class="card o-hidden widget-cards">
                <div class="primary-box card-body">
                    <div class="media static-top-widget align-items-center">
                        <div class="icons-widgets">
                            <div class="align-self-center text-center">
                                <i class="fa fa-eye font-primary" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                        <div class="media-body media-doller">
                            <span class="m-0">{{ __('Total Visits') }}</span>
                            <h3 class="mb-0">{{ $totalVisits }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-md-6 xl-50">
            <div class="card o-hidden widget-cards">
                <div class="secondary-box card-body">
                    <div class="media static-top-widget align-items-center">
                        <div class="icons-widgets">
                            <div class="align-self-center text-center">
                                <i class="fa fa-clock font-secondary" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                        <div class="media-body media-doller">
                            <span class="m-0">{{ __('Avg. Time/Page (s)') }}</span>
                            <h3 class="mb-0">
                                @php $avg = collect($averageTimeSpent)->avg('avg_time_spent'); @endphp
                                {{ number_format($avg, 2) }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-md-6 xl-50">
            <div class="card o-hidden widget-cards">
                <div class="warning-box card-body">
                    <div class="media static-top-widget align-items-center">
                        <div class="icons-widgets">
                            <div class="align-self-center text-center">
                                <i class="fa fa-globe font-warning" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                        <div class="media-body media-doller">
                            <span class="m-0">{{ __('Countries') }}</span>
                            <h3 class="mb-0">{{ count($visitsByCountry) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-md-6 xl-50">
            <div class="card o-hidden widget-cards">
                <div class="danger-box card-body">
                    <div class="media static-top-widget align-items-center">
                        <div class="icons-widgets">
                            <div class="align-self-center text-center">
                                <i class="fa fa-mobile font-danger" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                        <div class="media-body media-doller">
                            <span class="m-0">{{ __('Device Types') }}</span>
                            <h3 class="mb-0">{{ count($visitsByDevice) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trend Chart Placeholder -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Visit Trend (Last Period)') }}</h5>
                </div>
                <div class="card-body">
                    <div style="height: 300px;">
                        <!-- Chart.js or ApexCharts can be used here -->
                        <canvas id="visitTrendChart" style="width:100%;height:100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Tables -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Visits by Page') }}</h5>
                </div>
                <div class="card-body table-responsive" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="bg-primary">
                            <tr>
                                <th>{{ __('Page URL') }}</th>
                                <th>{{ __('Visits') }}</th>
                                <th>{{ __('Avg. Time (s)') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($visitsByPage as $item)
                                <tr>
                                    <td>{{ $item['page_url'] }}</td>
                                    <td>{{ $item['visit_count'] }}</td>
                                    <td>
                                        @php
                                            $avg = collect($averageTimeSpent)->firstWhere('page_url', $item['page_url'])['avg_time_spent'] ?? 0;
                                        @endphp
                                        {{ number_format($avg, 2) }}
                                    </td>
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
                    <h5>{{ __('Visits by Device') }}</h5>
                </div>
                <div class="card-body table-responsive" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="bg-secondary">
                            <tr>
                                <th>{{ __('Device Type') }}</th>
                                <th>{{ __('Visits') }}</th>
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
                    <h5>{{ __('Visits by Country') }}</h5>
                </div>
                <div class="card-body table-responsive" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="bg-success">
                            <tr>
                                <th>{{ __('Country') }}</th>
                                <th>{{ __('Visits') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($visitsByCountry as $item)
                                <tr>
                                    <td>{{ $item['country'] ?? 'Unknown' }}</td>
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
                    <h5>{{ __('Visits by Referrer') }}</h5>
                </div>
                <div class="card-body table-responsive" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="bg-info">
                            <tr>
                                <th>{{ __('Referrer') }}</th>
                                <th>{{ __('Visits') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($visitsByReferrer as $item)
                                <tr>
                                    <td>{{ $item['referrer'] ?? 'Direct' }}</td>
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
                    label: 'Visits',
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
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visit Reports</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Visit Reports</h1>

        <!-- Filters Form -->
        <form method="GET" action="{{ route('reports') }}" class="mb-6 bg-white p-6 rounded-lg shadow-md">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Time Range -->
                <div>
                    <label for="time_range" class="block text-sm font-medium text-gray-700">Time Range</label>
                    <select name="time_range" id="time_range" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="7" {{ $timeRange == '7' ? 'selected' : '' }}>Last 7 Days</option>
                        <option value="30" {{ $timeRange == '30' ? 'selected' : '' }}>Last 30 Days</option>
                        <option value="90" {{ $timeRange == '90' ? 'selected' : '' }}>Last 90 Days</option>
                        <option value="custom" {{ $timeRange == 'custom' ? 'selected' : '' }}>Custom Range</option>
                    </select>
                </div>

                <!-- Custom Date Range -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                    <input type="date" name="start_date" id="start_date" value="{{ $startDate }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" {{ $timeRange != 'custom' ? 'disabled' : '' }}>
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                    <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" {{ $timeRange != 'custom' ? 'disabled' : '' }}>
                </div>

                <!-- Device Type -->
                <div>
                    <label for="device_type" class="block text-sm font-medium text-gray-700">Device Type</label>
                    <select name="device_type" id="device_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">All Devices</option>
                        <option value="mobile" {{ $deviceType == 'mobile' ? 'selected' : '' }}>Mobile</option>
                        <option value="desktop" {{ $deviceType == 'desktop' ? 'selected' : '' }}>Desktop</option>
                        <option value="tablet" {{ $deviceType == 'tablet' ? 'selected' : '' }}>Tablet</option>
                        <option value="other" {{ $deviceType == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <!-- Country -->
                <div>
                    <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                    <select name="country" id="country" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">All Countries</option>
                        @foreach ($countries as $countryItem)
                            <option value="{{ $countryItem }}" {{ $country == $countryItem ? 'selected' : '' }}>{{ $countryItem }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Apply Filters</button>
        </form>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Total Visits -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold">Total Visits</h2>
                <p class="text-2xl">{{ $totalVisits }}</p>
            </div>

            <!-- Average Time Spent -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold">Average Time Spent (seconds)</h2>
                @foreach ($averageTimeSpent as $item)
                    <p>{{ $item['page_url'] }}: {{ number_format($item['avg_time_spent'], 2) }}</p>
                @endforeach
            </div>
        </div>

        <!-- Charts/Data Tables -->
        <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Visits by Page -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold">Visits by Page</h2>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Page URL</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Visits</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($visitsByPage as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item['page_url'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item['visit_count'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Visits by Device -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold">Visits by Device</h2>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Device Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Visits</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($visitsByDevice as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item['device_type'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item['visit_count'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Visits by Country -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold">Visits by Country</h2>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Country</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Visits</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($visitsByCountry as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item['country'] ?? 'Unknown' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item['visit_count'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Visits by Referrer -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold">Visits by Referrer</h2>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Referrer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Visits</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($visitsByReferrer as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item['referrer'] ?? 'Direct' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item['visit_count'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Enable/disable custom date inputs based on time range
        document.getElementById('time_range').addEventListener('change', function () {
            const isCustom = this.value === 'custom';
            document.getElementById('start_date').disabled = !isCustom;
            document.getElementById('end_date').disabled = !isCustom;
        });
    </script>
</body>
</html>

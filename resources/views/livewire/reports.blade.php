<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقارير الموقع</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @livewireStyles
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">تقارير الموقع</h1>

        <!-- Filters -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold mb-4">الفلاتر</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">النطاق الزمني</label>
                    <select wire:model="timeRange" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="7">آخر 7 أيام</option>
                        <option value="30">آخر 30 يومًا</option>
                        <option value="custom">مخصص</option>
                    </select>
                </div>
                @if($timeRange === 'custom')
                    <div>
                        <label class="block text-sm font-medium text-gray-700">من تاريخ</label>
                        <input type="date" wire:model="startDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">إلى تاريخ</label>
                        <input type="date" wire:model="endDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                @endif
                <div>
                    <label class="block text-sm font-medium text-gray-700">نوع الجهاز</label>
                    <select wire:model="deviceType" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">الكل</option>
                        <option value="mobile">موبايل</option>
                        <option value="desktop">ديسكتوب</option>
                        <option value="tablet">تابلت</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">البلد</label>
                    <select wire:model="country" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">الكل</option>
                        @foreach($countries as $countryOption)
                            <option value="{{ $countryOption }}">{{ $countryOption }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Total Visits -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold">إجمالي الزيارات</h2>
            <p class="text-3xl">{{ $totalVisits }}</p>
        </div>

        <!-- Visits by Device -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold">الزيارات حسب الجهاز</h2>
            <ul class="mt-4">
                @foreach($visitsByDevice as $device)
                    <li>{{ $device['device_type'] }}: {{ $device['visit_count'] }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Visits by Country -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold">الزيارات حسب البلد</h2>
            <ul class="mt-4">
                @foreach($visitsByCountry as $country)
                    <li>{{ $country['country'] ?? 'غير معروف' }}: {{ $country['visit_count'] }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Visits by Referrer -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold">الزيارات حسب المصدر</h2>
            <ul class="mt-4">
                @foreach($visitsByReferrer as $referrer)
                    <li>{{ $referrer['referrer'] ?? 'مباشر' }}: {{ $referrer['visit_count'] }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Average Time Spent -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold">متوسط وقت الزيارة</h2>
            <ul class="mt-4">
                @foreach($averageTimeSpent as $time)
                    <li>{{ $time['page_url'] }}: {{ round($time['avg_time_spent']) }} ثانية</li>
                @endforeach
            </ul>
        </div>

        <!-- Top Pages -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold">الصفحات الأكثر زيارة</h2>
            <ul class="mt-4">
                @foreach($visitsByPage as $page)
                    <li>{{ $page['page_url'] }}: {{ $page['visit_count'] }} زيارة</li>
                @endforeach
            </ul>
        </div>

        <!-- Visit Trend Chart -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold">اتجاه الزيارات</h2>
            <canvas id="visitTrendChart" class="mt-4"></canvas>
        </div>
    </div>

    @livewireScripts
    <script>
        document.addEventListener('livewire:load', function () {
            let chart;
            function initChart(data) {
                if (chart) chart.destroy();
                const ctx = document.getElementById('visitTrendChart').getContext('2d');
                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'عدد الزيارات',
                            data: data.values,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            fill: false,
                        }]
                    },
                    options: {
                        scales: {
                            x: { title: { display: true, text: 'التاريخ' } },
                            y: { title: { display: true, text: 'عدد الزيارات' } }
                        }
                    }
                });
            }

            initChart({
                labels: @json(array_column($visitTrend, 'date')),
                values: @json(array_column($visitTrend, 'visit_count'))
            });

            Livewire.on('updateChart', function () {
                initChart({
                    labels: @json(array_column($visitTrend, 'date')),
                    values: @json(array_column($visitTrend, 'visit_count'))
                });
            });
        });

        // Track time spent on page
        let startTime = Date.now();
        window.addEventListener('beforeunload', function () {
            let timeSpent = Math.round((Date.now() - startTime) / 1000);
            fetch('{{ route('visits.time') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    session_id: '{{ session()->getId() }}',
                    page_url: window.location.pathname,
                    time_spent: timeSpent,
                }),
            });
        });
    </script>
</body>
</html>

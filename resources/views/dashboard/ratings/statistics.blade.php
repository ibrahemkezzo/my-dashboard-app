@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('التقييمات'), 'url' => route('dashboard.ratings.index')],
        ['label' => __('إحصائيات'), 'url' => route('dashboard.ratings.statistics')],
    ]" :pageName="__('إحصائيات التقييمات')" />
@endsection

@section('content')
    <x-alert-message />

    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h4>{{ $pendingCount }}</h4>
                        <p class="mb-0">قيد المراجعة</p>
                    </div>
                </div>
            </div>
            <!-- Add more KPI cards here if desired -->
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">أحدث التقييمات</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الصالون</th>
                            <th>المستخدم</th>
                            <th>التقييم</th>
                            <th>الحالة</th>
                            <th>التاريخ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentRatings as $rating)
                            <tr>
                                <td>{{ $rating->id }}</td>
                                <td>{{ $rating->salon->name ?? '#' }} (ID: {{ $rating->salon_id }})</td>
                                <td>{{ $rating->user->name ?? '#' }} (ID: {{ $rating->user_id }})</td>
                                <td>
                                    @for($i=1;$i<=5;$i++)
                                        <i class="fa {{ $i <= $rating->rating ? 'fa-star text-warning' : 'fa-star-o text-muted' }}"></i>
                                    @endfor
                                </td>
                                <td>
                                    <span class="badge {{ $rating->status==='approved'?'bg-success':($rating->status==='rejected'?'bg-danger':'bg-warning') }}">
                                        {{ $rating->status }}
                                    </span>
                                </td>
                                <td>{{ $rating->created_at?->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">لا توجد بيانات</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

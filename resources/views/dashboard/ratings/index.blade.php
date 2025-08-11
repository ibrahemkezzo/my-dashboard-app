@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('التقييمات'), 'url' => route('dashboard.ratings.index')],
    ]" :pageName="__('التقييمات')" />
@endsection

@section('content')
    <x-alert-message />

    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">الحالة</label>
                        <select name="status" class="form-select">
                            <option value="">الكل</option>
                            <option value="pending" {{ request('status')==='pending'?'selected':'' }}>قيد المراجعة</option>
                            <option value="approved" {{ request('status')==='approved'?'selected':'' }}>معتمد</option>
                            <option value="rejected" {{ request('status')==='rejected'?'selected':'' }}>مرفوض</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">معرف الصالون</label>
                        <input type="number" class="form-control" name="salon_id" value="{{ request('salon_id') }}" placeholder="ID">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">معرف المستخدم</label>
                        <input type="number" class="form-control" name="user_id" value="{{ request('user_id') }}" placeholder="ID">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">التقييم</label>
                        <select name="rating" class="form-select">
                            <option value="">الكل</option>
                            @for($i=1;$i<=5;$i++)
                                <option value="{{ $i }}" {{ (string)request('rating')===(string)$i?'selected':'' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> بحث</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">قائمة التقييمات</h5>
                <span class="badge bg-warning">قيد المراجعة: {{ $pendingCount }}</span>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الصالون</th>
                            <th>المستخدم</th>
                            <th>التقييم</th>
                            <th>المراجعة</th>
                            <th>الحالة</th>
                            <th>تاريخ الإنشاء</th>
                            <th class="text-end">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ratings as $rating)
                            <tr>
                                <td>{{ $rating->id }}</td>
                                <td>{{ $rating->salon->name ?? '#' }} (ID: {{ $rating->salon_id }})</td>
                                <td>{{ $rating->user->name ?? '#' }} (ID: {{ $rating->user_id }})</td>
                                <td>
                                    @for($i=1;$i<=5;$i++)
                                        <i class="fa {{ $i <= $rating->rating ? 'fa-star text-warning' : 'fa-star-o text-muted' }}"></i>
                                    @endfor
                                </td>
                                <td style="max-width: 320px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $rating->review }}</td>
                                <td>
                                    <span class="badge {{ $rating->status==='approved'?'bg-success':($rating->status==='rejected'?'bg-danger':'bg-warning') }}">
                                        {{ $rating->status }}
                                    </span>
                                </td>
                                <td>{{ $rating->created_at?->format('Y-m-d H:i') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('dashboard.ratings.edit', $rating) }}" class="btn btn-sm btn-warning ">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('dashboard.ratings.approve', $rating) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-success" onclick="return confirm('اعتماد التقييم؟')"><i class="fa fa-check"></i></button>
                                    </form>
                                    <form action="{{ route('dashboard.ratings.reject', $rating) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('رفض التقييم؟')"><i class="fa fa-times"></i></button>
                                    </form>
                                    <form action="{{ route('dashboard.ratings.destroy', $rating) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('حذف التقييم؟')"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">لا توجد بيانات</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($ratings instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="card-footer d-flex justify-content-center">
                    {{ $ratings->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

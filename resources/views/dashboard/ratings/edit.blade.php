@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('التقييمات'), 'url' => route('dashboard.ratings.index')],
        ['label' => __('تعديل التقييم'), 'url' => route('dashboard.ratings.edit', $rating)],
    ]" :pageName="__('تعديل التقييم #').$rating->id" />
@endsection

@section('content')
    <x-alert-message />

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">تعديل التقييم</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('dashboard.ratings.update', $rating) }}" method="POST" class="row g-3">
                    @csrf
                    @method('PUT')

                    <div class="col-md-4">
                        <label class="form-label">المعرف</label>
                        <input class="form-control" value="{{ $rating->id }}" disabled>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">الصالون</label>
                        <input class="form-control" value="{{ $rating->salon->name ?? '#'}} (ID: {{ $rating->salon_id }})" disabled>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">المستخدم</label>
                        <input class="form-control" value="{{ $rating->user->name ?? '#'}} (ID: {{ $rating->user_id }})" disabled>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">التقييم</label>
                        <select name="rating" class="form-select @error('rating') is-invalid @enderror" required>
                            @for($i=1;$i<=5;$i++)
                                <option value="{{ $i }}" {{ $rating->rating==$i?'selected':'' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        @error('rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">الحالة</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="pending" {{ $rating->status==='pending'?'selected':'' }}>قيد المراجعة</option>
                            <option value="approved" {{ $rating->status==='approved'?'selected':'' }}>معتمد</option>
                            <option value="rejected" {{ $rating->status==='rejected'?'selected':'' }}>مرفوض</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">المراجعة</label>
                        <textarea name="review" rows="4" class="form-control @error('review') is-invalid @enderror" placeholder="نص المراجعة">{{ old('review', $rating->review) }}</textarea>
                        @error('review')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('dashboard.ratings.index') }}" class="btn btn-secondary"><i class="fa fa-times"></i> إلغاء</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

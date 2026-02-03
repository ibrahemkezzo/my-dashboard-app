@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.subscriptions'), 'url' => route('dashboard.subscriptions.index')],
        ['label' => $salon->subscription ? __('dashboard.renew_subscription') : __('dashboard.assign_subscription')],
    ]" :pageName="$salon->subscription ? __('dashboard.renew_subscription') : __('dashboard.assign_subscription')" />
@endsection

@section('content')
    <x-alert-message />
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h4 class="mb-0">
                    {{ $salon->subscription ? 'تجديد اشتراك' : 'اسناد اشتراك جديد' }} - {{ $salon->name }}
                </h4>
                @if($salon->subscription)
                    <div class="alert alert-info mt-3">
                        <i class="fa fa-info-circle me-2"></i>
                        الاشتراك الحالي: <strong>{{ $salon->subscription->plan->name }}</strong>
                        ينتهي في: <strong>{{ $salon->subscription->end_date->format('d/m/Y') }}</strong>
                        <br>التجديد سيضيف الأيام الجديدة على التاريخ الحالي.
                    </div>
                @endif
            </div>
            <div class="card-body">
                <form action="{{ route('dashboard.subscriptions.assign', $salon) }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">{{ __('dashboard.plan') }}</label>
                            <select name="plan_id" class="form-select" required>
                                <option value="">{{ __('dashboard.choose_plan') }}</option>
                                @foreach($plans as $plan)
                                    <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
                                        {{ $plan->name }} ({{ $plan->price }} ريال - {{ $plan->duration_days }} يوم)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ __('dashboard.paid_amount') }} (اختياري)</label>
                            <input type="number" name="paid_amount" class="form-control" step="0.01" value="{{ old('paid_amount') }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">{{ __('dashboard.note') }}</label>
                            <textarea name="note" class="form-control" rows="3">{{ old('note') }}</textarea>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-success">
                            {{ $salon->subscription ? 'تجديد الاشتراك' : 'اسناد الاشتراك' }}
                        </button>
                        <a href="{{ route('dashboard.subscriptions.index') }}" class="btn btn-secondary ms-2">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

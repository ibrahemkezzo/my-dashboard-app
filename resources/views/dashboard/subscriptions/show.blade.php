@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.subscriptions'), 'url' => route('dashboard.subscriptions.index')],
        ['label' => 'تاريخ الاشتراك - ' . $salon->name],
    ]" :pageName="'تاريخ الاشتراك - ' . $salon->name" />
@endsection

@section('content')
    <x-alert-message />
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">تاريخ الاشتراكات والدفعات - {{ $salon->name }}</h5>
                <a href="{{ route('dashboard.subscriptions.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left me-1"></i> رجوع
                </a>
            </div>
            <div class="card-body">
                @if($salon->subscription)
                    <div class="alert alert-info mb-4">
                        <strong>الاشتراك الحالي:</strong> {{ $salon->subscription->plan->name }}
                        <br>بدأ في: {{ $salon->subscription->start_date->format('d/m/Y') }}
                        <br>ينتهي في: {{ $salon->subscription->end_date?->format('d/m/Y') ?? 'غير محدود' }}
                        <br>الحالة: <span class="badge bg-success">{{ __('dashboard.' . $salon->subscription->status) }}</span>
                    </div>
                @else
                    <div class="alert alert-warning mb-4">
                        لا يوجد اشتراك حالي لهذا الصالون.
                    </div>
                @endif

                <h6 class="mb-3">سجل التجديدات والدفعات ({{ $histories->count() }})</h6>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>التاريخ</th>
                                <th>الخطة</th>
                                <th>المدة المضافة</th>
                                <th>المبلغ</th>
                                <th>طريقة الدفع</th>
                                <th>ملاحظات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($histories as $history)
                                <tr>
                                    <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $history->plan->name }}</td>
                                    <td>{{ $history->plan->duration_days }} يوم</td>
                                    <td>{{ number_format($history->paid_amount, 2) }} ريال</td>
                                    <td>{{ $history->payment_method }}</td>
                                    <td>{{ $history->note ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">لا يوجد سجل تجديدات</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <h6 class="mt-5 mb-3">سجل الدفعات ({{ $payments->count() }})</h6>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>التاريخ</th>
                                <th>المبلغ</th>
                                <th>الطريقة</th>
                                <th>معرف الدفع</th>
                                <th>ملاحظات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $payment)
                                <tr>
                                    <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ number_format($payment->amount, 2) }} ريال</td>
                                    <td>{{ $payment->method ?? 'غير محدد' }}</td>
                                    <td>{{ $payment->payment_reference }}</td>
                                    <td>{{ $payment->failure_reason ? $payment->failure_reason : $payment->note ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">لا يوجد دفعات</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

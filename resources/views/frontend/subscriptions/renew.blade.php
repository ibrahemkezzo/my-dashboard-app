{{-- resources/views/frontend/subscriptions/renew.blade.php --}}
@extends('layouts.frontend')

@section('title', 'تجديد الاشتراك | ' . config('app.name_ar'))

@section('main')
    <main>
        <!-- Hero Section -->
        <section class="hero-section" style="background: linear-gradient(135deg, #f56476 0%, #680d48 100%); padding: 120px 0;">
            <div class="container">
                <div class="hero-content text-center text-white">
                    <h1 class="hero-title mb-4">
                        جددي اشتراكك واستمري في التميز
                    </h1>
                    <p class="hero-description fs-5 opacity-90">
                        اختاري خطة التجديد المناسبة واستمري في استقبال الحجوزات بدون انقطاع
                    </p>
                </div>
            </div>
        </section>

        <!-- Current Subscription Info -->
        <section class="py-4 bg-white">
            <div class="container">
                <div class="alert alert-info text-center">
                    <strong>اشتراكك الحالي:</strong> {{ $subscription->plan->name ?? 'فترة تجريبية' }}
                    <br>
                    <strong>ينتهي في:</strong> {{ $subscription->end_date?->format('d/m/Y') ?? 'غير محدد' }}
                    <br>
                    <strong>الحالة:</strong>
                    <span class="badge bg-{{ $subscription->status == 'active' ? 'success' : 'warning' }}">
                        {{ __('dashboard.' . $subscription->status) }}
                    </span>
                </div>
            </div>
        </section>

        <!-- Plans Section -->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="section-header text-center mb-5">
                    <h2 class="section-title">خطط التجديد المتوفرة</h2>
                    <p class="section-description">
                        اختاري الخطة الجديدة، وسيتم إضافة المدة على تاريخ انتهاء اشتراكك الحالي
                    </p>
                </div>

                @if($plans->isEmpty())
                    <div class="alert alert-info text-center">
                        لا توجد خطط مدفوعة متوفرة حاليًا.
                    </div>
                @else
                    <div class="row g-4 justify-content-center">
                        @foreach($plans as $plan)
                            <div class="col-lg-4 col-md-6">
                                <div class="card h-100 shadow-sm border-0 plan-card position-relative overflow-hidden">
                                    @if($plan->id == $subscription->subscription_plan_id)
                                        <div class="ribbon ribbon-top-left">
                                            <span>خطتك الحالية</span>
                                        </div>
                                    @endif
                                    @if($plan->is_popular ?? false)
                                        <div class="ribbon ribbon-top-right">
                                            <span>الأكثر شعبية</span>
                                        </div>
                                    @endif
                                    <div class="card-body text-center p-4">
                                        <h3 class="card-title mb-3">{{ $plan->name }}</h3>
                                        <div class="price mb-4">
                                            <span class="price-amount">{{ number_format($plan->price) }}</span>
                                            <span class="price-currency">ريال</span>
                                            <span class="price-period">/{{ $plan->duration_days }} يوم</span>
                                        </div>
                                        <ul class="list-unstyled mb-4 features-list">
                                            <li><i class="fa fa-check text-success me-2"></i> عدد حجوزات غير محدود</li>
                                            <li><i class="fa fa-check text-success me-2"></i> عرض مميز في البحث</li>
                                            <li><i class="fa fa-check text-success me-2"></i> إدارة مواعيد متقدمة</li>
                                            <li><i class="fa fa-check text-success me-2"></i> دعم فني 24/7</li>
                                            <li><i class="fa fa-check text-success me-2"></i> تقارير مفصلة</li>
                                        </ul>
                                        <form action="{{ route('subscriptions.process_renew', $subscription) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                                جددي بهذه الخطة
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection

@push('styles')
<style>
    .plan-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .plan-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    .price {
        font-size: 2.5rem;
        font-weight: bold;
        color: #680d48;
    }
    .price-amount {
        font-size: 3rem;
    }
    .price-period {
        font-size: 1rem;
        color: #666;
    }
    .features-list li {
        margin-bottom: 0.75rem;
        font-size: 1.1rem;
    }
    .ribbon {
        position: absolute;
        background: #f56476;
        color: white;
        padding: 5px 30px;
        font-weight: bold;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        z-index: 1;
    }
    .ribbon-top-right {
        top: 20px;
        right: -10px;
        transform: rotate(45deg);
    }
    .ribbon-top-left {
        top: 20px;
        left: -10px;
        transform: rotate(-45deg);
    }
</style>
@endpush

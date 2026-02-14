{{-- resources/views/frontend/subscriptions/create.blade.php --}}
@extends('layouts.frontend')

@section('title', 'اختر خطة الاشتراك | ' . config('app.name_ar'))

@section('main')
    <main>

        <!-- Plans Section -->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="section-header text-center mb-5">
                    <h2 class="section-title">خطط الاشتراك المتوفرة</h2>
                    <p class="section-description">
                        اختاري الخطة التي تناسب احتياجات صالونك وابدئي في استقبال الحجوزات فورًا
                    </p>
                </div>

                @if($plans->isEmpty())
                    <div class="alert alert-info text-center">
                        لا توجد خطط مدفوعة متوفرة حاليًا. تواصلي مع الإدارة.
                    </div>
                @else
                    <div class="row g-4 justify-content-center">
                        @foreach($plans as $plan)
                            <div class="col-lg-4 col-md-6">
                                <div class="card h-100 shadow-sm border-0 plan-card position-relative overflow-hidden">
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
                                            <li><i class="fa fa-check text-success me-2"></i> عرض مميز في نتائج البحث</li>
                                            <li><i class="fa fa-check text-success me-2"></i> إدارة كاملة للمواعيد</li>
                                            <li><i class="fa fa-check text-success me-2"></i> دعم فني 24/7</li>
                                            <li><i class="fa fa-check text-success me-2"></i> تقارير وإحصائيات</li>
                                        </ul>
                                        <a href="{{ route('front.subscriptions.payment', $plan) }}" class="btn btn-primary btn-lg w-100">
                                            
                                                اشتركي الآن

                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <!-- Benefits Section (مشابه للـ home) -->
        <section class="py-5">
            <div class="container">
                <div class="section-header text-center mb-5">
                    <h2 class="section-title">لماذا اشتراك مدفوع معنا؟</h2>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="benefit-icon mb-3 mx-auto">
                                <i data-lucide="trending-up" class="icon-large"></i>
                            </div>
                            <h4>زيادة الحجوزات</h4>
                            <p>عرض مميز يجذب المزيد من العميلات</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="benefit-icon mb-3 mx-auto">
                                <i data-lucide="award" class="icon-large"></i>
                            </div>
                            <h4>بناء سمعة قوية</h4>
                            <p>تقييمات وآراء تساعد في التميز</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="benefit-icon mb-3 mx-auto">
                                <i data-lucide="headphones" class="icon-large"></i>
                            </div>
                            <h4>دعم مستمر</h4>
                            <p>فريق دعم جاهز لمساعدتك في أي وقت</p>
                        </div>
                    </div>
                </div>
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
        top: 20px;
        right: -10px;
        background: #f56476;
        color: white;
        padding: 5px 30px;
        transform: rotate(45deg);
        font-weight: bold;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    .icon-large {
        width: 60px;
        height: 60px;
        stroke-width: 1.5;
        color: #f56476;
    }
</style>
@endpush

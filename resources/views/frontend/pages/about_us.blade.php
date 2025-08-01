@extends('layouts.frontend')

@section('title', 'منصة حجز خدمات التجميل | كوافيري | My Kawafir')

@section('main')
<div class="container my-5">
    <!-- Hero Section -->
    <div class="row align-items-center pt-5">
        <div class="col-md-6 col-10">
            <div class="about-hero-content">
                <h1 class="display-4 fw-bold text-dark mb-4 title">عن كوافيري</h1>
                <p class="lead text-muted mb-4">
                    منصة رائدة في المملكة العربية السعودية تربط بين العميلات وأفضل خبيرات التجميل والصالونات المعتمدة، لتوفير تجربة حجز سهلة ومميزة.
                </p>
                <p class="text-muted">
                    نحن نؤمن بأن كل امرأة تستحق أن تشعر بالجمال والثقة، ولذلك نسعى لتوفير أفضل خدمات التجميل والعناية بأعلى معايير الجودة والاحترافية.
                </p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="about-hero-image">
                <img src="https://images.unsplash.com/photo-1516975080664-ed2fc6a32937?ixlib=rb-4.0.3&amp;auto=format&amp;fit=crop&amp;w=500&amp;q=80" alt="كوافيري" class="img-fluid rounded-3 shadow">
            </div>
        </div>
    </div>

    <!-- Customer Reviews Section -->
    <section class="reviews-section">
        <div class="container">
            <!-- Trust Indicators -->
            <div class="trust-indicators mb-5">
                <div class="trust-item">
                    <div class="trust-number">95%</div>
                    <div class="trust-label">معدل الرضا</div>
                </div>
                <div class="trust-item">
                    <div class="trust-number">24/7</div>
                    <div class="trust-label">دعم العملاء</div>
                </div>
                <div class="trust-item">
                    <div class="trust-number">آمن 100%</div>
                    <div class="trust-label">الخصوصية</div>
                </div>
                <div class="trust-item">
                    <div class="trust-number">مجاني</div>
                    <div class="trust-label">إلغاء الحجز</div>
                </div>
            </div>

            <div class="section-header pt-5">
                <h2 class="section-title title">ماذا تقول عميلاتنا؟</h2>
                <p class="section-description">
                    آراء حقيقية من عميلات استخدمن منصتنا وحصلن على تجربة مميزة
                </p>

                <div class="overall-rating">
                    <div class="rating-stars">
                        <i data-lucide="star" class="star filled"></i>
                        <i data-lucide="star" class="star filled"></i>
                        <i data-lucide="star" class="star filled"></i>
                        <i data-lucide="star" class="star filled"></i>
                        <i data-lucide="star" class="star filled"></i>
                    </div>
                    <span class="rating-score">4.9</span>
                    <span class="rating-text">من أصل 5 (أكثر من 1,000 تقييم)</span>
                </div>
            </div>

            <div class="reviews-grid">
                <div class="review-card">
                    <div class="quote-icon">
                        <i data-lucide="quote"></i>
                    </div>
                    <div class="review-rating">
                        <i data-lucide="star" class="star filled"></i>
                        <i data-lucide="star" class="star filled"></i>
                        <i data-lucide="star" class="star filled"></i>
                        <i data-lucide="star" class="star filled"></i>
                        <i data-lucide="star" class="star filled"></i>
                    </div>
                    <p class="review-text">
                        "منصة موثوقة وآمنة. حجزت عدة جلسات مختلفة وكانت كلها ممتازة. أنصح جميع صديقاتي باستخدامها."
                    </p>
                    <div class="review-service">باقة عناية شاملة</div>
                    <div class="reviewer-info">
                        <img src="{{ asset('assets/img/clients/profile.png') }}" alt="مريم العتيبي" class="reviewer-avatar">
                        <div class="reviewer-details">
                            <h4 class="reviewer-name">مريم العتيبي</h4>
                            <div class="reviewer-meta">
                                <span>الرياض</span>
                                <span>•</span>
                                <span>منذ 5 أيام</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="review-card">
                    <div class="quote-icon">
                        <i data-lucide="quote"></i>
                    </div>
                    <div class="review-rating">
                        <i data-lucide="star" class="star filled"></i>
                        <i data-lucide="star" class="star filled"></i>
                        <i data-lucide="star" class="star filled"></i>
                        <i data-lucide="star" class="star filled"></i>
                        <i data-lucide="star" class="star filled"></i>
                    </div>
                    <p class="review-text">
                        "المنصة سهلة الاستخدام والعروض مغرية. حصلت على خصم رائع في أول حجز. الصالون كان نظيف والموظفات محترفات."
                    </p>
                    <div class="review-service">مانيكير وباديكير</div>
                    <div class="reviewer-info">
                        <img src="{{ asset('assets/img/clients/profile.png') }}" alt="هيا السعد" class="reviewer-avatar">
                        <div class="reviewer-details">
                            <h4 class="reviewer-name">رهف الشهري</h4>
                            <div class="reviewer-meta">
                                <span>أبها</span>
                                <span>•</span>
                                <span>منذ أسبوعين</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="review-card">
                    <div class="quote-icon">
                        <i data-lucide="quote"></i>
                    </div>
                    <div class="review-rating">
                        <i data-lucide="star" class="star filled"></i>
                        <i data-lucide="star" class="star filled"></i>
                        <i data-lucide="star" class="star filled"></i>
                        <i data-lucide="star" class="star filled"></i>
                        <i data-lucide="star" class="star filled"></i>
                    </div>
                    <p class="review-text">
                        "خدمة ممتازة من البداية للنهاية. سهولة في الحجز، تأكيد سريع، وجودة عالية في الخدمة. هذا المكان الأفضل لحجز مواعيد التجميل."
                    </p>
                    <div class="review-service">قص وصبغ الشعر</div>
                    <div class="reviewer-info">
                        <img src="{{ asset('assets/img/clients/profile.png') }}" alt="ريما الحربي" class="reviewer-avatar">
                        <div class="reviewer-details">
                            <h4 class="reviewer-name">ريما الحربي</h4>
                            <div class="reviewer-meta">
                                <span>تبوك</span>
                                <span>•</span>
                                <span>منذ 4 أيام</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</div>
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/pages-styles.css') }}">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/assets/js/pages-scripts.js') }}"></script>
@endpush
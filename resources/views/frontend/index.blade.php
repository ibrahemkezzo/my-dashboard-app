@extends('layouts.frontend')

@section('title', 'منصة حجز خدمات التجميل | كوافيري | My Kawafir')

@section('main')
    <main>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-bg-pattern">
                <div class="hero-pattern-circle hero-pattern-1"></div>
                <div class="hero-pattern-circle hero-pattern-2"></div>
                <div class="hero-pattern-circle hero-pattern-3"></div>
            </div>

            <div class="container">
                <div class="hero-content">
                    <h1 class="hero-title">
                        اكتشفي جمالك مع
                        <br>
                        <span class="hero-title-highlight">أفضل خبيرات التجميل</span>
                    </h1>
                    <p class="hero-description">
                        احجزي موعدك مع أفضل صالونات التجميل ومراكز العناية في مدينتك بضغطة واحدة
                    </p>
                </div>

                <!-- Search Bar -->
                <div class="search-bar">
                    <form method="GET" action="{{route('front.salons.list')}}">
                        {{-- @csrf --}}
                        <div class="search-grid">
                            <div class="search-field">
                                <label class="search-label">نوع الخدمة</label>
                                <select class="search-select no-hover-effects" id="serviceType" name="service_type">
                                    <option value="">جميع الخدمات</option>
                                    @foreach($subServices as $subService)
                                        <option value="{{ $subService->name }}" {{ request('service_type') == $subService->name ? 'selected' : '' }}>
                                            {{ $subService->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="search-field">
                                <label class="search-label">المدينة</label>
                                <select class="search-select no-hover-effects" id="city" name="city_id">
                                    <option value="">جميع المدن</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="search-field">
                                <label class="search-label">البحث بالاسم</label>
                                <input type="text" class="search-select no-hover-effects" id="date" name="search" />
                            </div>
                        </div>
                        <button type="submit" class="search-btn">
                            <i data-lucide="search"></i>
                            ابحثي عن أفضل الخيارات
                        </button>
                    </form>
                </div>

                <!-- Stats -->
                <div class="hero-stats">
                    <div class="stat-card">
                        <div class="stat-number">50+</div>
                        <div class="stat-label">خبيرة تجميل</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">1,000+</div>
                        <div class="stat-label">عميلة راضية</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">10+</div>
                        <div class="stat-label">مدينة</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">4.9</div>
                        <div class="stat-label">
                            <i data-lucide="star" class="star-icon"></i>
                            تقييم المنصة
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Categories Section -->
        <section class="categories-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">خدماتنا المتنوعة</h2>
                    <p class="section-description">
                        اكتشفي مجموعة واسعة من خدمات التجميل والعناية المتوفرة على منصتنا
                    </p>
                </div>

                <div class="categories-grid">
                    @php
                        $icons = [
                            'flower-icon',
                            'eyebrow-icon',
                            'zap-icon',
                            'crown-icon',
                            'eye-icon',
                            'palette-icon',
                            'scissors-icon',
                            'sparkles-icon',
                        ];
                        $servicesToShow = $services->take(8);
                    @endphp

                    @foreach ($servicesToShow as $index => $service)
                        <div class="category-card">
                            <div class="category-icon {{ $icons[$index % count($icons)] }}">
                                <img src="{{ asset($service->media[0]->url) }}" style="height: 50px; width: 50px"
                                    alt="Service Image" />
                            </div>
                            <h3 class="category-title">{{ $service->name }}</h3>
                            <p class="category-description">{{ $service->short_description }}</p>
                            <div class="category-services">
                                @foreach ($service->sub_services->take(3) as $sub_service)
                                    <span class="service-tag">{{ $sub_service->name }}</span>
                                @endforeach
                                @if ($service->sub_services->count() > 3)
                                    <span class="service-more">+{{$service->sub_services->count() - 3}} المزيد</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($services->count() > 8)
                    <div class="section-footer">
                        <p class="section-description">
                            <a href="#" style="color: #f56476" class="view-more">عرض المزيد</a>
                        </p>
                    </div>
                @endif

            </div>
        </section>

        <!-- Suggested Salons Section -->
        <section class="salons-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">صالونات مختارة لكِ</h2>
                    <p class="section-description">
                        اكتشفي أفضل صالونات التجميل المُقيمة من قبل عميلاتنا
                    </p>
                </div>
                {{-- start salons list --}}
                <x-frontend.salons-list :limit='4' status="active" promoted="active" />
                {{-- end salons list --}}
                <div class="section-footer">
                    <a href="{{route('front.salons.list')}}" class="btn btn-outline btn-lg">عرض جميع الصالونات</a>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section id="how-it-works" class="how-it-works-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">كيف تعمل منصتنا؟</h2>
                    <p class="section-description">
                        ثلاث خطوات بسيطة للحصول على أفضل خدمات التجميل
                    </p>
                </div>

                <div class="steps-grid">
                    <div class="step-card">
                        <div class="step-icon search-step">
                            <i data-lucide="search"></i>
                            <div class="step-number">1</div>
                        </div>
                        <h3 class="step-title">ابحثي واستكشفي</h3>
                        <p class="step-description">تصفحي عشرات الصالونات والخبيرات المُعتمدات في مدينتك واختاري الأنسب لكِ
                        </p>
                    </div>

                    <div class="step-card">
                        <div class="step-icon calendar-step">
                            <i data-lucide="calendar"></i>
                            <div class="step-number">2</div>
                        </div>
                        <h3 class="step-title">احجزي موعدك</h3>
                        <p class="step-description">اختاري التاريخ والوقت المناسب واحجزي موعدك بضغطة واحدة</p>
                    </div>

                    <div class="step-card">
                        <div class="step-icon star-step">
                            <i data-lucide="star"></i>
                            <div class="step-number">3</div>
                        </div>
                        <h3 class="step-title">استمتعي وقيّمي</h3>
                        <p class="step-description">استمتعي بتجربة مميزة وشاركي تقييمك لمساعدة العميلات الأخريات</p>
                    </div>
                </div>

            </div>
        </section>

        <!-- Customer Reviews Section -->
        <section class="reviews-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">ماذا تقول عميلاتنا؟</h2>
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
                            <img src="{{ asset('assets/img/clients/profile.png') }}" alt="مريم العتيبي"
                                class="reviewer-avatar">
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
                            "المنصة سهلة الاستخدام والعروض مغرية. حصلت على خصم رائع في أول حجز. الصالون كان نظيف والموظفات
                            محترفات."
                        </p>
                        <div class="review-service">مانيكير وباديكير</div>
                        <div class="reviewer-info">
                            <img src="{{ asset('assets/img/clients/profile.png') }}" alt="هيا السعد"
                                class="reviewer-avatar">
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
                            "خدمة ممتازة من البداية للنهاية. سهولة في الحجز، تأكيد سريع، وجودة عالية في الخدمة. هذا المكان
                            الأفضل لحجز مواعيد التجميل."
                        </p>
                        <div class="review-service">قص وصبغ الشعر</div>
                        <div class="reviewer-info">
                            <img src="{{ asset('assets/img/clients/profile.png') }}" alt="ريما الحربي"
                                class="reviewer-avatar">
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

                <!-- Trust Indicators -->
                <div class="trust-indicators">
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
            </div>
        </section>

        <!-- Join Beautician Section -->
        <section class="join-beautician-section">
            <div class="join-bg-pattern">
                <div class="join-pattern-circle join-pattern-1"></div>
                <div class="join-pattern-circle join-pattern-2"></div>
                <div class="join-pattern-circle join-pattern-3"></div>
            </div>

            <div class="container">
                <div class="join-grid">
                    <!-- Left Side - Content -->
                    <div class="join-content">
                        <h2 class="join-title">
                            انضمي كخبيرة تجميل
                            <br>
                            <span class="join-title-sub">وابدئي النجاح معنا</span>
                        </h2>

                        <p class="join-description">
                            هل أنتِ خبيرة تجميل محترفة؟ انضمي إلى منصتنا الرائدة واحصلي على فرص لا محدودة للنمو وزيادة
                            عملائك
                        </p>

                        <div class="benefits-list">
                            <div class="benefit-item">
                                <div class="benefit-icon">
                                    <i data-lucide="users"></i>
                                </div>
                                <div class="benefit-content">
                                    <h3 class="benefit-title">وصول لمئات العميلات</h3>
                                    <p class="benefit-description">اعرضي خدماتك أمام مئات العميلات الباحثات عن خبيرات
                                        التجميل</p>
                                </div>
                            </div>

                            <div class="benefit-item">
                                <div class="benefit-icon">
                                    <i data-lucide="trending-up"></i>
                                </div>
                                <div class="benefit-content">
                                    <h3 class="benefit-title">زيادة في الدخل</h3>
                                    <p class="benefit-description">احصلي على المزيد من الحجوزات وزيدي دخلك الشهري بشكل
                                        ملحوظ</p>
                                </div>
                            </div>

                            <div class="benefit-item">
                                <div class="benefit-icon">
                                    <i data-lucide="calendar"></i>
                                </div>
                                <div class="benefit-content">
                                    <h3 class="benefit-title">إدارة سهلة للمواعيد</h3>
                                    <p class="benefit-description">نظام متطور لإدارة مواعيدك وتنظيم جدولك اليومي بسهولة
                                        تامة</p>
                                </div>
                            </div>

                            <div class="benefit-item">
                                <div class="benefit-icon">
                                    <i data-lucide="award"></i>
                                </div>
                                <div class="benefit-content">
                                    <h3 class="benefit-title">بناء سمعة مهنية</h3>
                                    <p class="benefit-description">احصلي على تقييمات من العميلات وابني سمعة مهنية قوية</p>
                                </div>
                            </div>
                        </div>

                        <div class="join-buttons">
                            <button class="btn btn-white">
                                ابدئي الآن مجاناً
                                <i data-lucide="arrow-left"></i>
                            </button>

                        </div>
                    </div>

                    <!-- Right Side - Stats & Image -->
                    <div class="join-stats">
                        <!-- Stats Cards -->
                        <div class="stats-grid">
                            <div class="stat-card-glass">
                                <div class="stat-number">50+</div>
                                <div class="stat-label">خبيرة مسجلة</div>
                            </div>
                            <div class="stat-card-glass">
                                <div class="stat-number">10K+</div>
                                <div class="stat-label">حجز شهرياً</div>
                            </div>
                            <div class="stat-card-glass">
                                <div class="stat-number">4.9</div>
                                <div class="stat-label">تقييم المنصة</div>
                            </div>
                            <div class="stat-card-glass">
                                <div class="stat-number">95%</div>
                                <div class="stat-label">رضا الخبيرات</div>
                            </div>
                        </div>

                        <!-- Success Story -->
                        <div class="success-story">
                            <h3 class="success-title">قصة نجاح</h3>
                            <div class="success-profile">
                                <img src="{{ asset('assets/img/clients/profile.png') }}" alt="أمل محمد"
                                    class="success-avatar">
                                <div class="success-info">
                                    <div class="success-name">أمل محمد</div>
                                    <div class="success-role">خبيرة مكياج</div>
                                </div>
                            </div>
                            <p class="success-quote">
                                "من يوم سجلت في المنصة قبل 6 شهور، عدد عميلاتي تضاعف 3 مرات، وصار جدول مواعيدي دايم فل!
                                المنصة غيرت مجرى شغلي تمامًا!"
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('frontend/assets/js/pages-scripts.js') }}"></script>
<script src="{{ asset('frontend/assets/js/pages-scripts2.js') }}"></script>

@endpush

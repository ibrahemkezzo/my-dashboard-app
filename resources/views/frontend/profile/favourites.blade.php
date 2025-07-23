@extends('layouts.frontend')

@section('title', 'منصة حجز خدمات التجميل | كوافيري | My Kawafir')

@section('main')
<main class="main-content">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">الصالونات المفضلة</h1>
            <p class="page-subtitle">جميع الصالونات والخبيرات التي أضفتِها لقائمة المفضلة</p>
            <div class="favorites-stats">
                <span class="stat-item">
                    <i class="fas fa-heart"></i>6 صالونات مفضلة
                </span>
            </div>
        </div>

        <section class="main-layout py-4">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 mb-4">
                            <div class="salon-card" data-salon-id="1">
                                <div class="salon-image">
                                    <img src="https://images.unsplash.com/photo-1560066984-138dadb4c035?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="صالون لمسة جمال" onerror="this.src='https://images.unsplash.com/photo-1560066984-138dadb4c035?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80'">

                                    <button class="favorite-btn active" onclick="toggleFavorite(1)">
                                        <i class="bi bi-heart-fill"></i>
                                    </button>

                                </div>

                                <div class="salon-card-content">
                                    <div class="salon-header">
                                        <div>
                                            <h3 class="salon-name">صالون لمسة جمال</h3>
                                        </div>
                                    </div>

                                    <p class="salon-description">صالون راقي يقدم خدمات تصفيف الشعر والمكياج والعناية بالبشرة بأعلى جودة.</p>

                                    <div class="salon-details">
                                        <div class="detail-item">
                                            <span class="detail-icon">💰</span>
                                            <span class="price-category expensive">مرتفع</span>
                                        </div>

                                        <div class="detail-item">
                                            <div class="rating">
                                                <span class="stars">⭐</span>
                                                <span>4.8</span>
                                                <span class="rating-text">(12 تقييم)</span>
                                            </div>
                                        </div>

                                        <div class="detail-item">
                                            <span class="detail-icon">🕒</span>
                                            <span class="salon-working-hours">9:00 ص - 10:00 م</span>
                                        </div>

                                        <div class="detail-item">
                                            <span class="detail-icon">📍</span>
                                            <span>الرياض</span>
                                        </div>
                                    </div>

                                    <div class="salon-actions">
                                        <button class="btn-availability" onclick="checkAvailability(1)">
                                            عرض التوافر
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-4">
                            <div class="salon-card" data-salon-id="1">
                                <div class="salon-image">
                                    <img src="https://images.unsplash.com/photo-1560066984-138dadb4c035?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="صالون لمسة جمال" onerror="this.src='https://images.unsplash.com/photo-1560066984-138dadb4c035?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80'">

                                    <button class="favorite-btn active" onclick="toggleFavorite(1)">
                                        <i class="bi bi-heart-fill"></i>
                                    </button>

                                </div>

                                <div class="salon-card-content">
                                    <div class="salon-header">
                                        <div>
                                            <h3 class="salon-name">صالون بيوتي</h3>
                                        </div>
                                    </div>

                                    <p class="salon-description">صالون راقي يقدم خدمات تصفيف الشعر والمكياج والعناية بالبشرة بأعلى جودة.</p>

                                    <div class="salon-details">
                                        <div class="detail-item">
                                            <span class="detail-icon">💰</span>
                                            <span class="price-category expensive">مرتفع</span>
                                        </div>

                                        <div class="detail-item">
                                            <div class="rating">
                                                <span class="stars">⭐</span>
                                                <span>4.8</span>
                                                <span class="rating-text">(14 تقييم)</span>
                                            </div>
                                        </div>

                                        <div class="detail-item">
                                            <span class="detail-icon">🕒</span>
                                            <span class="salon-working-hours">9:00 ص - 10:00 م</span>
                                        </div>

                                        <div class="detail-item">
                                            <span class="detail-icon">📍</span>
                                            <span>الرياض</span>
                                        </div>
                                    </div>

                                    <div class="salon-actions">
                                        <button class="btn-availability" onclick="checkAvailability(1)">
                                            عرض التوافر
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>

        <!-- Empty State -->
        <div class="empty-state hidden" id="emptyState">
            <i class="fas fa-calendar-times"></i>
            <h4>لا توجد حجوزات</h4>
            <p>ابدئي بحجز موعدك الأول مع إحدى خبيرات التجميل</p>
            <a href="#" class="btn-primary">
                <i class="fas fa-search"></i>تصفح الصالونات
            </a>
        </div>
    </div>
</main>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/pages-styles2.css') }}">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/assets/js/pages-scripts2.js') }}"></script>
@endpush
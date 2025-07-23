@extends('layouts.frontend')

@section('title', 'منصة حجز خدمات التجميل | كوافيري | My Kawafir')

@section('main')
<main class="hairdressers-page">
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            @if(request('hasOffers') == 1)
                <h1>العروض الخاصة</h1>
                <p>إليكِ أفضل العروض من صالونات التجميل في منطقتك</p>
            @else
                <h1>صالونات التجميل المتاحة</h1>
                <p>إليكِ أفضل صالونات التجميل في منطقتك</p>
            @endif
        </div>
    </section>

    <!-- Filters and Controls Section -->
    <section class="filters-controls-section py-4 pb-2">
        <div class="container">
            <div class="row">
                <!-- Search Filters Accordion -->
                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="accordion" id="filtersAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed no-hover-effects" type="button" data-bs-toggle="collapse" data-bs-target="#filtersCollapse" aria-expanded="false" aria-controls="filtersCollapse">
                                    <i class="bi bi-funnel-fill ms-2"></i>
                                    فلاتر البحث
                                </button>
                            </h2>
                            <div id="filtersCollapse" class="accordion-collapse collapse" data-bs-parent="#filtersAccordion">
                                <div class="accordion-body">
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">البحث</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control no-hover-effects" id="searchInput" placeholder="ابحثي عن صالون أو خدمة...">
                                                <button class="btn btn-primary" type="button" id="searchButton">
                                                    <i class="bi bi-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-lg-4 col-md-4">
                                            <label class="form-label fw-semibold">نوع الخدمة</label>
                                            <select class="form-select no-hover-effects" id="serviceType">
                                                <option value="">جميع الخدمات</option>

                                            </select>
                                        </div>
                                        <div class="col-lg-4 col-md-4">
                                            <label class="form-label fw-semibold">المدينة</label>
                                            <select class="form-select no-hover-effects" id="city">
                                                <option value="">جميع المدن</option>

                                            </select>
                                        </div>
                                        <div class="col-lg-4 col-md-4">
                                            <label class="form-label fw-semibold">تاريخ الحجز</label>
                                            <input type="date" class="form-control no-hover-effects" id="date" />
                                        </div>
                                        <div class="col-lg-4 col-md-4 d-none">
                                            <label class="form-label fw-semibold">نطاق السعر</label>
                                            <select class="form-select no-hover-effects" id="priceRange">
                                                <option value="">جميع الأسعار</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sort By -->
                <div class="col-lg-3 col-md-6 col-6 mb-3">
                    <select class="form-select no-hover-effects" id="sortBy">
                        <option value="">ترتيب حسب</option>
                        <option value="lowest-price">الأسعار الأقل</option>
                        <option value="highest-price">الأسعار الأعلى</option>
                        <option value="highest-rating">التقييم الأعلى</option>
                        <option value="lowest-rating">التقييم الأقل</option>
                        <option value="certified">الصالونات المعتمدة</option>
                        <option value="home-based">خدمات منزلية</option>
                    </select>
                </div>

                <!-- Price Filter -->
                <div class="col-lg-3 col-md-6 col-6 mb-3">
                    <select class="form-select no-hover-effects" id="priceFilter">
                        <option value="">تصفية السعر</option>
                        <option value="50-200">50 - 200 ريال</option>
                        <option value="200-500">200 - 500 ريال</option>
                        <option value="500-1000">500 - 1000 ريال</option>
                        <option value="1000+">1000+ ريال</option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <!-- Results Count -->
    <section class="results-section py-2">
        <div class="container">
            <div class="results-info">
                <span class="fw-semibold">النتائج المتاحة: <span id="resultsCount" class="text-danger">12</span> صالون</span>
            </div>
        </div>
    </section>

    <!-- Main Layout -->
    <section class="main-layout py-4">
        <div class="container">
            <div class="row">
                <!-- Main Content - First on mobile -->
                <div class="col-lg-8 order-1 mb-4">
                    <div class="salons-grid" id="salonsGrid">
                        @foreach($salons ?? [] as $salon)
                            @include('components.frontend.salon-card', ['salon' => $salon])
                        @endforeach
                    </div>
                </div>

                <!-- Sidebar - Second on mobile -->
                <div class="col-lg-4 order-2">
                    <div class="sidebar">
                        <!-- Map -->
                        <div class="sidebar-section">
                            <h5 class="fw-semibold mb-3">عرض على الخريطة</h5>
                            <div class="map-container">
                                <div id="map" class="map-placeholder">
                                    <i class="bi bi-geo-alt-fill fs-1 text-muted"></i>
                                    <p class="text-muted mt-2">خريطة جوجل</p>
                                </div>
                            </div>
                        </div>

                        <!-- Special Offers -->
                        <div class="sidebar-section">
                            <h5 class="fw-semibold mb-3">العروض الخاصة</h5>
                            <div class="offers-filter">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="hasOffers" name="hasOffers" {{ request('hasOffers') == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="hasOffers">
                                        صالونات بعروض خاصة
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="newClient">
                                    <label class="form-check-label" for="newClient">
                                        خصم العميل الجديد
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="packages">
                                    <label class="form-check-label" for="packages">
                                        باقات مخفضة
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/list.css') }}">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/assets/js/list.js') }}"></script>
    <script>
        // تعريف المسار في Blade
        window.routes = {
            salonShow: "{{ route('front.salons.show', ':id') }}"
        };
    </script>
@endpush
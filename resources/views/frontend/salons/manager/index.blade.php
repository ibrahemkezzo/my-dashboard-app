@extends('layouts.frontend')

@section('title', config('app.name') . ' | ' . config('app.name_ar') . 'منصة حجز خدمات التجميل | ')

@section('main')
    <main class="main-content">
        <div class="container">
            <div class="page-header">
                <h1 class="page-title">إدارة الصالون</h1>
                <p class="page-subtitle">تحكم كامل في بيانات الصالون، الخدمات، الصور، والحجوزات</p>
            </div>
            <div class="card tab2-card">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-4" id="salonManagerTabs">
                        <li class="nav-item">
                            <a class="nav-link{{ $tab == 'info' ? ' active' : '' }}" href="?tab=info">بيانات الصالون</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link{{ $tab == 'services' ? ' active' : '' }}" href="?tab=services">
                                @if ($salon->sub_services_count == 0)
                                    <i class="fas fa-exclamation-circle" style=" color: #87365b; margin-left: 0.5rem;"></i>
                                @endif
                                الخدمات المقدمة

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link{{ $tab == 'gallery' ? ' active' : '' }}" href="?tab=gallery">معرض الصور</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link{{ $tab == 'bookings' ? ' active' : '' }}" href="?tab=bookings">الحجوزات</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade{{ $tab == 'info' ? ' show active' : '' }}" id="info">
                            @include('frontend.salons.manager._info', ['salon' => $salon])
                        </div>
                        <div class="tab-pane fade{{ $tab == 'services' ? ' show active' : '' }}" id="services">
                            @include('frontend.salons.manager._services', [
                                'salon' => $salon,
                                'services' => $services,
                            ])
                        </div>
                        <div class="tab-pane fade{{ $tab == 'gallery' ? ' show active' : '' }}" id="gallery">
                            @include('frontend.salons.manager._gallery', ['salon' => $salon])
                        </div>
                        <div class="tab-pane fade{{ $tab == 'bookings' ? ' show active' : '' }}" id="bookings">
                            @include('frontend.salons.manager._bookings', [
                                'salon' => $salon,
                                'bookings' => $bookings,
                                'statistics' => $statistics,
                            ])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/pages-styles2.css?v=1.0.1') }}">
    <style>
    .no-wrap-date {
        white-space: nowrap;
    }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/assets/js/pages-scripts2.js') }}"></script>
@endpush

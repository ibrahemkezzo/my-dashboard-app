@extends('layouts.frontend')

@section('title', 'منصة حجز خدمات التجميل | كوافيري | My Kawafir')

@section('main')
    <main class="main-content">
        <div class="container">
            <div class="page-header">
                <h1 class="page-title">حجوزاتي</h1>
                <p class="page-subtitle">إدارة جميع حجوزاتك والاطلاع على تاريخ المواعيد</p>
            </div>

            <!-- Booking Tabs -->
            <div class="booking-tabs" id="bookingTabs">
                <button class="booking-tab active" data-tab="current">
                    <i class="fas fa-clock"></i>الحجوزات الحالية
                </button>
                <button class="booking-tab" data-tab="past">
                    <i class="fas fa-history"></i>الحجوزات السابقة
                </button>
                {{-- <a href="{{ route('front.profile.bookings.create') }}" class="btn btn-primary float-end">
                <i class="fas fa-plus"></i> حجز جديد
            </a> --}}
            </div>

            <div class="tab-content">
                <!-- Current Bookings -->
                <div class="tab-pane active" id="current">
                    <div class="bookings-grid">
                        @php

                            $now = now();
                            $currentBookings = $bookings->filter(
                                fn($b) => in_array($b->status, ['pending', 'salon_confirmed', 'user_confirmed']) &&
                                    $b->preferred_datetime >= $now,
                            );
                        @endphp
                        @forelse($currentBookings as $booking)
                            <div class="booking-card">
                                <div class="booking-status">
                                    <span class="status-badge {{ $booking->status_badge_class }}">
                                        <i
                                            class="fas fa-{{ $booking->status === 'pending' ? 'hourglass-half' : ($booking->status === 'salon_confirmed' ? 'check' : 'check-double') }}-circle"></i>
                                        {{ $booking->status_text }}
                                    </span>
                                </div>
                                <div class="booking-header">
                                    <div class="salon-image">
                                        <img src="{{ $booking->salon->cover_image_url ?? asset('frontend/assets/img/clients/default.png') }}"
                                            alt="{{ $booking->salon->name }}">
                                    </div>
                                    <div class="salon-info">
                                        <h5 class="salon-name">{{ $booking->salon->name }}</h5>
                                        <div class="salon-rating">
                                            <span class="stars">★★★★★</span>
                                            <span class="rating-text">({{ $booking->salon->rating ?? '4.5' }})</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="booking-details">
                                    <div class="detail-row">
                                        <i class="fas fa-calendar detail-icon"></i>
                                        <span>{{ $booking->preferred_datetime->translatedFormat('l، j F Y') }}</span>
                                    </div>
                                    <div class="detail-row">
                                        <i class="fas fa-clock detail-icon"></i>
                                        <span>{{ $booking->preferred_datetime->format('g:i A') }}</span>
                                    </div>
                                    <div class="detail-row">
                                        <i class="fas fa-cut detail-icon"></i>
                                        <span>{{ $booking->salonSubService->subService->name }}</span>
                                        @isset($booking->rejection_reason)
                                         <span>{{ $booking->rejection_reason }}</span>
                                        @endisset
                                    </div>
                                    <div class="detail-row">
                                        <i class="fas fa-money-bill-wave detail-icon"></i>
                                        <span class="price">{{ $booking->final_price }} ريال</span>
                                    </div>
                                </div>
                                <div class="booking-actions">
                                    @if ($booking->canBeCancelled())
                                        <form action="{{ route('front.profile.bookings.cancel', $booking->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            <button class="btn-action cancel" type="submit">
                                                <i class="fas fa-times"></i>إلغاء
                                            </button>
                                        </form>
                                    @endif
                                    @if ($booking->canBeConfirmedByUser())
                                        {{-- <a href="{{ route('front.profile.bookings.confirm', $booking) }}" class="btn-action confirm">
                                        <i class="fas fa-check"></i>تأكيد
                                    </a> --}}
                                        <form action="{{ route('front.profile.bookings.confirm', $booking) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            <input class="form-check-input" type="hidden" name="action" value="confirm">

                                            <button class="btn-primo btn-aoutlin-primary confirm" type="submit">
                                                <i class="fas fa-check"></i>تثبيت الحجز
                                            </button>
                                        </form>
                                    @endif
                                    @if ($booking->canBeCompleted())
                                        <form action="{{ route('front.profile.bookings.completed', $booking) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="action" value="completed">
                                            <button type="submit" class="btn-primo confirm">مكتمل</button>
                                        </form>
                                    @endif
                                    {{-- @if ($booking->canBeRejected())
                                        <a href="{{ route('front.profile.bookings.edit', $booking) }}"
                                            class="btn-action modify">
                                            <i class="fas fa-edit"></i>تعديل
                                        </a>
                                    @endif --}}
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">لا توجد حجوزات حالية</h5>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Past Bookings -->
                <div class="tab-pane" id="past">
                    <div class="bookings-grid">
                        @php
                            $pastBookings = $bookings->filter(
                                fn($b) => !in_array($b->status, ['pending', 'salon_confirmed', 'user_confirmed']) ||
                                    $b->preferred_datetime < $now,
                            );
                        @endphp
                        @forelse($pastBookings as $booking)
                            <div class="booking-card">
                                <div class="booking-status">
                                    <span class="status-badge {{ $booking->status_badge_class }}">
                                        <i
                                            class="fas fa-{{ $booking->status === 'completed' ? 'check-double' : ($booking->status === 'cancelled' ? 'times' : 'ban') }}-circle"></i>
                                        {{ $booking->status_text }}
                                    </span>
                                     @isset($booking->rejection_reason)
                                        <span style="color: red" class="me-3 mt-5">{{ $booking->rejection_reason }}</span>
                                    @endisset
                                </div>
                                <div class="booking-header">
                                    <div class="salon-image">
                                        <img src="{{ $booking->salon->cover_image_url ?? asset('frontend/assets/img/clients/default.png') }}"
                                            alt="{{ $booking->salon->name }}">
                                    </div>
                                    <div class="salon-info">
                                        <h5 class="salon-name">{{ $booking->salon->name }}</h5>
                                        <div class="salon-rating">
                                            <span class="stars">★★★★★</span>
                                            <span class="rating-text">({{ $booking->salon->rating ?? '4.5' }})</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="booking-details">
                                    <div class="detail-row">
                                        <i class="fas fa-calendar detail-icon"></i>
                                        <span>{{ $booking->preferred_datetime->translatedFormat('l، j F Y') }}</span>
                                    </div>
                                    <div class="detail-row">
                                        <i class="fas fa-clock detail-icon"></i>
                                        <span>{{ $booking->preferred_datetime->format('g:i A') }}</span>
                                    </div>
                                    <div class="detail-row">
                                        <i class="fas fa-cut detail-icon"></i>
                                        <span>{{ $booking->salonSubService->subService->name }}</span>

                                    </div>
                                    <div class="detail-row">
                                        <i class="fas fa-money-bill-wave detail-icon"></i>
                                        <span class="price">{{ $booking->final_price }} ريال</span>
                                    </div>
                                </div>
                                <div class="booking-actions">

                                    <a href="{{ route('front.salons.show', $booking->salon->id) }}"
                                        class="btn-action re-book">
                                        <i class="fas fa-redo"></i>حجز مرة أخرى
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">لا توجد حجوزات سابقة</h5>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            @if ($bookings->isEmpty())
                <div class="empty-state" id="emptyState">
                    <i class="fas fa-calendar-times"></i>
                    <h4>لا توجد حجوزات</h4>
                    <p>ابدئي بحجز موعدك الأول مع إحدى خبيرات التجميل</p>
                    <a href="{{ route('front.salons.list') }}" class="btn-primary">
                        <i class="fas fa-search"></i>تصفح الصالونات
                    </a>
                </div>
            @endif
        </div>
    </main>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/pages-styles2.css') }}">
    <style>
        .btn-primo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: var(--radius-small);
            border: 1px solid;
            background: var(--blue);
            cursor: pointer;
            transition: var(--transition);
            font-family: inherit;
            font-size: 0.875rem;
            font-weight: 500;
            color: blue;
        }

        .btn-primo.confirm {
            color: var(--success-color);
            border-color: #198754;
        }

        .btn-primo.confirm:hover {
            background: var(--success-color);
            color: var(--white);
        }

        .btn-action.re-book {
            color: var(--primary-border);
            border-color: var(--primary-border);
        }

        .btn-action.re-book:hover {
            background: var(--primary-border);
            color: var(--white);
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/assets/js/pages-scripts2.js') }}"></script>
@endpush

@extends('layouts.frontend')

@section('title', 'منصة حجز خدمات التجميل | كوافيري | My Kawafir')

@section('main')
    <!-- Breadcrumb -->
    <div class="bg-light py-3 pt-5">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('front.home') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('front.salons.list') }}">الصالونات المتاحة</a></li>
                    <li class="breadcrumb-item active" aria-current="page">صالون الجمال الراقي</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container my-5">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Salon Header -->

                <div class="salon-profile-header mb-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h1 class="h2 fw-bold text-dark title">
                            @if ($salon->logo)
                                <img src="{{ $salon->logo_url }}" alt="logo" class="me-3 ms-3"
                                    style="width:60px;height:60px;object-fit:cover;border-radius:50%;">
                            @else
                                <div
                                    style="width:150px;height:150px;background:#f0f0f0;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto;">
                                    <i class="fa fa-building fa-3x text-muted"></i>
                                </div>
                            @endif
                            {{ $salon->name }}

                        </h1>
                        <div class="d-flex gap-2">
                            <div class="text-center">
                                <button class="btn btn-primary px-5" id="bookNowBtn" data-bs-toggle="modal"
                                    data-bs-target="#bookingModal">
                                    <i class="fas fa-calendar-check me-2"></i>احجز الآن
                                </button>
                            </div>

                            <button class="btn-icon-outline" id="favoriteBtn" title="إضافة للمفضلة">
                                <i class="far fa-heart"></i>
                            </button>
                            <button class="btn-icon-outline" id="shareBtn" title="مشاركة الرابط">
                                <i class="fas fa-share"></i>
                            </button>
                        </div>
                    </div>

                    <div class="salon-meta mb-3">
                        <p class="text-muted mb-2">
                            <i class="fas fa-map-marker-alt ms-2"></i>
                            {{ $salon->city->name }} - {{ $salon->address }}
                        </p>
                        <div class="d-flex align-items-center gap-3">
                            <div class="rating">
                                <span class="stars text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </span>
                                <span class="ms-2">4.8 (24 تقييم)</span>
                            </div>
                            <span class="badge bg-success">مركز معتمد</span>
                        </div>
                    </div>
                </div>

                <!-- Image Gallery -->
                <div class="salon-gallery mb-4">
                    <div id="salonCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ $salon->cover_image_url }}" class="d-block w-100 salon-gallery-image"
                                    alt="صالون 1">
                            </div>
                            @foreach ($salon->media as $photo)
                                <div class="carousel-item">
                                    <img src="{{ $photo->url }}" class="d-block w-100 salon-gallery-image" alt="صالون 2">
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#salonCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#salonCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>

                <!-- Description -->
                <div class="salon-description mb-4">
                    <h3 class="h5 fw-semibold mb-3">وصف الصالون</h3>
                    <p class="text-muted">
                        {{ $salon->description }}
                    </p>
                    @if ($salon->working_hours)
                        <div class="mt-3">
                            <h3 class="h5 fw-semibold mb-3">أوقات الدوام</h3>
                            <div class="row">
                                @foreach ($salon->working_hours as $day => $times)
                                    <div class="col-md-6 mt-3 row">
                                        <strong class="col-md-3 ms-2">{{ __('dashboard.' . $day) }} : </strong>
                                        @if (isset($times['closed']) && $times['closed'])
                                            <span class="col-md-3 badge bg-danger me-2">مغلق</span>
                                        @else
                                            @php
                                                try {
                                                    $open = \Carbon\Carbon::createFromFormat('H:i', $times['open']);
                                                    $close = \Carbon\Carbon::createFromFormat('H:i', $times['close']);
                                                    $formattedTime =
                                                        'من ' .
                                                        $open->format('h:i') .
                                                        ' ' .
                                                        ($open->format('A') == 'AM' ? 'صباحًا' : 'مساءً') .
                                                        ' إلى ' .
                                                        $close->format('h:i') .
                                                        ' ' .
                                                        ($close->format('A') == 'AM' ? 'صباحًا' : 'مساءً');
                                                } catch (\Exception $e) {
                                                    $formattedTime = 'وقت غير صالح';
                                                }
                                            @endphp
                                            <span class="col-md-8">
                                                {{ $formattedTime }}
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Services Table -->
                <div class="services-table mb-4">
                    <h3 class="h5 fw-semibold mb-3">الخدمات والأسعار</h3>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>الخدمة</th>
                                    <th>الوصف</th>
                                    <th>المدة</th>
                                    <th>السعر</th>
                                    <th>الحالة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($salon->subServices as $service)
                                    <tr>
                                        <td>{{ $service->service->name }}</td>
                                        <td>{{ $service->name }}</td>
                                        <td>{{ $service->pivot->duration }}</td>
                                        <td>{{ $service->pivot->price }}</td>
                                        <td>{{ $service->pivot->status ? 'متوفرة' : 'غير متوفرة' }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="table-warning">باقة العروس</td>
                                    <td class="table-warning">باقة شاملة للعروس تشمل جميع الخدمات</td>
                                    <td class="table-warning">4 ساعات</td>
                                    <td class="table-warning">500 ريال</td>
                                    <td class="table-warning"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Features -->
                <div class="salon-features mb-4">
                    <h3 class="h5 fw-semibold mb-3">مميزات الصالون</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check text-success ms-2"></i>خبيرات معتمدات</li>
                                <li class="mb-2"><i class="fas fa-check text-success ms-2"></i>منتجات عالمية</li>
                                <li class="mb-2"><i class="fas fa-check text-success ms-2"></i>أدوات معقمة</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check text-success ms-2"></i>مواعيد مرنة</li>
                                <li class="mb-2"><i class="fas fa-check text-success ms-2"></i>زيارة منزلية متاحة</li>
                                <li class="mb-2"><i class="fas fa-check text-success ms-2"></i>أسعار تنافسية</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Book Now Button -->
                <div class="text-center py-4">
                    <button class="btn btn-primary btn-lg px-5" id="bookNowBtn" data-bs-toggle="modal"
                        data-bs-target="#bookingModal">
                        <i class="fas fa-calendar-check me-2"></i>احجز الآن
                    </button>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Map -->
                <div class="sidebar-section mb-4">
                    <h5 class="fw-semibold mb-3">الموقع</h5>
                    <div class="map-container">
                        <div class="map-placeholder">
                            <i class="fas fa-map-marker-alt fa-3x text-muted mb-2"></i>
                            <p class="text-muted mb-0">خريطة موقع الصالون</p>
                        </div>
                    </div>
                </div>

                <!-- Quality Metrics -->
                <div class="sidebar-section mb-4">
                    <h5 class="fw-semibold mb-3">تقييم الخدمات</h5>
                    <div class="quality-metric mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-sm">جودة الخدمة</span>
                            <span class="text-sm fw-semibold">95%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" style="width: 95%"></div>
                        </div>
                    </div>
                    <div class="quality-metric mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-sm">أداء الموظفات</span>
                            <span class="text-sm fw-semibold">92%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-info" style="width: 92%"></div>
                        </div>
                    </div>
                    <div class="quality-metric">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-sm">الراحة والنظافة</span>
                            <span class="text-sm fw-semibold">98%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" style="width: 98%; background-color: #F56476;"></div>
                        </div>
                    </div>
                </div>
                <div class="sidebar-section mb-4">
                    <div class="form-section">
                        <h5 class="fw-semibold mb-3">
                            <i class="fas fa-star ms-2" style="color: #F56476"></i>المميزات المتوفرة
                        </h5>
                        <div class="row">
                            @if (isset($salon->features['parking']))
                                <div class="quality-metric col-md-6 mb-3">
                                    <i style="color: #6c757d" class="fas fa-car ms-2"></i>
                                    <span>موقف سيارات</span>
                                </div>
                            @endif
                            @if (isset($salon->features['wifi']))
                                <div class="quality-metric col-md-6 mb-3">
                                    <i style="color: #6c757d" class="fas fa-wifi ms-2"></i>
                                    <span>واي فاي مجاني</span>
                                </div>
                            @endif
                            @if (isset($salon->features['ac']))
                                <div class="quality-metric col-md-6 mb-3">
                                    <i style="color: #6c757d" class="fas fa-snowflake ms-2"></i>
                                    <span>تكييف</span>
                                </div>
                            @endif
                            @if (isset($salon->features['waiting-area']))
                                <div class="quality-metric col-md-6 mb-3">
                                    <i style="color: #6c757d" class="fas fa-couch ms-2"></i>
                                    <span>منطقة انتظار</span>
                                </div>
                            @endif
                            @if (isset($salon->features['refreshments']))
                                <div class="quality-metric col-md-6 mb-3">
                                    <i style="color: #6c757d" class="fas fa-coffee ms-2"></i>
                                    <span>مشروبات مجانية</span>
                                </div>
                            @endif
                            @if (isset($salon->features['child-care']))
                                <div class="quality-metric col-md-6 mb-3">
                                    <i style="color: #6c757d" class="fas fa-baby ms-2"></i>
                                    <span>رعاية أطفال</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="sidebar-section mb-4">
                    <div class="form-section">
                        <h5 class="fw-semibold mb-3">
                            <i class="fas fa-star ms-2" style="color: #F56476"></i>روابط التواصل الاجتماعي
                        </h5>
                        <div class="row">
                            @if (isset($salon->social_links['instagram']))
                                <div class="quality-metric col-md-6 mb-3">
                                    <a href="{{ $salon->social_links['instagram'] }}"
                                        class="social"><span>instagram</span><i class="fab fa-instagram me-3"></i></a>
                                </div>
                            @endif
                            @if (isset($salon->social_links['facebook']))
                                <div class="quality-metric col-md-6 mb-3">
                                    <a href="{{ $salon->social_links['facebook'] }}"
                                        class="social"><span>facebook</span><i class="fab fa-facebook me-2"></i></a>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            @if (isset($salon->social_links['snapchat']))
                                <div class="quality-metric col-md-6 mb-3">
                                    <a href="{{ $salon->social_links['snapchat'] }}" class="social">
                                        <span>snapchat</span>
                                        <i class="fab fa-snapchat me-3"></i>
                                    </a>
                                </div>
                            @endif
                            @if (isset($salon->social_links['tiktok']))
                                <div class="quality-metric col-md-6 mb-3">
                                    <a href="{{ $salon->social_links['tiktok'] }}" class="social">
                                        <span>tiktok</span><i class="fab fa-tiktok me-3"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            @if (isset($salon->social_links['youtube']))
                                <div class="quality-metric col-md-6 mb-3">
                                    <a href="{{ $salon->social_links['youtube'] }}" class="social">
                                        <span>youtube</span>
                                        <i class="fab fa-youtube me-3"></i>
                                    </a>
                                </div>
                            @endif
                            @if (isset($salon->social_links['twitter']))
                                <div class="quality-metric col-md-6 mb-3">
                                    <a href="{{ $salon->social_links['twitter'] }}" class="social">
                                        <span>(X)_twitter</span>
                                        <i class="fab fa-twitter me-2"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="quality-metric col-md-2 me-3"></div>
                            @if (isset($salon->phone))
                                <div class="quality-metric col-md-8">
                                    <span dir="ltr">{{ $salon->phone }}</span>
                                    <i class="fa fa-phone me-2"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Modal -->
    <div class="modal fade" id="bookingModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">حجز موعد</h5>
                    <button type="button" class="btn-close no-hover-effects" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('front.profile.bookings.create') }}" id="bookingForm">
                        @csrf
                        <input type="hidden" name="salon_id" value="{{ $salon->id }}">
                        <input type="hidden" name="service_description"
                            value="{{ $salon->subService->description ?? 'no thing for description stay it null' }}">
                        <div class="mb-3">
                            <label for="salon_sub_service_id" class="form-label">{{ __('dashboard.service') }} <span
                                    class="text-danger">*</span></label>
                            <select name="salon_sub_service_id"
                                class="form-select no-hover-effects @error('salon_sub_service_id') is-invalid @enderror"
                                required>
                                <option value="">{{ __('dashboard.select_service') }}</option>
                                @foreach ($salon->subServices as $service)
                                    @if ($service->pivot->status == true)
                                        <option value="{{ $service->pivot->id }}">{{ $service->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('salon_sub_service_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="preferred_datetime" class="form-label">{{ __('dashboard.preferred_datetime') }}
                                <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="preferred_datetime" id="preferred_datetime"
                                class="form-control @error('preferred_datetime') is-invalid @enderror"
                                value="{{ old('preferred_datetime') }}" required>
                            @error('preferred_datetime')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-primary">تأكيد الحجز</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/pages-styles.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .social {
            color: #000;
        }

        .social:hover {
            color: #F56476;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('frontend/assets/js/pages-scripts.js') }}"></script>
    <script>
        // Define authentication status
        window.isAuthenticated = @json(auth()->check());

        // Handle Book Now button click
        document.getElementById('bookNowBtn').addEventListener('click', function(event) {
            if (!window.isAuthenticated) {
                event.preventDefault(); // Prevent modal from opening
                Swal.fire({
                    title: 'تسجيل الدخول مطلوب',
                    text: 'يرجى تسجيل الدخول لإتمام الحجز.',
                    icon: 'warning',
                    confirmButtonText: 'تسجيل الدخول',
                    cancelButtonText: 'إلغاء',
                    showCancelButton: true,
                    buttonsStyling: true,
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-secondary'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to login page
                        window.location.href = '{{ route('login') }}';
                    }
                });
            }
            // If authenticated, the modal will open automatically due to data-bs-toggle and data-bs-target
        });
    </script>
@endpush

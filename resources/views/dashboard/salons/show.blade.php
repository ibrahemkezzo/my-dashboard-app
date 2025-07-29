@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.salons'), 'url' => route('dashboard.salons.index')],
        ['label' => __('dashboard.show_salon'), 'url' => route('dashboard.salons.show', $salon->id)],
    ]" :pageName="__('dashboard.show_salon')" />
@endsection

@section('content')
    <x-alert-message />
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card tab2-card">
                    <div class="card-body">
                        <h4>{{ __('dashboard.salon_details') }}</h4>

                        <!-- Tab Navigation -->
                        <ul class="nav nav-tabs mb-3" id="salonDetailTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="info-tab" data-bs-toggle="tab" href="#info" role="tab"
                                    aria-controls="info" aria-selected="true">
                                    <i class="fa fa-building me-2"></i>{{ __('dashboard.salon_information') }}
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="bookings-tab" data-bs-toggle="tab" href="#bookings" role="tab"
                                    aria-controls="bookings" aria-selected="false">
                                    <i class="fa fa-calendar me-2"></i>{{ __('dashboard.bookings') }}
                                </a>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content" id="salonDetailTabContent">
                            <!-- Salon Information Tab -->
                            <div class="tab-pane fade show active" id="info" role="tabpanel"
                                aria-labelledby="info-tab">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card">

                                                <div style="position:relative;">
                                                    @if ($salon->cover_image_url)
                                                        <div
                                                            style="height:120px;background:url('{{ $salon->cover_image_url }}') center center/cover no-repeat;border-top-left-radius:.5rem;border-top-right-radius:.5rem;">
                                                        </div>
                                                    @else
                                                        <div
                                                            style="height:120px;background:#e9ecef;border-top-left-radius:.5rem;border-top-right-radius:.5rem;">
                                                        </div>
                                                    @endif
                                                    <div
                                                        style="position:absolute;left:50%;bottom:-50px;transform:translateX(-50%);">
                                                        @if ($salon->logo_url)
                                                            <img src="{{ $salon->logo_url }}" alt="logo"
                                                                style="width:100px;height:100px;object-fit:cover;border-radius:50%;border:4px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
                                                        @else
                                                            <div
                                                                style="width:100px;height:100px;background:#f0f0f0;border-radius:50%;display:flex;align-items:center;justify-content:center;border:4px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
                                                                <i class="fa fa-building fa-2x text-muted"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="card-body text-center mt-3">
                                                <h4 class="mt-3">{{ $salon->name }}</h4>
                                                <p class="text-muted">{{ $salon->description }}</p>
                                                <div class="mb-3">
                                                    @if ($salon->status)
                                                        <span class="badge bg-success">{{ __('dashboard.active') }}</span>
                                                    @else
                                                        <span class="badge bg-danger">{{ __('dashboard.inactive') }}</span>
                                                    @endif

                                                    @if ($salon->type == 'beauty_center')
                                                        <span
                                                            class="badge bg-info">{{ __('dashboard.beauty_center') }}</span>
                                                    @else
                                                        <span class="badge bg-info">{{ __('dashboard.home_salon') }}</span>
                                                    @endif
                                                </div>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('dashboard.salons.edit', $salon) }}"
                                                        class="btn btn-warning mb-3">
                                                        <i class="fa fa-edit"></i> {{ __('dashboard.edit') }}
                                                    </a>
                                                    <form action="{{ route('dashboard.salons.destroy', $salon) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('{{ __('dashboard.confirm_delete_salon') }}')">
                                                            <i class="fa fa-trash"></i> {{ __('dashboard.delete') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{ __('dashboard.salon_details') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p><strong>{{ __('dashboard.owner') }}:</strong>
                                                            {{ $salon->owner->name }}</p>
                                                        <p><strong>{{ __('dashboard.city') }}:</strong>
                                                            {{ $salon->city->name }}</p>
                                                        <p><strong>{{ __('dashboard.phone') }}:</strong>
                                                            {{ $salon->phone }}</p>
                                                        <p><strong>{{ __('dashboard.email') }}:</strong>
                                                            {{ $salon->email ?? ($salon->owner->email ?? __('dashboard.not_provided')) }}
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p><strong>{{ __('dashboard.rating') }}:</strong>
                                                            @if ($salon->rating > 0)
                                                                <span
                                                                    class="badge bg-warning">{{ $salon->rating }}/5</span>
                                                            @else
                                                                <span
                                                                    class="text-muted">{{ __('dashboard.no_rating') }}</span>
                                                            @endif
                                                        </p>
                                                        <p><strong>{{ __('dashboard.address') }}:</strong>
                                                            {{ $salon->address }}</p>
                                                        <p><strong>{{ __('dashboard.created_at') }}:</strong>
                                                            {{ $salon->created_at->format('M j, Y') }}</p>
                                                        <p><strong>{{ __('dashboard.type_salon') }}:</strong>
                                                            {{ __('dashboard.' . $salon->type) }}</p>
                                                    </div>
                                                </div>

                                                @if ($salon->working_hours)
                                                    <div class="mt-3">
                                                        {{-- @dd($salon->working_hours) --}}
                                                        <h6>{{ __('dashboard.working_hours') }}</h6>
                                                        <div class="row">
                                                            @foreach ($salon->working_hours as $day => $times)
                                                                <div class="col-md-6">
                                                                    {{-- @dump($day, $times) --}}
                                                                    <strong>{{ __('dashboard.' . $day) }}:</strong>
                                                                    @if (isset($times['closed']) && $times['closed'] == 'on')
                                                                        <span
                                                                            class="badge bg-primary me-2">{{ __('dashboard.closed') }}
                                                                        </span>
                                                                    @else
                                                                        @php
                                                                            try {
                                                                                // تحويل أوقات الفتح والإغلاق إلى كائنات Carbon
                                                                                $open = \Carbon\Carbon::createFromFormat(
                                                                                    'H:i',
                                                                                    $times['open'],
                                                                                );
                                                                                $close = \Carbon\Carbon::createFromFormat(
                                                                                    'H:i',
                                                                                    $times['close'],
                                                                                );
                                                                                // تنسيق الإخراج: من [وقت الفتح] صباحًا/مساءً إلى [وقت الإغلاق] صباحًا/مساءً
                                                                                $formattedTime =
                                                                                    __('dashboard.from') .
                                                                                    ' ' .
                                                                                    $open->format('h:i') .
                                                                                    ' ' .
                                                                                    ($open->format('A') == 'AM'
                                                                                        ? __('dashboard.am')
                                                                                        : __('dashboard.pm')) .
                                                                                    ' ' .
                                                                                    __('dashboard.to') .
                                                                                    ' ' .
                                                                                    $close->format('h:i') .
                                                                                    ' ' .
                                                                                    ($close->format('A') == 'AM'
                                                                                        ? __('dashboard.am')
                                                                                        : __('dashboard.pm'));
                                                                            } catch (\Exception $e) {
                                                                                $formattedTime = __(
                                                                                    'dashboard.invalid_time',
                                                                                );
                                                                            }
                                                                        @endphp
                                                                        {{ $formattedTime }}
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="mt-3">
                                                    <h6>{{ __('dashboard.features') }}</h6>
                                                    <div class="row ">
                                                        @if (isset($salon->features['parking']))
                                                            <div class="quality-metric col-md-6  mb-1">
                                                                <i style="color: #6c757d" class="fa fa-car ms-2"></i>
                                                                <span>موقف سيارات</span>
                                                            </div>
                                                        @endif
                                                        @if (isset($salon->features['wifi']))
                                                            <div class="quality-metric col-md-6 mb-1">
                                                                <i style="color: #6c757d" class="fa fa-wifi ms-2"></i>
                                                                <span>واي فاي مجاني</span>
                                                            </div>
                                                        @endif
                                                        @if (isset($salon->features['ac']))
                                                            <div class="quality-metric col-md-6 mb-1">
                                                                <i style="color: #6c757d" class="fa fa-snowflake ms-2"></i>
                                                                <span>تكييف</span>
                                                            </div>
                                                        @endif
                                                        @if (isset($salon->features['waiting-area']))
                                                            <div class="quality-metric col-md-6 mb-1">
                                                                <i style="color: #6c757d" class="fa fa-couch ms-2"></i>
                                                                <span>منطقة انتظار</span>
                                                            </div>
                                                        @endif
                                                        @if (isset($salon->features['refreshments']))
                                                            <div class="quality-metric col-md-6 mb-1">
                                                                <i style="color: #6c757d" class="fa fa-coffee ms-2"></i>
                                                                <span>مشروبات مجانية</span>
                                                            </div>
                                                        @endif
                                                        @if (isset($salon->features['child-care']))
                                                            <div class="quality-metric col-md-6 mb-1">
                                                                <i style="color: #6c757d" class="fa fa-baby ms-2"></i>
                                                                <span>رعاية أطفال</span>
                                                            </div>
                                                        @endif

                                                    </div>

                                                </div>
                                                <div class="mt-3">
                                                    <h6>{{ __('dashboard.social_links') }}</h6>
                                                    <div class="row ">


                                                        @if (isset($salon->social_links['instagram']))
                                                            <div class="quality-metric col-md-6 mb-1 ">

                                                                <a href="{{ $salon->social_links['instagram'] }}"
                                                                    class="social">
                                                                    <i class="fa fa-instagram ms-2 me-2 "></i></a>
                                                                <span>instagram</span>

                                                            </div>
                                                        @endif
                                                        @if (isset($salon->social_links['facebook']))
                                                            <div class="quality-metric col-md-6 mb-1">
                                                                <a href="{{ $salon->social_links['facebook'] }}"
                                                                    class="social">
                                                                    <i class="fa fa-facebook ms-2 me-2"></i></a>
                                                                <span>facebook</span>

                                                            </div>
                                                        @endif

                                                    </div>
                                                    <div class="row">
                                                        @if (isset($salon->social_links['snapchat']))
                                                            <div class="quality-metric col-md-6 mb-1">
                                                                <a href="{{ $salon->social_links['snapchat'] }}"
                                                                    class="social">
                                                                    <i class="fa fa-snapchat ms-2 me-2"></i>
                                                                    <span>snapchat</span>
                                                                </a>

                                                            </div>
                                                        @endif
                                                        @if (isset($salon->social_links['tiktok']))
                                                            <div class="quality-metric col-md-6 mb-1">
                                                                <a href="{{ $salon->social_links['tiktok'] }}"
                                                                    class="social">
                                                                    <i class="fa fa-tiktok ms-2 me-2"></i>
                                                                    <span>tiktok</span>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="row">
                                                        @if (isset($salon->social_links['youtube']))
                                                            <div class="quality-metric col-md-6 mb-1">
                                                                <a href="{{ $salon->social_links['youtube'] }}"
                                                                    class="social">
                                                                    <i class="fa fa-youtube ms-2 me-2"></i>
                                                                    <span>youtube</span>
                                                                </a>

                                                            </div>
                                                        @endif
                                                        @if (isset($salon->social_links['twitter']))
                                                            <div class="quality-metric col-md-6 mb-1">
                                                                <a href="{{ $salon->social_links['twitter'] }}"
                                                                    class="social">
                                                                    <i class="fa fa-twitter ms-2 me-2"></i>
                                                                    <span>(X)_twitter</span>
                                                                </a>

                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mt-3">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5>{{ __('dashboard.salon_services') }}</h5>
                                            <a href="{{ route('dashboard.salons.sub-services.create', $salon) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="fa fa-plus"></i> {{ __('dashboard.add_service') }}
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            @if ($salon->subServices->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ __('dashboard.service') }}</th>
                                                                <th>{{ __('dashboard.price') }}</th>
                                                                <th>{{ __('dashboard.duration') }}</th>
                                                                <th>{{ __('dashboard.status') }}</th>
                                                                <th>{{ __('dashboard.actions') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($salon->subServices as $subService)
                                                                <tr>
                                                                    <td>{{ $subService->name }}</td>
                                                                    <td>{{ $subService->pivot->price }}
                                                                        {{ __('dashboard.currency') }}</td>
                                                                    <td>{{ $subService->pivot->duration }}
                                                                        {{ __('dashboard.minutes') }}</td>
                                                                    <td>
                                                                        @if ($subService->pivot->status)
                                                                            <span
                                                                                class="badge bg-success">{{ __('dashboard.active') }}</span>
                                                                        @else
                                                                            <span
                                                                                class="badge bg-danger">{{ __('dashboard.inactive') }}</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('dashboard.salons.sub-services.show', [$salon, $subService->pivot->id]) }}"
                                                                            class="text-info me-2"
                                                                            title="{{ __('dashboard.view') }}">
                                                                            <i class="fa fa-eye"></i>
                                                                        </a>

                                                                        <a href="{{ route('dashboard.salons.sub-services.edit', [$salon, $subService->pivot->id]) }}"
                                                                            class="text-warning me-2"
                                                                            title="{{ __('dashboard.edit') }}">
                                                                            <i class="fa fa-edit"></i>
                                                                        </a>

                                                                        <form
                                                                            action="{{ route('dashboard.salons.sub-services.destroy', [$salon, $subService->pivot->id]) }}"
                                                                            method="POST"
                                                                            id="destroy-form-{{ $subService->pivot->id }}"
                                                                            style="display:none;">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                        </form>
                                                                        <a href="#"
                                                                            class="text-red-500 hover:text-red-700"
                                                                            title="{{ __('dashboard.delete') }}"
                                                                            onclick="event.preventDefault(); return confirm('{{ __('dashboard.are_you_sure_delete_subservice') }}') && document.getElementById('destroy-form-{{ $subService->pivot->id }}').submit();">
                                                                            <i class="fa fa-trash"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="text-muted">{{ __('dashboard.no_services_assigned') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Gallery Images Section -->
                                    <div class="card mt-3">
                                        <div class="card-header">
                                            <h5>{{ __('dashboard.gallery_images') }}</h5>
                                        </div>
                                        <div class="card-body">
                                            @if (isset($salon) && $salon->media && $salon->media->count())
                                                <div class="row mt-2">
                                                    @foreach ($salon->media as $media)
                                                        <div class="col-md-2 text-center mb-3">
                                                            <div class="position-relative">
                                                                <img src="{{ asset('storage/' . $media->path) }}"
                                                                    alt="gallery"
                                                                    style="width:100px;height:100px;object-fit:cover;border-radius:8px;">
                                                                <div class="mt-2">
                                                                    <form
                                                                        action="{{ route('dashboard.media.update', $media->id) }}"
                                                                        method="POST" enctype="multipart/form-data"
                                                                        style="display:inline;">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="file" name="file"
                                                                            accept="image/*"
                                                                            style="width:80px;display:inline-block;">
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-primary mt-1"><i
                                                                                class="fa fa-upload"></i></button>
                                                                    </form>
                                                                    <form
                                                                        action="{{ route('dashboard.media.destroy', $media->id) }}"
                                                                        method="POST" style="display:inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-danger mt-1"
                                                                            onclick="return confirm('{{ __('dashboard.confirm_delete_image') }}')"><i
                                                                                class="fa fa-trash"></i></button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-muted">{{ __('dashboard.no_gallery_images') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- End Gallery Images Section -->
                                </div>
                            </div>

                            <!-- Salon Bookings Tab -->
                            <div class="tab-pane fade" id="bookings" role="tabpanel" aria-labelledby="bookings-tab">
                                <x-dashboard.salon-bookings-tab :salon="$salon" :bookings="$bookings" :statistics="$bookingStatistics" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Store active tab in localStorage for better UX
            const tabLinks = document.querySelectorAll('#salonDetailTab .nav-link');
            const tabPanes = document.querySelectorAll('.tab-pane');

            // Get tab from URL parameter or stored tab or default to first tab
            const urlParams = new URLSearchParams(window.location.search);
            const tabFromUrl = urlParams.get('tab');
            const activeTab = tabFromUrl || localStorage.getItem('salonDetailActiveTab') || 'info';

            // Activate the stored tab
            tabLinks.forEach(link => {
                if (link.getAttribute('href') === '#' + activeTab) {
                    link.classList.add('active');
                    link.setAttribute('aria-selected', 'true');
                } else {
                    link.classList.remove('active');
                    link.setAttribute('aria-selected', 'false');
                }
            });

            tabPanes.forEach(pane => {
                if (pane.id === activeTab) {
                    pane.classList.add('show', 'active');
                } else {
                    pane.classList.remove('show', 'active');
                }
            });

            // Store active tab when clicked
            tabLinks.forEach(link => {
                link.addEventListener('click', function() {
                    const targetTab = this.getAttribute('href').substring(1);
                    localStorage.setItem('salonDetailActiveTab', targetTab);
                });
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .social {
            color: #000;


        }

        /* لون النص عند الـ hover */
        .social:hover {
            color: #F56476;
            /* اللون المطلوب عند الـ hover */
        }
    </style>
    </style>
@endpush

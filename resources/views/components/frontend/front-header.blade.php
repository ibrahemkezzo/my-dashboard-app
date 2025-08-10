<header class="header">
    <div class="container">
        <div class="nav-wrapper">
            <!-- Logo -->
            <div class="logo">
                {{-- <h1>كوافيري | My Kawafir</h1> --}}
                <a href="{{ route('front.home') }}"><img src="{{ asset('frontend/assets/img/logo.png') }}"
                        alt="كوافيري | My Kawafir" width="168px" /></a>
            </div>
            <!-- Desktop Navigation -->
            <nav class="nav-desktop">
                <a href="{{ route('front.home') }}" class="nav-link">الرئيسية</a>
                <a href="{{ route('front.about-us') }}" class="nav-link">عن المنصة</a>
                <a href="{{ route('front.salons.list') }}" class="nav-link">العروض الخاصة</a>
                {{-- <a href="{{ route('front.salons.list', ['hasOffers' => true]) }}" class="nav-link">العروض الخاصة</a> --}}
                <a href="{{ route('front.faq') }}" class="nav-link">الأسئلة الشائعة</a>

            </nav>
            <!-- Desktop Auth Buttons -->
            <div class="auth-buttons-desktop">
                @auth
                    <div class="d-flex align-items-center">
                        @if (!Auth::user()->hasVerifiedEmail())
                           <a href="{{ route('verification.notice') }}" title="يرجى تأكيد بريدك الإلكتروني" class="mt-2">
                               <i class="fas fa-exclamation-circle"
                                style=" color: #f56476; font-size: 1.5rem; margin-left: 0.5rem;"></i>
                           </a>
                       @endif
                        <div class="dropdown" id="profile-header">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-user me-2"></i>{{ $user->name }}
                            </button>
                            <ul class="dropdown-menu text-start">
                                <li><a class="dropdown-item" href="{{ route('front.profile.account') }}">حسابي</a></li>
                                <li><a class="dropdown-item" href="{{ route('front.profile.bookings') }}">حجوزاتي</a></li>
                                <li><a class="dropdown-item" href="{{ route('front.profile.favourites') }}">المفضلة</a></li>
                                @if (!Auth::user()->hasVerifiedEmail())
                                    <li>
                                        <a class="dropdown-item" href="{{ route('verification.notice') }}">
                                            <i class="fas fa-exclamation-circle"
                                                style=" color: #f56476; font-size: 1rem; margin-left: 0.5rem;"></i>
                                            تاكيد البريد الالكتروني
                                        </a>
                                    </li>
                                @endif
                                @role(['salon-manager'])
                                    <li><a class="dropdown-item" href="{{ route('front.profile.salon.manager') }}">ادارة
                                            الصالون</a></li>
                                @endrole
                                @role(['super-admin'])
                                    <li><a class="dropdown-item" href="{{ route('dashboard.index') }}">لوحة التحكم </a></li>
                                @endrole
                                @role('user')
                                    <li><a href="{{ route('front.salons.create') }}" class="dropdown-item">انضمي كخبيرة
                                            تجميل</a> </li>
                                @endrole
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                {{-- <li><a class="dropdown-item" href="#">تسجيل الخروج</a></li> --}}
                                <li>
                                    <a href="#" class="dropdown-item"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('dashboard.logout') }}
                                    </a>
                                </li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </ul>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-ghost">
                        <i data-lucide="user"></i>
                        تسجيل الدخول
                    </a>
                    <a href="{{ route('front.salons.create') }}" class="btn btn-primary">انضمي كخبيرة تجميل</a>
                @endauth
            </div>



            <!-- Mobile Menu Button -->
            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <i data-lucide="menu"></i>
            </button>
        </div>
    </div>
    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobileMenuOverlay">
        <div class="mobile-menu">
            <div class="mobile-menu-header">
                <a href="{{ route('front.home') }}"><img src="{{ asset('frontend/assets/img/logo.png') }}"
                        alt="كوافيري | My Kawafir" width="158px" /></a>
                <button class="mobile-menu-close" id="mobileMenuClose">
                    <i data-lucide="x"></i>
                </button>
            </div>
            <div class="mobile-auth-buttons">
                @auth
                    <div class="d-flex align-items-center mb-5">
                        <div class="dropdown" id="profile-header">
                            @if (!Auth::user()->hasVerifiedEmail())
                                <a href="{{ route('verification.notice') }}" title="يرجى تأكيد بريدك الإلكتروني">
                                    <i class="fas fa-exclamation-circle"
                                     style=" color: #f0ad4e; font-size: 1.2rem; margin-left: 0.5rem;"></i>
                                </a>
                            @endif

                            <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-user me-2"></i>{{ $user->name }}
                            </button>
                            <ul class="dropdown-menu text-start me-5">
                                <li><a class="dropdown-item" href="{{ route('front.profile.account') }}">حسابي</a></li>
                                <li><a class="dropdown-item" href="{{ route('front.profile.bookings') }}">حجوزاتي</a></li>
                                <li><a class="dropdown-item" href="{{ route('front.profile.favourites') }}">المفضلة</a>
                                </li>
                                @role(['salon-manager'])
                                    <li><a class="dropdown-item" href="{{ route('front.profile.salon.manager') }}">ادارة
                                            الصالون</a></li>
                                @endrole
                                @role(['super-admin'])
                                    <li><a class="dropdown-item" href="{{ route('dashboard.index') }}">لوحة التحكم </a></li>
                                @endrole
                                @role('user')
                                    <li><a href="{{ route('front.salons.create') }}" class="dropdown-item">انضمي كخبيرة
                                            تجميل</a> </li>
                                @endrole
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                {{-- <li><a class="dropdown-item" href="#">تسجيل الخروج</a></li> --}}
                                <li>
                                    <a href="#" class="dropdown-item"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('dashboard.logout') }}
                                    </a>
                                </li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </ul>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-ghost">
                        <i data-lucide="user"></i>
                        تسجيل الدخول
                    </a>
                    <a href="{{ route('front.salons.create') }}" class="btn btn-primary">انضمي كخبيرة تجميل</a>
                @endauth
            </div>
            <nav class="mobile-nav">
                <a href="{{ route('front.home') }}" class="nav-link">الرئيسية</a>
                <a href="{{ route('front.about-us') }}" class="nav-link">عن المنصة</a>
                <a href="{{ route('front.salons.list', ['hasOffers' => true]) }}" class="nav-link">العروض الخاصة</a>
                <a href="{{ route('front.faq') }}" class="nav-link">الأسئلة الشائعة</a>
            </nav>



        </div>
    </div>
</header>
@push('styles')
<style>
    .email-verification-icon {
        color: #f0ad4e;
        font-size: 1.2rem;
        margin-left: 0.5rem;
    }
    .email-verification-icon:hover {
        color: #e0a800;
    }
</style>
@endpush

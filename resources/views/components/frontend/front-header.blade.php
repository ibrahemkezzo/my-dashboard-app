<header class="header">
    <div class="container">
        <div class="nav-wrapper">
            <!-- Logo -->
            <div class="logo">
                {{-- <h1>كوافيري | My Kawafir</h1> --}}
                <a href="{{ route('home') }}"><img src="{{ asset('frontend/assets/img/logo.png') }}" alt="كوافيري | My Kawafir" width="168px" /></a>
            </div>
            <!-- Desktop Navigation -->
            <nav class="nav-desktop">
                <a href="{{ route('home') }}" class="nav-link">الرئيسية</a>
                <a href="{{ route('about') }}" class="nav-link">عن المنصة</a>
                <a href="{{ route('list', ['hasOffers' => true]) }}" class="nav-link">العروض الخاصة</a>
                <a href="{{ route('faq') }}" class="nav-link">الأسئلة الشائعة</a>

            </nav>
            <!-- Desktop Auth Buttons -->
            <div class="auth-buttons-desktop">
                @auth
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-2"></i>{{$user->name}}
                        </button>
                        <ul class="dropdown-menu text-start">
                            <li><a class="dropdown-item" href="{{ route('account') }}">حسابي</a></li>
                            <li><a class="dropdown-item" href="{{ route('bookings') }}">حجوزاتي</a></li>
                            <li><a class="dropdown-item" href="{{ route('favorits') }}">المفضلة</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">تسجيل الخروج</a></li>
                        </ul>
                    </div>
                </div>
                    <form method="POST" action="{{route('logout')}}">
                        @csrf
                        <button type="submit" class="btn btn-ghost">
                            <i class="fa fa-sign-out"></i>
                            تسجيل الخروج
                        </button>
                    </form>
                @else
                    <a href="{{route('login')}}" class="btn btn-ghost">
                        <i data-lucide="user"></i>
                        تسجيل الدخول
                    </a>
                    <button class="btn btn-primary">انضمي كخبيرة تجميل</button>
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
                <a href="{{ route('home') }}"><img src="{{ asset('frontend/assets/img/logo.png') }}" alt="كوافيري | My Kawafir" width="158px" /></a>
                <button class="mobile-menu-close" id="mobileMenuClose">
                    <i data-lucide="x"></i>
                </button>
            </div>
            <nav class="mobile-nav">
                <a href="{{ route('home') }}" class="nav-link">الرئيسية</a>
                <a href="{{ route('about') }}" class="nav-link">عن المنصة</a>
                <a href="{{ route('list', ['hasOffers' => true]) }}" class="nav-link">العروض الخاصة</a>
                <a href="{{ route('faq') }}" class="nav-link">الأسئلة الشائعة</a>
            </nav>
            <div class="mobile-auth-buttons">
                @auth
                    <form method="POST" action="{{route('logout')}}">
                        @csrf
                        <button type="submit" class="btn btn-outline">
                            <i class="fa fa-sign-out"></i>
                            تسجيل الخروج
                        </button>
                    </form>
                @else
                    <a href="{{route('login')}}" class="btn btn-outline">
                        <i data-lucide="user"></i>
                        تسجيل الدخول
                    </a>
                    <button class="btn btn-primary">انضمي كخبيرة تجميل</button>
                @endauth
            </div>

        </div>
    </div>
</header>
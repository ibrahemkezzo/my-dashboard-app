<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <meta name="description" content="منصة حجز خدمات التجميل - احجزي موعدك مع أفضل صالونات التجميل ومراكز العناية">
    <meta name="author" content="{{ config('app.name') }}">

    <!-- Icons -->
    <link href="{{ asset('frontend/assets/img/icons/favicon.png') }}" rel="icon">
    <link href="{{ asset('frontend/assets/img/icons/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- IBM Plex Arabic Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/styles.css?v=' . config('app.version')) }}">
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/drop.css?v=' . config('app.version')) }}">
    <style>
        .dropdown-parent-f {
            position: relative;
        }

        .dropdown-menu-f {
            display: none;
            position: absolute;
            background-color: #000000;
            border: 1px solid #87365b;
            border-radius: 4px;
            padding: 5px 0;
            min-width: 200px;
            z-index: 20;
            box-shadow: 0 2px 5px rgba(52, 51, 51, 0.1);
            right: 50%;
            /* يضع القائمة إلى الجانب الأيمن */
            top: 0;
            /* يحاذيها مع الأعلى */
        }

        .dropdown-parent-f:hover .dropdown-menu-f {
            display: block;
        }

        .dropdown-item {
            list-style: none;
            padding: 5px 10px;
        }

        .dropdown-item:hover {
            color: #87365b;
        }

        .dropdown-item a {
            color: #ffffff;
            text-decoration: none;
        }

        .hover-bg-light:hover {
            background-color: #f8f0f4 !important;
        }

        .avatar {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
    </style>
    @livewireStyles
</head>

<body>
    <div id="loader">
        <img src="{{ asset('frontend/assets/img/logo.png') }}" alt="Logo Loader" class="logo-loader">
    </div>
    {{-- @include('frontend.layouts.header') --}}
    {{-- start header --}}
    <x-frontend.front-header />
    {{-- end header --}}

    <!-- Alert Message Start -->
    <x-alert-message />
    <!-- Alert Message End -->

    @yield('main')

    {{-- @include('frontend.layouts.footer') --}}
    {{-- start footer --}}
    <x-frontend.front-footer />
    {{-- end footer --}}

    <script src="{{ asset('frontend/assets/js/script.js') }}"></script>
    <script>
        // Initialize Lucide icons
        lucide.createIcons();
    </script>
    @php
        $whatsapp = \App\Models\Setting::where('key', 'number_settings')->first()?->value ?? '966501234567';
        // $whatsapp = "580499243";
        // تنظيف الرقم من كل شيء غير الأرقام
    $clean = preg_replace('/[^0-9]/', '', $whatsapp);

    // إزالة البادئة الخاطئة إذا وجدت (+966 أو 00966 أو 966)
    if (str_starts_with($clean, '00')) {
        $clean = substr($clean, 2);            // حذف 00 من البداية
    } elseif (str_starts_with($clean, '0')) {
        $clean = substr($clean, 1);            // حذف الصفر الأول فقط (لو كان سعودي محلي)
    }
    $message = urlencode('مرحباً، أحتاج مساعدة في ' . config('app.name'));
        // إذا كنت تستخدم cache أو config أفضل، لكن هذا يكفي للتطوير
    @endphp

    @if ($whatsapp)
        <a href="https://wa.me/{{ $clean }}?text={{ $message }}"
            class="whatsapp-float" target="_blank" rel="noopener noreferrer" aria-label="تواصل معنا عبر واتساب">
            <i class="fab fa-whatsapp"></i>
        </a>
      <style>
        .whatsapp-float {
            position: fixed;
            width: 68px;
            height: 68px;
            bottom: 90px;
            right: 20px;           /* ← نقلناه لليمين */
            left: auto;            /* إلغاء اليسار */
            background-color: #25D366;
            color: #FFF;
            border-radius: 50%;    /* دائرة مثالية */
            text-align: center;
            font-size: 40px;       /* أكبر شوية وأجمل */
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
            z-index: 9999;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border: 4px solid #fff;  /* إطار أبيض خفيف يخليها أجمل */
        }

        .whatsapp-float:hover {
            transform: translateY(-5px) scale(1.1);
            background-color: #128C7E;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        /* النبضة الخفيفة الجميلة */
        .whatsapp-float::before {
            content: '';
            position: absolute;
            top: -8px;
            left: -8px;
            right: -8px;
            bottom: -8px;
            background-color: #25D366;
            border-radius: 50%;
            opacity: 0.4;
            animation: pulse 2.5s infinite;
            z-index: -1;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.9);
                opacity: 0.7;
            }
            70% {
                transform: scale(1.25);
                opacity: 0;
            }
            100% {
                transform: scale(0.9);
                opacity: 0;
            }
        }

        /* تحسين على الموبايل */
        @media (max-width: 480px) {
            .whatsapp-float {
                width: 62px;
                height: 62px;
                font-size: 36px;
                bottom: 85px;
                right: 15px;
            }
        }

        @media (max-width: 350px) {
            .whatsapp-float {
                width: 58px;
                height: 58px;
                font-size: 34px;
                bottom: 80px;
            }
        }
    </style>
    @endif


    @stack('scripts')

    @livewireScripts

</body>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const btn = document.getElementById("profile-btn");
        const menu = document.getElementById("profile-menu");

        btn.addEventListener("click", function(e) {
            e.stopPropagation();
            menu.style.display = (menu.style.display === "block") ? "none" : "block";
        });

        // إغلاق القائمة عند الضغط خارجها
        document.addEventListener("click", function() {
            menu.style.display = "none";
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const mobileBtn = document.getElementById("mobile-profile-btn");
        const mobileMenu = document.getElementById("mobile-profile-menu");

        mobileBtn.addEventListener("click", function(e) {
            e.stopPropagation();
            mobileMenu.style.display = (mobileMenu.style.display === "block") ? "none" : "block";
        });

        // إغلاق القائمة عند الضغط خارجها
        document.addEventListener("click", function() {
            mobileMenu.style.display = "none";
        });
    });
</script>
<script>
    const buttons = document.querySelectorAll('.custom-dropdown-btn');

    buttons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            this.classList.toggle('custom-show');
        });
    });

    document.addEventListener('click', function() {
        buttons.forEach(btn => btn.classList.remove('custom-show'));
    });
</script>
<script>
    // إخفاء اللودر عند انتهاء تحميل الصفحة
    window.addEventListener("load", function() {
        const loader = document.getElementById("loader");
        loader.style.display = "none";
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // === Desktop ===
        const desktopBtn = document.getElementById("notifications-btn-desktop");
        const desktopMenu = document.getElementById("notifications-menu-desktop");

        if (desktopBtn && desktopMenu) {
            desktopBtn.addEventListener("click", function(e) {
                e.stopPropagation();
                desktopMenu.style.display = (desktopMenu.style.display === "block") ? "none" : "block";
            });

            desktopMenu.addEventListener("click", function(e) {
                e.stopPropagation();
            });
        }

        // // === Mobile ===
        const mobileBtn = document.getElementById("notifications-btn-mobile");
        const mobileMenu = document.getElementById("notifications-menu-mobile");

        console.log("Mobile Button:", mobileBtn);
        console.log("Mobile Menu:", mobileMenu);

        if (mobileBtn && mobileMenu) {
            mobileBtn.onclick = function(e) {
                e.stopPropagation();
                const isOpen = mobileMenu.style.display === "block";
                console.log("Mobile Click - Open:", !isOpen);
                mobileMenu.style.display = isOpen ? "none" : "block";
            };
            mobileMenu.onclick = (e) => e.stopPropagation();
        } else {
            console.warn("Mobile elements not found");
        }

        // === إغلاق عند النقر خارج القوائم ===
        document.addEventListener("click", function() {
            if (desktopMenu) desktopMenu.style.display = "none";
            if (mobileMenu) mobileMenu.style.display = "none";
            console.log("Clicked outside - Closing all menus");
        });

    });
</script>

</html>

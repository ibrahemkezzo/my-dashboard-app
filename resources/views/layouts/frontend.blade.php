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



    @stack('scripts')

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

</html>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <meta name="description" content="منصة حجز خدمات التجميل - احجزي موعدك مع أفضل صالونات التجميل ومراكز العناية">
    <meta name="author" content="My Kawafir">

    <!-- Icons -->
    <link href="{{ asset('frontend/assets/img/icons/favicon.png') }}" rel="icon">
    <link href="{{ asset('frontend/assets/img/icons/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- IBM Plex Arabic Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/styles.css') }}">
    @stack('styles')
</head>
<body>
    {{-- @include('frontend.layouts.header') --}}
    {{-- start header --}}
    <x-frontend.front-header/>
    {{-- end header --}}

    @yield('main')

    {{-- @include('frontend.layouts.footer') --}}
    {{-- start footer --}}
    <x-frontend.front-footer/>
    {{-- end footer --}}

    <script src="{{ asset('frontend/assets/js/script.js') }}"></script>
    <script>
        // Initialize Lucide icons
        lucide.createIcons();
    </script>

    @stack('scripts')
</body>
</html>
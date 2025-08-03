@extends('layouts.frontend')

@section('title', 'منصة حجز خدمات التجميل | كوافيري | My Kawafir')

@section('main')
<div class="container my-5">
    <!-- Hero Section -->
    <div class="row align-items-center pt-5">
        <div class="col-md-6 col-10">
            <div class="about-hero-content">
                <h1 class="display-4 fw-bold text-dark mb-4 title">عن كوافيري</h1>
                <p class="lead text-muted mb-4">
                    منصة رائدة في المملكة العربية السعودية تربط بين العميلات وأفضل خبيرات التجميل والصالونات المعتمدة، لتوفير تجربة حجز سهلة ومميزة.
                </p>
                <p class="text-muted">
                    نحن نؤمن بأن كل امرأة تستحق أن تشعر بالجمال والثقة، ولذلك نسعى لتوفير أفضل خدمات التجميل والعناية بأعلى معايير الجودة والاحترافية.
                </p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="about-hero-image">
                <img src="https://images.unsplash.com/photo-1516975080664-ed2fc6a32937?ixlib=rb-4.0.3&amp;auto=format&amp;fit=crop&amp;w=500&amp;q=80" alt="كوافيري" class="img-fluid rounded-3 shadow">
            </div>
        </div>
    </div>

    <!-- start Customer Reviews Section -->
    <x-frontend.rating/>
    <!-- end Customer Reviews Section -->

</div>
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/pages-styles.css') }}">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/assets/js/pages-scripts.js') }}"></script>
@endpush

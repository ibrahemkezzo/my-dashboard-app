@extends('layouts.frontend')

@section('title', 'منصة حجز خدمات التجميل | كوافيري | My Kawafir')


@section('main')
<div class="container my-5 legal">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="privacy-header text-center mb-5">
                <h1 class="display-4 fw-bold text-dark mb-3 title">الشروط والأحكام</h1>
                <p class="lead text-muted">آخر تحديث: {{$terms->updated_at->format('Y M')}}</p>
            </div>

            <div class="privacy-content">
                <div class="section mb-5">
                    <h2 class="h4 fw-bold text-primary mb-3 title">مقدمة</h2>
                    <p class="text-muted">
                        {{-- ترحب بك منصة كوافيري. باستخدامك لخدماتنا، فإنك توافق على الالتزام بالشروط والأحكام التالية. يرجى قراءتها بعناية قبل استخدام المنصة. --}}
                        {{$info->value}}
                    </p>
                </div>

                <div class="section mb-5">
                    {{-- <h2 class="h4 fw-bold text-primary mb-3 title">استخدام المنصة</h2>
                    <ul class="text-muted">
                        <li>يجب أن يكون عمرك 18 عاماً على الأقل لاستخدام المنصة.</li>
                        <li>توافق على استخدام المنصة لأغراض قانونية وشخصية فقط.</li>
                        <li>تلتزم بعدم إساءة استخدام الخدمات أو التدخل في عمل المنصة.</li>
                        <li>تقر بأن جميع المعلومات التي تقدمها صحيحة وحديثة.</li>
                    </ul> --}}
                    {!!$terms->value!!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/pages-styles.css') }}">
    <style>
        h2 {
            color: #e43f6f;
            margin-top: 6%;
            margin-bottom: 4%;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/assets/js/pages-scripts.js') }}"></script>
@endpush
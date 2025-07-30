@extends('layouts.frontend')

@section('title', 'منصة حجز خدمات التجميل | كوافيري | My Kawafir')

@section('main')
    <div class="container my-5">
        <div class="faq-header text-center mb-5">
            <h1 class="display-4 fw-bold text-dark mb-3 title">الأسئلة الشائعة</h1>
            <p class="lead text-muted">{{ $info->value }}</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- FAQ Accordion -->
                <div class="accordion" id="faqAccordion">
                    <!-- General Questions -->

                    @php
                        // تجميع الأسئلة حسب الفئة
                        $groupedQuestions = collect($questions->value)->groupBy('category');
                    @endphp

                    @foreach ($groupedQuestions as $category => $questions)
                        <div class="faq-category mb-4">
                            <h4 class="fw-semibold text-primary mb-3 title">{{ $category }}</h4>

                            @foreach ($questions as $index => $question)
                                <div class="accordion-item ">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#faq-{{ md5($category . $index) }}">
                                            {{ $question['question'] }}
                                        </button>
                                    </h2>
                                    <div id="faq-{{ md5($category . $index) }}"
                                        class="accordion-collapse collapse "
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            {{ $question['answer'] }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                </div>

                <!-- Contact Section -->
                <div class="text-center mt-5">
                    <div class="bg-light rounded-3 p-4">
                        <h5 class="fw-semibold mb-3">لم تجدي إجابة لسؤالك؟</h5>
                        <p class="text-muted mb-3">تواصلي مع فريق خدمة العملاء وسنكون سعداء لمساعدتك</p>
                        <button class="btn btn-primary">تواصل معنا</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/pages-styles.css') }}">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/assets/js/pages-scripts.js') }}"></script>
@endpush

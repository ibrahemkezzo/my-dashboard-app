@extends('frontend.layouts.app')

@section('title', 'الشروط والأحكام | كوافيري | My Kawafir')

@section('main')
    <div class="container my-5 legal">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="privacy-header text-center mb-5">
                    <h1 class="display-4 fw-bold text-dark mb-3 title">الشروط والأحكام</h1>
                    <p class="lead text-muted">آخر تحديث: يوليو 2025</p>
                </div>

                <div class="privacy-content">
                    <div class="section mb-5">
                        <h2 class="h4 fw-bold text-primary mb-3 title">مقدمة</h2>
                        <p class="text-muted">
                            ترحب بك منصة كوافيري. باستخدامك لخدماتنا، فإنك توافق على الالتزام بالشروط والأحكام التالية. يرجى قراءتها بعناية قبل استخدام المنصة.
                        </p>
                    </div>

                    <div class="section mb-5">
                        <h2 class="h4 fw-bold text-primary mb-3 title">استخدام المنصة</h2>
                        <ul class="text-muted">
                            <li>يجب أن يكون عمرك 18 عاماً على الأقل لاستخدام المنصة.</li>
                            <li>توافق على استخدام المنصة لأغراض قانونية وشخصية فقط.</li>
                            <li>تلتزم بعدم إساءة استخدام الخدمات أو التدخل في عمل المنصة.</li>
                            <li>تقر بأن جميع المعلومات التي تقدمها صحيحة وحديثة.</li>
                        </ul>
                    </div>

                    <div class="section mb-5">
                        <h2 class="h4 fw-bold text-primary mb-3 title">الحجوزات والدفع</h2>
                        <ul class="text-muted">
                            <li>يمكنك حجز الخدمات مباشرة من خلال المنصة.</li>
                            <li>قد تتطلب بعض الحجوزات دفعاً مسبقاً أو تأكيداً عبر الصالون.</li>
                            <li>في حال الإلغاء، يجب مراجعة سياسة الإلغاء الخاصة بالصالون.</li>
                            <li>المنصة غير مسؤولة عن أي خلل في المواعيد أو جودة الخدمة المقدمة من الصالون.</li>
                        </ul>
                    </div>

                    <div class="section mb-5">
                        <h2 class="h4 fw-bold text-primary mb-3 title">الحسابات والمستخدمين</h2>
                        <ul class="text-muted">
                            <li>يجب عليك إنشاء حساب لاستخدام بعض الميزات.</li>
                            <li>تتحمل مسؤولية سرية معلومات الدخول الخاصة بك.</li>
                            <li>يحق للمنصة تعليق أو حذف الحسابات التي تخرق الشروط.</li>
                        </ul>
                    </div>

                    <div class="section mb-5">
                        <h2 class="h4 fw-bold text-primary mb-3 title">المحتوى والتقييمات</h2>
                        <ul class="text-muted">
                            <li>يمكن للمستخدمين ترك تقييمات بعد إتمام الحجز.</li>
                            <li>يجب أن تكون التقييمات صادقة وخالية من الإساءة أو التشهير.</li>
                            <li>تحتفظ المنصة بحق حذف أو تعديل أي محتوى مخالف.</li>
                        </ul>
                    </div>

                    <div class="section mb-5">
                        <h2 class="h4 fw-bold text-primary mb-3 title">الملكية الفكرية</h2>
                        <p class="text-muted">
                            جميع حقوق المحتوى والتصميم والعلامات التجارية مملوكة لمنصة كوافيري أو للجهات المالكة ذات العلاقة. يُمنع استخدام أي محتوى دون إذن خطي مسبق.
                        </p>
                    </div>

                    <div class="section mb-5">
                        <h2 class="h4 fw-bold text-primary mb-3 title">المسؤولية القانونية</h2>
                        <p class="text-muted">
                            لا تتحمل منصة كوافيري أي مسؤولية عن الخسائر أو الأضرار الناتجة عن استخدام المنصة أو الخدمات المقدمة من الصالونات. استخدامك للمنصة يتم على مسؤوليتك الخاصة.
                        </p>
                    </div>

                    <div class="section mb-5">
                        <h2 class="h4 fw-bold text-primary mb-3 title">تعديلات على الشروط</h2>
                        <p class="text-muted">
                            قد نقوم بتحديث هذه الشروط من وقت لآخر. سيتم إخطار المستخدمين بالتعديلات الجوهرية عبر البريد الإلكتروني أو إشعار داخل المنصة. استمرار استخدامك للمنصة يعني موافقتك على الشروط المعدلة.
                        </p>
                    </div>

                    <div class="section mb-5">
                        <h2 class="h4 fw-bold text-primary mb-3 title">القانون الواجب التطبيق</h2>
                        <p class="text-muted">
                            تخضع هذه الشروط وتُفسر وفقاً لأنظمة وقوانين المملكة العربية السعودية. وفي حال وجود أي نزاع، تكون المحاكم السعودية صاحبة الاختصاص.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages-styles.css') }}">
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/pages-scripts.js') }}"></script>
@endsection
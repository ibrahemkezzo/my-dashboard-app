@extends('layouts.frontend')

@section('title', 'منصة حجز خدمات التجميل | كوافيري | My Kawafir')

@section('main')
<div class="container my-5 legal">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="privacy-header text-center mb-5">
                <h1 class="display-4 fw-bold text-dark mb-3 title">سياسة الخصوصية</h1>
                <p class="lead text-muted">آخر تحديث:  {{$sections->updated_at->format('Y M')}}</p>
            </div>

            <div class="privacy-content">
                <div class="section mb-5">
                    <h2 class="h4 fw-bold text-primary mb-3 title">مقدمة</h2>
                    <p class="text-muted">
                        {{-- نحن في كوافيري نقدر خصوصيتك ونلتزم بحماية بياناتك الشخصية. تشرح سياسة الخصوصية هذه كيفية جمعنا واستخدامنا وحمايتنا للمعلومات التي تقدمينها لنا عند استخدام منصتنا. --}}
                        {{$info->value}}
                    </p>
                </div>
                <div class="section mb-5">
                    <h2 class="h4 fw-bold text-primary mb-3 title">المعلومات التي نجمعها</h2>
                </div>

                @foreach ($sections->value as $section)
                    <div class="section mb-5">
                        <h2 class="h4 fw-bold text-primary mb-3 title">{{$section['title']}}</h2>
                        <ul class="text-muted mb-4">
                            @foreach (explode(',', $section['content']) as $item)
                                <li>{{ trim($item) }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
{{--
                <div class="section mb-5">
                    <h2 class="h4 fw-bold text-primary mb-3 title">كيف نستخدم معلوماتك</h2>
                    <ul class="text-muted">
                        <li>توفير وتحسين خدماتنا</li>
                        <li>معالجة الحجوزات والمدفوعات</li>
                        <li>التواصل معك بشأن حجوزاتك</li>
                        <li>إرسال إشعارات مهمة وتحديثات الخدمة</li>
                        <li>تخصيص تجربتك على المنصة</li>
                        <li>إجراء تحليلات لتحسين الخدمة</li>
                        <li>منع الاحتيال وضمان الأمان</li>
                        <li>الامتثال للمتطلبات القانونية</li>
                    </ul>
                </div>

                <div class="section mb-5">
                    <h2 class="h4 fw-bold text-primary mb-3 title">مشاركة المعلومات</h2>
                    <p class="text-muted mb-3">
                        نحن لا نبيع أو نؤجر أو نتداول معلوماتك الشخصية مع أطراف ثالثة. قد نشارك معلوماتك في الحالات التالية:
                    </p>
                    <ul class="text-muted">
                        <li><strong>مع الصالونات:</strong> نشارك المعلومات الضرورية لتنفيذ حجزك</li>
                        <li><strong>مع مقدمي الخدمات:</strong> لمعالجة المدفوعات وتقديم الدعم التقني</li>
                        <li><strong>للامتثال القانوني:</strong> عند الطلب من السلطات المختصة</li>
                        <li><strong>لحماية حقوقنا:</strong> في حالة انتهاك الشروط والأحكام</li>
                    </ul>
                </div>

                <div class="section mb-5">
                    <h2 class="h4 fw-bold text-primary mb-3 title">حماية البيانات</h2>
                    <p class="text-muted mb-3">
                        نتخذ إجراءات أمنية متقدمة لحماية معلوماتك الشخصية:
                    </p>
                    <ul class="text-muted">
                        <li>تشفير البيانات أثناء النقل والتخزين</li>
                        <li>الوصول المحدود للبيانات من قبل الموظفين المخولين فقط</li>
                        <li>مراقبة أمنية مستمرة للأنظمة</li>
                        <li>تحديثات أمنية منتظمة</li>
                        <li>نسخ احتياطية آمنة</li>
                    </ul>
                </div>

                <div class="section mb-5">
                    <h2 class="h4 fw-bold text-primary mb-3 title">حقوقك</h2>
                    <p class="text-muted mb-3">لديك الحق في:</p>
                    <ul class="text-muted">
                        <li><strong>الوصول:</strong> طلب نسخة من بياناتك الشخصية</li>
                        <li><strong>التصحيح:</strong> تحديث أو تصحيح معلوماتك</li>
                        <li><strong>الحذف:</strong> طلب حذف حسابك وبياناتك</li>
                        <li><strong>النقل:</strong> الحصول على بياناتك بصيغة قابلة للقراءة</li>
                        <li><strong>الاعتراض:</strong> رفض استخدام بياناتك لأغراض معينة</li>
                        <li><strong>التحكم:</strong> إدارة تفضيلات الخصوصية</li>
                    </ul>
                </div>

                <div class="section mb-5">
                    <h2 class="h4 fw-bold text-primary mb-3 title">ملفات تعريف الارتباط (Cookies)</h2>
                    <p class="text-muted mb-3">
                        نستخدم ملفات تعريف الارتباط لتحسين تجربتك على المنصة:
                    </p>
                    <ul class="text-muted">
                        <li><strong>ملفات أساسية:</strong> ضرورية لعمل المنصة</li>
                        <li><strong>ملفات الأداء:</strong> لتحليل استخدام المنصة</li>
                        <li><strong>ملفات التخصيص:</strong> لحفظ تفضيلاتك</li>
                        <li><strong>ملفات التسويق:</strong> لعرض إعلانات مخصصة (بموافقتك)</li>
                    </ul>
                </div>

                <div class="section mb-5">
                    <h2 class="h4 fw-bold text-primary mb-3 title">الاحتفاظ بالبيانات</h2>
                    <p class="text-muted">
                        نحتفظ بمعلوماتك الشخصية للمدة اللازمة لتوفير خدماتنا أو حسب ما تتطلبه القوانين المعمول بها. عند حذف حسابك، سنقوم بحذف معلوماتك الشخصية خلال 30 يوماً، باستثناء المعلومات المطلوبة قانونياً للاحتفاظ بها.
                    </p>
                </div>

                <div class="section mb-5">
                    <h2 class="h4 fw-bold text-primary mb-3 title">خصوصية الأطفال</h2>
                    <p class="text-muted">
                        خدماتنا مخصصة للبالغين فقط. نحن لا نجمع عمداً معلومات شخصية من الأطفال دون سن 18 عاماً. إذا علمنا أننا جمعنا معلومات من طفل، سنقوم بحذفها فوراً.
                    </p>
                </div>

                <div class="section mb-5">
                    <h2 class="h4 fw-bold text-primary mb-3 title">التحديثات على السياسة</h2>
                    <p class="text-muted">
                        قد نحدث سياسة الخصوصية من وقت لآخر. سنخطرك بأي تغييرات مهمة عبر البريد الإلكتروني أو من خلال إشعار على المنصة. استمرارك في استخدام خدماتنا بعد التحديث يعني موافقتك على السياسة المحدثة.
                    </p>
                </div> --}}

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
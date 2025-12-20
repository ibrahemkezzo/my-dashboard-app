<footer id="contact" class="footer">
    <div class="container">
        <!-- Newsletter Section -->
        <div class="newsletter-section">
            <div class="newsletter-content">
                <h3 class="newsletter-title">اشتركي في نشرتنا الإخبارية</h3>
                <p class="newsletter-description">
                    احصلي على أحدث العروض والخصومات وأخبار عالم التجميل
                </p>
                <form class="newsletter-form">
                    <input type="email" placeholder="عنوان بريدك الإلكتروني" class="newsletter-input">
                    <button type="reset" class="btn btn-primary newsletter-btn">
                        <i data-lucide="send"></i>
                        اشتركي
                    </button>
                </form>
            </div>
        </div>
        <!-- Main Footer Content -->
        <div class="footer-content">
            <!-- Company Info -->
            <div class="footer-section">
                <a href="{{ route('front.home') }}"><img class="logo-footer"
                        src="{{ asset('storage/' . $settings['cover_image']) }}" alt="Glowzelle | غلوزيلي"
                        width="168px" /></a>
                <p class="footer-description">
                    {{ $settings['footer_text'] }}
                </p>
                <!-- Contact Info -->
                <div class="contact-info">
                    <div class="contact-item">
                        <i data-lucide="phone"></i>
                        <span dir="ltr">{{ $settings['number_settings'] ?? '+966 50 123 4567' }}</span>
                    </div>
                    <div class="contact-item">
                        <i data-lucide="mail"></i>
                        <span>{{ $settings['email_settings'] }}</span>
                    </div>
                    <div class="contact-item">
                        <i data-lucide="map-pin"></i>
                        <span>{{ $settings['site_title'] }}</span>
                    </div>
                    <div class="contact-item d-flex flex-column align-items-start text-end">
                        <img src="{{ asset('frontend/assets/img/Logo_Ministry_of_Commerce.svg') }}" class="mb-3"
                            style="min-width:120px; max-width: 180px;" alt="وزارة التجارة">

                        <p class="mb-2">الرقم الموحد للمنشأه : <span>1111184535</span></p>
                        <p class="mb-2">الرقم الموحد للسجل التجاري : <span>7051733553</span></p>
                        <p class="mb-2">الرقم المميز : <span>3142449397</span></p>
                        <p class="mb-0">رقم الشهادة : <span>100251150643226</span></p>
                    </div>
                </div>
            </div>
            <!-- Quick Links -->
            <div class="footer-section">
                <h3 class="footer-section-title">روابط سريعة</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('front.home') }}" class="footer-link">الرئيسية</a></li>
                    <li><a href="{{ route('front.about-us') }}" class="footer-link">عن المنصة</a></li>
                    <li><a href="{{ route('front.salons.list', ['hasOffers' => true]) }}" class="footer-link">العروض
                            الخاصة</a></li>
                    <li><a href="{{ route('front.faq') }}" class="footer-link">الأسئلة الشائعة</a></li>
                    <li><a href="#" class="footer-link">تواصل معنا</a></li>
                    <li><a href="{{ route('front.privacy') }}" class="footer-link">سياسة الخصوصية</a></li>
                    <li><a href="{{ route('front.terms') }}" class="footer-link">الشروط والأحكام</a></li>
                </ul>
            </div>
            <!-- Services -->
            <div class="footer-section">
                <h3 class="footer-section-title">الخدمات</h3>
                <ul class="footer-links">
                    @foreach ($services as $service)
                        <li class="dropdown-parent-f">{{ $service->name }}
                            <ul class="dropdown-menu-f">
                                @foreach ($service->sub_services as $subService)
                                    <li class="dropdown-item"><a
                                            href="{{ route('front.salons.list', ['service_type' => $subService->name]) }}"
                                            class="footer-link">{{ $subService->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- Cities & Social -->
            <div class="footer-section">
                <h3 class="footer-section-title">المدن المتاحة</h3>
                {{-- <ul class="footer-links d-flex flex-wrap gap-3 list-unstyled">
                    @forelse ($cities as $index => $city)
                        @if ($index < 9)
                            <li>
                                <a href="{{ route('front.salons.list', ['city_id' => $city->id]) }}"
                                    class="footer-link text-decoration-none">
                                    {{ $city->name }}
                                </a>
                            </li>
                        @endif

                        @if ($index == 9)
                            @php
                                $remaining = $cities->count() - 9;
                            @endphp

                            <li>
                                <a href="#" class="footer-link text-decoration-none">
                                    +{{ $remaining }} مدينة أخرى
                                </a>
                            </li>
                        @endif
                    @empty
                        <li class="text-muted">لا توجد مدن متاحة حالياً</li>
                    @endforelse
                </ul> --}}

                <div class="footer-cities-container">
                    @php
                        $visibleCities = $cities->take(10); // أول 10 مدن فقط
                        $total = $cities->count();
                        $remaining = $total - 10;
                        $firstColumn = $visibleCities->take(5); // العمود الأيسر: أول 5
                        $secondColumn = $visibleCities->skip(5)->take(5); // العمود الأيمن: التالية 5
                    @endphp

                    <div class="row g-4">
                        <!-- العمود الأول -->
                        <div class="col-12 col-md-6 col-lg-5">
                            <ul class="footer-links list-unstyled mb-0">
                                @foreach ($firstColumn as $city)
                                    <li class="mb-2">
                                        <a href="{{ route('front.salons.list', ['city_id' => $city->id]) }}"
                                            class="footer-link ">
                                            {{ $city->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- العمود الثاني -->
                        <div class="col-12 col-md-6 col-lg-5">
                            <ul class="footer-links list-unstyled mb-0">
                                @foreach ($secondColumn as $city)
                                    <li class="mb-2">
                                        <a href="{{ route('front.salons.list', ['city_id' => $city->id]) }}"
                                            class="footer-link">
                                            {{ $city->name }}
                                        </a>
                                    </li>
                                @endforeach

                                {{-- +X مدينة أخرى في آخر العمود الثاني --}}

                            </ul>
                        </div>
                    </div>

                </div>


                {{-- إذا كان عدد المدن أقل من أو يساوي 9، نعرض الجملة فقط بدون +X --}}

                @if ($remaining > 0)
                    <a href="#" class="footer-link text-decoration-none">
                        +{{ $remaining }} مدينة أخرى
                    </a>
                @endif
                <p class="mt-3 mb-0 footer-link text-decoration-none">
                    <i class="fas fa-map-marker-alt me-1"></i>
                    نخدم جميع مدن ومحافظات المملكة العربية السعودية 🇸🇦
                </p>




                <!-- Social Media -->
                <div class="social-media">
                    <h4 class="social-title">تابعينا</h4>
                    <div class="social-links">
                        <a href="{{ $settings['social_links']['instagram'] ?? '#' }}" class="social-link">
                            <i data-lucide="instagram"></i>
                        </a>
                        <a href="{{ $settings['social_links']['facebook'] ?? '#' }}" class="social-link">
                            <i data-lucide="facebook"></i>
                        </a>
                        <a href="{{ $settings['social_links']['youtube'] ?? '#' }}" class="social-link">
                            <i data-lucide="youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bottom Bar -->
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <div class="copyright">
                    منصة غلوزيلي. جميع الحقوق محفوظة 2025 ©
                </div>
                <div class="footer-bottom-links">
                    <a href="{{ route('front.terms') }}" class="footer-bottom-link">الشروط والأحكام</a>
                    <a href="{{ route('front.privacy') }}" class="footer-bottom-link">سياسة الخصوصية</a>
                </div>
            </div>
        </div>
    </div>
</footer>

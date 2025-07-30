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
                <a href="{{ route('front.home') }}"><img class="logo-footer" src="{{ asset('storage/'.$settings['cover_image']) }}" alt="كوافيري | My Kawafir" width="168px" /></a>
                <p class="footer-description">
                    {{$settings['footer_text']}}
                </p>

                <!-- Contact Info -->
                <div class="contact-info">
                    <div class="contact-item">
                        <i data-lucide="phone"></i>
                        <span dir="ltr">{{$settings['number'] ?? '+966 50 123 4567'}}</span>
                    </div>
                    <div class="contact-item">
                        <i data-lucide="mail"></i>
                        <span>{{$settings['email_settings']}}</span>
                    </div>
                    <div class="contact-item">
                        <i data-lucide="map-pin"></i>
                        <span>{{$settings['site_title']}}</span>
                    </div>
                </div>
            </div>
            <!-- Quick Links -->
            <div class="footer-section">
                <h3 class="footer-section-title">روابط سريعة</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('front.home') }}" class="footer-link">الرئيسية</a></li>
                    <li><a href="{{ route('front.about-us') }}" class="footer-link">عن المنصة</a></li>
                    <li><a href="{{ route('front.salons.list', ['hasOffers' => true]) }}" class="footer-link">العروض الخاصة</a></li>
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
                        <li><a href="{{ route('front.salons.list', ['service_type' => $service->name]) }}" class="footer-link">{{ $service->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <!-- Cities & Social -->
            <div class="footer-section">
                <h3 class="footer-section-title">المدن المتاحة</h3>
                <ul class="footer-links">
                    @foreach ($cities as $city)
                        <li><a href="{{route('front.salons.list',['city_id'=>$city->id])}}" class="footer-link">{{$city->name}}</a></li>
                    @endforeach
                </ul>

                <!-- Social Media -->
                <div class="social-media">
                    <h4 class="social-title">تابعينا</h4>
                    <div class="social-links">
                        <a href="{{$settings['social_links']['instagram'] ?? '#'}}" class="social-link">
                            <i data-lucide="instagram"></i>
                        </a>
                        <a href="{{$settings['social_links']['facebook'] ?? '#'}}" class="social-link">
                            <i data-lucide="facebook"></i>
                        </a>
                        <a href="{{$settings['social_links']['youtube'] ?? '#'}}" class="social-link">
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
                    منصة كوافيري. جميع الحقوق محفوظة 2025 ©
                </div>
                <div class="footer-bottom-links">
                    <a href="{{ route('front.terms') }}" class="footer-bottom-link">الشروط والأحكام</a>
                    <a href="{{ route('front.privacy') }}" class="footer-bottom-link">سياسة الخصوصية</a>
                </div>
            </div>
        </div>
    </div>
</footer>
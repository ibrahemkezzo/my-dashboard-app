@if (session('message'))
    @php
        $type = session('message.type') ?? 'success';
        $content = session('message.content') ?? '';
        $img = session('message.img') ?? null;
        $icons = [
            'success' => '<i class="fa fa-check-circle me-2"></i>',
            'error' => '<i class="fa fa-times-circle me-2"></i>',
            'draft' => '<i class="fa fa-edit me-2"></i>',
        ];
        $alertClasses = [
            'success' => 'alert-success',
            'error' => 'alert-danger',
            'draft' => 'alert-warning',
        ];
        $icon = $icons[$type] ?? '';
    @endphp

    <!-- 1. Toast النصي (تحت الشاشة) -->
    @if ($content && !$img)
        <div id="text-toast" class="alert {{ $alertClasses[$type] ?? 'alert-info' }} d-flex align-items-center shadow-lg"
            style="
                position: fixed;
                bottom: 20px;
                left: 50%;
                transform: translateX(-50%) translateY(100px);
                z-index: 9998;
                min-width: 300px;
                max-width: 90vw;
                border-radius: 12px;
                padding: 1rem 1.5rem;
                opacity: 0;
                transition: all 0.6s ease;
                backdrop-filter: blur(12px);
                border: 1px solid rgba(255,255,255,0.3);
                font-weight: 600;
             ">
            @if ( $icon)
                <div class="me-3">{!! $icon !!}</div>
            @endif
            <span>{{ $content }}</span>
            <button type="button" class="btn-close btn-close-white ms-3"
                onclick="document.getElementById('text-toast')?.remove()"></button>
        </div>
    @endif

    <!-- 2. الصورة في المنتصف (كبيرة ومركزية) - مُعدّلة لرؤية الموقع خلفها -->
    @if ($img)
        <div id="image-toast"
            style="
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.3);
            z-index: 9999;
            opacity: 0;
            transition: all 0.9s cubic-bezier(0.18, 0.89, 0.32, 1.38);
            pointer-events: none;
         ">
            <div
                style="
                position: relative;
                width: fit-content;
                padding: 20px;
                background: rgba(255, 255, 255, 0.22);
                border-radius: 36px;
                backdrop-filter: blur(24px);
                -webkit-backdrop-filter: blur(24px);
                border: 1.5px solid rgba(255, 255, 255, 0.4);
                box-shadow:
                    0 30px 60px rgba(0, 0, 0, 0.35),
                    0 0 40px rgba(135, 54, 91, 0.25),
                    inset 0 2px 8px rgba(255, 255, 255, 0.3);
             ">
                <img src="{{ $img }}" alt="إنجاز رائع"
                    style="
                    width: 340px;
                    height: 460px;
                    max-width: 88vw;
                    max-height: 78vh;
                    object-fit: contain;
                    border-radius: 28px;
                    border: 7px solid white;
                    box-shadow: 0 15px 35px rgba(0,0,0,0.3);
                 ">
                <!-- Caption أنيق تحت الصورة -->
                @if ($content)
                    <div
                        style="
                    position: absolute;
                    bottom: -64px;
                    left: 50%;
                    transform: translateX(-50%);
                    background: linear-gradient(135deg, #87365b, #a45c7d);
                    color: white;
                    padding: 12px 32px;
                    border-radius: 50px;
                    font-size: 18px;
                    font-weight: 700;
                    white-space: nowrap;
                    backdrop-filter: blur(12px);
                    border: 2px solid rgba(255,255,255,0.3);
                    box-shadow: 0 10px 20px rgba(0,0,0,0.3);
                    letter-spacing: 0.5px;
                 ">
                        {{ $content }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Overlay مُحسّن: يظهر الموقع خلف الصورة بشكل خفيف وأنيق -->
        <div id="image-overlay"
            style="
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg,
                        rgba(135, 54, 91, 0.38),
                        rgba(164, 92, 125, 0.42),
                        rgba(215, 184, 198, 0.35));
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            z-index: 9997;
            opacity: 0;
            transition: opacity 0.8s ease;
         ">
        </div>
    @endif

    <style>
        /* موبايل */
        @media (max-width: 768px) {
            #image-toast img {
                width: 280px !important;
                height: 380px !important;
                border-width: 6px !important;
                border-radius: 24px !important;
            }

            #image-toast>div {
                padding: 12px !important;
                border-radius: 28px !important;
            }

            #image-toast>div>div {
                font-size: 16px !important;
                padding: 10px 28px !important;
                bottom: -56px !important;
            }
        }

        @media (max-width: 480px) {
            #image-toast img {
                width: 240px !important;
                height: 325px !important;
                border-width: 5px !important;
            }

            #image-toast>div>div {
                font-size: 15px !important;
                padding: 9px 24px !important;
            }
        }

        /* لابتوب وشاشات كبيرة */
        @media (min-width: 1024px) {
            #image-toast img {
                width: 380px !important;
                height: 510px !important;
            }
        }

        /* تحسين عام */
        #text-toast {
            font-family: 'Cairo', sans-serif;
        }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Text Toast
                const textToast = document.getElementById('text-toast');
                if (textToast) {
                    textToast.style.display = 'flex';
                    setTimeout(() => {
                        textToast.style.opacity = '1';
                        textToast.style.transform = 'translateX(-50%) translateY(0)';
                    }, 100);
                    setTimeout(() => {
                        textToast.style.opacity = '0.5';
                        textToast.style.transform = 'translateX(-50%) translateY(100px)';
                        setTimeout(() => textToast.remove(), 600);
                    }, 4000);
                }

                // Image Toast (صورة Glowzelle الفخمة)
                const imageToast = document.getElementById('image-toast');
                const overlay = document.getElementById('image-overlay');

                if (imageToast) {
                    overlay.style.opacity = '1';
                    setTimeout(() => {
                        imageToast.style.opacity = '1';
                        imageToast.style.transform = 'translate(-50%, -50%) scale(1)';
                    }, 150);

                    // ظهور لمدة 4 ثوانٍ (أطول كما طلبت)
                    setTimeout(() => {
                        imageToast.style.transform = 'translate(-50%, -50%) scale(0.3)';
                        imageToast.style.opacity = '0.5';
                        overlay.style.opacity = '0.5';

                        setTimeout(() => {
                            if (imageToast) imageToast.remove();
                            if (overlay) overlay.remove();
                        }, 900);
                    }, 4000);
                }
            });
        </script>
    @endpush

    {{-- تنظيف الرسالة من الـ session بعد العرض --}}
    @php session()->forget('message'); @endphp
@endif

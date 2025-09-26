@if(session('message'))
    @php
        $type = session('message.type') ?? 'success';
        $content = session('message.content') ?? '';
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
    @endphp
    <div id="alert-message">
        <div id="dashboard-toast-alert" class="alert {{ $alertClasses[$type] ?? 'alert-info' }} d-flex align-items-center"
         style="
            display: none;
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            z-index: 9999;
            min-width: 35%;
            max-width: 90vw;
            box-shadow: 0 4px 16px rgba(0,0,0,0.12);
            font-size: 16px;
            padding: 1rem 2rem;
            border-radius: 6px;
            opacity: 0;
            transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
         "
         role="alert"
        >
            {!! $icons[$type] ?? '' !!}
            <span>{{ $content }}</span>
        </div>
    </div>

    <style>
        @media (max-width: 768px) {
            #dashboard-toast-alert {
                min-width: 90%; /* زيادة العرض النسبي للشاشات الصغيرة */
                max-width: 100vw; /* ضمان عدم خروج الرسالة عن الشاشة */
                font-size: 14px; /* تصغير حجم الخط قليلاً */
                padding: 0.75rem 0.5rem; /* تقليل الحشوة */
            }
        }

        @media (max-width: 576px) {
            #dashboard-toast-alert {
                min-width: 99%; /* عرض أكبر للشاشات الصغيرة جدًا */
                max-width: 100vw; /* ضمان عدم قطع الرسالة */
                font-size: 12px; /* حجم خط أصغر */
                padding: 0.5rem 0.2rem; /* حشوة أصغر */
            }
        }
    </style>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var alertEl = document.getElementById('dashboard-toast-alert');
            if (alertEl) {
                // Show the alert with slide-in effect
                alertEl.style.display = 'flex';
                setTimeout(function() {
                    alertEl.style.opacity = '1';
                    alertEl.style.transform = 'translateX(-50%) translateY(0)';
                }, 10); // Small delay to ensure transition triggers

                // Hide the alert after 4 seconds with slide-out effect
                setTimeout(function() {
                    alertEl.style.opacity = '0';
                    alertEl.style.transform = 'translateX(-50%) translateY(100px)';
                    setTimeout(function() {
                        alertEl.style.display = 'none';
                    }, 500); // Match the transition duration
                }, 4000);
            }
        });
    </script>
    @endpush
    @php
        session()->forget('message');
    @endphp
@endif


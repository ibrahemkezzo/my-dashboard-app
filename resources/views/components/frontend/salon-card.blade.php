{{-- @dump(Auth::user()->favoriteSalons()->where('salon_id', $salon->id)->first() != null) --}}
<div class="salon-card">
    <div class="salon-image-container">
        <img src="{{ $salon->cover_image_url }}" alt="{{ $salon->name }}" class="salon-image" style="width: 100%;
    height: 230px;">
        <div class="salon-badge featured">
            @if ($salon->type == 'beauty_center')
            <i data-lucide="award"></i>
            مركز معتمد
            @elseif ($salon->type == 'cosmetic_clinic')
            <i data-lucide="syringe"></i>
            عيادة تجميل
            @else
            <i  style="width: 20px; height:20px;" data-lucide="home"></i>
            صالون منزلي
            @endif
        </div>
        @auth
        <button
            class="salon-fa-vorite {{Auth::user()->favoriteSalons()->where('salon_id', $salon->id)->first() ? 'active' : '' }}"
            data-salon-id="{{ $salon->id }}" onclick="toggleFavorite({{ $salon->id }})">
            <i data-lucide="heart" ></i>
        </button>
        @endauth

        <div class="salon-status {{ $salon->isOpen ? 'open' : 'closed' }}">
            <div class="status-dot"></div>
            {{ $salon->isOpen ? 'مفتوح' : 'مغلق' }}
        </div>
    </div>
    <div class="salon-content">
        <h3 class="salon-name">{{ $salon->name }}</h3>
        <div class="salon-rating">
            <div class="rating-stars">
                <i data-lucide="star" class="star filled"></i>
                <span class="rating-number">{{ $salon->rating ?? '4.9' }}</span>
            </div>
            <span class="reviews-count">({{ $salon->review_count ?? '24' }} تقييم)</span>
        </div>
        <div class="salon-location">
            <i data-lucide="map-pin"></i>
            <span>{{ $salon->city->name ?? ($salon->city_name ?? '-') }}</span>
        </div>
        <div class="salon-services">
            @if (isset($salon->subServices))
                @foreach ($salon->subServices->take(3) as $sub_service)
                    <span class="service-tag service-tag-salon two-words" data-text="{{ $sub_service->name }}">{{ implode(' ', array_slice(explode(' ', $sub_service->name), 0, 2)) }}</span>
                @endforeach
                @if ($salon->subServices->count() > 3)
                    <span class="service-tag service-tag-salon">+{{ $salon->subServices->count() - 3 }} المزيد</span>
                @else
                    <br />
                @endif
            @endif
        </div>

        <div class="salon-price">
            @if ($salon->price_range)
                @if ($salon->price_range['min'] == $salon->price_range['max'])
                    {{ $salon->price_range['min'] }}
                @else
                    {{ $salon->price_range['min'] }}-{{ $salon->price_range['max'] }} ريال
                @endif
            @else
                لا يوجد أسعار
            @endif
        </div>
        {{-- <div class="salon-offer">{{ $salon->offer_text ?? 'خصم 20% على الجلسة الأولى' }}</div> --}}
        <a href="{{ route('front.salons.show', $salon->id) }}" class="btn btn-primary salon-book-btn">احجزي موعدك</a>
    </div>
</div>

@push('styles')
    <style>
        .salon-services {
            display: inline-block;
            max-width: 300px; /* عرض ثابت */
            height: 60px; /* طول ثابت */
            overflow: hidden;
            vertical-align: middle;
        }
        .service-tag-salon {
            display: inline-block;
            /* padding: 5px 10px;
            margin: 2px;
            background-color: #f0f0f0; */
            /* border-radius: 5px; */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        /* .service-tag-salon::after {
            content: "";
            display: inline-block;
            width: 0;
        } */

        .service-tag.two-words {
            max-width: 100px; /* تحديد طول ثابت لكل تاج */
            overflow: hidden;
            text-overflow: ellipsis;
            display: inline-block;
        }
        /* .service-tag-salon.two-words::after {
            content: attr(data-text);
            position: absolute;
            visibility: hidden;
            white-space: nowrap;
        } */
        .service-tag-salon.two-words {
            display: inline-block;
            max-width: 100px; /* ضبط العرض حسب الحاجة */
        }
    </style>
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/assets/js/pages-scripts2.js') }}"></script>
    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        function toggleFavorite(salonId) {
            // Prevent action if user is not authenticated
            @if (!auth()->check())
                alert('يرجى تسجيل الدخول لإضافة الصالون إلى المفضلة.');
                return;
            @endif

            const button = document.querySelector(`button[data-salon-id="${salonId}"]`);

            fetch('{{ route('front.profile.toggleFavorite') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ salon_id: salonId }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Only toggle the 'active' class on the button
                    button.classList.toggle('active', data.is_favorited);

                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ أثناء الاتصال بالخادم، حاول مرة أخرى.');
            });
        }
    </script>
@endpush

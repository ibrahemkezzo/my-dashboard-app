
{{-- @dd($salon->working_hours) --}}
<div class="salon-card">
    <div class="salon-image-container">
        <img src="{{ $salon->cover_image_url }}" alt="{{ $salon->name }}" class="salon-image">
        <div class="salon-badge featured">
            <i data-lucide="award"></i>
            مركز معتمد
        </div>
        <button class="salon-favorite">
            <i data-lucide="heart"></i>
        </button>
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
                    <span class="service-tag">{{ $sub_service->name }}</span>
                @endforeach
                @if ($salon->subServices->count() > 3)
                    <span class="service-more">+{{ $salon->subServices->count() - 3 }} المزيد</span>
                @else
                    <br />
                @endif
            @elseif(isset($salon->sub_services))
                @foreach (collect($salon->sub_services)->take(3) as $sub_service)
                    <span class="service-tag">{{ $sub_service }}</span>
                @endforeach
                @if (count($salon->sub_services) > 3)
                    <span class="service-more">+{{ count($salon->sub_services) - 3 }} المزيد</span>
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
        <div class="salon-offer">{{ $salon->offer_text ?? 'خصم 20% على الجلسة الأولى' }}</div>
        <a href="{{ route('front.salons.show', $salon->id) }}" class="btn btn-primary salon-book-btn">احجزي موعدك</a>
    </div>
</div>

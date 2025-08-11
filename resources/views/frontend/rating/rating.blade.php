@extends('layouts.frontend')

@section('title', 'تقييم الصالون | كوافيري | My Kawafir')

@section('main')
    <main class="main-content rating-page">
        <div class="container">
            <div class="rating-container">
                <div class="rating-card">
                    <!-- Page Title -->
                    <div class="page-header">
                        <h1 class="page-title">تقييم التجربة</h1>
                        <p class="page-subtitle">شاركينا تجربتك وساعدي العملاء الآخرين في اتخاذ القرار المناسب</p>
                    </div>

                    <!-- Rating Form -->
                    <form class="rating-form" id="ratingForm" action="{{ route('front.ratings.store', $salon) }}" method="POST" onsubmit="return handleSubmitOnce(this)">
                        @csrf
                        <!-- Salon Info Section -->
                        <div class="salon-info-section">
                            <div class="salon-img">
                                @if ($salon->cover_image_url)
                                    <img src="{{ $salon->cover_image_url }}" alt="{{ $salon->name }}">
                                @elseif($salon->logo_url)
                                    <img src="{{ $salon->logo_url }}" alt="{{ $salon->name }}">
                                @else
                                    <img src="https://images.unsplash.com/photo-1560066984-138dadb4c035?ixlib=rb-4.0.3"
                                        alt="{{ $salon->name }}">
                                @endif
                            </div>
                            <div class="salon-details">
                                <h3 class="salon-name">{{ $salon->name }}</h3>
                                <p class="salon-address">{{ $salon->address }}</p>
                            </div>
                        </div>



                        <!-- Star Rating Section -->
                        <div class="rating-section">
                            <label class="section-label">
                                <i class="fas fa-star"></i>
                                تقييمك العام للتجربة
                            </label>
                            <div class="star-rating" id="starRating">
                                <input type="radio" name="rating" value="5" id="star1" {{ (isset($existingRating) && $existingRating->rating==5) ? 'checked' : '' }}>
                                <label for="star1" class="star-label">
                                    <i class="fas fa-star"></i>
                                </label>
                                <input type="radio" name="rating" value="4" id="star2" {{ (isset($existingRating) && $existingRating->rating==4) ? 'checked' : '' }}>
                                <label for="star2" class="star-label">
                                    <i class="fas fa-star"></i>
                                </label>
                                <input type="radio" name="rating" value="3" id="star3" {{ (isset($existingRating) && $existingRating->rating==3) ? 'checked' : '' }}>
                                <label for="star3" class="star-label">
                                    <i class="fas fa-star"></i>
                                </label>
                                <input type="radio" name="rating" value="2" id="star4" {{ (isset($existingRating) && $existingRating->rating==2) ? 'checked' : '' }}>
                                <label for="star4" class="star-label">
                                    <i class="fas fa-star"></i>
                                </label>
                                <input type="radio" name="rating" value="1" id="star5" {{ (isset($existingRating) && $existingRating->rating==1) ? 'checked' : '' }}>
                                <label for="star5" class="star-label">
                                    <i class="fas fa-star"></i>
                                </label>
                            </div>
                            <div class="rating-text" id="ratingText">اختاري التقييم</div>
                        </div>

                        <!-- Review Text Section -->
                        <div class="review-section">
                            <label for="reviewText" class="section-label">
                                <i class="fas fa-edit"></i>
                                شاركي تفاصيل تجربتك
                            </label>
                            <textarea id="reviewText" name="review" class="review-textarea" placeholder="أخبرينا عن تجربتك..." rows="6">{{ $existingRating->review ?? '' }}</textarea>
                            <div class="character-count">
                                <span id="charCount">0</span>/500 حرف
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="submit-section">
                            <button type="submit" class="btn-submit" id="submitBtn">
                                <i class="fas fa-paper-plane"></i>
                                {{ isset($existingRating) ? 'تحديث التقييم' : 'إرسال التقييم' }}
                            </button>
                            <p class="submit-note">سيتم نشر تقييمك بعد مراجعته من قبل فريقنا</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/rating.css') }}">
@endpush

@push('scripts')
<script>
function handleSubmitOnce(form){
  const btn = form.querySelector('#submitBtn');
  if(btn){ btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الإرسال...'; }
  return true;
}
// live char count
const ta = document.getElementById('reviewText');
const cc = document.getElementById('charCount');
if(ta && cc){
  ta.addEventListener('input',()=>{ cc.textContent = Math.min(ta.value.length, 500); });
  cc.textContent = Math.min(ta.value.length, 500);
}
</script>
@endpush

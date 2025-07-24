@extends('layouts.frontend')

@section('title', 'منصة حجز خدمات التجميل | كوافيري | المفضلة')

@section('main')
<main class="main-content">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">الصالونات المفضلة</h1>
            <p class="page-subtitle">جميع الصالونات والخبيرات التي أضفتِها لقائمة المفضلة</p>
            <div class="favorites-stats">
                <span class="stat-item">
                    <i class="fas fa-heart"></i>{{ $favorites->count() }} صالونات مفضلة
                </span>
            </div>
        </div>

        <section class="main-layout py-4">
            <div class="container">
                <div class="row">
                    @forelse ($favorites as $salon)
                        <div class="col-lg-4 mb-4">
                            <x-frontend.salon-card :salon="$salon" />
                        </div>
                    @empty
                        <div class="empty-state" id="emptyState">
                            <i class="fas fa-heart"></i>
                            <h4>لا توجد صالونات مفضلة</h4>
                            <p>ابدئي بإضافة صالونات إلى قائمة المفضلة</p>
                            <a href="{{ route('front.salons.list') }}" class="btn btn-primary">
                                <i class="fa fa-search-sm"></i>تصفح الصالونات
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
</main>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/pages-styles2.css') }}">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/assets/js/pages-scripts2.js') }}"></script>
    <script>
        function toggleFavorite(salonId) {
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
                const button = document.querySelector(`button[data-salon-id="${salonId}"]`);
                if (data.success) {
                    button.classList.toggle('active', data.is_favorited);
                    alert(data.message);
                } else {
                    alert('حدث خطأ، حاول مرة أخرى.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ، حاول مرة أخرى.');
            });
        }
    </script>
@endpush
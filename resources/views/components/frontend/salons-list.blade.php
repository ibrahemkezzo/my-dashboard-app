<div class="salons-grid">
    @foreach ($salons as $salon)
        @include('components.frontend.salon-card', ['salon' => $salon])
    @endforeach
</div>
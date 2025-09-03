<div class="footer-categories">
    <h6 class="pb-3 pt-5">Kategori Event</h6>
    <div class="d-flex flex-column align-items-start">
        @foreach ($categories as $category)
            <a href="{{ route('events.category', $category->slug) }}">
                <p class="fw-medium text-capitalize text-nowrap">
                    {{ $category->name }}
                </p>
            </a>
        @endforeach
    </div>
</div>

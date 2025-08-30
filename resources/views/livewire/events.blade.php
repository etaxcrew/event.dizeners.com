@section('title')
Semua Event
@stop

@section('keywords')
Food Store, Event Gorontalo
@stop

@section('description')
Cari tiket event seru di Gorontalo
@stop

<main class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="mb-0">Semua Event</h2>
            </div>
        </div>

        <div class="row">
            @forelse($events as $event)
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title mb-2">{{ $event->title }}</h5>
                            <p class="card-text text-muted">{{ Str::limit(strip_tags($event->description), 160, '...') }}</p>
                            <a href="{{ route('event.detail', $event->slug) }}" class="btn btn-dark">Detail</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">Belum ada event.</p>
                </div>
            @endforelse
        </div>
    </div>
</main>




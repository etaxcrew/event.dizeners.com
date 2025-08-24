@section('title')
{{ $event->title }}
@stop

@section('keywords')
Food Store, Event Gorontalo
@stop

@section('description')
Cari tiket event seru di Gorontalo
@stop

{{-- @section('image')
{{ asset('images/logo.png') }}
@stop --}}

    <main>
        <section class="charity-section-header position-relative pb-80 overflow-hidden d-none d-lg-block">
            <div class="position-relative text-center bg-img-coworking" data-background="{{ asset('images/header-bg.png') }}">
                <div class="container py-100 position-relative z-1">
                    <div class="col-12 text-center">
                        <h1 class="mb-5 text-anime-style-2">{{ $event->title }}</h1>
                        <div class="d-flex justify-content-center flex-wrap align-items-center gap-2 d-inline-flex">
                            <a href="{{ route('home') }}">
                                <span class="text-capitaliz fw-medium">Beranda</span>
                            </a>
                            <i class="fa-solid fa-angle-right fs-7 d-block"></i>
                            <a href="{{ route('home') }}" class="d-block">
                                <span class="text-capitalize fw-medium">{{ $event->category->name;  }}</span>
                            </a>
                            <i class="fa-solid fa-angle-right fs-7"></i>
                            <span class="text-capitalize fw-medium">{{ $event->title }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="charity-causes-details-section-1 pt-5 pb-7 overflow-hidden d-block d-lg-none">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex flex-wrap align-items-center gap-2 d-inline-flex">
                            <a href="{{ route('home') }}">
                                <span class="text-capitalize fw-medium">Beranda</span>
                            </a>
                            <i class="fa-solid fa-angle-right fs-7 d-block"></i>
                            <a href="{{ route('home') }}" class="d-block">
                                <span class="text-capitalize fw-medium">{{ $event->category->name; }}</span>
                            </a>
                            <i class="fa-solid fa-angle-right fs-7"></i>
                            <span class="text-capitalize fw-medium">{{ $event->title }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="charity-donation-details-section-1 pb-100 overflow-hidden">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 mx-lg-auto">
                        <div class="mb-5">
                            <img class="rounded-5" data-aos="zoom-in" src="{{ Storage::url($event->banner_path) }}" alt="{{ $event->title }}" width="100%" />
                            <div class="bg-light rounded-4 p-lg-5 p-md-4 p-3 z-1 wow img-custom-anim-top d-none d-lg-block">
                                {{-- Progress Bar dengan Pengecekan Tiket --}}
                                @if ($event->tickets->isNotEmpty())
                                    @php
                                        $ticket = $event->tickets->first(); // tiket pertama (misal harga termurah, sudah diurutkan di controller)
                                        $remaining = $ticket->remaining ?? 0;
                                        $stock = $ticket->stock ?? 1;
                                        $sold = $stock - $remaining;
                                        $percentSold = ($stock > 0) ? round(($sold / $stock) * 100) : 0;
                                    @endphp
                                    <div class="position-relative progressbar mt-5">
                                        <span class="position-absolute top-0 start-50 translate-middle-y fs-7 fw-medium" style="margin: -10px">
                                            {{ $percentSold }}%
                                        </span>
                                        <div class="progress bg-white" role="progressbar"
                                            aria-label="Sisa Tiket"
                                            aria-valuenow="{{ $remaining }}"
                                            aria-valuemin="0"
                                            aria-valuemax="{{ $stock }}">
                                            <div class="progress-bar rounded-pill wow img-custom-anim-left"
                                                style="width: {{ $percentSold }}%; transition: width 1.2s ease-in-out;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-3 mb-3">
                                        <div class="d-flex gap-2">
                                            <p class="fs-7 mb$-0">Kuota</p>
                                            <p class="fs-7 mb-0 fw-bold text-dark">{{ $stock }} Tiket</p>
                                        </div>
                                        <div class="d-flex gap-2">
                                            @if ($ticket->remaining > 0)
                                            <p class="fs-7 mb-0 fw-bold text-dark">Tersisa</p>
                                            <p class="fs-7 mb-0 fw-bold text-dark">{{ $remaining }} Tiket</p>
                                            @else
                                            <p class="fs-7 mb-0 fw-bold text-dark">Habis Terjual</p>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                <div class="d-flex flex-wrap gap-1 align-items-center justify-content-between">
                                    <h6 class="mb-0">
                                        @php
                                        $minPrice = $event->tickets->min('price');
                                        @endphp
                                        {{ $minPrice == 0 ? 'Event Gratis' : 'Mulai dari Rp ' . number_format($minPrice, 0, ',', '.') }}
                                    </h6>
                                    <a href="{{ route('select.ticket', $event->slug) }}" class="btn btn-primary hover-up">
                                        <span class="text-dark">Daftar Tiket</span>
                                        {{-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <g clip-path="url(#clip0_1136_654)">
                                                <path d="M15.8167 7.55759C15.8165 7.5574 15.8163 7.55719 15.8161 7.557L12.5504 4.307C12.3057 4.06353 11.91 4.06444 11.6665 4.30912C11.423 4.55378 11.4239 4.9495 11.6686 5.193L13.8612 7.375H0.625C0.279813 7.375 0 7.65481 0 8C0 8.34519 0.279813 8.625 0.625 8.625H13.8612L11.6686 10.807C11.4239 11.0505 11.423 11.4462 11.6665 11.6909C11.91 11.9356 12.3058 11.9364 12.5504 11.693L15.8162 8.443C15.8163 8.44281 15.8165 8.44259 15.8167 8.4424C16.0615 8.19809 16.0607 7.80109 15.8167 7.55759Z" fill="#ECAB23" />
                                            </g>
                                        </svg> --}}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <h4 class="mb-3 text-anime-style-3">{{ $event->title }}</h4>
                        <p class="fw-semibold">
                            <i class="fa-regular fa-calendar-days me-1"></i> {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d F Y') }}
                            @if (!is_null($event->end_date))
                            -
                            {{ \Carbon\Carbon::parse($event->end_date)->translatedFormat('d F Y') }}
                            @endif
                        </p>
                        <p class="fw-semibold">
                            <i class="fa-regular fa-clock me-1"></i> {{ \Carbon\Carbon::parse($event->open_time)->translatedFormat('H:i') }}
                            @if (!is_null($event->closed_time))
                            -
                            {{ \Carbon\Carbon::parse($event->closed_time)->translatedFormat('H:i') }} WIB
                            @endif
                        </p>
                        <p class="fw-semibold">
                            <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $event->location }}
                        </p>
                        <p class="wow img-custom-anim-top">{{ $event->highlight }}</p>
                        <h5 class="mb-3 mt-3 text-anime-style-3">Deskripsi</h6>
                        <p class="wow img-custom-anim-top">{{ $event->description }}</p>
                    </div>
                </div>
            </div>

            <!-- Fixed bottom bar hanya mobile/tablet -->
            <div class="ticket-bar bg-light">
                <p class="fs-18 text-dark mb-0">
                    @php
                    $minPrice = $event->tickets->min('price');
                    @endphp
                    {{ $minPrice == 0 ? 'Event Gratis' : 'Mulai dari Rp ' . number_format($minPrice, 0, ',', '.') }}
                </p>
                <a href="{{ route('select.ticket', $event->slug) }}" class="btn btn-primary hover-up">
                    <span class="text-dark">Daftar Tiket</span>
                </a>
            </div>

        </section>
    </main>

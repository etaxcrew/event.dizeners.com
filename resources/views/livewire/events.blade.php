@section('title')
Beli Tiket Event dan Konser Online dengan Mudah | Dizeners.com @stop

@section('keywords')dizeners, event, platform penjualan, event gorontalo @stop

@section('description')
Beli tiket event, konser, dan festival online dengan mudah dan cepat. Temukan hiburan favoritmu hanya di Dizeners.com @stop

    <main>
        <section class="charity-section-header position-relative pb-80 overflow-hidden d-none d-lg-block">
            <div class="position-relative text-center bg-img-coworking" data-background="{{ asset('images/header-bg.png') }}">
                <div class="container py-100 position-relative z-1">
                    <div class="col-12 text-center">
                        <h1 class="mb-5 text-anime-style-2">Semua Acara yang Tersedia</h1>
                        <div class="d-flex justify-content-center flex-wrap align-items-center gap-2 d-inline-flex">
                            <a href="{{ route('home') }}">
                                <span class="text-capitaliz fw-medium">Beranda</span>
                            </a>
                            <i class="fa-solid fa-angle-right fs-7"></i>
                            <span class="text-capitalize fw-medium">Daftar Event</span>
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
                            <i class="fa-solid fa-angle-right fs-7"></i>
                            <span class="text-capitalize fw-medium">Daftar Event</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- home section 4 -->
        <section class="charity-donation-details-section-1 pb-100 overflow-hidden">
            <div class="container position-relative d-block d-lg-none">
                <div class="row text-center mb-80">
                    <div class="number-step d-flex align-items-center justify-content-center gap-3">
                        <i class="fa-regular fa-calendar-days text-primary"></i>
                        <span class="btn-text">Semua Acara yang Tersedia</span>
                    </div>
                    <h2 class="text-dark my-3 text-anime-style-3">
                        Pilih Jenis Acara yang Sesuai
                        <span class="bg-white border border-dark rounded-5 px-2">Minatmu</span>
                    </h2>
                </div>
            </div>

            <div class="container-fluid wow img-custom-anim-top">
                <div class="text-center">
                    <div class="button-group filter-button-group filter-menu-active">
                        <button class="fs-18 btn btn-md btn-filter mb-5 me-4 {{ $selectedCategory === 'all' ? 'active' : '' }}" wire:click="setCategory('all')">Semua Kategori</button>

                        {{-- <button class="fs-18 btn btn-md btn-filter mb-5 me-4 {{ $selectedCategory === 'upcoming' ? 'active' : '' }}" wire:click="setCategory('upcoming')">Event Mendatang</button>
                        <button class="fs-18 btn btn-md btn-filter mb-5 me-4 {{ $selectedCategory === 'online' ? 'active' : '' }}" wire:click="setCategory('online')">Event Online</button>
                        <button class="fs-18 btn btn-md btn-filter mb-5 me-4 {{ $selectedCategory === 'offline' ? 'active' : '' }}" wire:click="setCategory('offline')">Event Offline</button>
                        <button class="fs-18 btn btn-md btn-filter mb-5 me-4 {{ $selectedCategory === 'free' ? 'active' : '' }}" wire:click="setCategory('free')">Event Gratis</button>
                        <button class="fs-18 btn btn-md btn-filter mb-5 me-4 {{ $selectedCategory === 'paid' ? 'active' : '' }}" wire:click="setCategory('paid')">Event Berbayar</button>
                        <button class="fs-18 btn btn-md btn-filter mb-5 me-4 {{ $selectedCategory === 'popular' ? 'active' : '' }}" wire:click="setCategory('popular')">Event Populer</button> --}}

                        @foreach ($categories as $category)
                            <button class="fs-18 btn btn-md btn-filter mb-5 me-4 {{ $selectedCategory === $category->slug ? 'active' : '' }}" wire:click="setCategory('{{ $category->slug }}')">
                                {{ $category->name }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="container mt-4">
                    <div class="row justify-content-between">
                        @forelse ($events as $event)
                            <div class="col-12 col-lg-4 col-md-6 mb-4">
                                <div class="card-listing bg-white rounded-4 hover-up border overflow-hidden">
                                    <div class="position-relative">
                                        <a href="{{ route('event.detail', $event->slug) }}">
                                            <img class="w-100" src="{{ Storage::url($event->banner_path) }}" alt="{{ $event->title }}" />
                                        </a>
                                        <a href="our-causes-details.html">
                                            <span class="badge bg-primary border border-dark fs-7 position-absolute top-100 end-0 translate-middle-y me-8 text-dark">
                                                {{ $event->category->name }}
                                            </span>
                                        </a>
                                    </div>
                                    <div class="card-content p-4 bg-white align-self-stretch">
                                        <a href="{{ route('event.detail', $event->slug) }}">
                                            <h6 class="text-anime-style-3">{{ $event->title }}</h6>
                                        </a>
                                        {{-- <p class="mt-3 text-muted">{{ Str::limit(strip_tags($event->highlight), 100, '...') }}</p> --}}
                                        <p class="mt-4 fw-semibold">
                                            <i class="fa-regular fa-calendar-days me-1"></i>
                                            {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d F Y') }}
                                            @if (!is_null($event->end_date))
                                                -
                                                {{ \Carbon\Carbon::parse($event->end_date)->translatedFormat('d F Y') }}
                                            @endif
                                            {{-- @php
                                                use Carbon\Carbon;
                                                $tanggalAkhir = $event->end_date ?? $event->start_date;
                                            @endphp
                                            - {{ Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') }} --}}
                                        </p>
                                        <p class="text-muted">
                                            @if ($event->is_online)
                                                <i class="bi bi-wifi text-success"></i>
                                                <span class="fw-medium">Event Online</span>
                                            @else
                                                <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                                {{ $event->location ?? '-' }}
                                            @endif
                                        </p>

                                        {{-- Progress Bar dengan Pengecekan Tiket --}}
                                        @if ($event->tickets->isNotEmpty())
                                            @php
                                                $ticket = $event->tickets->first(); // tiket pertama (misal harga termurah, sudah diurutkan di controller)
                                                $remaining = $ticket->remaining ?? 0;
                                                //$sisa = $ticket->remaining > 0 ? $ticket->remaining . ' Tiket' : 'Habis Terjual';
                                                //$sisa = ($ticket->remaining ?? 0) . ' Tiket';
                                                $stock = $ticket->stock ?? 1;
                                                $sold = $stock - $remaining;
                                                $percentSold = ($stock > 0) ? round(($sold / $stock) * 100) : 0;
                                            @endphp

                                            <div class="position-relative mt-5">
                                                <div class="progress" role="progressbar"
                                                    aria-label="Sisa Tiket"
                                                    aria-valuenow="{{ $remaining }}"
                                                    aria-valuemin="0"
                                                    aria-valuemax="{{ $stock }}">
                                                    <div
                                                        class="progress-bar bg-success rounded-pill wow img-custom-anim-left"
                                                        style="width: {{ $percentSold }}%; transition: width 1.2s ease-in-out;">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="d-flex justify-content-between mt-3">
                                            <div class="d-flex gap-2">
                                                <div>
                                                    <p class="fs-7 mb-0">Mulai dari</p>
                                                    <p class="fs-7 mb-0 fw-bold text-dark">
                                                        @php
                                                        $minPrice = $event->tickets->min('price');
                                                        @endphp
                                                        {{ $minPrice == 0 ? 'Gratis' : 'Rp ' . number_format($minPrice, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <div>
                                                    @if ($ticket->remaining > 0)
                                                        <p class="fs-7 mb-0">Tersedia</p>
                                                        <p class="fs-7 mb-0 fw-bold text-dark">{{ $remaining }} Tiket</p>
                                                    @else
                                                        <p class="fs-7 mb-0 fw-bold text-dark">Habis Terjual</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="fs-18 text-center">Belum ada acara tersedia.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

    </main>

{{-- <main class="py-5">
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
</main> --}}




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
        <section class="charity-causes-details-section-1 pt-5 overflow-hidden">
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
                            <i class="fa-solid fa-angle-right fs-7 d-block"></i>
                            <a href="{{ route('event.detail', $event->slug) }}" class="d-block">
                                <span class="text-capitalize fw-medium">{{ $event->title; }}</span>
                            </a>
                            <i class="fa-solid fa-angle-right fs-7"></i>
                            <span class="text-capitalize fw-medium">Pilih Tiket</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="charity-donation-details-section-2 pt-40 pb-80 overflow-hidden">
            <div class="container py-4">
                {{-- Header --}}
                <div class="bg-white p-4 rounded shadow-sm mb-5">
                    <h4>{{ $event->title }}</h4>
                    <p>
                        <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $event->location }}
                    </p>
                </div>
                @if (session()->has('message'))
                    <div class="alert alert-success mt-2">
                        {{ session('message') }}
                    </div>
                @endif
                <div class="row g-4">
                    {{-- Daftar tiket --}}
                    <div class="col-lg-8">
                        <p class="fs-18 mb-3">Pilihan tiket untuk Anda</h6>
                        @foreach($tickets as $ticket)
                            <div class="card border shadow-sm mb-3">
                                <div class="card-body d-flex justify-content-between">
                                    <div>
                                        <p class="fs-18 fw-semibold text-dark">{{ $ticket->name }}</p>
                                        <div class="text-muted mb-3">
                                            <i class="bi bi-clock"></i>
                                            {{ \Carbon\Carbon::parse($ticket->start_date)->format('d F Y') }} WIB
                                        </div>
                                        <a class="fw-medium text-decoration-none text-primary" data-bs-toggle="modal" href="#infoModal">
                                            Lihat Detail Paket <i class="bi bi-chevron-right"></i>
                                        </a>
                                        <!-- Modal Info Pembelian -->
                                        <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title" id="infoModalLabel">Detail Paket</h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{-- <ul>
                                                            <li>Setiap pembelian tiket bersifat final dan tidak dapat dibatalkan atau dikembalikan.</li>
                                                            <li>Tiket yang sudah dibeli tidak dapat dipindahtangankan kepada orang lain.</li>
                                                            <li>Harap membawa identitas diri yang valid saat menghadiri acara.</li>
                                                            <li>Tiket hanya berlaku untuk tanggal dan waktu yang tertera pada tiket.</li>
                                                            <li>Harap tiba tepat waktu sesuai dengan jadwal acara.</li>
                                                        </ul> --}}
                                                        <p class="fw-medium">{{ $ticket->about }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="text-end">
                                        <div class="fw-semibold">
                                            @if ($ticket->price == 0)
                                                <span class="text-success">Gratis</span>
                                            @else
                                                <span class="text-dark">Rp {{ number_format($ticket->price, 0, ',', '.') }}</span>
                                            @endif
                                        </div>
                                        @if(isset($cart[$ticket->id]))
                                            <div class="d-flex align-items-center mt-2">
                                                <div class="input-group input-group-sm">
                                                    <button class="btn btn-outline-danger btn-sm me-1 d-lg-none" wire:click="removeFromCart({{ $ticket->id }})">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                    <button class="btn btn-outline-secondary btn-sm" wire:click="decrementQuantity({{ $ticket->id }})">-</button>
                                                    <span class="mx-3">{{ $cart[$ticket->id]['quantity'] }}</span>
                                                    {{-- <input type="text" min="1" max="{{ $ticket->max_per_user }}" class="form-control form-control-sm text-center"
                                                        style="width: 60px;" wire:model="cart.{{ $ticket->id }}.quantity" readonly /> --}}
                                                    <button class="btn btn-outline-secondary btn-sm" wire:click="incrementQuantity({{ $ticket->id }})">+</button>
                                                </div>
                                            </div>
                                            <small class="text-muted">Max {{ $ticket->max_per_user }} tix/user</small>
                                        @else
                                            <div class="input-group input-group-sm">
                                                <button class="btn btn-success btn-sm mt-3 me-1" wire:click="addToCart({{ $ticket->id }})">
                                                    Tambah
                                                </button>
                                            </div>
                                            <small class="text-muted d-block">Max {{ $ticket->max_per_user }} tix/user</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Ringkasan Pesanan --}}
                    <div class="col-lg-4 d-none d-lg-block">
                        <div class="card border shadow-sm">
                            <div class="card-body">
                                <p class="fs-22 fw-semibold text-dark mb-3">Detail Pemesanan</p>

                                @if(count($cart) > 0)
                                    @foreach($cart as $id => $item)
                                        <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-2">
                                            <div>
                                                <div class="fw-bold">{{ $item['name'] }}</div>
                                                {{-- <small class="text-muted">{{ $item['date'] }}</small><br /> --}}
                                                <span class="text-primary">Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="input-group input-group-sm">
                                                    <button class="btn btn-outline-danger btn-sm me-1" wire:click="removeFromCart({{ $id }})">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                    <button class="btn btn-outline-secondary btn-sm" wire:click="decrementQuantity({{ $id }})">-</button>
                                                    <span class="mx-2">{{ $item['quantity'] }}</span>
                                                    <button class="btn btn-outline-secondary btn-sm" wire:click="incrementQuantity({{ $id }})">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="d-flex justify-content-between fw-bold mt-3">
                                        <span>Total ({{ $totalQuantity }} tiket)</span>
                                        <span class="text-primary">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                                    </div>

                                    <button class="btn btn-primary w-100 mt-3 text-dark" wire:click="goToCheckout">Pesan Tiket</button>
                                @else
                                    <p class="text-muted">Tiket yang dipilih akan ditampilkan disini</p>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <span>Total (0 tiket)</span>
                                        <span>-</span>
                                    </div>
                                    <button class="btn btn-secondary w-100 mt-3" disabled>Pesan Tiket</button>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Fixed bottom bar hanya mobile/tablet -->
            <div class="ticket-bar d-lg-none">
                <div class="d-flex flex-column">
                    {{-- <a class="fs-12 fw-medium text-decoration-none text-primary mb-2" data-bs-toggle="modal" href="#viewCartModal">
                        Lihat Pesanan
                    </a> --}}
                    <p class="fs-12 text-dark mb-0">
                        @if($totalQuantity > 0) Total ({{ $totalQuantity }} tiket) @else Total (0 tiket) @endif
                    </p>
                    @if($totalQuantity > 0)
                    <p class="fs-18 fw-semibold text-dark mb-0">
                        Rp {{ number_format($totalPrice, 0, ',', '.') }}
                    </p>
                    @else
                    -
                    @endif
                </div>
                <button class="btn btn-primary text-dark" wire:click="goToCheckout" {{ $totalQuantity == 0 ? 'disabled' : '' }}>
                    Bayar Tiket
                </button>
            </div>

            <!-- Modal View Cart (Mobile) -->
            <div class="modal fade" id="viewCartModal" tabindex="-1" aria-labelledby="viewCartModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="viewCartModalLabel">Detail Pemesanan</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if(count($cart) > 0)
                                @foreach($cart as $id => $item)
                                    <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-2">
                                        <div>
                                            <div class="fw-bold">{{ $item['name'] }}</div>
                                            {{-- <small class="text-muted">{{ $item['date'] }}</small><br /> --}}
                                            <span class="text-primary">Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="input-group input-group-sm">
                                                <button class="btn btn-outline-danger btn-sm me-1" wire:click="removeFromCart({{ $id }})">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                                <button class="btn btn-outline-secondary btn-sm" wire:click="decrementQuantity({{ $id }})">-</button>
                                                <span class="mx-2">{{ $item['quantity'] }}</span>
                                                <button class="btn btn-outline-secondary btn-sm" wire:click="incrementQuantity({{ $id }})">+</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="d-flex justify-content-between fw-bold mt-3">
                                    <span>Total ({{ $totalQuantity }} tiket)</span>
                                    <span class="text-primary">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                                </div>

                            @else
                                <p class="text-muted">Tiket yang dipilih akan ditampilkan disini</p>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <span>Total (0 tiket)</span>
                                    <span>-</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

        </section>
        {{-- SweetAlert2 Toast --}}
        <script>
            window.addEventListener('ticket-limit-exceeded', event => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'warning',
                    title: event.detail.message,
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        </script>

    </main>




    <main>
        <section class="charity-causes-details-section-1 pt-5 pb-2 overflow-hidden">
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
                            <i class="fa-solid fa-angle-right fs-7 d-block"></i>
                            <a href="{{ route('event.detail', $event->slug) }}/pilih-tiket" class="d-block">
                                <span class="text-capitalize fw-medium">Pilih Tiket</span>
                            </a>
                            {{-- <i class="fa-solid fa-angle-right fs-7"></i>
                            <span class="text-capitalize fw-medium">Konfirmasi</span> --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="charity-donation-details-section-2 pt-40 pb-80 overflow-hidden">
            <div class="container py-4">
                {{-- Header --}}
                <div class="bg-white p-4 rounded shadow-sm mb-5">
                    <p class="text-muted">Konfirmasi Pemesanan Tiket</p>
                    <h4>{{ $event->title }}</h5>
                    <p>
                        <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $event->location }}
                    </p>
                    <p class="fs-18 mt-5 mb-0 d-lg-none">
                        <span class="text-dark me-1">Total</span>
                        <span class="fw-bold text-dark me-1">
                            {{ empty($cart) ? '0' : array_sum(array_map(fn($i) => (int) $i['quantity'], $cart)) }} tiket
                        </span>
                    </p>
                    @php
                    $total = empty($cart) ? 0 : array_sum(array_map(fn($i) => (int) $i['price'] * (int) $i['quantity'], $cart));
                    @endphp
                    <p class="fs-18 text-dark d-lg-none">
                        <span class="text-dark me-1">Total Pembayaran:</span>
                            <span class="fw-bold text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </p>
                </div>

                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6 class="mb-4">Informasi Pembeli</h6>

                                {{-- Login sebelum form data pemesan --}}
                                <div class="mb-4 text-gray-70">
                                    <a href="#" class="fw-semibold" data-bs-toggle="modal" data-bs-target="#loginModal">
                                        Login
                                    </a> atau isi data diri di bawah ini untuk melanjutkan pemesanan tiket.
                                </div>

                                @error('general')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <form wire:submit.prevent="submitOrder">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" wire:model.defer="name" placeholder="Nama Anda">
                                        @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" wire:model.defer="email" placeholder="email@contoh.com">
                                        @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">No. HP</label>
                                        <input type="text" class="form-control" wire:model.defer="phone" placeholder="08xxxxxxxxxx">
                                        @error('phone') <div class="text-danger small">{{ $message }}</div> @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3" {{ empty($cart) ? 'disabled' : '' }}>
                                        Konfirmasi
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 d-none d-lg-block">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6 class="mb-3">Detail Pemesanan</h6>

                                @if(empty($cart))
                                    <div class="alert alert-info mb-0">Keranjang kosong.</div>
                                @else
                                    <ul class="list-group mb-3">
                                        @foreach($cart as $item)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <div class="fw-semibold">{{ $item['name'] }}</div>
                                                    <small class="text-muted">{{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</small>
                                                </div>
                                                <div class="fw-semibold">
                                                    Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>

                                    @php
                                        $totalQty = array_sum(array_map(fn($i) => (int) $i['quantity'], $cart));
                                        $total    = array_sum(array_map(fn($i) => (int) $i['price'] * (int) $i['quantity'], $cart));
                                    @endphp

                                    <div class="fs-18 justify-content-between mb-1">
                                        <span class="me-1">Total</span>
                                        <span class="fw-semibold">{{ $totalQty }} tiket</span>
                                    </div>
                                    <div class="fs-18 justify-content-between">
                                        <span class="me-1">Total Pembayaran:</span>
                                        <span class="fw-bold text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main>

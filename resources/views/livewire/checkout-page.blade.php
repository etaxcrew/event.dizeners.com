<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Data Pemesan</h5>

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

                        <button type="submit" class="btn btn-primary">
                            Konfirmasi & Buat Pesanan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Ringkasan Pesanan</h5>

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

                        <div class="d-flex justify-content-between mb-1">
                            <span>Total Tiket</span>
                            <span class="fw-semibold">{{ $totalQty }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Total Pembayaran</span>
                            <span class="fw-bold text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

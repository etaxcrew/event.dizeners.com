@section('title')
Cari tiket event seru di Gorontalo
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
        <div class="container py-5">
            <div class="text-center mb-5">
                <div class="display-4 text-success"><i class="bi bi-check-circle-fill"></i></div>
                <h3 class="fw-bold">Pemesanan Berhasil</h2>
                <p class="text-muted">Terima kasih! Detail pesanan telah dikirim ke email Anda.</p>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <p>Nomor Pesanan:
                        <strong>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</strong>
                    </p>

                    <h5 class="mt-4">Detail Event</h5>
                    <p class="mb-1"><strong>{{ $order->event->title }}</strong></p>
                    <p class="text-muted">{{ $order->event->is_online ? 'Event Online' : $order->event->location }}</p>

                    <h5 class="mt-4">Data Pemesan</h5>
                    <p>{{ $order->customer->name }} — {{ $order->customer->email }} — {{ $order->customer->phone }}</p>

                    <h5 class="mt-4">Rincian Tiket</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Tiket</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->ticket->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>Rp {{ number_format($item->subtotal_price / max($item->quantity,1), 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($item->subtotal_price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total</th>
                                    <th>Rp {{ number_format($order->total_price, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <a href="{{ route('event.detail', $order->event->slug) }}" class="btn btn-primary">
                        Kembali ke halaman acara
                    </a>
                </div>
            </div>
        </div>

        {{-- <div class="container py-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Pemesanan Berhasil</h5>
                    <p>Nomor Pesanan: <strong>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</strong></p>

                    <h6>Detail Event</h6>
                    <p><strong>{{ $order->event->title }}</strong></p>

                    <h6>Data Pemesan</h6>
                    <p>{{ $order->customer->name }} — {{ $order->customer->email }} — {{ $order->customer->phone }}</p>

                    <h6>Rincian Tiket</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tiket</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->ticket->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rp {{ number_format($item->subtotal,0,',','.') }}</td>
                                    <td>Rp {{ number_format($item->subtotal,0,',','.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total</th>
                                <th>Rp {{ number_format($order->total_amount,0,',','.') }}</th>
                            </tr>
                        </tfoot>
                    </table>

                    <a href="{{ route('event.detail', $order->event->slug) }}" class="btn btn-primary">
                        Kembali ke halaman acara
                    </a>
                </div>
            </div>
        </div> --}}

    </main>

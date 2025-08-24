@component('mail::message')
# Pesanan Tiket Berhasil

Halo {{ $order->customer->name }},

Terima kasih telah memesan tiket untuk **{{ $order->event->title }}**.

**Detail Pesanan:**
@foreach($order->orderItems as $item)
- {{ $item->ticket->name }} ({{ $item->quantity }}x) - Rp {{ number_format($item->price, 0, ',', '.') }}
@endforeach

**Total:** Rp {{ number_format($order->total_amount, 0, ',', '.') }}

Kami menantikan kehadiran Anda di acara ini.

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent

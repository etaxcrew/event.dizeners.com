<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Session;

class CheckoutSuccess extends Component
{
    public $orderId;
    public $order;

    public function mount(int $orderId)
    {
        $this->orderId = $orderId;

        $this->order = Order::with(['event', 'customer', 'orderItems.ticket'])
            ->findOrFail($orderId);

        // Validasi: hanya pemilik order (berdasarkan session customer_id)
        $sessionCustomerId = session('customer_id');
        if (!$sessionCustomerId || $this->order->customer_id !== $sessionCustomerId) {
            abort(403, 'Unauthorized access to this order.');
        }

        // Bersihkan cart khusus event ini
        $eventId = $this->order->event_id;
        Session::forget("cart_{$eventId}");

        // (Opsional) Bersihkan customer_id supaya tidak bisa akses order lain
        // Session::forget('customer_id');
    }

    public function render()
    {
        return view('livewire.checkout-success', [
            'order' => $this->order
        ]);
    }
}

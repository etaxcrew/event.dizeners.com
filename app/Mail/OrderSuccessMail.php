<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order->load('customer', 'orderItems.ticket', 'event');
    }

    public function build()
    {
        return $this->subject('Pesanan Tiket Anda Berhasil')
                    ->markdown('emails.orders.success');
    }
}

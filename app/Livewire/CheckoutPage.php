<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Mail;
use App\Mail\OrderSuccessMail;

class CheckoutPage extends Component
{
    public Event $event;
    public $cart = [];  // isi dari session("cart_{eventId}")
    public $name;
    public $email;
    public $phone;

    public function mount($slug)
    {
        $this->event = Event::where('slug', $slug)->firstOrFail();
        $this->cart = session()->get("cart_{$this->event->id}", []);

        if (empty($this->cart)) {
            session()->flash('error', 'Keranjang kosong. Silakan pilih tiket terlebih dahulu.');
            return redirect()->route('select.ticket', $this->event->slug);
        }
    }

    public function submitOrder()
    {
        $this->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email',
            'phone' => 'required|string|min:6',
        ]);

        DB::beginTransaction();
        try {
            // Customer
            $customer = Customer::firstOrCreate(
                ['email' => $this->email],
                ['name' => $this->name, 'phone' => $this->phone]
            );

            // Simpan untuk validasi halaman success
            session()->put('customer_id', $customer->id);

            // Hitung total + validasi stok
            $total = 0;
            foreach ($this->cart as $ticketId => $item) {
                $ticket = Ticket::where('event_id', $this->event->id)->findOrFail($ticketId);

                if ($ticket->stock < $item['quantity']) {
                    throw new \Exception("Stok tidak cukup untuk tiket: {$ticket->name}");
                }
                // Optional: enforce max_per_user kembali di server
                if ($ticket->max_per_user && $item['quantity'] > $ticket->max_per_user) {
                    throw new \Exception("Maksimal {$ticket->max_per_user} tiket untuk {$ticket->name}.");
                }

                $total += ((int) $item['price']) * ((int) $item['quantity']);
            }

            // Order
            $order = Order::create([
                'event_id'    => $this->event->id,
                'customer_id' => $customer->id,
                // 'order_code' => strtoupper(Str::random(8)),
                'total_price' => $total,
                'status'      => 'pending',
            ]);

            // Order items & kurangi stok
            foreach ($this->cart as $ticketId => $item) {
                $ticket = Ticket::where('event_id', $this->event->id)->findOrFail($ticketId);

                OrderItem::create([
                    'order_id'       => $order->id,
                    'ticket_id'      => $ticket->id,
                    'quantity'       => (int) $item['quantity'],
                    // 'price' => $item['price'],
                    'subtotal_price' => ((int) $item['price']) * ((int) $item['quantity']),
                ]);

                $ticket->decrement('stock', (int) $item['quantity']);
            }

            DB::commit();

            // Bersihkan cart event ini
            session()->forget("cart_{$this->event->id}");

            // ✅ kirim email notifikasi ke customer
            Mail::to($customer->email)->send(new OrderSuccessMail($order));
            
            // Redirect ke success + bawa orderId
            return redirect()->route('checkout.success', ['orderId' => $order->id]);

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            $this->addError('general', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.checkout-page');
    }
}

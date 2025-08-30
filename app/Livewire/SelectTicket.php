<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use App\Models\Ticket;

class SelectTicket extends Component
{
    public Event $event;
    public $tickets = [];
    public $cart = []; // [ticketId => ['ticket_id','name','price','quantity']]
    public $totalQuantity = 0;
    public $totalPrice = 0;

    public function mount(string $slug)
    {
        $this->event = Event::with(['tickets' => function ($q) {
            $q->orderBy('price');
        }])->where('slug', $slug)->firstOrFail();

        $this->tickets = $this->event->tickets;
        $this->cart    = session()->get("cart_{$this->event->id}", []);
        $this->recalculate();
    }

    public function addToCart(int $ticketId)
    {
        $ticket = Ticket::where('event_id', $this->event->id)->findOrFail($ticketId);

        $current  = (int) ($this->cart[$ticketId]['quantity'] ?? 0);
        $willBe   = $current + 1;

        // Validasi batas per user
        if (!empty($ticket->max_per_user) && $willBe > (int) $ticket->max_per_user) {
            $this->dispatch('toast', icon: 'warning', message: "Maksimal {$ticket->max_per_user} tiket untuk {$ticket->name}.");
            return;
        }

        // Validasi stok
        if ((int) $ticket->stock < $willBe) {
            $this->dispatch('toast', icon: 'error', message: "Stok tiket {$ticket->name} tidak mencukupi.");
            return;
        }

        // Max per user & stock guard
        // $currentQty = $this->cart[$ticketId]['quantity'] ?? 0;
        // if ($ticket->max_per_user && $currentQty + 1 > $ticket->max_per_user) {
        //     $this->dispatchBrowserEvent('notify', ['type' => 'warning', 'message' => "Maksimal {$ticket->max_per_user} tiket untuk {$ticket->name}."]);
        //     return;
        // }
        // if ($ticket->stock <= $currentQty) {
        //     $this->dispatchBrowserEvent('notify', ['type' => 'error', 'message' => "Stok tiket {$ticket->name} tidak mencukupi."]);
        //     return;
        // }

        // if (!isset($this->cart[$ticketId])) {
        //     $this->cart[$ticketId] = [
        //         'ticket_id' => $ticket->id,
        //         'name'      => $ticket->name,
        //         'date'      => $ticket->start_date ? $ticket->start_date->format("d M 'y, H.i") . ' WIB' : null,
        //         'price'     => (int) $ticket->price,
        //         'quantity'  => 1,
        //     ];
        // } else {
        //     $this->cart[$ticketId]['quantity']++;
        // }

        // session()->put("cart_{$this->event->id}", $this->cart);
        // $this->recalculate();

        if (!isset($this->cart[$ticketId])) {
            $this->cart[$ticketId] = [
                'ticket_id' => $ticket->id,
                'name'      => $ticket->name,
                'date'      => $ticket->start_date
                    ? $ticket->start_date->format("d M 'y, H.i") . ' WIB'
                    : null,
                'price'     => (int) $ticket->price,
                'quantity'  => 1,
            ];
        } else {
            $this->cart[$ticketId]['quantity'] = $willBe;
        }

        session()->put("cart_{$this->event->id}", $this->cart);
        $this->recalculate();

        $this->dispatch('toast', icon: 'success', message: 'Tiket ditambahkan ke keranjang.');
    }

    public function removeFromCart(int $ticketId)
    {
        if (!isset($this->cart[$ticketId])) return;

        $this->cart[$ticketId]['quantity']--;

        if ($this->cart[$ticketId]['quantity'] <= 0) {
            unset($this->cart[$ticketId]);
            $this->dispatch('toast', icon: 'info', message: 'Tiket dihapus dari keranjang.');
        } else {
            $this->dispatch('toast', icon: 'info', message: 'Jumlah tiket dikurangi.');
        }

        session()->put("cart_{$this->event->id}", $this->cart);
        $this->recalculate();
    }

    /** 
     * Shortcut agar kompatibel dengan blade wire:click 
     */
    public function incrementQuantity(int $ticketId)
    {
        $this->addToCart($ticketId);
    }

    public function decrementQuantity(int $ticketId)
    {
        $this->removeFromCart($ticketId);
    }

    public function goToCheckout()
    {
        // Validasi keranjang kosong
        if (empty($this->cart)) {
            $this->dispatch('toast', icon: 'warning', message: 'Keranjang kosong. Silakan pilih tiket terlebih dahulu.');
            return;
        }

        return redirect()->route('checkout.page', $this->event->slug);
    }

    private function recalculate(): void
    {
        $this->totalQuantity = 0;
        $this->totalPrice    = 0;

        foreach ($this->cart as $item) {
            $this->totalQuantity += (int) $item['quantity'];
            $this->totalPrice    += ((int) $item['price']) * ((int) $item['quantity']);
        }
    }

    public function render()
    {
        return view('livewire.select-ticket');
    }
}

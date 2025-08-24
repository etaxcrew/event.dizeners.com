<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;

class EventDetail extends Component
{
    public Event $event;

    public function mount($slug)
    {
        $this->event = Event::with(['tickets','category'])
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.event-detail');
    }
}

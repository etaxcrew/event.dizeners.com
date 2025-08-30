<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event as EventModel;

class Event extends Component
{
    public function render()
    {
        $events = EventModel::query()->latest()->get();

        return view('livewire.events', [
            'events' => $events,
        ]);
    }
}




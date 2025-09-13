<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event as EventModel;
use App\Models\Category;

class Event extends Component
{
    public $selectedCategory = 'all';

    public function setCategory($category)
    {
        $this->selectedCategory = $category;
    }

    public function render()
    {
        // $events = EventModel::query()->latest()->get();

        // return view('livewire.events', [
        //     'events' => $events,
        // ]);

        $categories = Category::all();

        $events = EventModel::query()->with('category', 'tickets')
            ->when($this->selectedCategory !== 'all', function ($query) {
                $query->whereHas('category', function ($q) {
                    $q->where('slug', $this->selectedCategory);
                });
            })
            ->latest()
            ->get();

        return view('livewire.events', [
            'events' => $events,
            'categories' => $categories,
            'selectedCategory' => $this->selectedCategory
        ]);
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use App\Models\Category;

class Homepage extends Component
{
    public $selectedCategory = 'all';

    public function setCategory($category)
    {
        $this->selectedCategory = $category;
    }

    public function render()
    {
        $categories = Category::all();

        $events = Event::with('category', 'tickets')
            ->when($this->selectedCategory !== 'all', function ($query) {
                $query->whereHas('category', function ($q) {
                    $q->where('slug', $this->selectedCategory);
                });
            })
            ->latest()
            ->get();

        return view('livewire.homepage', [
            'events' => $events,
            'categories' => $categories,
            'selectedCategory' => $this->selectedCategory
        ]);
    }
}

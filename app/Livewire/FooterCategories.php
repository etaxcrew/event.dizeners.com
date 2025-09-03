<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class FooterCategories extends Component
{
    public $categories = [];

    public function mount()
    {
        $this->categories = Cache::remember('footer_categories', 3600, function () {
            return Category::all();
        });
    }

    public function render()
    {
        return view('livewire.footer-categories');
    }
}

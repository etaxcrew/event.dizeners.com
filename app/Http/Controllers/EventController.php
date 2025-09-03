<?php

namespace App\Http\Controllers;

use App\Models\Category;

class EventController extends Controller
{
    public function showByCategory($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();
        $events = $category->events()->with('tickets')->latest()->get();

        return view('events.category', compact('category', 'events'));
    }
}

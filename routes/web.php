<?php
namespace App\Livewire;

use Illuminate\Support\Facades\Route;

use App\Livewire\Homepage;
use App\Livewire\About;
use App\Livewire\Contact;
use App\Livewire\Events;
use App\Livewire\EventDetail;
use App\Livewire\SelectTicket;
use App\Livewire\CheckoutPage;
use App\Livewire\CheckoutSuccess;

use App\Http\Controllers\EventController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Beranda (Livewire)
Route::get('/', Homepage::class)->name('home');
Route::get('/about', About::class)->name('about');
Route::get('/kontak', Contact::class)->name('contact');

// Daftar semua event
Route::get('/events', Event::class)->name('events.index');

// Kategori event
Route::get('/events/category/{categorySlug}', [EventController::class, 'showByCategory'])
    ->name('events.category');

// Event berdasarkan slug
Route::get('/event/{slug}', EventDetail::class)->name('event.detail');

// Pilih tiket
Route::get('/event/{slug}/pilih-tiket', SelectTicket::class)
    ->name('select.ticket');

// Checkout
Route::get('/checkout/{slug}', CheckoutPage::class)
    ->name('checkout.page');

// Success
Route::get('/checkout-success/{orderId}', CheckoutSuccess::class)
    ->name('checkout.success');

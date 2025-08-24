<?php
namespace App\Livewire;

use Illuminate\Support\Facades\Route;

use App\Livewire\Homepage;
use App\Livewire\EventDetail;
use App\Livewire\SelectTicket;
use App\Livewire\CheckoutPage;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Beranda (Livewire)
Route::get('/', Homepage::class)->name('home');

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

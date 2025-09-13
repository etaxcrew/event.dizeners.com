<?php

use App\Livewire\Customer\Auth\Login;
use App\Livewire\Customer\Auth\Register;
use App\Livewire\Customer\Auth\ForgotPassword;
use App\Livewire\Customer\Auth\ResetPassword;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;

Route::middleware('guest:customer')->group(function () {
    Route::get('login', Login::class)->name('customer.login');
    Route::get('register', Register::class)->name('customer.register');

    // Google OAuth Routes
    Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('customer.login.google');
    Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

    // Password Reset Routes
    Route::get('forgot-password', ForgotPassword::class)->name('customer.password.request');
    Route::get('reset-password/{token}', ResetPassword::class)->name('customer.password.reset');
});

Route::middleware('auth:customer')->group(function () {
    Route::get('dashboard', function() {
        return view('customer.dashboard');
    })->name('customer.dashboard');

    Route::post('logout', function() {
        auth()->guard('customer')->logout();
        return redirect()->route('customer.login');
    })->name('customer.logout');
});

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            $finduser = Customer::where('email', $user->email)->first();

            if ($finduser) {
                Auth::guard('customer')->login($finduser);
                return redirect()->route('customer.dashboard');
            } else {
                $newUser = Customer::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => bcrypt('password@' . time()),
                    'phone' => null,
                ]);

                Auth::guard('customer')->login($newUser);
                return redirect()->route('customer.dashboard');
            }
        } catch (Exception $e) {
            return redirect()->route('customer.login')
                ->with('error', 'Something went wrong with Google login');
        }
    }
}

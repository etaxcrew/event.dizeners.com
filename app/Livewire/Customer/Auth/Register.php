<?php

namespace App\Livewire\Customer\Auth;

use App\Models\Customer;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class Register extends Component
{
    public $name;
    public $email;
    public $phone;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:customers',
        'phone' => 'required',
        'password' => 'required|min:8|confirmed',
    ];

    public function register()
    {
        $this->validate();

        $customer = Customer::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
        ]);

        auth()->guard('customer')->login($customer);

        return redirect()->route('customer.dashboard');
    }

    public function render()
    {
        return view('livewire.customer.auth.register');
    }
}

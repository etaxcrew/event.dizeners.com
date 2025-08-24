<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //protected $guard = 'customer';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'image',
        'address',
        'city',
        'country'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventPhoto extends Model
{
    //
    protected $fillable = [
        'event_id',
        'event_photo',
    ];
}

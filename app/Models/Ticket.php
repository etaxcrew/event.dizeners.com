<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //
    protected $fillable = [
        'event_id',
        'organizer_id',
        'name',
        'about',
        'stock',
        'remaining',
        'price',
        'ticket_date',
        'open_time_at',
        'closed_time_at',
        'end_date_sale',
        'max_per_user',
        'is_active',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}

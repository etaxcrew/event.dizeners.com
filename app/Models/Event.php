<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    //
    protected $fillable = [
        'organizer_id',
        'category_id',
        'title',
        'slug',
        'highlight',
        'description',
        'location',
        'is_online',
        'start_date',
        'end_date',
        'open_time',
        'closed_time',
        'banner_path',
        'video_path',
        'status',
    ];

    protected static function booted()
    {
        static::saving(function ($model) {
            if (empty($model->slug) || $model->isDirty('title')) {
                $model->slug = Str::slug($model->title);
            }
        });
    }

    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function photos()
    {
        return $this->hasMany(EventPhoto::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

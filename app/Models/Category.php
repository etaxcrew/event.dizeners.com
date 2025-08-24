<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['image', 'name', 'slug', 'description'];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * boot
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Generate slug before saving
        static::saving(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }
}

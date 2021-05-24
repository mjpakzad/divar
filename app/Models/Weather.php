<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    const STATUS_DRAFT      = false;
    const STATUS_PUBLISHED  = true;

    protected $fillable = ['name', 'status', 'code'];
    
    protected $table = 'weather';
    
    protected $casts = [
        'status' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    public function items()
    {
        return $this->hasMany(WeatherItem::class);
    }

    public function orderedItems()
    {
        return $this->hasMany(WeatherItem::class)->orderBy('sort_order', 'asc');
    }

    public function scopeDraft($query)
    {
        return $query->whereStatus(self::STATUS_DRAFT);
    }

    public function scopePublished($query)
    {
        return $query->whereStatus(self::STATUS_PUBLISHED);
    }
}

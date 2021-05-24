<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherItem extends Model
{
    protected $fillable = ['title', 'slug', 'file', 'image_id', 'sort_order'];

    public function weather()
    {
        return $this->belongsTo(Weather::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}

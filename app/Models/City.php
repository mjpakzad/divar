<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'title',
        'latitude',
        'longitude',
        'sort_order',
        'meta_keywords',
        'meta_description'
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];
    
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function commercials()
    {
        return $this->hasMany(Commercial::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = [
        'city_id',
        'name',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function commercials()
    {
        return $this->hasMany(Commercial::class);
    }
}

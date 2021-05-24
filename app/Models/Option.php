<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'sort_order'
    ];

    public function values()
    {
        return $this->hasMany(OptionValue::class, '');
    }

    public function products()
    {
        $this->belongsToMany(ProductOption::class);
    }
}

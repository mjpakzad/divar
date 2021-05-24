<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'content',
    ];

    protected $dates = ['seen_at'];

    public function scopeUnseen($query)
    {
        return $query->whereNull('seen_at');
    }

    public function scopeSeen($query)
    {
        return $query->whereNotNull('seen_at');
    }
}

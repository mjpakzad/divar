<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['value'];

    protected $casts = [
        'autoload'  => 'boolean',
    ];

    public function scopeManualLoad($query)
    {
        return $query->whereAutoload(false);
    }

    public function scopeAutoload($query)
    {
        return $query->whereAutoload(true);
    }
}

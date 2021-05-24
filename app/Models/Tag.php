<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public const TYPE_CATEGORY  = 0;
    public const TYPE_BUY       = 1;
    public const TYPE_FIELD     = 2;

    protected $fillable = ['name', 'search', 'type'];

    public function commercials()
    {
        return $this->belongsToMany(Commercial::class)->withTimestamps();
    }
}

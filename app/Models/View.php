<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $fillable = [
        'viewable_id',
        'viewable_type',
    ];

    public function viewable()
    {
        return $this->morphTo();
    }
}

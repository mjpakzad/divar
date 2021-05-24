<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
    protected $fillable = [
        'user_id',
        'option_id',
        'name',
        'sort_order',
    ];

    public $timestamps = false;

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function productOptions()
    {
        return $this->belongsToMany(ProductOption::class);
    }
}

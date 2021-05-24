<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    protected $fillable = [
        'product_id',
        'option_id',
        'required',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function optionValues()
    {
        return $this->belongsToMany(OptionValue::class, 'product_option_values')
            ->withPivot(['surplus_price', 'price']);
    }
}

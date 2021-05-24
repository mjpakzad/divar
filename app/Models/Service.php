<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'field',
        'amount',
        'price',
        'description',
    ];

    public function invoices()
    {
        return $this->hasMany(InvoiceServices::class);
    }
}

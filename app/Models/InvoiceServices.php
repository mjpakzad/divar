<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceServices extends Model
{
    protected $fillable = [
        'invoice_id',
        'service_id',
        'service_name',
        'field',
        'amount',
        'price',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}

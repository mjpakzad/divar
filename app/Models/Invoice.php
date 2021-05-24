<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public const STATUS_INACTIVE    = 0;
    public const STATUS_ACTIVE      = 1;
    public const STATUS_PAID        = 2;
    public const STATUS_GIFT        = 3;

    protected $fillable = [
        'user_id',
        'commercial_id',
        'status',
        'price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commercial()
    {
        return $this->belongsTo(Commercial::class);
    }

    public function services()
    {
        return $this->hasMany(InvoiceServices::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function scopeInactive($query)
    {
        return $query->whereStatus(static::STATUS_INACTIVE);
    }

    public function scopeActive($query)
    {
        return $query->whereStatus(static::STATUS_ACTIVE);
    }

    public function scopePaid($query)
    {
        return $query->whereStatus(static::STATUS_PAID);
    }

    public function scopeGift($query)
    {
        return $query->whereStatus(static::STATUS_GIFT);
    }
}

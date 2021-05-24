<?php

namespace App\Models;

use App\Interfaces\Security;
use App\Traits\Security as SecurityTrait;
use Illuminate\Database\Eloquent\Model;

class TwoFactor extends Model implements Security
{
    use SecurityTrait;

    protected $fillable = [
        'code',
        'user_id',
        'used',
    ];

    public function __construct(array $attributes = [])
    {
        if (!isset($attributes['code'])) {
            $attributes['code'] = static::generateCode();
        }

        parent::__construct($attributes);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

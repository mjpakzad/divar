<?php
namespace App\Models;

use App\Interfaces\Security;
use App\Traits\Security as SecurityTrait;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model implements Security
{
    use SecurityTrait;

    protected $fillable = [
        'mobile',
        'token',
        'created_at'
    ];

    protected $casts = [
        'used'  => 'boolean',
    ];

    public function scopeMobile($query, $mobile)
    {
        return $query->whereMobile($mobile);
    }

    public function scopeToken($query, $token)
    {
        return $query->whereToken($token);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    const PRIVATE   = true;
    const PUBLIC    = false;
    const APPROVED  = true;
    const REJECTED  = false;

    protected $fillable = [
        'commercial_id',
        'receiver_id',
        'sender_id',
        'parent_id',
        'name',
        'mobile',
        'content',
        'is_private',
        'is_approved',
    ];

    public function commercial()
    {
        return $this->belongsTo(Commercial::class);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopePublic($query)
    {
        return $query->whereIsPrivate(self::PRIVATE);
    }

    public function scopePrivate($query)
    {
        return $query->whereIsPrivate(self::PUBLIC);
    }

    public function scopeApproved($query)
    {
        return $query->whereIsApproved(self::APPROVED);
    }

    public function scopeRejected($query)
    {
        return $query->whereIsApproved(self::REJECTED);
    }
}

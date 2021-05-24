<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    const APPROVED  = true;
    const REJECTED  = false;

    protected $fillable = [
        'commercial_id',
        'user_id',
        'parent_id',
        'name',
        'mobile',
        'content',
        'is_approved',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Review::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Review::class);
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

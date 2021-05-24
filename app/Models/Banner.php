<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    const STATUS_DRAFT      = false;
    const STATUS_PUBLISHED  = true;

    protected $fillable = ['name', 'status', 'position', 'width', 'height'];

    public function items()
    {
        return $this->hasMany(BannerItem::class);
    }

    public function orderedItems()
    {
        return $this->hasMany(BannerItem::class)->orderBy('sort_order', 'asc');
    }

    public function scopeInPosition($query, $position)
    {
        return $query->wherePosition($position);
    }

    public function scopeInPositions($query, array $positions)
    {
        return $query->whereIn('position', $positions);
    }

    public function scopeDraft($query)
    {
        return $query->whereStatus(self::STATUS_DRAFT);
    }

    public function scopePublished($query)
    {
        return $query->whereStatus(self::STATUS_PUBLISHED);
    }

    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}

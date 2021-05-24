<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public const STATUS_DRAFT       = false;
    public const STATUS_PUBLISHED   = true;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'image_id',
        'content',
        'meta_keywords',
        'meta_description',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    public function views()
    {
        return $this->morphMany('App\Models\View', 'viewable');
    }
    
    public function clicks()
    {
        return $this->morphMany('App\Models\Click', 'clickable');
    }

    public function scopeDraft($query)
    {
        return $query->whereStatus(self::STATUS_DRAFT);
    }

    public function scopePublished($query)
    {
        return $query->whereStatus(self::STATUS_PUBLISHED);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function delete()
    {
        if($this->image_id) {
            unlink($this->image->name);
        }
        return parent::delete();
    }
}

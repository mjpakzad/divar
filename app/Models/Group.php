<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    const STATUS_DRAFT      = false;
    const STATUS_PUBLISHED  = true;

    protected $fillable = [
        'name',
        'slug',
        'meta_keywords',
        'meta_description',
        'parent_id',
        'status',
    ];

    protected $casts = ['status' => 'boolean'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    public function children()
    {
        return $this->hasMany(Group::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Group::class, 'parent_id');
    }

    public function activeChildren()
    {
        return $this->hasMany(Group::class, 'parent_id')->published();
    }

    public function activeParent()
    {
        return $this->belongsTo(Group::class, 'parent_id')->published();
    }

    public function scopeMain($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeDoesntHaveParent($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeHasParent($query)
    {
        return $query->whereNotNull('parent_id');
    }

    public function scopeHasChildren($query)
    {
        return $query->children()->exists();
    }

    public function scopeDraft($query)
    {
        return $query->whereStatus(self::STATUS_DRAFT);
    }

    public function scopePublished($query)
    {
        return $query->whereStatus(self::STATUS_PUBLISHED);
    }

    public function delete()
    {
        unlink($this->image->name);
        return parent::delete();
    }
}

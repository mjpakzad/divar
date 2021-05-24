<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'alt',
    ];

    protected static function boot() {
        parent::boot();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function commercial()
    {
        return $this->hasOne(Commercial::class);
    }

    public function category()
    {
        return $this->hasOne(Category::class);
    }
    
    public function manufacturer()
    {
        return $this->hasOne(Manufacturer::class);
    }

    public function commercials()
    {
        return $this->morphedByMany(Commercial::class, 'imageable');
    }
}

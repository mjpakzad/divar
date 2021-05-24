<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerItem extends Model
{
    protected $fillable = ['title', 'banner_id', 'url', 'image_id', 'content', 'sort_order'];

    public function banner()
    {
        return $this->belongsTo(Banner::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}

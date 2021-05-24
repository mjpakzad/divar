<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Attribute extends Model
{
    protected $fillable = ['group_id', 'name', 'sort_order'];

    public $timestamps = false;

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function group()
    {
        return $this->belongsTo(AttributeGroups::class);
    }
}

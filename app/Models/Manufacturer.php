<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CategoryProducts;
use App\Models\Product;

class Manufacturer extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image_id',
        'description',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function categories()
    {
        return $this->belongsToMany(CategoryProducts::class);
    }
    
    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

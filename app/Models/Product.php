<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'user_id',
        'description',
        'meta_keywords',
        'meta_description',
        'manufacturer_id',
        'model',
        'code',
        'length',
        'width',
        'height',
        'weight',
        'length_unit',
        'weight_unit',
        'src',
        'sort_order',
        'count_star',
        'price',
        'stock',
        'status',
        'suggest',
        'giftcard',
        'warranty',
        'image_id',
        'special',
        'special_started_at',
        'special_ended_at',
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

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)
            ->withPivot('value', 'highlight');
    }

    public function filters()
    {
        return $this->belongsToMany(Filter::class);
    }

    public function search($filters)
    {
        return $this->hasManyThrough(Product::class, Filter::class)->whereIn('filter_id', $filters)->get();
        //return $this->belongsToMany(Filter::class)->whereIn('filter_id', $filters);
    }

    public function categories()
    {
        return $this->belongsToMany(ShopCategories::class, 'category_product', 'product_id', 'category_id');
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
    
    public function images()
    {
        return $this->morphToMany(Image::class, 'imageable');
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->reviews()->where('status', 1);
    }

    public static function getlatest()
    {
        return static::with('approvedReviews')->where(['status' =>1])->latest()->take(8)->get();
    }

    public static function getMostPopular()
    {
        return static::with('approvedReviews')->latest('view_counts')->take(8)->get();
    }

    public static function getMostStock()
    {
        return static::with('approvedReviews')->latest('stock')->take(8)->get();
    }

    public static function getSuggests()
    {
        return static::where(['status' => 1, 'suggest' => 1])->latest()->take(12)->get();
    }

    public function wishlist()
    {
        return $this->belongsToMany(User::class);
    }

    public function options()
    {
        return $this->hasMany(ProductOption::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}

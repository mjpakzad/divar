<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopCategories extends Model
{
    public const STATUS_DRAFT       = false;
    public const STATUS_PUBLISHED   = true;
    public const FEATURED           = true;
    public const FEATURED_NOT       = false;
    public const PARENT             = true;
    public const PARENT_NOT         = false;

    protected $casts = [
        'sort_order'    => 'integer',
        'status'        => 'boolean',
        'featured'      => 'boolean',
    ];

    protected $fillable = [
        'name',
        'slug',
        'image_id',
        'type_id',
        'content',
        'meta_keywords',
        'meta_description',
        'featured',
        'parent_id',
        'sort_order',
        'status',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
    
    public function filterGroups()
    {
        return $this->belongsToMany(FilterGroup::class, 'category_filter_group', 'category_id');
    }

    public function filtersWithGroup()
    {
        return $this->filterGroups()->with('filters');
    }
    
    public function manufacturers()
    {
        return $this->belongsToMany(Manufacturer::class, 'category_manufacturer', 'category_id');
    }

    public function activeChildren()
    {
        return $this->hasMany(Category::class, 'parent_id')->published();
    }

    public function activeParent()
    {
        return $this->belongsTo(Category::class, 'parent_id')->published();
    }
    
    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product', 'product_id', 'category_id');
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function fields()
    {
        return $this->belongsToMany(Field::class);
    }
    
    public function getProductsWithAttributes()
    {
        return $this->products()->with('attributes')->where('status', 1)->latest()->paginate(15);
    }

    public function getMostExpensiveProduct()
    {
        return $this->products()->where('status', 1)->latest('price')->first();
    }

    public function scopeDraft($query)
    {
        return $query->whereStatus(self::STATUS_DRAFT);
    }

    public function scopePublished($query)
    {
        return $query->whereStatus(self::STATUS_PUBLISHED);
    }

    public function scopeFeatured($query)
    {
        return $query->whereFeatured(self::FEATURED);
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

    public function scopeSorted($query)
    {
        return $query->oldest('sort_order');
    }

}

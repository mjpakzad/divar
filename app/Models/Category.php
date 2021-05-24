<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
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
        'buy',
        'sell',
        'status',
    ];
    
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('sorted', function (Builder $builder) {
            $builder->latest('sort_order');
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function activeChildren()
    {
        return $this->hasMany(Category::class, 'parent_id')->published();
    }

    public function activeParent()
    {
        return $this->belongsTo(Category::class, 'parent_id')->published();
    }

    public function commercials()
    {
        return $this->hasMany(Commercial::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function filterGroups()
    {
        return $this->belongsToMany(FilterGroup::class)->latest('sort_order');
    }

    public function filtersWithGroup()
    {
        return $this->filterGroups()->with('filters');
    }

    public function fields()
    {
        return $this->belongsToMany(Field::class);
    }

    public function filteredProducts(array $filters, $limit = 15, $order = 'created_at', $sort = 'ASC', $minPrice = 0, $maxPrice = 999999999, $manufacturers = [])
    {
        if ($minPrice == null) {
            $minPrice = 0;
        }
        if ($maxPrice == null) {
            $maxPrice = 999999999;
        }

        $query = $this->products()
            ->with('attributes')
            ->when(!empty($filters), function($q) use ($filters)
            {
                foreach ($filters as $filter)
                {
                    $q->whereHas('filters', function($q) use ($filter)
                    {
                        $q->whereIn('filter_id', $filter);
                    });
                }
            })
            ->where('price', '<=', $maxPrice)
            ->where('price', '>=', $minPrice)
            ->where('status', 1);

        if($manufacturers) {
            $query->whereIn('manufacturer_id', $manufacturers);
        }

        return $query->orderBy($order, $sort)->paginate($limit);
    }

    public function manufacturers()
    {
        return $this->belongsToMany(Manufacturer::class);
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

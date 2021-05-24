<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Filter extends Model
{
    protected $fillable = ['name', 'sort_order'];

    protected $appends = ['filter'];

    public $timestamps = false;
    
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

    public function filterGroup()
    {
        return $this->belongsTo(FilterGroup::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function getFilterAttribute()
    {
        return $this->filterGroup->name . '(' . $this->filterGroup->label . ')' . ' > ' . $this->name;
    }
}

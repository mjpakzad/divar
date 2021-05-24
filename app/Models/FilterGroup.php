<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Modeles\ShopCategories;

class FilterGroup extends Model
{
    protected $fillable = ['filter_group_id', 'name', 'label', 'sort_order'];

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

    public function filters()
    {
        return $this->hasMany(Filter::class)->latest('sort_order');
    }

    public function category()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Get the filter's name along with its label.
     *
     * @return string
     */
    public function getNameLabelAttribute()
    {
        return $this->name . (!is_null($this->label) ? ' (' . $this->label . ')' : '');
    }
}

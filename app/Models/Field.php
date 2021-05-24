<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'name',
        'label',
        'placeholder',
        'values',
        'rules',
        'options',
        'is_price',
        'is_tag',
        'sort_order',
        'buy',
    ];

    protected $appends = ['name_label', 'options', 'values', 'rules'];

    protected $casts = [
        'is_price'  => 'boolean',
    ];

    /**
     * The "booting" method of the Field model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('sort_order', function (Builder $builder) {
            $builder->latest('sort_order');
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commercials()
    {
        return $this->belongsToMany(Commercial::class)->withPivot('value')->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Format name and label together.
     *
     * @return string
     */
    public function getnameLabelAttribute()
    {
        return $this->name . (empty($this->label) ? '' : " ({$this->label})");
    }

    /**
     * Serialize options to save.
     *
     * @param  string  $value
     * @return void
     */
    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = serialize($value);
    }

    /**
     * @param $options
     * @return mixed
     */
    public function getOptionsAttribute($options)
    {
        return unserialize($options);
    }

    /**
     * Serialize values to save.
     *
     * @param  string  $value
     * @return void
     */
    public function setValuesAttribute($value)
    {
        $this->attributes['values'] = serialize($value);
    }

    /**
     * @param $values
     * @return mixed
     */
    public function getValuesAttribute($values)
    {
        return unserialize($values);
    }

    /**
     * Serialize rules to save.
     *
     * @param  string  $value
     * @return void
     */
    public function setRulesAttribute($value)
    {
        $this->attributes['rules'] = serialize($value);
    }

    /**
     * @param $rules
     * @return mixed
     */
    public function getRulesAttribute($rules)
    {
        return unserialize($rules);
    }

    public function scopePrice($query)
    {
        return $query->whereIsPrice(true);
    }
    
    public function scopeTag($query)
    {
        return $query->whereIsTag(true);
    }
}

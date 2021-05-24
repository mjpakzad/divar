<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeGroups extends Model
{
    protected $fillable = ['name', 'sort_order'];

    public $timestamps = false;

    public function attributes()
    {
        return $this->hasMany(Attribute::class, 'group_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportReasons extends Model
{
    protected $fillable = ['title'];

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}

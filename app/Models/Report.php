<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['user_id', 'reason_id', 'commercial_id', 'content'];

    public function reason()
    {
        return $this->belongsTo(ReportReasons::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commercial()
    {
        return $this->belongsTo(Commercial::class);
    }
}

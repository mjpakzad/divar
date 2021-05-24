<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketAttachment extends Model
{
    public function message()
    {
        return $this->belongsTo(TicketMessage::class);
    }
}

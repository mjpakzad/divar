<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketMessage extends Model
{
    protected $fillable = [
        'user_id',
        'ticket_id',
        'body',
        'seen_at'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function attachment()
    {
        return $this->hasMany(TicketAttachment::class, 'message_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

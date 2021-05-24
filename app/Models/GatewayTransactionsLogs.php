<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GatewayTransactionsLogs extends Model
{
    public function transaction()
    {
        return $this->belongsTo(GatewayTransactions::class);
    }
}

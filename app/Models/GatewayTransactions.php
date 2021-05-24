<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GatewayTransactions extends Model
{
    public function logs()
    {
        return $this->hasMany(GatewayTransactionsLogs::class, 'transaction_id');
    }
}

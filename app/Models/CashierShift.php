<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashierShift extends Model
{
    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id', 'id');
    }
}

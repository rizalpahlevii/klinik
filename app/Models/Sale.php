<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class, 'sale_id', 'id');
    }
}

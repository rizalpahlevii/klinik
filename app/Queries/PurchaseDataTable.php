<?php

namespace App\Queries;

use App\Models\Purchase;

class PurchaseDataTable
{
    public function get()
    {
        return Purchase::with('supplier', 'salesman')->select('purchases.*');
    }
}

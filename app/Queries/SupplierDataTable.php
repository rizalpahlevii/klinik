<?php

namespace App\Queries;

use App\Models\Supplier;

class SupplierDataTable
{
    public function get()
    {
        $query = Supplier::query()->select('suppliers.*');
        return $query;
    }
}

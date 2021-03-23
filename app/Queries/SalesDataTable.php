<?php

namespace App\Queries;

use App\Models\Sale;

class SalesDataTable
{
    public function get()
    {
        return Sale::select('sales.*');
    }
}

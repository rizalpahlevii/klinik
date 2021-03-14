<?php

namespace App\Queries;

use App\Models\Product;

class ProductDataTable
{
    public function get()
    {
        return Product::with('brand', 'category')->select('products.*');
    }
}

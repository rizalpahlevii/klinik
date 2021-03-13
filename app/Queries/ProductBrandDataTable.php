<?php

namespace App\Queries;

use App\Models\ProductBrand;

class ProductBrandDataTable
{
    public function get()
    {
        return ProductBrand::select('product_brands.*');
    }
}

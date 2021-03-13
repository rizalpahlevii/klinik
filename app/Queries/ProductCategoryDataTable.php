<?php

namespace App\Queries;

use App\Models\ProductCategory;

class ProductCategoryDataTable
{
    public function get()
    {
        return ProductCategory::select('product_categories.*');
    }
}

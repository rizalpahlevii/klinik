<?php

use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = ProductCategory::get()->pluck('id')->toArray();
        $brand = ProductBrand::get()->pluck('id')->toArray();
        $data = [
            [
                'product_code' => 'A11',
                'name' => 'Minuman 1',
                'category_id' => $category[0],
                'brand_id' => $brand[0],
                'unit' => 'PCS',
                'selling_price' => 10000,

                'current_stock' => 11000,
                'total_minimum_stock' => 20,
                'side_effects' => 'Menyebabkan tidak haus',
                'notes' => 'Keterangan'
            ],
            [
                'product_code' => 'B11',
                'name' => 'Makanan 2',
                'category_id' => $category[1],
                'brand_id' => $brand[1],
                'unit' => 'PCS',
                'selling_price' => 9000,

                'current_stock' => 10,
                'total_minimum_stock' => 20,
                'side_effects' => 'Menyebabkan tidak lapar',
                'notes' => 'Keterangan'
            ],
            [
                'product_code' => 'C11',
                'name' => 'Makanan 2',
                'category_id' => $category[0],
                'brand_id' => $brand[0],
                'unit' => 'PCS',
                'current_stock' => 10,
                'selling_price' => 9500,
                'total_minimum_stock' => 20,
                'side_effects' => 'Menyebabkan tidak lapar',
                'notes' => 'Keterangan'
            ],
        ];
        foreach ($data as $row) {
            Product::create($row);
        }
    }
}

<?php

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'category_name' => 'Kategori 1'
            ],
            [
                'category_name' => 'Kategori 2'
            ],
        ];
        foreach ($data as $key => $row) {
            ProductCategory::create($row);
        }
    }
}

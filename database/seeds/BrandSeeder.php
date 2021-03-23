<?php

use App\Models\ProductBrand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
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
                'brand_name' => 'Brand 1'
            ],
            [
                'brand_name' => 'Brand 2'
            ],
        ];
        foreach ($data as $key => $row) {
            ProductBrand::create($row);
        }
    }
}

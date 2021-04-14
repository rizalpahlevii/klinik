<?php

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
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
                'receipt_code' => getUniqueString(),
                'receipt_date' => '2021-07-01',
                'buyer_type' => 'member',
                'buyer_name' => 'Rizal',
                'sub_total' => 22000,
                'tax' => 0,
                'discount' => 0,
                'grand_total' => 22000,
                'doctor_id' => NULL,
                'payment_method' => 'debit'
            ],
            [
                'receipt_code' => getUniqueString(),
                'receipt_date' => '2021-08-01',
                'buyer_type' => 'member',
                'buyer_name' => 'Pahlevi',
                'sub_total' => 20000,
                'tax' => 0,
                'discount' => 0,
                'grand_total' => 20000,
                'doctor_id' => NULL,
                'payment_method' => 'debit'
            ],
            [
                'receipt_code' => getUniqueString(),
                'receipt_date' => '2021-01-01',
                'buyer_type' => 'member',
                'buyer_name' => 'Muhammad R',
                'sub_total' => 30000,
                'tax' => 0,
                'discount' => 0,
                'grand_total' => 30000,
                'doctor_id' => NULL,
                'payment_method' => 'debit'
            ]
        ];
        foreach ($data as $row) {
            $sale = Sale::create($row);
            if ($row['buyer_name'] == 'Rizal') {
                $product = Product::where('product_code', 'A11')->first();
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'current_price' => 11000,
                    'quantity' => 2,
                    'total' => 22000
                ]);
            } else if ($row['buyer_name'] == 'Pahlevi') {
                $product = Product::where('product_code', 'B11')->first();
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'current_price' => 10000,
                    'quantity' => 2,
                    'total' => 20000
                ]);
            } else {
                $product = Product::where('product_code', 'C11')->first();
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'current_price' => 15000,
                    'quantity' => 2,
                    'total' => 30000
                ]);
            }
        }
    }
}

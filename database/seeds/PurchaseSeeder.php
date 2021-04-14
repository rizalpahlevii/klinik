<?php

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\SupplierSalesman;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $suppliers = Supplier::take(1)->first();
        $salesman = SupplierSalesman::where('supplier_id', $suppliers->id)->first();
        $data = [
            [
                'receipt_code' => getUniqueString(),
                'receipt_date' => '2021-09-01',
                'supplier_id' => $suppliers->id,
                'salesman_id' => $salesman->id,
                'sub_total' => 10000,
                'tax' => 0,
                'discount' => 0,
                'grand_total' => 10000,
            ],
            [
                'receipt_code' => getUniqueString(),
                'receipt_date' => '2021-09-01',
                'supplier_id' => $suppliers->id,
                'salesman_id' => $salesman->id,
                'sub_total' => 10000,
                'tax' => 0,
                'discount' => 0,
                'grand_total' => 10000,
            ],
            [
                'receipt_code' => getUniqueString(),
                'receipt_date' => '2021-09-01',
                'supplier_id' => $suppliers->id,
                'salesman_id' => $salesman->id,
                'sub_total' => 10000,
                'tax' => 0,
                'discount' => 0,
                'grand_total' => 10000,
            ],
        ];
        foreach ($data as $row) {
            $purchase = Purchase::create($row);
            $product = Product::where('product_code', 'A11')->first();
            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id' => $product->id,
                'current_price' => $product->selling_price,
                'quantity' => 1,
                'total' => $product->selling_price
            ]);
        }
    }
}

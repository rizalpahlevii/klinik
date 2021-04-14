<?php

use App\Models\Supplier;
use App\Models\SupplierSalesman;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $input = [
            [
                'name' => 'Supplier 1',
                'phone' => '01283398',
                'address' => 'Semarang'
            ],
            [
                'name' => 'Supplier 2',
                'phone' => '0128398',
                'address' => 'Tangerang'
            ],
            [
                'name' => 'Supplier 3',
                'phone' => '01283983',
                'address' => 'Jepara'
            ],
        ];
        foreach ($input as $key => $data) {
            $supplier = Supplier::create($data);
            SupplierSalesman::create(['supplier_id' => $supplier->id, 'salesman_name' => $data['name'] . $key, 'phone' => '01238912387']);
        }
    }
}

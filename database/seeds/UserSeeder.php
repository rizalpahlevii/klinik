<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::whereName('owner')->first();
        $cashierRole = Role::whereName('cashier')->first();
        $inventoryRole = Role::whereName('inventory')->first();
        $input = [
            [
                'fullname'          => 'Super Admin',
                'username'          => 'admin',
                'password'          => Hash::make('123123123'),
                'phone'             => '082158115949',
                'gender'            => 'male',
                'address'           => 'Pati Jawa Tengah',
                'start_working_date' => date('Y-m-d'),
            ],
            [
                'fullname'          => 'Kasir',
                'username'          => 'kasir',
                'password'          => Hash::make('123123123'),
                'phone'             => '012837187',
                'gender'            => 'male',
                'address'           => 'Pati Jawa Tengah',
                'start_working_date' => date('Y-m-d'),
            ],
            [
                'fullname'          => 'Gudang',
                'username'          => 'Gudang',
                'password'          => Hash::make('123123123'),
                'phone'             => '19237891237',
                'gender'            => 'male',
                'address'           => 'Pati Jawa Tengah',
                'start_working_date' => date('Y-m-d'),
            ],
        ];
        foreach ($input as $data) {
            $user = User::create($data);
            if ($data['username'] == "admin") {
                $user->assignRole($adminRole);
            } elseif ($data['username'] == "cashier") {
                $user->assignRole($cashierRole);
            } else {
                $user->assignRole($inventoryRole);
            }
        }
    }
}

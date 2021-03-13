<?php

use App\Models\Department;
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
        $adminRole = Role::whereName('admin')->first();
        $input = [
            'fullname'          => 'Super Admin',
            'username'          => 'Admin',
            'password'          => Hash::make('123123123'),
            'phone'             => '082158115949',
            'gender'            => 'male',
            'address'           => 'Pati Jawa Tengah',
            'start_working_date' => date('Y-m-d'),
        ];
        $user = User::create($input);
        $user->assignRole($adminRole);
    }
}

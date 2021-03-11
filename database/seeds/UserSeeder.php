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
        $adminRole = Role::whereName('Admin')->first();
        $input = [
            'fullname'          => 'Super Admin',
            'username'          => 'Admin',
            'password'          => Hash::make('123456789'),
            'phone'             => '7878454512',
            'gender'            => 'male',
            'address'           => 'Pati Jawa Tengah',
            'start_working_date' => date('Y-m-d'),
        ];
        $user = User::create($input);
        $user->assignRole($adminRole);
    }
}

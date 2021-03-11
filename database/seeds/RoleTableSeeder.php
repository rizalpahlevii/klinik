<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $input = [
            'Admin'
        ];
        foreach ($input as $value) {
            Role::create([
                'name'  => $value,
            ]);
        }
    }
}

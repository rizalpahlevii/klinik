<?php

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentsSeeder extends Seeder
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
            Department::create([
                'name'      => $value,
                'is_active' => true,
            ]);
        }
    }
}

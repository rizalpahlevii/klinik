<?php

use App\Models\Medic;
use Illuminate\Database\Seeder;

class MedicSeeder extends Seeder
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
                'name' => 'Rizal Pahlevi',
                'specialization' => 'Dokter 1',
                'birth_date' => date('Y-m-d'),
                'phone' => '012378123',
                'gender' => 'male',
                'blood_group' => 'AB',
                'address' => 'Semarang',
                'city' => 'Semarang'
            ],
            [
                'name' => 'Briska Irvan',
                'specialization' => 'Dokter 2',
                'birth_date' => date('Y-m-d'),
                'phone' => '012378123',
                'gender' => 'male',
                'blood_group' => 'O',
                'address' => 'Semarang',
                'city' => 'Semarang'
            ]
        ];
        foreach ($input as $data) {
            Medic::create($data);
        }
    }
}

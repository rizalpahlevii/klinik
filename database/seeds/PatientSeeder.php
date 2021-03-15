<?php

use App\Models\Patient;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
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
                'name' => 'Rizal Pasien',
                'birth_date' => date('Y-m-d'),
                'phone' => '012378123',
                'gender' => 'male',
                'blood_group' => 'AB',
                'address' => 'Semarang',
                'city' => 'Semarang'
            ],
            [
                'name' => 'Pahlevi Pasien',
                'birth_date' => date('Y-m-d'),
                'phone' => '012378123',
                'gender' => 'male',
                'blood_group' => 'O',
                'address' => 'Semarang',
                'city' => 'Semarang'
            ]
        ];
        foreach ($input as $data) {
            Patient::create($data);
        }
    }
}

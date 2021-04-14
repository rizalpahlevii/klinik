<?php

use App\Models\Medic;
use App\Models\Patient;
use App\Models\Services\General;
use Illuminate\Database\Seeder;

class GeneralServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $patients = Patient::get()->pluck('id')->toArray();
        $medics = Medic::get()->pluck('id')->toArray();
        $data = [
            [
                'registration_time' => now(),
                'patient_id' => $patients[array_rand($patients)],
                'medic_id' => $medics[array_rand($medics)],
                'phone' => '0123123',
                'notes' => 'Testing',
                'service_number' => getUniqueString(),
                'service_fee' => 200000,
                'discount' => 15000,
                'total_fee' => 185000
            ],
            [
                'registration_time' => now(),
                'patient_id' => $patients[array_rand($patients)],
                'medic_id' => $medics[array_rand($medics)],
                'phone' => '0123123',
                'notes' => 'Testing',
                'service_number' => getUniqueString(),
                'service_fee' => 200000,
                'discount' => 15000,
                'total_fee' => 185000
            ],
            [
                'registration_time' => now(),
                'patient_id' => $patients[array_rand($patients)],
                'medic_id' => $medics[array_rand($medics)],
                'phone' => '0123123',
                'notes' => 'Testing',
                'service_number' => getUniqueString(),
                'service_fee' => 200000,
                'discount' => 15000,
                'total_fee' => 185000
            ],
            [
                'registration_time' => now(),
                'patient_id' => $patients[array_rand($patients)],
                'medic_id' => $medics[array_rand($medics)],
                'phone' => '0123123',
                'notes' => 'Testing',
                'service_number' => getUniqueString(),
                'service_fee' => 200000,
                'discount' => 15000,
                'total_fee' => 185000
            ],
        ];
        foreach ($data as $row) {
            General::create($row);
        }
    }
}

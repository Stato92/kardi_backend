<?php

use App\PatientDisease;
use Illuminate\Database\Seeder;
use App\Patient;
use App\User;

class PatientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Patient::class, 150)
        ->create()->each(function($patient) {
            factory(PatientDisease::class, rand(1,2))->create([
                'patient_id' => $patient
            ]);
        });
    }
}

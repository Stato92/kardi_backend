<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Disease;
use App\Patient;
use App\PatientDisease;

$factory->define(PatientDisease::class, function ($patient) {
    return [
        'patient_id' => $patient,
        'disease_id' => Disease::all()->random()
    ];
});

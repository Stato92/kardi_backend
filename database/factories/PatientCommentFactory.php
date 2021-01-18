<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Patient;
use App\PatientComment;
use App\User;
use Faker\Generator as Faker;

$factory->define(PatientComment::class, function (Faker $faker) {
    return [
        'patient_id' => Patient::all()->random(),
        'user_id' => User::all()->random(),
        'content' => $faker->realText(100)
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Patient;
use App\Status;
use App\User;
use Faker\Generator as Faker;

$factory->define(Status::class, function (Faker $faker) {
    $status_table = [
        ['name' => 'Do omówienia na aortic team',
            'priority' => 2],
        ['name' => 'Zakwalifikowany do operacji pilnej',
            'priority' => 4],
        ['name' => 'Zakwalifikowany do operacji przyśpieszonej',
            'priority' => 3],
        ['name' => 'Zakwalifikowany do obserwacji',
            'priority' => 1],
        ['name' => 'Zwymiarowany',
            'priority' => 1],
        ['name' => 'Wysłany na tomografie',
            'priority' => 1],
        ['name' => 'Oglądnięta tomografia',
            'priority' => 1]
    ];
    $random_nr= rand(0,6);
    $name = $status_table[$random_nr]['name'];
    $priority = $status_table[$random_nr]['priority'];
    return [
        'name' => $name,
        'user_id' => User::all()->random(),
        'patient_id' => Patient::all()->random(),
        'priority' => $priority
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Event;
use App\EventType;
use App\Patient;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    $faker->addProvider(new \Faker\Provider\Payment($faker));
    $date = $faker->dateTimeBetween('-30 days','+ 60 days');
    return [
        'name' => $faker->text(150),
        'date' => $date,
        'is_finished' => $date<now()?true:false,
        'patient_id' => Patient::all()->random(),
        'event_type_id' => EventType::all()->random(),
        'gcal_id' => $faker->creditCardNumber
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Alert;
use App\Event;
use Faker\Generator as Faker;

$factory->define(Alert::class, function (Faker $faker) {
    return [
        'event_id' => Event::all()->random(),
        'date' => $faker->dateTimeBetween('-3 days','+ 30 days'),
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Event;
use App\EventUser;
use App\User;
use Faker\Generator as Faker;

$factory->define(EventUser::class, function (Faker $faker) {
    return [
            'event_id' => Event::all()->random(),
            'user_id' => User::all()->random(),
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Status;
use App\StatusComment;
use App\User;
use Faker\Generator as Faker;

$factory->define(StatusComment::class, function (Faker $faker) {
    return [
        'status_id' => Status::all()->random(),
        'user_id' => User::all()->random(),
        'content' => $faker->realText(100)
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Patient;
use Faker\Generator as Faker;
$factory->define(Patient::class, function (Faker $faker) {
    $faker->addProvider(new \Faker\Provider\pl_PL\Person($faker));
    $faker->addProvider(new \Faker\Provider\fr_FR\PhoneNumber($faker));
    return [
        'name' => $faker->firstName,
        'surname' => $faker->lastName,
        'pesel' => $faker->pesel,
        'phone_numbers' => json_encode($faker->mobileNumber),
        'email' => $faker->unique()->safeEmail,
        'diagnosis' => $faker->text($maxNbChars = 600),
        'is_alive' => $faker->boolean($chanceOfGettingTrue = 75),
        'user_id' => App\User::all()->random()
    ];
});

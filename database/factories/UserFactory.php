<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
$factory->define(User::class, function (Faker $faker) {
    $faker->addProvider(new \Faker\Provider\pl_PL\Person($faker));
    $faker->addProvider(new \Faker\Provider\fr_FR\PhoneNumber($faker));
    return [
        'name' => $faker->firstName,
        'surname' => $faker->lastName,
        'phone_numbers' => json_encode($faker->mobileNumber),
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$s5ltQozUCYwaQ.0TQKywGOp4Va7/gCd0eNNPlvNS/zk.Mu72a5BeK', // password
        'remember_token' => Str::random(10),
    ];
});

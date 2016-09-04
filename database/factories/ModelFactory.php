<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Url::class, function (Faker\Generator $faker) {
    return [
        'url' => $faker->url,
        'key' => str_random(10)
    ];
});

$factory->define(App\Click::class, function (Faker\Generator $faker) {
    return [
        'url_id' => $faker->randomDigit
    ];
});

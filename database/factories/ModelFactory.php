<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Hotelier;
use App\Location;
use App\Item;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->defineAs(User::class, 'hotelier', function (Faker $faker) {
    $hotelier = Hotelier::create();
    return [
        'email' => $faker->email,
        'password' => $faker->password,
        'userable_id' => $hotelier->id,
        'userable_type' => 'App\Hotelier',
    ];
});

$factory->define(Location::class, function (Faker $faker) {
    return [
        'city' => 'New York',
        'state' => 'New York',
        'Country' => 'United States',
        'zip_code' => '10007',
    ];
});

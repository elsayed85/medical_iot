<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\bpm;
use App\family;
use App\User;
use App\user_doctors;
use App\user_temp;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => Str::random(10).'@gmail.com',
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => Str::random(10),
        'facebook' => 'facebook.com/' . Str::random(7),
        'geneder' => $faker->randomElement(['male', 'female']),
        'age' => $faker->randomNumber(2),
        'state' => "1",
        'heart_audio' => "1",
        'phone' => $faker->randomNumber(9)
    ];
});

$factory->define(user_doctors::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'name' => $faker->word(),
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'facebook' => 'https://www.facebook.com/' . Str::random(7),
        'info' => $faker->paragraph(2)
    ];
});
$factory->define(bpm::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'bpm' => $faker->numberBetween(70,90),
    ];
});
$factory->define(user_temp::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'temp' => $faker->numberBetween(70,90),
    ];
});
$factory->define(family::class, function (Faker $faker) {
    return [
        'first' => User::all()->random()->id,
        'second' => User::all()->random()->id,
        'type' => $faker->randomElement(['son', 'father' , 'wife'])
    ];
});
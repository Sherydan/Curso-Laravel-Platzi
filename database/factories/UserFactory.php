<?php

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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'username' => $faker->userName(),
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'avatar' => 'https://lorempixel.com/600/338/people?4',
    ];
});

$factory->define(App\Message::class, function(Faker $faker){
    return[
        # nombre de la columna => tipo de dato para rellenar
        'content' => $faker->realText(random_int(20, 140)),
        'image' => $faker->imageUrl(600, 338),
        'created_at' => $faker->dateTimeThisDecade,
        'updated_at' => $faker->dateTimeThisDecade,
    ];
});

$factory->define(App\Response::class, function(Faker $faker){
    return [
        'message' => $faker->word(3, true),
        
    ];
});
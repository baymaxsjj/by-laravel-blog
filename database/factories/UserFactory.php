<?php

use Illuminate\Support\Str;
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

$factory->define(App\Modles\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,     // unique 唯一值
        'password' => '123456',      // 模型里的接受字段已经加密过了，所以这里不需要
        'avatar_url' => $faker->imageUrl($width = 200, $height = 200),
        // 'password' => bcrypt('123456'), // secret
    ];
    // return [
    //     'name' => $faker->name,
    //     'email' => $faker->unique()->safeEmail,
    //     'email_verified_at' => now(),
    //     'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
    //     'remember_token' => Str::random(10),
    // ];
});

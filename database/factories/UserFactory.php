<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
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
        'email' => $faker->unique()->safeEmail,     // unique 唯一值
        'password' => '123456',      // 模型里的接受字段已经加密过了，所以这里不需要
        'avatar_url' => $faker->imageUrl($width = 200, $height = 200),
        // 'password' => bcrypt('123456'), // secret
    ];
});

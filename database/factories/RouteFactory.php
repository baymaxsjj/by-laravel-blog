<?php

use Faker\Generator as Faker;
use App\Models\Route;
$factory->define(Route::class, function (Faker $faker) {
    return [
        'data'=>$faker->date("Y-m", 'now'),
        'category'=>$faker->sentence(3, true),
        'content'=> $faker->sentence(10, true)
    ];
});

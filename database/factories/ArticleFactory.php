<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Article::class, function (Faker $faker) {
    return [
        //
        'title'=>$faker->name,
        'desc'=>$faker->company,
        'title'=>$faker->jobTitle,
        'content'=>$faker->realText(),
        'label_id'=>$faker->randomDigit,
        'name'=>$faker->name,
    ];
});

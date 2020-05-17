<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Label::class, function (Faker $faker) {
    return [
        //
        'label' => $faker->name,
        'user_id' => $faker->randomDigit, 
    ];
});

<?php

use Faker\Generator as Faker;
use App\Models\Reply;
$factory->define(Reply::class, function (Faker $faker) {
    return [
        //
        'reply'=>$faker->realText,
        'mess_id'=>$faker->randomDigit
    ];
});

<?php

use Faker\Generator as Faker;
//  php artisan make:factory Linkfactory创建工厂
//  composer dump-autoload 
//   php artisan make:seeder LinkTableSeeder    
// php artisan db:seed填充数据
// php artisan db:seed --class=UserSeeder 指定填充数据类
$factory->define(App\Models\Link::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'link' => $faker->unique()->domainName,     // unique 唯一值
        'imgUrl'=>$faker->imageUrl(),      // 模型里的接受字段已经加密过了，所以这里不需要
        'info' => $faker->name
        // 'password' => bcrypt('123456'), // secret
    ];
});

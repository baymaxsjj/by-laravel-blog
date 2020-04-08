<?php

use Illuminate\Database\Seeder;
use App\Models\Route;
class RouteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(Route::class, 10)->create();
    }
}

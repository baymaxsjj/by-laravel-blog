<?php

use Illuminate\Database\Seeder;
use App\Models\Link;

class LinkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // factory(Link::class, 10)->create();
        factory(Link::class, 10)->create();
       
    }
}

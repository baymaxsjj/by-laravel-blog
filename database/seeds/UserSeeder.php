<?php

use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        factory(User::class, 25)->create();
        $user = User::first();
        $user->name = 'admin';
        $user->email = 'admin@163.com';
        $user->is_admin = 1;
        // 密码 123456
        $user->save();
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->comment('主键自增id');
            $table->string('name')->unique()->comment('用户名');
            $table->string('email')->unique()->nullable()->comment('email邮箱');
            $table->string('phone')->unique()->nullable()->comment('手机号码');
            $table->text('avatar_url')->nullable()->comment('头像地址');
            $table->string('password')->comment('密码');
            $table->integer('captcha')->nullable()->comment('验证码');
            $table->text('intro')->nullable()->comment('介绍');
            $table->string('is_admin')->nullable()->comment('是否为管理员');
            $table->timestamps();
            // unique 唯一
            // nullable 可以为空
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

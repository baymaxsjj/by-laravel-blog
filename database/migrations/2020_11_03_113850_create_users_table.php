<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id')->comment('主键自增id');
			$table->string('name')->unique()->comment('用户名');
			$table->string('email')->nullable()->unique()->comment('email邮箱');
			$table->string('phone')->nullable()->unique()->comment('手机号码');
			$table->text('avatar_url', 65535)->nullable()->comment('头像地址');
			$table->string('password')->comment('密码');
			$table->integer('captcha')->nullable()->comment('验证码');
			$table->text('intro', 65535)->nullable()->comment('介绍');
			$table->integer('is_admin')->nullable()->default(0)->comment('是否为管理员');
			$table->softDeletes();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}

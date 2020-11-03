<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('messages', function(Blueprint $table)
		{
			$table->increments('id')->comment('主键');
			$table->text('message', 65535)->comment('留言');
			$table->integer('user_id')->nullable()->comment('用户id');
			$table->integer('article_id')->default(0)->comment('文章id,0为网站留言');
			$table->string('tourist', 10)->nullable()->comment('游客留言');
			$table->integer('qq')->nullable()->comment('qq用于获取头像');
			$table->string('ip', 20)->nullable();
			$table->string('address', 100)->nullable();
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
		Schema::drop('messages');
	}

}

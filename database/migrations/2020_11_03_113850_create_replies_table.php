<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRepliesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('replies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('reply', 65535)->comment('回复内容');
			$table->integer('user_id')->default(0)->comment('0为管理员回复');
			$table->integer('mess_id')->comment('回复留言id');
			$table->integer('mess_reply_id')->nullable();
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
		Schema::drop('replies');
	}

}

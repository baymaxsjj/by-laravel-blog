<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMusicsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('musics', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('music_id', 50)->unique()->comment('音乐id');
			$table->string('title')->unique()->comment('音乐标题');
			$table->string('name')->unique()->comment('音乐作者');
			$table->string('type', 10)->default('qq')->comment('音乐位置');
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
		Schema::drop('musics');
	}

}

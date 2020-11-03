<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLinksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('links', function(Blueprint $table)
		{
			$table->increments('id')->comment('id');
			$table->string('name', 20)->unique()->comment('网站名称');
			$table->integer('type')->default(0);
			$table->text('link', 65535)->unique()->comment('网站链接');
			$table->text('imgUrl', 65535)->unique('links_imgurl_unique')->comment('图标');
			$table->string('info', 50)->comment('信息');
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
		Schema::drop('links');
	}

}

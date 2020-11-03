<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRoutesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('routes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('data', 30)->comment('日期');
			$table->string('logo', 100);
			$table->string('category', 30)->comment('类别');
			$table->string('content', 100)->comment('内容');
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
		Schema::drop('routes');
	}

}

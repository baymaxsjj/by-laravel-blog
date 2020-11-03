<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHomesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('homes', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('title', 50)->nullable();
			$table->string('info', 100)->nullable();
			$table->text('link', 65535)->nullable();
			$table->text('img_url', 65535);
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
		Schema::drop('homes');
	}

}

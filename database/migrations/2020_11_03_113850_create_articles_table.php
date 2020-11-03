<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('articles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title')->nullable()->comment('标题');
			$table->string('desc')->nullable()->comment('介绍');
			$table->text('content', 65535)->comment('文章内容');
			$table->text('img', 65535)->nullable()->comment('封面');
			$table->text('classty', 65535)->nullable()->comment('分类');
			$table->text('channels', 65535)->nullable()->comment('多端发布');
			$table->string('name')->comment('作者');
			$table->integer('click')->default(0)->comment('浏览量');
			$table->integer('like')->default(0)->comment('喜欢量');
			$table->integer('is_show')->default(1)->comment('首页显示');
			$table->integer('head_show')->default(1)->comment('头部显示');
			$table->integer('share_show')->nullable()->default(1)->comment('分享显示');
			$table->integer('copyright_show')->nullable()->default(1)->comment('版权显示');
			$table->integer('message_show')->nullable()->default(1)->comment('留言显示');
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
		Schema::drop('articles');
	}

}

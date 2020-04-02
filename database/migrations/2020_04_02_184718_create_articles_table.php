<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('标题');
            $table->string('desc')->nullable()->comment('介绍');
            $table->text('content')->comment('文章内容');
            $table->text('img')->nullable()->comment('封面');
            $table->string('classty')->nullable()->default('前端')->comment('分类');
            $table->string('name')->comment('作者');
            $table->integer('label_id')->comment('标签id');
            $table->integer('click')->default(0)->comment('浏览量');
            $table->integer('like')->default(0)->comment('喜欢量');
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
        Schema::dropIfExists('articles');
    }
}

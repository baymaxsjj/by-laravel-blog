<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            // 可以回复多次
            $table->text('message')->comment('留言');
            $table->integer('user_id')->comment('用户id');
            // $table->text('messconn')->comment('回复内容');
            $table->integer('article_id')->default(0)->comment('文章id');
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
        Schema::dropIfExists('messages');
    }
}

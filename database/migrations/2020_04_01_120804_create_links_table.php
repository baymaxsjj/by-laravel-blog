<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->increments('id')->comment('id');
            $table->string('name',20)->unique()->comment('网站名称');
            $table->text('link')->unique()->comment('网站链接');
            $table->text('imgUrl')->unique()->comment('图标');
            $table->string('info',50)->comment('信息');
            $table->integer('apply')->default(0)->comment('申请0或1');
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
        Schema::dropIfExists('links');
    }
}

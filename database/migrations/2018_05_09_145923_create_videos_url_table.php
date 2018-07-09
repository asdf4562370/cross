<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosUrlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos_url', function (Blueprint $table) {
            $table->increments('id');
            $table->char('pid', '24')->index()->comment('商品ID');
            $table->string('line', 10)->comment('线路');
            $table->string('quality', 10)->comment('画质');
            $table->string('url', 191)->comment('网址');
            $table->string('size', 20)->comment('视频大小(byte)');
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
        Schema::dropIfExists('videos_url');
    }
}

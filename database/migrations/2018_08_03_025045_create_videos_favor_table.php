<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosFavorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos_favor', function (Blueprint $table) {
            $table->increments('id');
            $table->char('pid', '24')->index()->comment('视频ID');
            $table->string('title', 100)->comment('标题');
            $table->char('created_by', '24')->comment('创建人uid');
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
        Schema::dropIfExists('videos_favor');
    }
}

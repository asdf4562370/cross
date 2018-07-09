<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosExtendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos_extend', function (Blueprint $table) {
            $table->increments('id');
            $table->char('pid', '24')->index()->comment('视频ID');
            $table ->unsignedInteger('play_count')->default(0)->comment('播放次数');
            $table ->unsignedInteger('sales_volume')->default(0)->comment('购买次数');
            $table ->unsignedInteger('comments_count')->default(0)->comment('评论数量');
            $table ->unsignedInteger('favorite_count')->default(0)->comment('喜欢数量');
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
        Schema::dropIfExists('videos_extend');
    }
}

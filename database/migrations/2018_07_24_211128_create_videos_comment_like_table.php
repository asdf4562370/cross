<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosCommentLikeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos_comment_like', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('comment_id')->default(0)->comment('评论ID');
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
        Schema::dropIfExists('videos_comment_like');
    }
}

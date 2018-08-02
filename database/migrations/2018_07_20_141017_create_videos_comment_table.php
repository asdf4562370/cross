<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos_comment', function (Blueprint $table) {
            $table->increments('id');
            $table->char('pid', '24')->index()->comment('视频ID');
            $table->unsignedInteger('parent_id')->default(0)->comment('评论父ID');
            $table->char('content', '200')->nullable()->comment('评论正文');
            $table->unsignedInteger('like_num')->default(0)->comment('点赞数量');
            $table->string('nickname')->default('')->comment('创建人昵称');
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
        Schema::dropIfExists('videos_comment');
    }
}

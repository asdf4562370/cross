<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     *
     * 销售规则：rule    =>  [table:product_rule]
     * 每日，工作日（1-5），周六，周日，周末（6-7）
     * 时间段:0-23勾选
     * 列表页不出现价格，点入后，单独调用一个视频，检索销售规则，不会影响效率
     *
     * 状态: status
     * 'init',   'uploading', 'uploaded',        'merge',   'merged',
     * '初始化', '正在上传',   '上传完成，待合并', '正在合并', '合并完成，待转码',
     * 'merge_fail', 'encoding', 'encoded',         'encode_fail', 'verified',
     * '合并失败',   '正在转码',  '转码完成，待审核', '转码失败',     '审核通过',
     * 'reject',    'release', 'unpublished', 'release_failure', 'expired', 'retention',   'disabled']
     * '审核不通过', '发布',    '未发布',       '发布失败',        '已过期',  '过期保留阶段', '禁止播放']
     *
     * $expiresAt = Carbon::now()->addDays(3);
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->char('pid', '24')->index()->comment('商品ID');
            $table->string('title', 100)->comment('标题');
            $table->text('content')->nullable()->comment('描述');
            $table->enum('currency', ['free', 'ticket', 'diamond'])->default('free')->comment('货币,点券/钻石');
            $table->unsignedInteger('price')->default(0)->comment('价格');
            $table->unsignedInteger('duration')->default(0)->comment('视频的长度');
            $table->unsignedInteger('clip_begin')->default(0)->comment('试看片段的开始时间');
            $table->string('origin_filename',255)->nullable()->comment('视频原始文件名');
            $table->unsignedInteger('origin_filesize')->default(0)->comment('视频原始文件大小');
//            $table->unsignedInteger('encode_filesize')->default(0)->comment('视频转码后的文件大小');
//            $table->string('encode_tmpfile',255)->nullable()->comment('视频转码后的临时文件');
            $table->string('video_cover',255)->nullable()->comment('封面图片的web相对地址');
            $table->text('comments')->nullable()->comment('冗余-评论');
            $table->string('reson', 100)->nullable()->comment('审核未通过原因');
            $table->enum('status', ['init', 'uploading', 'uploaded', 'merge', 'merged', 'encoding', 'encoded', 'encode_fail', 'verified', 'reject', 'release', 'unpublished', 'release_failure', 'expired', 'retention', 'disabled'])->comment('状态');
            $table->dateTime('expire')->comment('视频生命周期');
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
        Schema::dropIfExists('videos');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     *
     * 商品id之所以没有用pid，是因为购买的东西包含有：视频、暂时想到了彩票等各种东西（）
     * type: video|
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->char('item_id', '24')->index()->comment('商品ID');
            $table->string('type',30)->default(null)->comment('商品类型');
            $table->string('currency',30)->default(null)->comment('货币');
            $table->unsignedInteger('amount')->default(0)->comment('价格');
            $table->char('created_by', '24')->comment('买家uid');
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
        Schema::dropIfExists('orders');
    }
}

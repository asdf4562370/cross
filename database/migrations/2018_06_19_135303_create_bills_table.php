<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id')->default(0)->comment('定单id');
            $table->string('currency',30)->default(null)->comment('货币');
            $table->integer('amount')->default(0)->comment('金额');
            $table->unsignedInteger('balance')->default(0)->comment('交易后的金额');
            $table->string('business_type',30)->nullable()->comment('交易类型');
            $table->text('description')->nullable()->comment('描述');
            $table->string('status',30)->default(null)->comment('状态');
            $table->char('created_by', '24')->comment('用户uid');
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
        Schema::dropIfExists('bills');
    }
}

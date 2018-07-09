<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ticket')->default(0)->comment('点券');
            $table->unsignedInteger('diamond')->default(0)->comment('钻石');
            $table->unsignedInteger('frozen_diamond')->default(0)->comment('冻结的钻石');
            $table->string('last_withdraw_type',30)->nullable()->comment('最近提现方式');
            $table->dateTime('last_withdraw_time')->nullable()->comment('最近提现时间');
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
        Schema::dropIfExists('wallet');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->char('uid', '24')->comment('防猜UID');
            $table->unsignedInteger('introducer_id')->index();
            $table->string('username');
            $table->string('nickname')->default('')->comment('昵称');
            $table->string('email', 50);
            $table->string('password');
            $table->string('access_token', 100)->comment('访问令牌');
            $table->string('slat', 100)->comment('盐值');
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
        Schema::dropIfExists('users');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersPreferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_preference', function (Blueprint $table) {
            $table->increments('id');
            $table->char('uid', '24')->index()->comment('用户UID');
            $table ->unsignedTinyInteger('normal')->default(0)->comment('标准');
            $table ->unsignedTinyInteger('horror')->default(0)->comment('恐怖');
            $table ->unsignedTinyInteger('war')->default(0)->comment('战争');
            $table ->unsignedTinyInteger('crime')->default(0)->comment('犯罪');
            $table ->unsignedTinyInteger('sm')->default(0)->comment('虐恋');
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
        Schema::dropIfExists('users_preference');
    }
}

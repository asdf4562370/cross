<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table ->string('preference', 30)->after('pid')->default("normal")->comment('偏好类型');
            $table ->unsignedTinyInteger('level')->after('preference')->default(0)->comment('偏好等级');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table ->dropColumn('preference');
            $table ->dropColumn('level');
        });
    }
}

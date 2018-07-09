<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterVideosTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        Schema::table('videos', function (Blueprint $table) {
            $table->string('title', 200)->comment('标题')->change();
        });
        Schema::table('videos', function (Blueprint $table) {
            $table->string('screen_orientation', 30)->after('duration')->default("portrait")->comment('屏幕方向');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        Schema::table('videos', function (Blueprint $table) {
            $table->string('title', 100)->comment('标题')->change();
        });
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('screen_orientation');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditMediaUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media_users', function (Blueprint $table) {
            //$table->integer('current_episode')->nullable();
            $table->foreign('current_episode')->references('episode_id')->on('episode_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media_users', function (Blueprint $table) {
            $table->dropForeign('current_episode');
            $table->dropColumn('current_episode');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditEpisodeUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('episode_users', function (Blueprint $table) {
            $table->integer('episode_id')->unique()->change();
            $table->integer('season');
            $table->integer('episode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('episode_users', function (Blueprint $table) {
            $table->string('episode_id');
            $table->dropColumn('episode_id')->unique();
            $table->dropColumn('season');
            $table->dropColumn('episode');
        });
    }
}

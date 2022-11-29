<?php

use App\Models\MediaUser;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpisodeUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episode_users', function (Blueprint $table) {
            $table->id();
            $table->integer('episode_id');
            $table->boolean('is_watched');
            $table->dateTime('date_completed');
            $table->foreignIdFor(MediaUser::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('episode_users');
    }
}

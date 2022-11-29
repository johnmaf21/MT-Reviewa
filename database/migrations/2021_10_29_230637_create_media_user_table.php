<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Media;

class CreateMediaUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_users', function (Blueprint $table) {
            $table->id();
            $table->integer('media_id');
            $table->string('media_type');
            $table->dateTime('last_watched')->nullable();
            $table->boolean('is_completed');
            $table->boolean('has_liked');
            $table->boolean('has_reaction');
            $table->float('completion');
            $table->string('current_episode')->nullable();
            $table->foreignIdFor(User::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_users');
    }
}

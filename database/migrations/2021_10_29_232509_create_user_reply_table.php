<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\UserComment;

class CreateUserReplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_replys', function (Blueprint $table) {
            $table->id();
            $table->string('comment');
            $table->foreignIdFor(UserComment::class);
            $table->foreignIdFor(User::class);
            $table->dateTime('date_posted');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_replys');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLoginOptionsForUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('github_id')->nullable();
            $table->string('google_id')->nullable();
            $table->string('twitter_id')->nullable();
            $table->string('linkedIn_id')->nullable();
            $table->string('auth_type')->nullable();

            $table->dateTime('dob')->nullable()->change();
            $table->string('profile_pic')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

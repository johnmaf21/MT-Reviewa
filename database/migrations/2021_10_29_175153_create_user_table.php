<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\User;

class CreateUserTable extends Migration
{
    /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::table('users', function (Blueprint $table) {
                $table->string('username');
                $table->date('dob');
                $table->string('profile_pic');
                $table->boolean('is_private');
                $table->dropColumn('name');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::table('users', function (Blueprint $table) {
                        $table->string('name');
                        $table->dropColumn('username');
                        $table->dropColumn('dob');
                        $table->dropColumn('profile_pic');
                        $table->dropColumn('is_private');
                    });
        }

}

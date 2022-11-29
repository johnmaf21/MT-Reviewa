<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditTwoFactor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('two_factor_code')
                ->after('password')
                ->nullable();

            $table->dateTime('two_factor_expires_at')
                ->after('two_factor_code')
                ->nullable();

            $table->dropColumn('two_factor_secret');
            $table->dropColumn('two_factor_recovery_codes');
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

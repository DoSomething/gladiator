<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOauthFieldsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update columns on user table
        Schema::table('users', function (Blueprint $table) {
            $table->string('access_token', 1024)->after('remember_token')->nullable();
            $table->integer('access_token_expiration')->after('access_token')->nullable();
            $table->string('refresh_token', 1024)->after('access_token_expiration')->nullable();
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
            $table->dropColumn('access_token');
            $table->dropColumn('access_token_expiration');
            $table->dropColumn('refresh_token');
        });
    }
}

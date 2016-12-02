<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameUserIdColumnsToNorthstarId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_waiting_room', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->renameColumn('user_id', 'northstar_id');
            $table->foreign('northstar_id')->references('northstar_id')->on('users')->onDelete('cascade');
        });

        Schema::table('competition_user', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->renameColumn('user_id', 'northstar_id');
            $table->foreign('northstar_id')->references('northstar_id')->on('users')->onDelete('cascade');
        });

        Schema::table('leaderboard_photos', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->renameColumn('user_id', 'northstar_id');
            $table->foreign('northstar_id')->references('northstar_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_waiting_room', function (Blueprint $table) {
            $table->dropForeign(['northstar_id']);
            $table->renameColumn('northstar_id', 'user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('competition_user', function (Blueprint $table) {
            $table->dropForeign(['northstar_id']);
            $table->renameColumn('northstar_id', 'user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('leaderboard_photos', function (Blueprint $table) {
            $table->dropForeign(['northstar_id']);
            $table->renameColumn('northstar_id', 'user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
}

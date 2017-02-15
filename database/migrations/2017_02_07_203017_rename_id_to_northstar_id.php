<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameIdToNorthstarId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('id', 'northstar_id');
        });

        // Schema::table('user_waiting_room', function (Blueprint $table) {
        //     $table->dropForeign('user_waiting_room_user_id_foreign');
        //     $table->renameColumn('user_id', 'northstar_id');
        //     $table->foreign('northstar_id')->references('northstar_id')->on('users')->onDelete('cascade');
        // });

        // Schema::table('competition_user', function (Blueprint $table) {
        //     $table->dropForeign('competition_user_user_id_foreign');
        //     $table->renameColumn('user_id', 'northstar_id');
        //     $table->foreign('northstar_id')->references('northstar_id')->on('users')->onDelete('cascade');
        // });

        // Schema::table('leaderboard_photos', function (Blueprint $table) {
        //     $table->dropForeign('leaderboard_photos_user_id_foreign');
        //     $table->renameColumn('user_id', 'northstar_id');
        //     $table->foreign('northstar_id')->references('northstar_id')->on('users')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('northstar_id', 'id');
        });

        // Schema::table('user_waiting_room', function (Blueprint $table) {
        //     $table->dropForeign('user_waiting_room_northstar_id_foreign');
        //     $table->renameColumn('northstar_id', 'user_id');
        //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        // });

        // Schema::table('competition_user', function (Blueprint $table) {
        //     $table->dropForeign('competition_user_northstar_id_foreign');
        //     $table->renameColumn('northstar_id', 'user_id');
        //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        // });

        // Schema::table('leaderboard_photos', function (Blueprint $table) {
        //     $table->dropForeign('leaderboard_photos_northstar_id_foreign');
        //     $table->renameColumn('northstar_id', 'user_id');
        //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        // });
    }
}

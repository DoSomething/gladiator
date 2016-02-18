<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserWaitingRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_waiting_room', function (Blueprint $table) {
            $table->string('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('waiting_room_id')->unsigned()->index();
            $table->foreign('waiting_room_id')->references('id')->on('waiting_rooms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_waiting_room');
    }
}

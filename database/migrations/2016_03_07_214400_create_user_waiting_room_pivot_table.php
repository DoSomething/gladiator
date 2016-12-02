<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserWaitingRoomPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_waiting_room', function (Blueprint $table) {
            $table->string('northstar_id');
            $table->foreign('northstar_id')->references('northstar_id')->on('users')->onDelete('cascade');
            $table->integer('waiting_room_id')->unsigned();
            $table->foreign('waiting_room_id')->references('id')->on('waiting_rooms')->onDelete('cascade');
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

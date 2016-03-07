<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWaitingRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waiting_rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contest_id')->unsigned();
            $table->foreign('contest_id')->references('id')->on('contests')->onDelete('cascade');
            $table->dateTime('signup_start_date');
            $table->dateTime('signup_end_date');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('waiting_rooms');
    }
}

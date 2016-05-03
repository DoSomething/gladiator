<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->index();
            $table->integer('key')->unsigned();
            $table->string('label')->nullable();
            $table->string('subject')->nullable();
            $table->longText('body')->nullable();
            $table->longtext('pro_tip')->nullable();
            $table->longText('shoutout')->nullable();
            $table->longtext('signoff')->nullable();
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
        Schema::drop('messages_settings');
    }
}

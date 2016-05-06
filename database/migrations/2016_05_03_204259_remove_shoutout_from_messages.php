<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveShoutoutFromMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages_settings', function (Blueprint $table) {
            $table->dropColumn('shoutout');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages_settings', function (Blueprint $table) {
            $table->longText('shoutout')->nullable();
        });
    }
}

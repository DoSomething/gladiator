<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeaturedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('reportback_id');
            $table->dropColumn('reportback_item_id');
            $table->dropColumn('shoutout');
        });

        Schema::create('featured_reportbacks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('competition_id')->unsigned();
            $table->foreign('competition_id')->references('id')->on('competitions')->onDelete('cascade');
            $table->integer('message_id')->unsigned();
            $table->foreign('message_id')->references('id')->on('messages')->onDelete('cascade');
            $table->integer('reportback_id')->nullable();
            $table->integer('reportback_item_id')->nullable();
            $table->longText('shoutout')->nullable();
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
        Schema::drop('featured_reportbacks');

        Schema::table('messages', function (Blueprint $table) {
            $table->integer('reportback_id')->nullable()->after('pro_tip');
            $table->integer('reportback_item_id')->nullable()->after('reportback_id');
            $table->longText('shoutout')->nullable()->after('reportback_item_id');
        });
    }
}

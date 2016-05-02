<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveFeaturedReportbackToCompetition extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drop featured reportback from messages.
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('reportback_id');
            $table->dropColumn('reportback_item_id');
            $table->dropColumn('shoutout');
        });
        // Add featured reportback to competitions.
        Schema::table('competitions', function (Blueprint $table) {
            $table->integer('reportback_id')->nullable()->after('leaderboard_msg_day');
            $table->integer('reportback_item_id')->nullable()->after('reportback_id');
            $table->longText('shoutout')->nullable()->after('reportback_item_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('competitions', function (Blueprint $table) {
            $table->dropColumn('reportback_id');
            $table->dropColumn('reportback_item_id');
            $table->dropColumn('shoutout');
        });
        Schema::table('messages', function (Blueprint $table) {
            $table->integer('reportback_id')->nullable()->after('leaderboard_msg_day');
            $table->integer('reportback_item_id')->nullable()->after('reportback_id');
            $table->longText('shoutout')->nullable()->after('reportback_item_id');
        });
    }
}

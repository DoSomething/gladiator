<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameSenderColumnToSenderEmailAndAddSenderNameColumnToContestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contests', function (Blueprint $table) {
            $table->string('sender_name')->nullable()->after('sender');
            $table->renameColumn('sender', 'sender_email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contests', function (Blueprint $table) {
            $table->renameColumn('sender_email', 'sender');
            $table->dropColumn('sender_name');
        });
    }
}

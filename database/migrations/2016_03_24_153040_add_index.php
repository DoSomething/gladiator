<?php

use Illuminate\Database\Migrations\Migration;

class AddIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contests', function ($table) {
            $table->unique('id');
        });

        Schema::table('competitions', function ($table) {
            $table->unique('id');
        });

        Schema::table('users', function ($table) {
            $table->unique('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contests', function ($table) {
            $table->dropUnique('id');
        });

        Schema::table('competitions', function ($table) {
            $table->dropUnique('id');
        });

        Schema::table('users', function ($table) {
            $table->dropUnique('id');
        });
    }
}

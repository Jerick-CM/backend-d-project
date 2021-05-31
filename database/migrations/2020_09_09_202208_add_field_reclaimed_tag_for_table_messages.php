<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldReclaimedTagForTableMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('messages', function ($table) {     
            DB::statement("ALTER TABLE `messages` ADD `is_reclaimed_token` TINYINT NULL DEFAULT NULL AFTER `is_recipienttoken_removed`;");
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

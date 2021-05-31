<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsRefundedTagToTableMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::table('messages', function ($table) {     
            DB::statement("ALTER TABLE `messages` ADD `is_refunded` TINYINT NULL DEFAULT NULL AFTER `is_reclaimed_token`;");
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

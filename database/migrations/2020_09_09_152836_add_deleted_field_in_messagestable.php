<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeletedFieldInMessagestable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('messages', function ($table) {
            DB::statement("ALTER TABLE `messages` ADD `deleted` TINYINT NULL DEFAULT '0' AFTER `deleted_at`;");
            DB::statement("UPDATE `messages` SET deleted=0;");
            DB::statement("ALTER TABLE `messages` ADD `is_badge_removed` TINYINT NULL DEFAULT '0' AFTER `deleted_at`, ADD `is_recipient_removed` TINYINT NULL DEFAULT '0' AFTER `is_badge_removed`;");
            DB::statement("UPDATE `messages` SET is_badge_removed=0;");
            DB::statement("UPDATE `messages` SET is_recipient_removed=0;");
        });

        Schema::table('message_badges', function ($table) {
            DB::statement("ALTER TABLE `message_badges` ADD `deleted` TINYINT NULL DEFAULT '0' AFTER `deleted_at`;");
            DB::statement("UPDATE `message_badges` SET deleted=0;");
        });

        Schema::table('message_tokens', function ($table) {
            DB::statement("ALTER TABLE `message_tokens` ADD `deleted` TINYINT NULL DEFAULT '0' AFTER `deleted_at`;");
            DB::statement("UPDATE `message_tokens` SET deleted=0;");
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

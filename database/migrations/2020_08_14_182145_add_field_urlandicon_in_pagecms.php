<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldUrlandiconInPagecms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //  Schema::table('pages', function ($table) {
        //     DB::statement("TRUNCATE pages");
        // });

        Schema::table('pages', function ($table) {
            DB::statement("ALTER TABLE `pages` ADD `icon` VARCHAR(255) NULL DEFAULT NULL AFTER `content`, ADD `pageurl` VARCHAR(255) NULL DEFAULT NULL AFTER `icon`;");
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

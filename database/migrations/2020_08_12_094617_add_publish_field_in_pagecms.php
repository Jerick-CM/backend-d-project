<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPublishFieldInPagecms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('pages', function ($table) {
            DB::statement("ALTER TABLE `pages` ADD `publish` TINYINT(1) NOT NULL DEFAULT '0' AFTER `priority`;");
        });
     //
        Schema::table('pages', function ($table) {
            DB::statement("update pages set publish=0;");
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

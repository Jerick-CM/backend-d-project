<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddfieldPagesmenuIdupload extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('pages', function ($table) {

                DB::statement("ALTER TABLE `pages` ADD `is_upload` TINYINT NULL DEFAULT '0' AFTER `icon`;");
                DB::statement("Update `pages` set is_upload=0; ");
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

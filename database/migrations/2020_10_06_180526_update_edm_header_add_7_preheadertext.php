<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEdmHeaderAdd7Preheadertext extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('edm_header', function ($table) { 

            DB::statement("ALTER TABLE `edm_header` ADD `preheadertext1` VARCHAR(1024) NULL DEFAULT NULL AFTER `image3`, ADD `preheadertext2` VARCHAR(1024) NULL DEFAULT NULL AFTER `preheadertext1`, ADD `preheadertext3` VARCHAR(1024) NULL DEFAULT NULL AFTER `preheadertext2`, ADD `preheadertext4` VARCHAR(1024) NULL DEFAULT NULL AFTER `preheadertext3`, ADD `preheadertext5` VARCHAR(1024) NULL DEFAULT NULL AFTER `preheadertext4`, ADD `preheadertext6` VARCHAR(1024) NULL DEFAULT NULL AFTER `preheadertext5`, ADD `preheadertext7` VARCHAR(1024) NULL DEFAULT NULL AFTER `preheadertext6`;");

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

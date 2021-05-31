<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEdmFoterWithTextfields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('edm_footer', function ($table) { 

            DB::statement("ALTER TABLE `edm_footer` ADD `footerlabel1` VARCHAR(2048) NULL DEFAULT NULL AFTER `content`, ADD `footerlabel2` VARCHAR(2048) NULL DEFAULT NULL AFTER `footerlabel1`, ADD `footerlabel3` VARCHAR(2048) NULL DEFAULT NULL AFTER `footerlabel2`, ADD `footerlabel4` VARCHAR(2048) NULL DEFAULT NULL AFTER `footerlabel3`, ADD `footerlabel5` VARCHAR(2048) NULL DEFAULT NULL AFTER `footerlabel4`, ADD `footerlabel6` VARCHAR(2048) NULL DEFAULT NULL AFTER `footerlabel5`, ADD `footerlabel7` VARCHAR(2048) NULL DEFAULT NULL AFTER `footerlabel6`;");

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

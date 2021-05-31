<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEdmHeaderWithLabelandimagefields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('edm_header', function ($table) { 

            DB::statement("ALTER TABLE `edm_header` ADD `title` VARCHAR(1024) NULL DEFAULT NULL AFTER `content`, ADD `label1` MEDIUMTEXT NULL DEFAULT NULL AFTER `title`, ADD `label2` MEDIUMTEXT NULL DEFAULT NULL AFTER `label1`, ADD `label3` MEDIUMTEXT NULL DEFAULT NULL AFTER `label2`, ADD `image1` VARCHAR(1024) NULL DEFAULT NULL AFTER `label3`, ADD `label4` MEDIUMTEXT NULL DEFAULT NULL AFTER `image1`, ADD `image2` VARCHAR(1024) NULL DEFAULT NULL AFTER `label4`, ADD `image3` VARCHAR(1024) NULL DEFAULT NULL AFTER `image2`;");

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

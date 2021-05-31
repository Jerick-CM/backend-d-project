<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEdmHeaderAddaddionalImagesspecific extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::table('edm_header', function ($table) { 

            DB::statement("ALTER TABLE `edm_header` ADD `image4` MEDIUMTEXT NULL DEFAULT NULL AFTER `image3`, ADD `image5` MEDIUMTEXT NULL DEFAULT NULL AFTER `image4`, ADD `image6` MEDIUMTEXT NULL DEFAULT NULL AFTER `image5`, ADD `image7` MEDIUMTEXT NULL DEFAULT NULL AFTER `image6`, ADD `image8` MEDIUMTEXT NULL DEFAULT NULL AFTER `image7`, ADD `image9` MEDIUMTEXT NULL DEFAULT NULL AFTER `image8`;");

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

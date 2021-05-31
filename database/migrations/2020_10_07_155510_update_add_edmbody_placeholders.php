<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddEdmbodyPlaceholders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    
        Schema::table('edm_template_body', function ($table) { 

            DB::statement("ALTER TABLE `edm_template_body` ADD `placeholder1` MEDIUMTEXT NOT NULL AFTER `content`, ADD `placeholder2` MEDIUMTEXT NOT NULL AFTER `placeholder1`, ADD `placeholder3` MEDIUMTEXT NOT NULL AFTER `placeholder2`, ADD `placeholder4` MEDIUMTEXT NOT NULL AFTER `placeholder3`, ADD `placeholder5` MEDIUMTEXT NOT NULL AFTER `placeholder4`, ADD `placeholder6` MEDIUMTEXT NOT NULL AFTER `placeholder5`, ADD `placeholder7` MEDIUMTEXT NOT NULL AFTER `placeholder6`, ADD `placeholder8` MEDIUMTEXT NOT NULL AFTER `placeholder7`, ADD `placeholder9` MEDIUMTEXT NOT NULL AFTER `placeholder8`, ADD `placeholder10` MEDIUMTEXT NOT NULL AFTER `placeholder9`, ADD `placeholder11` MEDIUMTEXT NOT NULL AFTER `placeholder10`, ADD `placeholder12` MEDIUMTEXT NOT NULL AFTER `placeholder11`, ADD `placeholder13` MEDIUMTEXT NOT NULL AFTER `placeholder12`, ADD `placeholder14` MEDIUMTEXT NOT NULL AFTER `placeholder13`, ADD `placeholder15` MEDIUMTEXT NOT NULL AFTER `placeholder14`, ADD `placeholder16` MEDIUMTEXT NOT NULL AFTER `placeholder15`, ADD `placeholder17` MEDIUMTEXT NOT NULL AFTER `placeholder16`, ADD `placeholder18` MEDIUMTEXT NOT NULL AFTER `placeholder17`, ADD `placeholder19` MEDIUMTEXT NOT NULL AFTER `placeholder18`, ADD `placeholder20` MEDIUMTEXT NOT NULL AFTER `placeholder19`, ADD `placeholder21` MEDIUMTEXT NOT NULL AFTER `placeholder20`, ADD `placeholder22` MEDIUMTEXT NOT NULL AFTER `placeholder21`, ADD `placeholder23` MEDIUMTEXT NOT NULL AFTER `placeholder22`, ADD `placeholder24` MEDIUMTEXT NOT NULL AFTER `placeholder23`, ADD `placeholder25` MEDIUMTEXT NOT NULL AFTER `placeholder24`, ADD `placeholder26` MEDIUMTEXT NOT NULL AFTER `placeholder25`, ADD `placeholder27` MEDIUMTEXT NOT NULL AFTER `placeholder26`;");

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

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEdmTemplatebodyFieldsHeadersToBody extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

      
        // Schema::table('edm_template_body', function ($table) { 

        //     DB::statement("ALTER TABLE `edm_template_body` ADD `header1` MEDIUMTEXT NOT NULL AFTER `content`, ADD `header2` MEDIUMTEXT NOT NULL AFTER `header1`, ADD `header3` MEDIUMTEXT NOT NULL AFTER `header2`, ADD `header4` MEDIUMTEXT NOT NULL AFTER `header3`, ADD `header5` MEDIUMTEXT NOT NULL AFTER `header4`;");
            
        // });  

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

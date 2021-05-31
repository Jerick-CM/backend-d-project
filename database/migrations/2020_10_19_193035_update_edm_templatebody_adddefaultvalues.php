<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEdmTemplatebodyAdddefaultvalues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        // Schema::table('edm_template_body', function ($table) { 
        //     DB::statement("ALTER TABLE `edm_template_body` CHANGE `header1` `header1` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/top-banner.jpg\"></figure>';");
        // });  

        // Schema::table('edm_template_body', function ($table) { 
        //     DB::statement("ALTER TABLE `edm_template_body` CHANGE `header2` `header2` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT '<p><span style=\"background-color:rgb(255,255,255);color:rgb(128,128,128);\">Singapore | {{date}}</span></p>'");
        // });  


        // Schema::table('edm_template_body', function ($table) { 
        //     DB::statement("ALTER TABLE `edm_template_body` CHANGE `header3` `header3` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/main-banner.jpg\"></figure>';");
        // });  


        // Schema::table('edm_template_body', function ($table) { 
        //     DB::statement("ALTER TABLE `edm_template_body` CHANGE `header4` `header4` MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/welcome-banner-default.jpg\"></figure>';");
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

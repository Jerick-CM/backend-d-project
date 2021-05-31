<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEdmBodyBanner1Default extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('edm_template_body', function ($table) { 

            DB::statement("ALTER TABLE `edm_template_body` CHANGE `header1` `header1` VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT 'img/edm/main-banner.jpg';
            ;");

        }); 

       Schema::table('edm_template_body', function ($table) { 

            DB::statement("UPDATE `edm_template_body` SET header1='img/edm/main-banner.jpg';");

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

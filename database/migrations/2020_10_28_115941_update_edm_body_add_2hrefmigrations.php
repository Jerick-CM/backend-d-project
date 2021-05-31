<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEdmBodyAdd2hrefmigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
       Schema::table('edm_template_body', function ($table) { 

            DB::statement("ALTER TABLE `edm_template_body` ADD `href1` VARCHAR(512) NULL DEFAULT 'https://www.deloitte.com/' AFTER `content`, ADD `href2` VARCHAR(512) NULL DEFAULT 'https://www.deloitte.com/' AFTER `href1`;");            

        }); 


        Schema::table('edm_template_body', function ($table) {

            DB::statement("UPDATE edm_template_body SET href1='https://www.deloitte.com/' ");

        }); 

        Schema::table('edm_template_body', function ($table) {   

            DB::statement("UPDATE edm_template_body SET href2='https://www.deloitte.com/' ");   

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

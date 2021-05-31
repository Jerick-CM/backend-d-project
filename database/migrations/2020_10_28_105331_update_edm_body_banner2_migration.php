<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEdmBodyBanner2Migration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('edm_template_body', function ($table) { 

            DB::statement("UPDATE  edm_template_body set header2='img/edm/welcome-banner-default.jpg';");

        }); 

        Schema::table('edm_template_body', function ($table) { 

            DB::statement("UPDATE  edm_template_body set header2='img/edm/welcome-banner-6.jpg' where id=1;");

        }); 

        Schema::table('edm_template_body', function ($table) { 

            DB::statement("UPDATE  edm_template_body set header2='img/edm/welcome-banner-4-v2.jpg' where id=2;");

        });

        Schema::table('edm_template_body', function ($table) { 

            DB::statement("UPDATE  edm_template_body set header2='img/edm/welcome-banner-7.jpg' where id=3;");

        }); 

        Schema::table('edm_template_body', function ($table) { 

            DB::statement("UPDATE  edm_template_body set header2='img/edm/welcome-banner-5-v2.jpg' where id=4;");

        }); 

        Schema::table('edm_template_body', function ($table) { 

            DB::statement("UPDATE  edm_template_body set header2='img/edm/welcome-banner-2.jpg' where id=5;");

        }); 

        Schema::table('edm_template_body', function ($table) { 

            DB::statement("UPDATE  edm_template_body set header2='img/edm/welcome-banner-1.jpg' where id=6;");

        }); 


        Schema::table('edm_template_body', function ($table) { 

            DB::statement("UPDATE  edm_template_body set header2='img/edm/welcome-banner-3-v2.jpg' where id=7;");

        }); 

        Schema::table('edm_template_body', function ($table) { 

            DB::statement("UPDATE  edm_template_body set header2='img/edm/welcome-banner-8-tierpromotion.jpg' where id=8;");

        }); 

        Schema::table('edm_template_body', function ($table) { 

            DB::statement("UPDATE  edm_template_body set header2='img/edm/welcome-banner-masstokenupdate.jpg' where id=9;");

        }); 

        Schema::table('edm_template_body', function ($table) {


             DB::statement("ALTER TABLE `edm_template_body` CHANGE `header2` `header2` VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT 'img/edm/welcome-banner-default.jpg';");

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

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEdmTierWelcomebannerimageAndData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('edm_header', function ($table) { 

            DB::statement("ALTER TABLE `edm_header` ADD `image10` TEXT NOT NULL AFTER `image9`;");

        });  

        Schema::table('edm_header', function ($table) { 

            DB::statement("update edm_header set image10='public/img/edm/welcome-banner-8-tierpromotion.jpg'");

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

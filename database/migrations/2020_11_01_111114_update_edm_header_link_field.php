<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEdmHeaderLinkField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           Schema::table('edm_header', function ($table) { 

            DB::statement("ALTER TABLE `edm_header` ADD `link` VARCHAR(512) NULL DEFAULT 'https://www.deloitte.com/' AFTER `content`;");            

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

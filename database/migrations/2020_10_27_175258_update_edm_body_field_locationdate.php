<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEdmBodyFieldLocationdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('edm_template_body', function ($table) { 

            DB::statement("ALTER TABLE `edm_template_body` ADD `locationdate` VARCHAR(255) NULL DEFAULT NULL AFTER `content`;");

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

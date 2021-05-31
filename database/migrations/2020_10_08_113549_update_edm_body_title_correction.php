<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEdmBodyTitleCorrection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('edm_template_body', function ($table) { 
            DB::statement("UPDATE `edm_template_body` SET `label` = 'Message Received', `deleted_at` = NULL WHERE `edm_template_body`.`id` = 2");
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

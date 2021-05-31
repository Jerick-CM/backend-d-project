<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EdmBodyTableTitleAndSubject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('edm_template_body', function ($table) { 
           DB::statement("ALTER TABLE `edm_template_body` ADD `title` VARCHAR(1024) NULL DEFAULT NULL AFTER `content`, ADD `subject` VARCHAR(2000) NULL DEFAULT NULL AFTER `title`;");
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

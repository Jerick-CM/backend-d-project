<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEdmtemplatebodyMasstokenBannerimages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('edm_template_body', function ($table) { 

            DB::statement("UPDATE edm_template_body SET header1 = 'img/edm/main-banner.jpg', header2 ='img/edm/welcome-banner-masstokenupdate.jpg' WHERE id=9; ");
                
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

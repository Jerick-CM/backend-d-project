<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Reupdatemasstokencontentvalue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::table('edm_template_body', function ($table) { 

                DB::statement("UPDATE edm_template_body SET content = '<p>Dear {{name}} ,</p><p>{{message}}</p><p>{{masstokenupadetable}}</p><p>&nbsp;</p>' WHERE id=9; ");
                
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

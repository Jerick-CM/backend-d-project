<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMasstokenUploadMaildata extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('edm_template_body', function ($table) { 

           DB::statement("Update edm_template_body set label='Mass Token Upload Mail',content='<p>Dear {{name}} ,</p><p>{{message}}</p><figure class=\"table\" style=\"float:left;\"><table><tbody><tr><td>Recognize Others Token Deduct</td><td>{{RO_deduct}}</td></tr><tr><td>Recognize Others Token Add</td><td>{{RO_add}}</td></tr><tr><td>My Rewards Token Deduct</td><td>{{MR_deduct}}</td></tr><tr><td>My Rewards Token Added</td><td>{{MR_add}}</td></tr></tbody></table></figure><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>',subject='Mass Token Upload' where id=9 ");

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

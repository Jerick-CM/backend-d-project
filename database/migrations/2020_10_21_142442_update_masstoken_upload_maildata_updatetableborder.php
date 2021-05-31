<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMasstokenUploadMaildataUpdatetableborder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           Schema::table('edm_template_body', function ($table) { 

           DB::statement("Update edm_template_body set content='<p>Dear {{name}} ,</p><p>{{message}}</p><figure class=\"table\" style=\"float:left;\"><table><tbody><tr><td style=\"border-bottom:solid hsl(0, 0%, 90%);border-left:solid hsl(0, 0%, 90%);border-right:solid hsl(0, 0%, 90%);border-top:solid hsl(0, 0%, 90%);\">Recognize Others Token Deduct</td><td style=\"border-bottom:solid hsl(0, 0%, 90%);border-left:solid hsl(0, 0%, 90%);border-right:solid hsl(0, 0%, 90%);border-top:solid hsl(0, 0%, 90%);\">{{RO_deduct}}</td></tr><tr><td style=\"border-bottom:solid hsl(0, 0%, 90%);border-left:solid hsl(0, 0%, 90%);border-right:solid hsl(0, 0%, 90%);border-top:solid hsl(0, 0%, 90%);\">Recognize Others Token Add</td><td style=\"border-bottom:solid hsl(0, 0%, 90%);border-left:solid hsl(0, 0%, 90%);border-right:solid hsl(0, 0%, 90%);border-top:solid hsl(0, 0%, 90%);\">{{RO_add}}</td></tr><tr><td style=\"border-bottom:solid hsl(0, 0%, 90%);border-left:solid hsl(0, 0%, 90%);border-right:solid hsl(0, 0%, 90%);border-top:solid hsl(0, 0%, 90%);\">My Rewards Token Deduct</td><td style=\"border-bottom:solid hsl(0, 0%, 90%);border-left:solid hsl(0, 0%, 90%);border-right:solid hsl(0, 0%, 90%);border-top:solid hsl(0, 0%, 90%);\">{{MR_deduct}}</td></tr><tr><td style=\"border-bottom:solid hsl(0, 0%, 90%);border-left:solid hsl(0, 0%, 90%);border-right:solid hsl(0, 0%, 90%);border-top:solid hsl(0, 0%, 90%);\">My Rewards Token Add</td><td style=\"border-bottom:solid hsl(0, 0%, 90%);border-left:solid hsl(0, 0%, 90%);border-right:solid hsl(0, 0%, 90%);border-top:solid hsl(0, 0%, 90%);\">{{MR_add}}</td></tr></tbody></table></figure><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>' where id=9 ");

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

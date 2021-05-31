<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEdmBodySubjectforreserved extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('edm_template_body', function ($table) { 

            DB::statement("UPDATE edm_template_body SET subject = 'A little appreciation goes a long way! Your encouragement is sure to make someone’s day.' WHERE id=1; ");

            DB::statement("UPDATE edm_template_body SET subject = 'Excellent work! :name has awarded you with a new badge!' WHERE id=2; ");  

            DB::statement("UPDATE edm_template_body SET subject = 'A little appreciation goes a long way! Your encouragement is sure to make someone’s day.' WHERE id=3; ");

            DB::statement("UPDATE edm_template_body SET subject = 'Excellent work! :name has awarded you with a new badge!' WHERE id=4; ");              

            DB::statement("UPDATE edm_template_body SET subject = 'Introducing ACE! A platform specially designed for us to appreciate each other better!' WHERE id=5; ");    // Welcome        

            DB::statement("UPDATE edm_template_body SET subject = 'Your ACE portal activity summary for the month of :month is ready for viewing!' WHERE id=6; ");    // Monthly

            DB::statement("UPDATE edm_template_body SET subject = 'Your redemption item(s) is/are ready for collection!' WHERE id=7; ");    // Redemption

            DB::statement("UPDATE edm_template_body SET subject = 'Excellent work! :name you have been promoted to a new Tier' WHERE id=8; ");    // Tier Promotion

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

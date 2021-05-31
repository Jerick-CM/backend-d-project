<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEdmFooter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('edm_footer', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->mediumText('content');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('edm_footer', function ($table) { 
            DB::statement("
               INSERT INTO `edm_footer` VALUES (1, 'footer', '<p>Deloitte refers to one or more of Deloitte Touche Tohmatsu Limited (“DTTL”), its global network of member firms, and their related entities. DTTL (also referred to as “Deloitte Global”) and each of its member firms and their affiliated entities are legally separate and independent entities. DTTL does not provide services to clients. Please see&nbsp;<a href=\"http://www.deloitte.com/about\"><span style=\"color:windowtext;\">www.deloitte.com/about</span></a> to learn more.</p><p><span style=\"color:black;\">This communication is for internal distribution and use only among personnel of Deloitte Touche Tohmatsu Limited, its member firms, and their related entities (collectively, the “Deloitte network”). None of the Deloitte network shall be responsible for any loss whatsoever sustained by any person who relies on this communication.</span></p><p><span style=\"color:gray;\">© 2020 Deloitte &amp; Touche LLP</span><a href=\"#_msocom_1\"><span style=\"color:black;\">[TJYZ1]</span></a><span style=\"color:black;\">&nbsp;</span></p>', '2020-07-09 21:15:33', '2020-09-27 17:00:55', NULL);
            ");

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::dropIfExists('edm_footer');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEdmFooterRemovebackground extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
             Schema::table('edm_footer', function ($table) { 

           DB::statement("Truncate edm_footer;");
        });  

        Schema::table('edm_footer', function ($table) { 

            DB::statement("INSERT INTO `edm_footer` (`id`, `label`, `content`, `footerlabel1`, `footerlabel2`, `footerlabel3`, `footerlabel4`, `footerlabel5`, `footerlabel6`, `footerlabel7`, `created_at`, `updated_at`, `deleted_at`) VALUES
                (1, 'footer', '<p><span style=\"color:rgb(128,128,128);\">Please do not reply to this email. For any questions, please submit your enquiry or refer to the FAQ {{here}}.</span><br><br><span style=\"color:rgb(128,128,128);\">Deloitte refers to one or more of Deloitte Touche Tohmatsu Limited (“DTTL”), its global network of member firms, and their related entities. DTTL (also referred to as “Deloitte Global”) and each of its member firms and their affiliated entities are legally separate and independent entities. DTTL does not provide services to clients. Please see&nbsp;</span> {{<a href=\"http://www.deloitte.com/about\"><span style=\"color:windowtext;\">www.deloitte.com/about</span></a><span style=\"color:windowtext;\">}}</span>&nbsp; <span style=\"color:rgb(128,128,128);\">to learn more.</span></p><p><span style=\"color:rgb(128,128,128);\">This communication is for internal distribution and use only among personnel of Deloitte Touche Tohmatsu Limited, its member firms, and their related entities (collectively, the “Deloitte network”). None of the Deloitte network shall be responsible for any loss whatsoever sustained by any person who relies on this communication.</span></p><p><span style=\"color:gray;\">© 2020 Deloitte &amp; Touche LLP</span></p>', 'Please do not reply to this email. For any questions, please submit your enquiry or refer to the FAQ', 'here', 'Deloitte refers to one or more of Deloitte Touche Tohmatsu Limited (“DTTL”), its global network of member firms, and their related entities. DTTL (also referred to as “Deloitte Global”) and each of its member firms and their affiliated entities are legally separate and independent entities. DTTL does not provide services to clients. Please see', 'www.deloitte.com/about', 'to learn more.', 'This communication is for internal distribution and use only among personnel of Deloitte Touche Tohmatsu Limited, its member firms, and their related entities (collectively, the “Deloitte network”). None of the Deloitte network shall be responsible for any loss whatsoever sustained by any person who relies on this communication.', '2020 Deloitte & Touche LLP', '2020-07-08 13:15:33', '2020-10-09 07:00:45', NULL);

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
        //
    }
}

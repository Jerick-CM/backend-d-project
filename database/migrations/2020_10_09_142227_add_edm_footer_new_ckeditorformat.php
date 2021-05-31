<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEdmFooterNewCkeditorformat extends Migration
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
                (1, 'footer', '<p>Please do not reply to this email. For any questions, please submit your enquiry or refer to the FAQ &nbsp;{{here}}.</p><p>Deloitte refers to one or more of Deloitte Touche Tohmatsu Limited (“DTTL”), its global network of member firms, and their related entities. DTTL (also referred to as “Deloitte Global”) and each of its member firms and their affiliated entities are legally separate and independent entities. DTTL does not provide services to clients. Please see&nbsp;{{<a href=\"http://www.deloitte.com/about\"><span style=\"color:windowtext;\">www.deloitte.com/about</span></a><span style=\"color:windowtext;\">}}</span> to learn more.</p><p><span style=\"color:black;\">This communication is for internal distribution and use only among personnel of Deloitte Touche Tohmatsu Limited, its member firms, and their related entities (collectively, the “Deloitte network”). None of the Deloitte network shall be responsible for any loss whatsoever sustained by any person who relies on this communication.</span></p><p><span style=\"color:gray;\">© 2020 Deloitte &amp; Touche LLP</span></p>', 'Please do not reply to this email. For any questions, please submit your enquiry or refer to the FAQ', 'here', 'Deloitte refers to one or more of Deloitte Touche Tohmatsu Limited (“DTTL”), its global network of member firms, and their related entities. DTTL (also referred to as “Deloitte Global”) and each of its member firms and their affiliated entities are legally separate and independent entities. DTTL does not provide services to clients. Please see', 'www.deloitte.com/about', 'to learn more.', 'This communication is for internal distribution and use only among personnel of Deloitte Touche Tohmatsu Limited, its member firms, and their related entities (collectively, the “Deloitte network”). None of the Deloitte network shall be responsible for any loss whatsoever sustained by any person who relies on this communication.', '2020 Deloitte & Touche LLP', '2020-07-09 05:15:33', '2020-10-09 06:12:38', NULL);
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

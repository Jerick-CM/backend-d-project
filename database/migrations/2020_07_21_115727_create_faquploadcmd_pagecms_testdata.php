<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaquploadcmdPagecmsTestdata extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::table('pages', function ($table) {
            DB::statement("Truncate pages");
        });
        
        Schema::table('pages', function ($table) {
            DB::statement("INSERT INTO `pages` VALUES (1, 'test', 'test', '<p>test</p>', 1, '2020-07-21 11:55:18', '2020-07-21 11:55:18');");
        });

        Schema::table('faq_files', function ($table) {
            DB::statement("Truncate faq_files;");
        });

        Schema::table('faq_files', function ($table) {
            DB::statement("INSERT INTO `faq_files` VALUES (1, 'ace-faq_1595303698.pdf', '2020-07-21 11:54:58', '2020-07-21 11:54:58');");
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

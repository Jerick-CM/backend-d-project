<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFaqCategoriesPriorityStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('faq_categories', function ($table) {
            DB::statement("ALTER TABLE `faq_categories` ADD `priority` TINYINT(1) NULL AFTER `value`;");
        });
         Schema::table('faq_categories', function ($table) {
            DB::statement("Update faq_categories set priority=id;");
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

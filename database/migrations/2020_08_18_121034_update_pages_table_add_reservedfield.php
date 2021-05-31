<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePagesTableAddReservedfield extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function ($table) {

            DB::statement("ALTER TABLE `pages` ADD `reserved` TINYINT NOT NULL DEFAULT '0' AFTER `pageurl`;");
            DB::statement("update pages set reserved = 1 where id=1;");
            DB::statement("update pages set reserved = 1 where id=2;");
            DB::statement("update pages set reserved = 1 where id=3;");
            DB::statement("update pages set reserved = 1 where id=4;");
            DB::statement("update pages set reserved = 1 where id=5;"); 

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

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBlackandgreenTokenlogRemarksToMediumtext extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    
         Schema::table('green_token_logs', function ($table) {
            DB::statement("ALTER TABLE `green_token_logs` CHANGE `remarks` `remarks` MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;");
        });

        Schema::table('black_token_logs', function ($table) {
            DB::statement("ALTER TABLE `black_token_logs` CHANGE `remarks` `remarks` MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;");
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

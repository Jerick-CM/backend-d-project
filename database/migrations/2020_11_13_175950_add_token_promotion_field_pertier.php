<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTokenPromotionFieldPertier extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('users', function ($table) { 

            DB::statement("ALTER TABLE `users` ADD `rising_shining_star_token` INT(2) NULL DEFAULT NULL AFTER `remember_token`, ADD `shining_shooting_star_token` INT(2) NULL DEFAULT NULL AFTER `rising_shining_star_token`, ADD `shooting_super_star_token` INT(2) NULL DEFAULT NULL AFTER `shining_shooting_star_token`, ADD `super_mega_star_token` INT(2) NULL DEFAULT NULL AFTER `shooting_super_star_token`;");
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
 
          $table->dropColumn('rising_shining_star_token');
          $table->dropColumn('shining_shooting_star_token');
          $table->dropColumn('shooting_super_star_token');
          $table->dropColumn('super_mega_star_token');

       });
    }
}

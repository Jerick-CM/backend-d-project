<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableTierAndUserfieldTierId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('tier', function ($table) {    

            DB::statement("DROP TABLE IF EXISTS `tier`;");

        });

        Schema::create('tier', function (Blueprint $table) {     

            $table->increments('id');
            $table->string('description');
            $table->string('mintoken')->length(3);
            $table->string('maxtoken')->length(3);                     
            $table->timestamps();
            $table->softDeletes();

        });

        Schema::table('tier', function ($table) { 

            DB::statement("INSERT INTO `tier` (`id`, `description`, `mintoken`, `maxtoken`, `updated_at`, `created_at`) VALUES
                    (1, 'Rising Star', 1, 60, '2020-09-13 20:51:29', '2020-09-13 20:51:29'),
                    (2, 'Shining Star', 61, 240, '2020-09-13 20:51:29', '2020-09-13 20:51:29'),
                    (3, 'Shooting Star', 241, 480, '2020-09-13 20:51:29', '2020-09-13 20:51:29'),
                    (4, 'Super Star', 481, 800, '2020-09-13 20:51:29', '2020-09-13 20:51:29'),
                    (5, 'Megastar', 801, NULL, '2020-09-13 20:51:29', '2020-09-13 20:51:29');");

        });

        Schema::table('users', function ($table) { 

            DB::statement("ALTER TABLE `users` ADD `tier_id` INT(2) NULL AFTER `is_active`;");

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tier');

        Schema::table('users', function (Blueprint $table) {
           $table->dropColumn('tier_id');
        });


    }
}

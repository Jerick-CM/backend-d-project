<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMyrewards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('myrewards', function ($table) {    

            DB::statement("DROP TABLE IF EXISTS `myrewards`;");

        });

        Schema::create('myrewards', function (Blueprint $table) {     

            $table->increments('id');
            $table->string('description');
            $table->string('rewardstoken')->length(20);                        
            $table->timestamps();
            $table->softDeletes();

        });


        Schema::table('myrewards', function ($table) { 

            DB::statement("
                INSERT INTO `myrewards` (`id`, `description`, `rewardstoken`,`updated_at`, `created_at`) VALUES
                (1, 'Rising Star to Shining Star', 10,'2020-09-13 20:51:29','2020-09-13 20:51:29'),
                (2, 'Shining Star to Shooting Star', 20,'2020-09-13 20:51:29','2020-09-13 20:51:29'),
                (3, 'Shooting Star to Superstar', 30,'2020-09-13 20:51:29','2020-09-13 20:51:29'),
                (4, 'Superstar to Megastar', 40,'2020-09-13 20:51:29','2020-09-13 20:51:29');

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
        Schema::dropIfExists('myrewards');

    }
}

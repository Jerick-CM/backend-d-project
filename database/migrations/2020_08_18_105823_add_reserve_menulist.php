<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReserveMenulist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function ($table) {
            DB::statement("TRUNCATE pages");
        });


        Schema::table('pages', function ($table) {

            DB::statement("INSERT INTO `pages` VALUES (1, 'Home', 'Home', '<p>reserved</p>', '/img/icons/home-ico.svg', '/', 1, 1, '2020-08-17 22:24:32', '2020-08-17 22:24:32');");

            DB::statement("INSERT INTO `pages` VALUES (2, 'Profile', 'Profile', '<p>reserved</p>', '/img/icons/person-ico.svg', '/profile', 2, 1, '2020-08-17 22:26:15', '2020-08-17 22:26:51');");

            DB::statement("INSERT INTO `pages` VALUES (3, 'Redeem', 'Redeem', '<p>Reserved</p>', '/img/icons/gift-ico.svg', '/redeem', 3, 1, '2020-08-17 22:28:58', '2020-08-17 22:28:58');");

            DB::statement("INSERT INTO `pages` VALUES (4, 'FAQ', 'FAQ', '<p>Reserved</p>', '/img/icons/faq-ico.svg', '/faq', 4, 1, '2020-08-17 22:29:36', '2020-08-17 22:29:36');");

            DB::statement("INSERT INTO `pages` VALUES (5, 'ContactUs', 'ContactUs', '<p>Reserved</p>', 'phone', '/faq#contact-us', 5, 1, '2020-08-17 22:31:11', '2020-08-17 22:31:11');");

            DB::statement("INSERT INTO `pages` VALUES (6, 'test', 'test', '<p>test cms page </p>', 'storage', 'test1597721658', 6, 1, '2020-08-18 11:34:18', '2020-08-18 11:34:18');");

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

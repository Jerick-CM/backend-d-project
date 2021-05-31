<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePageTableReservedurl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
          Schema::table('pages', function ($table) {

                DB::statement("Truncate pages;");
          });

        Schema::table('pages', function ($table) {

              DB::statement("INSERT INTO `pages` (`id`, `name`, `title`, `content`, `icon`, `pageurl`, `reserved`, `priority`, `publish`, `created_at`, `updated_at`) VALUES
(1, 'Home', 'Home', '<p>reserved</p>', '/img/icons/home-ico.svg', '', 1, 1, 1, '2020-08-17 06:24:32', '2020-08-17 06:24:32'),
(2, 'Profile', 'Profile', '<p>reserved</p>', '/img/icons/person-ico.svg', 'profile', 1, 2, 1, '2020-08-17 06:26:15', '2020-08-17 06:26:51'),
(3, 'Redeem', 'Redeem', '<p>Reserved</p>', '/img/icons/gift-ico.svg', 'redeem', 1, 3, 1, '2020-08-17 06:28:58', '2020-08-17 06:28:58'),
(4, 'FAQ', 'FAQ', '<p>Reserved</p>', '/img/icons/faq-ico.svg', 'faq', 1, 4, 1, '2020-08-17 06:29:36', '2020-08-17 06:29:36'),
(5, 'ContactUs', 'ContactUs', '<p>Reserved</p>', 'phone', 'faq#contact-us', 1, 5, 1, '2020-08-17 06:31:11', '2020-08-17 06:31:11'),
(6, 'test baby again', 'test', '<p>test cms page </p>', 'storage', 'test-baby-again-1597932158', 0, 6, 0, '2020-08-17 19:34:18', '2020-08-20 06:02:38');");

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

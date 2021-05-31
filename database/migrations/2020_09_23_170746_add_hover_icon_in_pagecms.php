<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHoverIconInPagecms extends Migration
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
           
            DB::statement("ALTER TABLE `pages` ADD `icon_hover` VARCHAR(512) NULL DEFAULT NULL AFTER `icon`;");

        });

        Schema::table('pages', function ($table) {
        
            DB::statement("ALTER TABLE `pages` CHANGE `icon` `icon` VARCHAR(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;");
     
        });

        Schema::table('pages', function ($table) {

              DB::statement("INSERT INTO `pages` (`id`, `name`, `title`, `content`, `icon`, `icon_hover`, `is_upload`, `pageurl`, `reserved`, `priority`, `publish`, `created_at`, `updated_at`) VALUES
                (1, 'Home', 'Home', '<p>reserved</p>', 'img/menu/home-ico.svg', 'img/menu/home-ico-alt.svg', 0, '', 1, 1, 1, '2020-08-16 22:24:32', '2020-08-16 22:24:32'),
                (2, 'Profile', 'Profile', '<p>reserved</p>', 'img/menu/person-ico.svg', 'img/menu/person-ico-alt.svg', 0, 'profile', 1, 2, 1, '2020-08-16 22:26:15', '2020-08-16 22:26:51'),
                (3, 'Redeem', 'Redeem', '<p>Reserved</p>', 'img/menu/gift-ico.svg', 'img/menu/gift-ico-alt.svg', 0, 'redeem', 1, 3, 1, '2020-08-16 22:28:58', '2020-08-16 22:28:58'),
                (4, 'FAQ', 'FAQ', '<p>Reserved</p>', 'img/menu/faq-ico.svg', 'img/menu/faq-ico-alt.svg', 0, 'faq', 1, 4, 1, '2020-08-16 22:29:36', '2020-08-16 22:29:36'),
                (5, 'Contact Us', 'Contact Us', '<p>Reserved</p>', 'img/menu/call-black-24dp.svg', 'img/menu/local_phone-black-24dp.svg', 0, 'faq#contact-us', 1, 5, 1, '2020-08-16 22:31:11', '2020-08-16 22:31:11');
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
         Schema::dropIfExists('pages');        
    }
}

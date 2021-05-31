<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEdmHeaderImagedataaddDefaultstoredimageadata extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('edm_header', function ($table) { 

            DB::statement("Truncate edm_header;");

         });        

         Schema::table('edm_header', function ($table) { 

            DB::statement("INSERT INTO `edm_header` (`id`, `label`, `content`, `title`, `label1`, `label2`, `label3`, `image1`, `label4`, `image2`, `image3`, `image4`, `image5`, `image6`, `image7`, `image8`, `image9`, `preheadertext1`, `preheadertext2`, `preheadertext3`, `preheadertext4`, `preheadertext5`, `preheadertext6`, `preheadertext7`, `created_at`, `updated_at`, `deleted_at`) VALUES
                (1, 'header', '<figure class=\"table\" style=\"width:1000px;\"><table><tbody><tr><td style=\"background-color:hsl(0, 0%, 0%);\"><figure class=\"image image-style-align-left\"><img src=\"http://deloitte-backend.local.nmgdev.com/storage/edmheader/logo_1601606860.png\"></figure></td></tr><tr><td style=\"background-color:hsl(0, 0%, 0%);\"><figure class=\"image\"><img src=\"http://deloitte-backend.local.nmgdev.com/storage/edmheader/ace-logo_1601606930.jpg\"></figure></td></tr><tr><td style=\"background-color:hsl(0, 0%, 100%);\"><span style=\"color:#7F7F7F;\">Singapore&nbsp; | {{date}}</span></td></tr><tr><td style=\"background-color:hsl(0, 0%, 0%);\"><h2><span style=\"color:#92D050;\">A</span><span style=\"color:hsl(0,0%,100%);\">ppreciate</span><span style=\"color:#92D050;\">.</span> <span style=\"color:#92D050;\">C</span><span style=\"color:hsl(0,0%,100%);\">elebrate</span><span style=\"color:#92D050;\">.</span> <span style=\"color:#92D050;\">E</span><span style=\"color:hsl(0,0%,100%);\">levate</span><span style=\"color:#92D050;\">.</span></h2><p><span class=\"text-big\" style=\"color:hsl(0,0%,100%);\">Thank you for being awesome!</span></p></td></tr></tbody></table></figure>', 'Deloitte Rewards App Responsive Email Template', 'Having trouble viewing this e-mail?', 'Click here', 'Singapore | {{date}}', 'public/img/edm/main-banner.jpg', NULL, 'public/img/edm/top-banner.jpg', 'welcome-banner-1.jpg', 'public/img/edm/welcome-banner-2.jpg', 'public/img/edm/welcome-banner-3-v2.jpg', 'public/img/edm/welcome-banner-4-v2.jpg', 'public/img/edm/welcome-banner-5-v2.jpg', 'public/img/edm/welcome-banner-6.jpg', 'public/img/edm/welcome-banner-7.jpg', 'In recognition of { NAME }\'s excellent work, you’ve sent a badge! Here\'s what you said.', 'All your great work hasn\'t gone unnoticed! Check out what { NAME } has to say about you!', 'In recognition of { NAME }\'s excellent work, you’ve sent a badge! Here\'s what you said.', 'All your great work hasn\'t gone unnoticed! Check out what { NAME } has to say about you!', 'Let\'s appreciate our colleagues on their excellent work consistently and celebrate the people who have gone the extra mile to help us!', 'Personal growth achievement, new badges, and ACE portal reminders! Review your ACE portal activity now!', 'Thank you for shopping at ACE – your redemption item(s) is/are ready for collection on { DATE-BRITISH FORMAT }!', '2020-07-08 13:15:33', '2020-10-06 13:07:17', NULL);
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
        //
    }
}

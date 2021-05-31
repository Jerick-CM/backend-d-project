<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEdmTemplatebodyDefaultValuesAndWallappreciation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('edm_template_body', function ($table) { 

           DB::statement("Truncate edm_template_body;");

        });  



        if (Schema::hasColumn('edm_template_body', 'header1'))
        {
            Schema::table('edm_template_body', function (Blueprint $table)
            {
                $table->dropColumn('header1');
            });
        }

        if (Schema::hasColumn('edm_template_body', 'header2'))
        {
            Schema::table('edm_template_body', function (Blueprint $table)
            {
                $table->dropColumn('header2');
            });
        }

        if (Schema::hasColumn('edm_template_body', 'header3'))
        {
            Schema::table('edm_template_body', function (Blueprint $table)
            {
                $table->dropColumn('header3');
            });
        }

        if (Schema::hasColumn('edm_template_body', 'header4'))
        {
            Schema::table('edm_template_body', function (Blueprint $table)
            {
                $table->dropColumn('header4');
            });
        }

        if (Schema::hasColumn('edm_template_body', 'header5'))
        {
            Schema::table('edm_template_body', function (Blueprint $table)
            {
                $table->dropColumn('header5');
            });
        }


        Schema::table('edm_template_body', function ($table) { 

            DB::statement("ALTER TABLE `edm_template_body` ADD `header1` MEDIUMTEXT NOT NULL AFTER `content`, ADD `header2` MEDIUMTEXT NOT NULL AFTER `header1`, ADD `header3` MEDIUMTEXT NOT NULL AFTER `header2`, ADD `header4` MEDIUMTEXT NOT NULL AFTER `header3`, ADD `header5` MEDIUMTEXT NOT NULL AFTER `header4`;");
            
        }); 


        Schema::table('edm_template_body', function ($table) { 

           DB::statement("INSERT INTO `edm_template_body` (`id`, `label`, `content`, `header1`, `header2`, `header3`, `header4`, `header5`, `title`, `subject`, `placeholder1`, `placeholder2`, `placeholder3`, `placeholder4`, `placeholder5`, `placeholder6`, `placeholder7`, `placeholder8`, `placeholder9`, `placeholder10`, `placeholder11`, `placeholder12`, `placeholder13`, `placeholder14`, `placeholder15`, `placeholder16`, `placeholder17`, `placeholder18`, `placeholder19`, `placeholder20`, `placeholder21`, `placeholder22`, `placeholder23`, `placeholder24`, `placeholder25`, `placeholder26`, `placeholder27`, `created_at`, `updated_at`, `deleted_at`) VALUES
                (1, 'Message Send', '<figure class=\"table\" style=\"width:600px;\"><table><tbody><tr><td><p>Dear {{name}} , &nbsp;</p><p>You have sent your appreciation to {{recipientName}} for being a great help at work and have awarded {{recipientName}} with {{linkingVerb}} {{badgeType}} badge with the following message:</p><p>{{messageContent}}</p><p>Thank you for recognising the hard work and effort put in by our people who have gone the extra mile!</p></td></tr></tbody></table></figure>', '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/top-banner.jpg\"></figure>', '<p><span style=\"background-color:rgb(255,255,255);color:rgb(128,128,128);\">Singapore | {{date}}</span></p>', '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/main-banner.jpg\"></figure>', '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/welcome-banner-6.jpg\"></figure>', '', 'null', 'null', 'Dear {{name}},', 'You have sent your appreciation to {{recipientName}} for being a great help at work and have awarded {{recipientName}} with {{linkingVerb}} {{badgeType}} badge with the following message:', 'Thank you for recognising the hard work and effort put in by our people who have gone the extra mile!', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2020-07-06 05:15:33', '2020-10-19 09:46:43', NULL),
                (2, 'Message Received', '<figure class=\"table\" style=\"width:600px;\"><table><tbody><tr><td><p>Dear {{name}} ,</p><p>{{senderName}} recognises the great help you have been at work and has sent you a message and awarded you with {{linkingVerb}} {{badgeType}} &nbsp;badge with the following message:</p><p>{{messageContent}}&nbsp;</p><p>Log on to {{ACE}} and check out the {{ACE e-Store}} to redeem the item of your choice today!</p><p><strong>Appreciate others</strong></p><p>Have a colleague in mind whom you would like to thank?</p><p>Show your appreciation today by sending them a message or rewarding them with your <strong>“Recognise Others”</strong> tokens! It’s a really simple way to say thank you.</p></td></tr></tbody></table></figure>', '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/top-banner.jpg\"></figure>', '<p><span style=\"background-color:rgb(255,255,255);color:rgb(128,128,128);\">Singapore | {{date}}</span></p>', '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/main-banner.jpg\"></figure>', '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/welcome-banner-4-v2.jpg\"></figure>', '', NULL, NULL, 'Dear {{name}},', '{{senderName}} recognises the great help you have been at work and has sent you a message and awarded you with {{linkingVerb}} {{badgeType}} badge with the following message:', 'Log on to {{ACE}} and check out the {{ACE e-Store}} to redeem the item of your choice today!', 'Appreciate others', 'Appreciate others', 'Show your appreciation today by sending them a message or rewarding them with your', '“Recognise Others”', 'tokens! It’s a really simple way to say thank you.', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2020-07-06 05:15:33', '2020-10-05 08:58:11', NULL),
                (3, 'Message Send with Token', '<figure class=\"table\" style=\"width:600px;\"><table><tbody><tr><td><p>Dear {{name}},</p><p>You have sent your appreciation to {{recipientName}} for being a great help at work and have awarded {{recipientName}} with {{linkingVerb}} {{badgeType}} badge with the following message:</p><p>{{messageContent}}</p><p>In addition, you have awarded {{recipientName}} with {{token}} <strong>\"Recognise Others\"</strong> tokens.</p><p>Thank you for recognising the hard work and effort put in by our people who have gone the extra mile!</p></td></tr></tbody></table></figure>', '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/top-banner.jpg\"></figure>', '<p><span style=\"background-color:rgb(255,255,255);color:rgb(128,128,128);\">Singapore | {{date}}</span></p>', '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/main-banner.jpg\"></figure>', '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/welcome-banner-7.jpg\"></figure>', '', NULL, NULL, 'Dear {{name}},', 'You have sent your appreciation to {{recipientName}} for being a great help at work and have awarded {{recipientName}} with {{linkingVerb}} {{badgeType}} badge with the following message:', 'In addition, you have awarded {{recipientName}} with {{token}}', '\"Recognise Others\"', 'tokens', 'Thank you for recognising the hard work and effort put in by our people who have gone the extra mile!', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2020-07-06 05:15:33', '2020-10-05 09:29:16', NULL),
                (4, 'Message Received with Token', '<figure class=\"table\" style=\"width:600px;\"><table><tbody><tr><td><p>Dear {{name}},</p><p>&nbsp;</p><p>{{senderName}} recognises the great help you have been at work and has sent you a message and awarded you with {{linkingVerb}} {{badgeType}} badge with the following message:</p><p>&nbsp;</p><p>{{messageContent}}</p><p>&nbsp;</p><p>In addition, you have also received {{token}} \"<strong>My Rewards</strong>\" tokens from {{senderName}}.</p><p>&nbsp;</p><p>Log on to {{ACE}} and check out the {{ACE e-Store}} to redeem the item of your choice today!</p><p>&nbsp;</p><p><strong>Appreciate others</strong></p><p>&nbsp;</p><p>Have a colleague in mind whom you would like to thank?</p><p>&nbsp;</p><p>&nbsp;Show your appreciation today by sending them a message or rewarding them with your “<strong>Recognise Others</strong>” tokens! It’s a really simple way to say thank you.</p></td></tr></tbody></table></figure>', '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/top-banner.jpg\"></figure>', '<p><span style=\"background-color:rgb(255,255,255);color:rgb(128,128,128);\">Singapore | {{date}}</span></p>', '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/main-banner.jpg\"></figure>', '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/welcome-banner-5-v2.jpg\"></figure>', '', NULL, NULL, 'Dear {{name}},', '{{senderName}} recognises the great help you have been at work and has sent you a message and awarded you with {{linkingVerb}} {{badgeType}} badge with the following message:', 'In addition, you have also received {{token}}', '\"My Rewards\"', 'tokens from {{senderName}}.', 'Log on to {{ACE}} and check out the {{ACE e-Store}} to redeem the item of your choice today!', 'Appreciate others', 'Have a colleague in mind whom you would like to thank?', 'Show your appreciation today by sending them a message or rewarding them with your', '“Recognise Others”', 'tokens! It’s a really simple way to say thank you.', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2020-07-06 05:15:33', '2020-10-05 09:23:54', NULL),
                (5, 'Welcome Mail', '<figure class=\"table\" style=\"width:600px;\"><table><tbody><tr><td><p>Welcome to Deloitte!</p><p>We are delighted to share with you more information about ACE (Appreciate. Celebrate. Elevate.) – our online platform designed especially for us to appreciate our colleagues for their good work and to celebrate the people who have gone the extra mile to help us.</p><p>&nbsp;</p><p>On ACE, you can write personalised thank-you messages to colleagues across levels and businesses, and award them achievement badges and tokens. Your colleagues can also do the same for you.</p><p>&nbsp;</p><p>&nbsp;These tokens can be used to redeem special treats and gifts at the {{ACE e-Store}}.</p><p>&nbsp;</p><p>&nbsp;As a welcome gift, you will receive {{numberOfToken}} <strong>“My Rewards”</strong> tokens in your account. Live our Deloitte values and start accumulating “My Rewards” tokens to redeem the item of your choice today!</p><p>&nbsp;</p><p>You will find that you also have {{numberOfBlackToken}} <strong>“Recognise Others”</strong> tokens in your account that you can give out in appreciation of your colleagues.</p><p>&nbsp;</p><p>To find out how you can navigate ACE, please refer to the FAQ {{here}}</p><p>&nbsp;</p><p>Click {{aceLinkhere}}to access ACE now!</p><p>&nbsp;</p></td></tr></tbody></table></figure>', '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/top-banner.jpg\"></figure>', '<p><span style=\"background-color:rgb(255,255,255);color:rgb(128,128,128);\">Singapore | {{date}}</span></p>', '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/main-banner.jpg\"></figure>', '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/welcome-banner-3-v2.jpg\"></figure>', '', NULL, NULL, 'Welcome to Deloitte!', 'We are delighted to share with you more information about ACE (Appreciate. Celebrate. Elevate.) – our online platform designed especially for us to appreciate our colleagues for their good work and to celebrate the people who have gone the extra mile to help us.', 'On ACE, you can write personalised thank-you messages to colleagues across levels and businesses, and award them achievement badges and tokens. Your colleagues can also do the same for you.', 'These tokens can be used to redeem special treats and gifts at the {{ACE e-Store}}.', 'As a welcome gift, you will receive {{numberOfToken}} “My Rewards” tokens in your account. Live our Deloitte values and start accumulating “My Rewards” tokens to redeem the item of your choice today!', 'You will find that you also have {{numberOfBlackToken}} “Recognise Others” tokens in your account that you can give out in appreciation of your colleagues.', 'To find out how you can navigate ACE, please refer to the FAQ {{herefaq}}.', 'Click {{here}} to access ACE now!', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2020-07-06 05:15:33', '2020-10-06 06:03:16', NULL),
                (6, 'Monthly Summary Mail', '<figure class=\"table\" style=\"width:600px;\"><table><tbody><tr><td><p>Hi {{name}},</p><p>This is the latest summary of your ACE account.</p><p><strong>Personal growth achievements</strong></p><p>{{tierstatus}}</p><p>Continue to keep up the good work as you are just {{pointsToNextTier}} points away from becoming a {{nextTier}}!</p><p>{{Received<i>badgesthismonthANDSharedbadgesthis</i>month_table}}</p><p><strong>Balance tokens:</strong></p><p>{{Recognise<i>others</i>tokensANDMyrewardstokens_table}}</p><p>&nbsp;</p><p><strong>Your \"Recognise Others\" tokens</strong></p><p>For the month of {{month}}, You gave out a total of {{recognizeOthersTokenUsed}} \"Recognise Others\" tokens.</p><p>You have {{recognizeOthersToken}} \"Recognise Others\" tokens remaining, which will expire on {{recognizeOthersTokenExpiration}}.</p><p>Remember, you can use ACE to show your appreciation to your colleagues. A small gesture goes a long way!</p><p>&nbsp;</p><p><strong>Your \"My Rewards\" tokens</strong></p><p>For the month of {{month }}, you received {{myRewardsToken}} “My Rewards” tokens from your colleagues and you redeemed a total of {{myRewardsTokenUsed}} tokens from the ACE Redemption Store.</p><p>You have a total of {{myRewardsToken}} \"My Rewards\" tokens.</p><p>{{tokenexpirationprompt}}</p><p>&nbsp;</p><p>Be sure to exchange these tokens for exciting gifts available on the {{ACE e-Store}}</p><p>&nbsp;</p><p>To view a full summary of your ACE account, click {{here_viewhistorylink}}.</p><p>&nbsp;</p><p>Click {{here_acelink}} to access ACE now!</p></td></tr></tbody></table></figure>', '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/top-banner.jpg\"></figure>', '<p><span style=\"background-color:rgb(255,255,255);color:rgb(128,128,128);\">Singapore | {{date}}</span></p>', '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/main-banner.jpg\"></figure>', '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/welcome-banner-1.jpg\"></figure>', '', NULL, NULL, 'Hi {{name}},', 'This is the latest summary of your ACE account.', 'Personal growth achievements', 'You are currently a {{currentTier}}!', 'Continue to keep up the good work as you are just {{pointsToNextTier}} points away from becoming a {{nextTier}}!', 'Received badges this month', 'World<em>Class</em> Citizen', 'Count:', 'Shared badges this month', 'Balance tokens', '\"Recognise Others\" tokens', '\"My Rewards\" tokens', 'Your \"Recognise Others\" tokens', 'For the month of {{month}}, You gave out a total of {{recognizeOthersTokenUsed}} \"Recognise Others\" tokens.', 'You have {{recognizeOthersToken}} \"Recognise Others\" tokens remaining, which will expire on {{recognizeOthersTokenExpiration}}.', 'Remember, you can use ACE to show your appreciation to your colleagues. A small gesture goes a long way!', 'Your \"My Rewards\" tokens', 'For the month of {{month}}, you received {{myRewardsToken}} “My Rewards” tokens from your colleagues and you redeemed a total of {{myRewardsTokenUsed}} tokens from the ACE Redemption Store.', 'You have a total of {{myRewardsToken}} \"My Rewards\" tokens.', '{{myRewardsTokenExpirationAmount}} tokens will expire on {{myRewardsTokenExpiration}}.', 'Be sure to exchange these tokens for exciting gifts available on the {{ACE e-Store}}!', 'To view a full summary of your ACE account, click {{herehistorylink}}.', 'Click {{here}} to access ACE now!', '', '', '', '', '2020-07-06 05:15:33', '2020-10-06 14:07:39', NULL),
                (7, 'Redemption Mail', '<figure class=\"table\" style=\"width:600px;\"><table><tbody><tr><td><p>Dear {{name}}</p><p>Thank you for shopping at ACE. Here are the details of your redemption and collection:</p><p><strong>Order Number:</strong> &nbsp;{{orderNumber}}</p><p><strong>Order Date:</strong> {{orderDate}}</p><p>{{table_loop}}</p><p><strong>\"My Rewards\"</strong> tokens balance: &nbsp;{{remainingToken}}</p><p>&nbsp;Please collect your items from us on:</p><p><strong>Collection date/time:</strong> &nbsp;{{collectionDate}}</p><p><strong>Collection location:</strong> D Lounge, Level 30</p><p>If you are unable to pick up your item/s at the above date and time, please ensure that you appoint a colleague to collect on your behalf. Your colleague must present this redemption email and a photo of your staff pass to redeem the item.</p><p>To view your redemption history to date, please click {{here}}.</p></td></tr></tbody></table></figure>', '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/top-banner.jpg\"></figure>', '<p><span style=\"background-color:rgb(255,255,255);color:rgb(128,128,128);\">Singapore | {{date}}</span></p>', '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/main-banner.jpg\"></figure>', '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/welcome-banner-3-v2.jpg\"></figure>', '', NULL, NULL, 'Dear {{name}},', 'Thank you for shopping at ACE. Here are the details of your redemption and collection:', 'Order Number:', 'Order Date:', 'Product:', 'Quantity:', 'Tokens used:', '\"My Rewards\"', 'tokens balance:  {{remainingToken}}', 'Please collect your items from us on:', 'Collection date/time:', 'Collection location:', 'D Lounge, Level 30', 'If you are unable to pick up your item/s at the above date and time, please ensure that you appoint a colleague to collect on your behalf. Your colleague must present this redemption email and a photo of your staff pass to redeem the item.', 'To view your redemption history to date, please click {{here}}.', '', '', '', '', '', '', '', '', '', '', '', '', '2020-07-06 05:15:33', '2020-10-06 06:05:09', NULL),
                (8, 'Tier Promotion Mail', '', '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/top-banner.jpg\"></figure>', '<p><span style=\"background-color:rgb(255,255,255);color:rgb(128,128,128);\">Singapore | {{date}}</span></p>', '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/main-banner.jpg\"></figure>', '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/welcome-banner-4-v2.jpg\"></figure>', '', NULL, NULL, 'Dear {{name}},', 'Badge Promotion level went up from {{oldbadge}} to {{newbadge}}  has been granted , {{rewardstoken}} rewards token has been  granted to your account.', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2020-07-06 05:15:33', '2020-10-08 05:18:08', NULL),
                (9, 'Wall Appreciation Mail', '', '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/top-banner.jpg\"></figure>', '<p><span style=\"background-color:rgb(255,255,255);color:rgb(128,128,128);\">Singapore | {{date}}</span></p>', '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/main-banner.jpg\"></figure>', '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/welcome-banner-default.jpg\"></figure>', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2020-10-12 05:39:33', '2020-10-12 09:50:40', NULL);
                ");

        });  

        //

        // Schema::table('edm_template_body', function ($table) { 

        //    DB::statement("ALTER TABLE `edm_template_body` CHANGE `header1` `header1` MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/top-banner.jpg\"></figure>';");

        // });  

        // Schema::table('edm_template_body', function ($table) {   

        //    DB::statement("ALTER TABLE `edm_template_body` CHANGE `header2` `header2` MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '<p> <span style=\"background-color:rgb(255,255,255);color:rgb(128,128,128);\">Singapore | {{date}}</span></p>';");

        // });  

        // Schema::table('edm_template_body', function ($table) {  
        //     DB::statement("ALTER TABLE `edm_template_body` CHANGE `header3` `header3` MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/main-banner.jpg\"></figure>';"); 
        // });

        // Schema::table('edm_template_body', function ($table) {     
        //     DB::statement("ALTER TABLE `edm_template_body` CHANGE `header4` `header4` MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '<figure class=\"image\"><img src=\"https://deloitte-backend.nmgdev.com/public/img/edm/welcome-banner-default.jpg\"></figure>';"); 
        // });

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

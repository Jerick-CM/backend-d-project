<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEdmtemplatebodyinitialdraftdata extends Migration
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
        
        Schema::table('edm_template_body', function ($table) { 

            DB::statement("INSERT INTO `edm_template_body` (`id`, `label`, `content`, `created_at`, `updated_at`, `deleted_at`) VALUES
                (1, 'Message Send', '<figure class=\"table\" style=\"width:600px;\"><table><tbody><tr><td><p>Dear {{name}} ,</p><p>You have sent your appreciation to {{recipientName}} for being a great help at work and have awarded {{recipientName}} with {{linkingVerb}} {!! {{badgeType}} !!} badge with the following message:</p><p>{!! {{messageContent}} !!}</p><p>Thank you for recognising the hard work and effort put in by our people who have gone the extra mile!</p></td></tr></tbody></table></figure>', '2020-07-09 05:15:33', '2020-10-03 08:08:30', NULL),
                (2, 'Message Recieved', '<figure class=\"table\" style=\"width:600px;\"><table><tbody><tr><td><p>Dear {{name}} ,</p><p>{{senderName}} recognises the great help you have been at work and has sent you a message and awarded you with {{linkingVerb}} {!! {{badgeType}} !!} badge with the following message:</p><p>{!! {{messageContent}} !!}</p><p>Log on to {{ACE}} and check out the {{ACE e-Store}} to redeem the item of your choice today!</p><p><strong>Appreciate others</strong></p><p>Have a colleague in mind whom you would like to thank?</p><p>Show your appreciation today by sending them a message or rewarding them with your <strong>“Recognise Others”</strong> tokens! It’s a really simple way to say thank you.</p></td></tr></tbody></table></figure>', '2020-07-09 05:15:33', '2020-10-03 08:08:16', NULL),
                (3, 'Message Send with Token', '<figure class=\"table\" style=\"width:600px;\"><table><tbody><tr><td><p>Dear {{ name }},</p><p>You have sent your appreciation to {{ recipientName}} for being a great help at work and have awarded {{recipientName}} with {{ linkingVerb }} {!! badgeType !!} badge with the following message:</p><p>{!! messageContent !!}</p><p>In addition, you have awarded {{recipientName}} with {{ token }} &lt;b&gt;\"Recognise Others\"&lt;/b&gt; tokens.</p><p>Thank you for recognising the hard work and effort put in by our people who have gone the extra mile!</p></td></tr></tbody></table></figure>', '2020-07-09 05:15:33', '2020-10-03 08:09:49', NULL),
                (4, 'Message Received with Token', '<figure class=\"table\" style=\"width:600px;\"><table><tbody><tr><td><p>Dear {{ name }},</p><p>&nbsp;</p><p>{{ senderName }} recognises the great help you have been at work and has sent you a message and awarded you with {{ linkingVerb }} {!! badgeType !!} badge with the following message:</p><p>&nbsp;</p><p>{!! messageContent !!}</p><p>&nbsp;</p><p>In addition, you have also received {{ token }} &lt;b&gt;\"My Rewards\"&lt;/b&gt; tokens from {{ senderName }}.</p><p>&nbsp;</p><p>Log on to &lt;a href=\"{{ config(\'ace.url\') }}\"&gt;ACE&lt;/a&gt; and check out the &lt;a href=\"{{ config(\'ace.url\') }}/redeem\"&gt;ACE e-Store&lt;/a&gt; to redeem the item of your choice today!</p><p>&nbsp;</p><p><strong>Appreciate others</strong></p><p>&nbsp;</p><p>Have a colleague in mind whom you would like to thank?</p><p>&nbsp;</p><p>&nbsp;Show your appreciation today by sending them a message or rewarding them with your &lt;b&gt;“Recognise Others”&lt;/b&gt; tokens! It’s a really simple way to say thank you.</p></td></tr></tbody></table></figure>', '2020-07-09 05:15:33', '2020-10-03 08:11:54', NULL),
                (5, 'Welcome', '<figure class=\"table\" style=\"width:600px;\"><table><tbody><tr><td><p>Welcome to Deloitte!</p><p>We are delighted to share with you more information about ACE (Appreciate. Celebrate. Elevate.) – our online platform designed especially for us to appreciate our colleagues for their good work and to celebrate the people who have gone the extra mile to help us.</p><p>&nbsp;</p><p>On ACE, you can write personalised thank-you messages to colleagues across levels and businesses, and award them achievement badges and tokens. Your colleagues can also do the same for you.</p><p>&nbsp;</p><p>&nbsp;These tokens can be used to redeem special treats and gifts at the &lt;a href=\"{{ config(\'ace.url\') }}/redeem\"&gt;ACE e-Store&lt;/a&gt;.</p><p>&nbsp;</p><p>&nbsp;As a welcome gift, you will receive {{ numberOfToken }} “My Rewards” tokens in your account. Live our Deloitte values and start accumulating “My Rewards” tokens to redeem the item of your choice today!</p><p>&nbsp;</p><p>&nbsp;You will find that you also have {{ numberOfBlackToken }} “Recognise Others” tokens in your account that you can give out in appreciation of your colleagues.</p><p>&nbsp;</p><p>&nbsp;To find out how you can navigate ACE, please refer to the FAQ &lt;a style=\"color:#86BC25;text-decoration:none;\" href=\"{{ config(\'ace.url\') }}/faq\"&gt;here&lt;/a&gt;.</p><p>&nbsp;</p><p>Click &lt;a style=\"color:#86BC25;text-decoration:none;\" href=\"{{aceLink}}\"&gt;here&lt;/a&gt; to access ACE now!</p><p>&nbsp;</p></td></tr></tbody></table></figure>', '2020-07-09 05:15:33', '2020-10-03 08:13:48', NULL),
                (6, 'Monthly Send Token', '<figure class=\"table\" style=\"width:600px;\"><table><tbody><tr><td><p>Hi {{ name }},</p><p>This is the latest summary of your ACE account.</p><p>Personal growth achievements</p><p>//if conditions</p><p>Your \"Recognise Others\" tokens</p><p>For the month of {{ month }}, You gave out a total of {{ recognizeOthersTokenUsed }} \"Recognise Others\" tokens.</p><p>&nbsp;</p><p>&nbsp;You have {{ recognizeOthersToken }} \"Recognise Others\" tokens remaining, which will expire on {{ recognizeOthersTokenExpiration }}.</p><p>&nbsp;</p><p>Remember, you can use ACE to show your appreciation to your colleagues. A small gesture goes a long way!</p><p>&nbsp;</p><p><strong>Your \"My Rewards\" tokens</strong></p><p>&nbsp;</p><p>For the month of {{ month }}, you received {{ myRewardsToken }} “My Rewards” tokens from your colleagues and you redeemed a total of {{ myRewardsTokenUsed }} tokens from the ACE Redemption Store.</p><p>&nbsp;</p><p>&nbsp;You have a total of {{ myRewardsToken }} \"My Rewards\" tokens.</p><p>//if condition</p><p>&nbsp;</p><p>Be sure to exchange these tokens for exciting gifts available on the &lt;a style=\"color:#86BC25;text-decoration:none;\" target=\"_blank\" href=\"{{aceStoreLink}}\"&gt;ACE e-Store&lt;/a&gt;!</p><p>&nbsp;</p><p>To view a full summary of your ACE account, click &lt;a style=\"color:#86BC25;text-decoration:none;\" target=\"_blank\" href=\"{{historyLink}}\"&gt;here&lt;/a&gt;.</p><p>&lt;br&gt;&lt;br&gt;</p><p>Click &lt;a href=\"{{ config(\'ace.url\') }}\"&gt;here&lt;/a&gt; to access ACE now!</p></td></tr></tbody></table></figure>', '2020-07-09 05:15:33', '2020-10-03 09:06:40', NULL),
                (7, 'Redeem', '<figure class=\"table\" style=\"width:600px;\"><table><tbody><tr><td><p>Dear {{ name }}</p><p>Thank you for shopping at ACE. Here are the details of your redemption and collection:</p><p>&lt;b&gt;Order Number:&lt;/b&gt; {{ orderNumber }}</p><p>&lt;br&gt;&lt;b&gt;Order Date:&lt;/b&gt; {{ orderDate }} &lt;time&gt;</p><p>&nbsp;</p><p>//foreach</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;&lt;b&gt;\"My Rewards\"&lt;/b&gt; tokens balance: &nbsp;{{ remainingToken }}</p><p>&nbsp;</p><p>&nbsp;Please collect your items from us on:</p><p>&lt;b style=\"color: #92d050\"&gt;Collection date/time:&lt;/b&gt; &nbsp;{{ collectionDate }}</p><p>&lt;b style=\"color: #92d050\"&gt;Collection location:&lt;/b&gt; D Lounge, Level 30</p><p>&nbsp;</p><p>If you are unable to pick up your item/s at the above date and time, please ensure that you appoint a colleague to collect on your behalf. Your colleague must present this redemption email and a photo of your staff pass to redeem the item.</p><p>&nbsp;</p><p>To view your redemption history to date, please click &lt;a style=\"color:#86BC25;text-decoration:none;\" href=\"{{historyLink}}\" target=\"_blank\"&gt;here&lt;/a&gt;.</p></td></tr></tbody></table></figure>', '2020-07-09 05:15:33', '2020-10-03 08:19:31', NULL);");

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

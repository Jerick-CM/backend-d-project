<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEdmBodyContentSentandreceiveEdm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('edm_template_body', function ($table) { 

            DB::statement("UPDATE edm_template_body SET content = '<p><span class=\"text-small\">Dear {{name}},</span></p><p><span class=\"text-small\">You have sent your appreciation to {{recipientName}} for being a great help at work and have awarded {{recipientName}} with {{linkingVerb}} {{badgeType}} badge with the following message:</span></p><p><span class=\"text-small\">{{messageContent}}</span></p><p><span class=\"text-small\">Thank you for recognising the hard work and effort put in by our people who have gone the extra mile!</span></p>' WHERE id=1; ");

            DB::statement("UPDATE edm_template_body SET content = '<p><span class=\"text-small\">Dear {{name}} ,</span></p><p><span class=\"text-small\">{{senderName}} recognises the great help you have been at work and has sent you a message and awarded you with {{linkingVerb}} {{badgeType}} &nbsp;badge with the following message:</span></p><p><span class=\"text-small\">{{messageContent}}&nbsp;</span></p><p><span class=\"text-small\">Log on to {{ACE}} and check out the {{ACE e-Store}} to redeem the item of your choice today!</span></p><p><span class=\"text-small\"><strong>Appreciate others</strong></span></p><p><span class=\"text-small\">Have a colleague in mind whom you would like to thank?</span></p><p><span class=\"text-small\">Show your appreciation today by sending them a message or rewarding them with your <strong>“Recognise Others”</strong> tokens! It’s a really simple way to say thank you.</span></p>' WHERE id=2; ");  

            DB::statement("UPDATE edm_template_body SET content = '<p><span class=\"text-small\">Dear {{name}},</span></p><p><span class=\"text-small\">You have sent your appreciation to {{recipientName}} for being a great help at work and have awarded {{recipientName}} with {{linkingVerb}} {{badgeType}} badge with the following message:</span></p><p><span class=\"text-small\">{{messageContent}}</span></p><p><span class=\"text-small\">In addition, you have awarded {{recipientName}} with {{token}} <strong>\"Recognise Others\"</strong> tokens.</span></p><p><span class=\"text-small\">Thank you for recognising the hard work and effort put in by our people who have gone the extra mile!</span></p>' WHERE id=3; ");

            DB::statement("UPDATE edm_template_body SET content = '<p><span class=\"text-small\">Dear {{name}},</span></p><p><span class=\"text-small\">{{senderName}} recognises the great help you have been at work and has sent you a message and awarded you with {{linkingVerb}} {{badgeType}} badge with the following message:</span></p><p><span class=\"text-small\">{{messageContent}}</span></p><p><span class=\"text-small\">In addition, you have also received {{token}} \"<strong>My Rewards</strong>\" tokens from {{senderName}}.</span></p><p><span class=\"text-small\">Log on to {{ACE}} and check out the {{ACE e-Store}} to redeem the item of your choice today!</span></p><p><span class=\"text-small\"><strong>Appreciate others</strong></span></p><p><span class=\"text-small\">Have a colleague in mind whom you would like to thank?</span></p><p><span class=\"text-small\">&nbsp;Show your appreciation today by sending them a message or rewarding them with your “<strong>Recognise Others</strong>” tokens! It’s a really simple way to say thank you.</span></p>' WHERE id=4; ");   

            DB::statement("UPDATE edm_template_body SET content = '<p><span class=\"text-small\">Welcome to Deloitte!</span></p><p><span class=\"text-small\">We are delighted to share with you more information about ACE (Appreciate. Celebrate. Elevate.) – our online platform designed especially for us to appreciate our colleagues for their good work and to celebrate the people who have gone the extra mile to help us.</span></p><p><span class=\"text-small\">On ACE, you can write personalised thank-you messages to colleagues across levels and businesses, and award them achievement badges and tokens. Your colleagues can also do the same for you.</span></p><p><span class=\"text-small\">These tokens can be used to redeem special treats and gifts at the {{ACE e-Store}}.</span></p><p><span class=\"text-small\">&nbsp;As a welcome gift, you will receive {{numberOfToken}} <strong>“My Rewards”</strong> tokens in your account. Live our Deloitte values and start accumulating “My Rewards” tokens to redeem the item of your choice today!</span></p><p><span class=\"text-small\">You will find that you also have {{numberOfBlackToken}} <strong>“Recognise Others”</strong> tokens in your account that you can give out in appreciation of your colleagues.</span></p><p><span class=\"text-small\">To find out how you can navigate ACE, please refer to the FAQ {{herefaq}}</span></p><p><span class=\"text-small\">Click {{here}}to access ACE now!</span></p>' WHERE id=5; ");  
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

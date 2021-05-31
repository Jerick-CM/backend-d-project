<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEdmBodyContentMonthandredeemEdm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('edm_template_body', function ($table) { 

            DB::statement("UPDATE edm_template_body SET content = '<p><span class=\"text-small\" style=\"font-family:Arial, Helvetica, sans-serif;\">Hi {{name}},</span></p><p><span class=\"text-small\" style=\"font-family:Arial, Helvetica, sans-serif;\">This is the latest summary of your ACE account.</span></p><p><span style=\"font-family:Arial, Helvetica, sans-serif;\"><strong>Personal growth achievements</strong></span></p><p><span class=\"text-small\" style=\"font-family:Arial, Helvetica, sans-serif;\">{{currentTier}}</span></p><p><span class=\"text-small\" style=\"font-family:Arial, Helvetica, sans-serif;\">{{pointsToNextTier}}</span></p><p><span class=\"text-small\" style=\"font-family:Arial, Helvetica, sans-serif;\">{{personal_growth_achievement_table}}</span></p><p>&nbsp;</p><p><span style=\"font-family:Arial, Helvetica, sans-serif;\"><strong>Balance tokens:</strong></span></p><p><span class=\"text-small\" style=\"font-family:Arial, Helvetica, sans-serif;\">{{balance_tokens_table}}</span></p><p>&nbsp;</p><p><span style=\"font-family:Arial, Helvetica, sans-serif;\"><strong>Your \"Recognise Others\" tokens</strong></span></p><p><span class=\"text-small\" style=\"font-family:Arial, Helvetica, sans-serif;\">For the month of {{month}}, You gave out a total of {{recognizeOthersTokenUsed}} \"Recognise Others\" tokens.</span></p><p><span class=\"text-small\" style=\"font-family:Arial, Helvetica, sans-serif;\">You have {{recognizeOthersToken}} \"Recognise Others\" tokens remaining, which will expire on {{recognizeOthersTokenExpiration}}.</span></p><p><span class=\"text-small\" style=\"font-family:Arial, Helvetica, sans-serif;\">Remember, you can use ACE to show your appreciation to your colleagues. A small gesture goes a long way!</span></p><p><span style=\"font-family:Arial, Helvetica, sans-serif;\"><strong>Your \"My Rewards\" tokens</strong></span></p><p><span class=\"text-small\" style=\"font-family:Arial, Helvetica, sans-serif;\">For the month of {{month}}, you received {{myRewardsToken}} “My Rewards” tokens from your colleagues and you redeemed a total of {{myRewardsTokenUsed}} tokens from the ACE Redemption Store.</span></p><p><span class=\"text-small\" style=\"font-family:Arial, Helvetica, sans-serif;\">You have a total of {{myRewardsToken}} \"My Rewards\" tokens.</span></p><p><span class=\"text-small\" style=\"font-family:Arial, Helvetica, sans-serif;\">{{tokenexpirationprompt}}</span></p><p>&nbsp;</p><p><span class=\"text-small\" style=\"font-family:Arial, Helvetica, sans-serif;\">Be sure to exchange these tokens for exciting gifts available on the {{ACE e-Store}}</span></p><p><span class=\"text-small\" style=\"font-family:Arial, Helvetica, sans-serif;\">To view a full summary of your ACE account, click {{herehistorylink}}.</span></p><p>&nbsp;</p><p><span class=\"text-small\" style=\"font-family:Arial, Helvetica, sans-serif;\">Click {{here_acelink}} to access ACE now!</span></p><p>&nbsp;</p>' WHERE id=6; ");

            DB::statement("UPDATE edm_template_body SET content = '<p><span class=\"text-small\" style=\"font-family:Arial, Helvetica, sans-serif;\">Dear {{name}}</span></p><p><span class=\"text-small\" style=\"font-family:Arial, Helvetica, sans-serif;\">Thank you for shopping at ACE. Here are the details of your redemption and collection:</span></p><p><span class=\"text-small\" style=\"font-family:Arial, Helvetica, sans-serif;\"><strong>Order Number:</strong> &nbsp;{{orderNumber}}</span></p><p><span class=\"text-small\" style=\"font-family:Arial, Helvetica, sans-serif;\"><strong>Order Date:</strong> {{orderDate}}</span></p><p><span class=\"text-small\" style=\"font-family:Arial, Helvetica, sans-serif;\">{{orderItems_table}}</span></p><p><span class=\"text-small\" style=\"font-family:Arial, Helvetica, sans-serif;\"><strong>\"My Rewards\"</strong> tokens balance: &nbsp;{{remainingToken}}</span></p><p><span class=\"text-small\" style=\"font-family:Arial, Helvetica, sans-serif;\">&nbsp;Please collect your items from us on:</span></p><p><span class=\"text-small\" style=\"color:hsl(150, 75%, 60%);font-family:Arial, Helvetica, sans-serif;\"><strong>Collection date/time:</strong></span><span class=\"text-small\" style=\"font-family:Arial, Helvetica, sans-serif;\"> &nbsp;{{collectionDate}}</span></p><p><span class=\"text-small\" style=\"color:hsl(150, 75%, 60%);font-family:Arial, Helvetica, sans-serif;\"><strong>Collection location:</strong></span><span class=\"text-small\" style=\"font-family:Arial, Helvetica, sans-serif;\"> D Lounge, Level 30</span></p><p><span class=\"text-small\" style=\"font-family:Arial, Helvetica, sans-serif;\">If you are unable to pick up your item/s at the above date and time, please ensure that you appoint a colleague to collect on your behalf. Your colleague must present this redemption email and a photo of your staff pass to redeem the item.</span></p><p><span class=\"text-small\" style=\"font-family:Arial, Helvetica, sans-serif;\">To view your redemption history to date, please click {{here}}.</span></p>' WHERE id=7; ");

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

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEdmTierpromotionData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('edm_template_body', function ($table) { 

           DB::statement("Update edm_template_body set content='<p>Dear {{name}}</p><p>&nbsp;</p><p>Congratulations on becoming a {{newbadge}}&nbsp;</p><p>&nbsp;</p><p>Your great work and effort have been recognised and you are on your way to becoming a {{nextbadge}}!&nbsp;</p><p>&nbsp;</p><p>In addition, you have&nbsp; received {{rewardstoken}} “<strong>My Rewards</strong>” tokens for advancing to the next position on your Personal Growth Achievement tier.&nbsp;</p><p>&nbsp;</p><p>Continue to keep up the good work!&nbsp;</p><p>&nbsp;</p><p>Log on to ACE and check out the ACE e-Store to redeem the item of your choice today!&nbsp;</p><p>&nbsp;</p><p><strong>Appreciate others</strong></p><p>&nbsp;</p><p>Have a colleague in mind whom you would like to thank?&nbsp;</p><p>&nbsp;</p><p>Show your appreciation today by sending them a message or rewarding them with your “<i><strong>Recognise Others</strong></i>” tokens! It’s a really simple way to say thank you.</p><p>&nbsp;</p><p><span class=\"text-small\" style=\"color:hsl(0,0%,30%);\"><i>Please do not reply to this email. For any questions, please submit your enquiry or refer to the FAQ {{here}}</i></span></p><p>&nbsp;</p>' where id=8 ");

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

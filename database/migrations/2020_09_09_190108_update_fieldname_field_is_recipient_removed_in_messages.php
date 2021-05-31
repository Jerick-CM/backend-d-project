<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFieldnameFieldIsRecipientRemovedInMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::table('messages', function ($table) {     
            DB::statement("ALTER TABLE `messages` CHANGE `is_recipient_removed` `is_recipienttoken_removed` TINYINT(4) NULL DEFAULT '0';");
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

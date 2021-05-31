<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sender_user_id')->unsigned()->index();
            $table->foreign('sender_user_id')->references('id')->on('users');
            $table->integer('recipient_user_id')->unsigned()->index();
            $table->foreign('recipient_user_id')->references('id')->on('users');
            $table->integer('message_badge_id')->unsigned()->index();
            $table->integer('message_token_id')->unsigned()->index();
            $table->string('message')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}

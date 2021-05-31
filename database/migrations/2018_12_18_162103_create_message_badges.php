<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageBadges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_badges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sender_user_id')->unsigned()->index();
            $table->foreign('sender_user_id')->references('id')->on('users');
            $table->integer('recipient_user_id')->unsigned()->index();
            $table->foreign('recipient_user_id')->references('id')->on('users');
            $table->integer('type')->unsigned()->index();
            $table->foreign('type')->references('id')->on('badges');
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
        Schema::dropIfExists('message_badges');
    }
}

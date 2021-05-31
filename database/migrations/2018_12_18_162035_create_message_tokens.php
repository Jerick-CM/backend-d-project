<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageTokens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sender_user_id')->unsigned()->index();
            $table->foreign('sender_user_id')->references('id')->on('users');
            $table->integer('recipient_user_id')->unsigned()->index();
            $table->foreign('recipient_user_id')->references('id')->on('users');
            $table->integer('amount')->default(0);
            $table->timestamp('expires_at')->nullable();
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
        Schema::dropIfExists('message_tokens');
    }
}

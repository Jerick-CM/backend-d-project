<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRedeemTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redeem_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('redeem_id')->index()->unsigned();
            $table->foreign('redeem_id')->references('id')->on('redeems');
            $table->integer('inventory_id')->index()->unsigned();
            $table->foreign('inventory_id')->references('id')->on('inventory');
            $table->integer('quantity')->default(0);
            $table->integer('total_credits')->default(0);
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
        Schema::dropIfExists('redeem_transactions');
    }
}

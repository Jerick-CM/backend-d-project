<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->length(2)->unsigned();            
            $table->string('value');   
            $table->mediumText('body');
            $table->integer('priority')->length(2)->unsigned();          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    
    public function down()
    {
        Schema::dropIfExists('faqs');
    }
}

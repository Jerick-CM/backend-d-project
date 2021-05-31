<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_photos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventory_id')->index()->unsigned();
            $table->foreign('inventory_id')->references('id')->on('inventory');
            $table->tinyInteger('is_primary')->default(0);
            $table->string('file');
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
        Schema::dropIfExists('inventory_photos');
    }
}

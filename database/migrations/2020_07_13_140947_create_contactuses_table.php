<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contactus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullname');   
            $table->string('email');   
            $table->mediumText('role'); 
            $table->mediumText('type');  
            $table->mediumText('option');   
            $table->string('attachmentlabel');   
            $table->timestamps();
        });

        Schema::table('contactus', function ($table) {
            DB::statement("INSERT INTO `contactus` VALUES (1, 'Full Name', 'eric.cao@epressidservice.com', '[\"Intern\",\"Intern\"]', '[\"Redemption\",\"Tokens\\/Badges\",\"Technical Issue\",\"Others\"]', '[\"No reply required\",\"I would like a reply\"]', 'Select attachment upload', '2020-07-13 14:49:24', '2020-07-13 17:34:16');");
        });

    }
 




    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contactus');
    }
}

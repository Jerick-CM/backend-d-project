<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEdmTemplateBody extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edm_template_body', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->mediumText('content');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('edm_template_body', function ($table) { 
            DB::statement("INSERT INTO `edm_template_body` (`id`, `label`, `content`, `created_at`, `updated_at`, `deleted_at`) VALUES
                    (1, 'message send', '', '2020-07-09 13:15:33', '2020-10-02 12:11:54', NULL),
                    (2, 'message recieved', '', '2020-07-09 13:15:33', '2020-10-02 12:11:54', NULL),
                    (3, 'message send with token', '', '2020-07-09 13:15:33', '2020-10-02 12:11:54', NULL),
                    (4, 'message recieved with token', '', '2020-07-09 13:15:33', '2020-10-02 12:11:54', NULL),
                    (5, 'welcome', '', '2020-07-09 13:15:33', '2020-10-02 12:11:54', NULL),
                    (6, 'monthly send token', '', '2020-07-09 13:15:33', '2020-10-02 12:11:54', NULL);
            ");
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('edm_template_body');
    }
}

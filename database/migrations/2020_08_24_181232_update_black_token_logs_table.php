<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class UpdateBlackTokenLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
          Schema::table('black_token_logs', function ($table) {
            DB::statement("ALTER TABLE `black_token_logs` ADD `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL AFTER `amount`;");
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
        Schema::table('black_token_logs', function (Blueprint $table) {
            $table->dropColumn(['remarks']);
        });
    }
}

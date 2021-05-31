<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExpiresAtFieldOnBlackTokenLogsTable extends Migration
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
            DB::statement("ALTER TABLE black_token_logs ADD expires_at timestamp NULL DEFAULT NULL AFTER `remarks`;");
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
            $table->dropColumn(['expires_at']);
        });
    }
}

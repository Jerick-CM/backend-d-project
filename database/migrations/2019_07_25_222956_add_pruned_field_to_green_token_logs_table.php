<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrunedFieldToGreenTokenLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('green_token_logs', function (Blueprint $table) {
            $table->tinyInteger('is_pruned')->after('remarks')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('green_token_logs', function (Blueprint $table) {
            $table->dropColumn(['is_pruned']);
        });
    }
}

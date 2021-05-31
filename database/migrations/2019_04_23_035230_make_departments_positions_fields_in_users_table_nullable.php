<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeDepartmentsPositionsFieldsInUsersTableNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign('users_department_id_foreign');
                $table->dropForeign('users_position_id_foreign');
            });
        } catch (\Throwable $e) {
            //
        }
        
        try {
            Schema::table('users', function (Blueprint $table) {
                $table->integer('department_id')->nullable()->change();
                $table->integer('position_id')->nullable()->change();
            });
        } catch (\Throwable $e) {
            //
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}

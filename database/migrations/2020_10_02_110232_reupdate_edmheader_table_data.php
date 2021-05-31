<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReupdateEdmheaderTableData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('edm_header', function ($table) { 
            DB::statement("Truncate edm_header; ");

        });
        Schema::table('edm_header', function ($table) { 
            DB::statement("INSERT INTO `edm_header` (`id`, `label`, `content`, `created_at`, `updated_at`, `deleted_at`) VALUES
                (1, 'header', '<figure class=\"table\" style=\"width:1000px;\"><table><tbody><tr><td style=\"background-color:hsl(0, 0%, 0%);\"><figure class=\"image image-style-align-left\"><img src=\"http://deloitte-backend.local.nmgdev.com/storage/edmheader/logo_1601606860.png\"></figure></td></tr><tr><td style=\"background-color:hsl(0, 0%, 0%);\"><figure class=\"image\"><img src=\"http://deloitte-backend.local.nmgdev.com/storage/edmheader/ace-logo_1601606930.jpg\"></figure></td></tr><tr><td style=\"background-color:hsl(0, 0%, 100%);\"><span style=\"color:#7F7F7F;\">Singapore&nbsp; | {{date}}</span></td></tr><tr><td style=\"background-color:hsl(0, 0%, 0%);\"><h2><span style=\"color:#92D050;\">A</span><span style=\"color:hsl(0,0%,100%);\">ppreciate</span><span style=\"color:#92D050;\">.</span> <span style=\"color:#92D050;\">C</span><span style=\"color:hsl(0,0%,100%);\">elebrate</span><span style=\"color:#92D050;\">.</span> <span style=\"color:#92D050;\">E</span><span style=\"color:hsl(0,0%,100%);\">levate</span><span style=\"color:#92D050;\">.</span></h2><p><span class=\"text-big\" style=\"color:hsl(0,0%,100%);\">Thank you for being awesome!</span></p></td></tr></tbody></table></figure>', '2020-07-09 05:15:33', '2020-10-02 03:07:52', NULL);
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
         // Schema::dropIfExists('edm_header');
    }
}

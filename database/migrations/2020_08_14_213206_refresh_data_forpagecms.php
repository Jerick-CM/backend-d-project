<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefreshDataForpagecms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('pages', function ($table) {
            DB::statement("TRUNCATE pages");
        });
      Schema::table('pages', function ($table) {
            DB::statement("INSERT INTO `pages` (`id`, `name`, `title`, `content`, `icon`, `pageurl`, `priority`, `publish`, `created_at`, `updated_at`) VALUES
(1, 'menu_name', 'menu_title', '<p class=\"ql-align-justify\">In tempor odio eros. Proin laoreet porta ex, et dignissim est porttitor et. Duis ornare convallis ligula vitae aliquam. Curabitur tincidunt nibh metus, et pulvinar purus aliquam id. Nullam ullamcorper lorem posuere leo sodales, sit amet porta est varius. Vivamus facilisis erat turpis, eget dignissim ex volutpat nec. Pellentesque ut metus sed lacus dictum eleifend sed quis velit. In auctor sem id arcu convallis rhoncus. Pellentesque accumsan semper augue non tempus. Morbi dignissim tortor non enim varius, in viverra nunc imperdiet. Curabitur dignissim augue a nisl faucibus egestas a eget urna.</p><p class=\"ql-align-justify\">In eros diam, congue sodales facilisis ac, lacinia ac est. Nam sed laoreet lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Curabitur volutpat, massa ut euismod mattis, dolor velit faucibus mi, sed feugiat risus dolor eu purus. Donec dapibus elementum sem, vel dignissim ex pellentesque sit amet. Integer sed tristique nibh. Aenean venenatis, purus ac lobortis rhoncus, libero risus sodales sem, a dignissim dui elit at ex. Phasellus feugiat ante ut volutpat finibus. Phasellus tempor, sapien vitae aliquet interdum, orci felis mattis ligula, sed laoreet neque ligula eget eros. In ultricies ligula urna, vel porta dolor lobortis sit amet. Donec pulvinar a lectus sit amet lobortis. Duis a mi quis lectus iaculis mattis.</p><p><br></p>', 'home', 'menuname1597411815', 1, 1, '2020-08-14 13:30:15', '2020-08-14 13:30:15');");
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
    }
}

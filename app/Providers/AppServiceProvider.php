<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (Schema::hasTable('profanities')) {
            $this->registerProfanitiesConfig();
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register profanities in config
     *
     * @return void
     */
    public function registerProfanitiesConfig()
    {
        $profanityCollection = DB::table('profanities')->select('word')->get();

        $mapProfanityWords = $profanityCollection->map(function ($item, $key) {
            return $item->word;
        });

        $profanities = $mapProfanityWords->all();

        $this->app['config']->set('profanity.defaults', $profanities);
    }
}

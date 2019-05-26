<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Routing\UrlGenerator;
use Laravel\Dusk\DuskServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        if(env('APP_EENV'!== 'local')) {
            $url->forceScheme('https');
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
        /**
         * Added missing method for package to work
         */
        \Illuminate\Support\Collection::macro('lists', function ($a, $b = null) {
            return collect($this->items)->pluck($a, $b);
        });
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }

    }
}
